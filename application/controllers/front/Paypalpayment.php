<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PayPal\Api\Payment;

class Paypalpayment extends Common_Controller 
{

    function __construct() {
        parent::__construct();
        $this->checkLogin(); 
        $this->data['header'] = 'two';

        $this->load->library('paypal');
        $this->load->library('mail');
        $this->load->model('Payment_model', 'pm');
        $this->load->model('User_model', 'um');
        $this->lang->load( ['error', 'credit', 'payment'], 'english');
    }



    public function process($creditplan_hash_id)
    {
        $creditplan_id = decrypt_id( $creditplan_hash_id );
        $creditplan = $this->db->where(['id' => $creditplan_id])->from('credit_plans')->get()->row();

        if (! $creditplan) {
            $this->session->set_flashdata('error_msg', $this->lang->line('credit_not_exists'));
            redirect( $this->agent->referrer() );
        }

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');
        
        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($creditplan->sell_price);
        $amount->setCurrency(CURRENCY_CODE);
        
        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount)
            ->setDescription("Credit purchase from " . Sitesettings::get('site_name'))
            ->setInvoiceNumber(uniqid());
        
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl( base_url('payment-success') )
            ->setCancelUrl( base_url('payment-cancel') );
        
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);    
            
        try {
            $payment->create( $this->paypal->getApiContext(PAYPAL_MODE) );

            $values = [
                'user_id'      => $this->session->userdata('UserId'),
                'token'        => $payment->getToken(),
                'credit_id'    => $creditplan_id,
                'payment_mode' => PAYPAL_MODE
            ];
            
            if ($this->pm->add($values)) {
                redirect( $payment->getApprovalLink() );
            } else {
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));
                redirect( $this->agent->referrer() );
            }
        }
        catch (\PayPal\Exception\PayPalConnectionException $ex) {
            write_log( $ex->getData() );
            $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));
            redirect( $this->agent->referrer() );
        }            
    }



    public function success()
    {
        $token = $this->input->get('token');
        $payment_id = $this->input->get('paymentId');
        $payment = $this->paypal->getPayment($payment_id, PAYPAL_MODE);  

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($this->input->get('PayerID'));

        try {
            $result = $payment->execute($execution, $this->paypal->getApiContext(PAYPAL_MODE));
            write_log($result);

            $values = [
                'payment_desc'   => 'CREDITS',
                'transaction_id' => $payment->getId(),
                'amount'         => $payment->getTransactions()[0]->getAmount()->getTotal(),
                'token'          => ''
            ];
            $where = ['token' => $token];
            $user_payment = $this->db->where('token', $token)->from('user_payments')->get()->row();

            if ($this->pm->edit($values, $where)) {  
                $credit = $this->db->where('id', $user_payment->credit_id)->from('credit_plans')->get()->row();
                $this->pm->addCredit($this->session->userdata('UserId'), $credit->credit);  
                $this->um->applyForLoyaltyPoints($this->session->userdata('UserId'));
                $this->session->set_userdata('credited_amount', $credit->credit);   

                // Send email to user
                $blogname = Sitesettings::get('site_name');
                $current_user = $this->session->userdata('curr_user');
                $params = [
                    'display_name'   => ucwords( $this->session->userdata('UserName') ),
                    'credit_amount'  => $credit->credit,
                    'payment_date'   => date('j-m-Y'),
                    'payment_amount' => CURRENCY_SIGN . $values['amount'],
                    'transaction_id' => $payment->getId(),
                ];

                $mail_content = $this->mail->get_body( $params, 'payment-success-user.twig' );
                $this->mail->sent_mail( $current_user['email'], "[{$blogname}] Payment Received", $mail_content );

                // Send email to admin
                $params = [
                    'display_name'   => ucwords( $this->session->userdata('UserName') ),
                    'credit_amount'  => $credit->credit,
                    'payment_date'   => date('j-m-Y'),
                    'payment_amount' => CURRENCY_SIGN . $values['amount'],
                    'transaction_id' => $payment->getId(),
                    'payer_name'     => $current_user['name'],
                    'payer_email'    => $current_user['email'],
                ];

                $mail_content = $this->mail->get_body( $params, 'payment-success-admin.twig' );
                $this->mail->sent_mail( $this->config->item('admin_email'), "[{$blogname}] New Payment Received", $mail_content ); 
                
                redirect('payment-completed');
            } else {
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));            
                redirect( $this->agent->referrer() );
            }            
        } catch (Exception $ex) {
            $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));            
            redirect( $this->agent->referrer() );
        }
    }



    public function cancel()
    {
        $token = $this->input->get('token');
        $this->pm->removeCancel($token);        
        redirect('payment-cancelled');
    }



    public function cancelled()
    {
        $this->checkAge();
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/payment-cancelled');
        $this->load->view('frontend/layout/footer', $this->data);         
    }



    public function completed()
    {
        $this->checkAge();        
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/payment-completed');
        $this->load->view('frontend/layout/footer', $this->data);        
    }


    public function view_invoice($hashed_payment_id)
    {
        $payment_id = decrypt_id( $hashed_payment_id );
        $transaction = $this->cm->select_row('user_payments', ['id' => $payment_id]);

        if( ! $transaction ) {
            show_404();
        }

        try {
            $payment = $this->paypal->getPayment( 
                $transaction['transaction_id'], 
                $transaction['payment_mode'] 
            );

            $this->data['transaction'] = $transaction;
            $this->data['payment']     = $payment->toArray();
            $this->data['invoice_no']  = $payment->getTransactions()[0]->getInvoiceNumber();

            $this->checkAge();        
            $this->load->view('frontend/layout/header', $this->data);
            $this->load->view('frontend/pages/view-invoice');
            $this->load->view('frontend/layout/footer', $this->data);             

        } catch (Exception $ex) {
            write_log($ex->getMessage());
        }
    }

}