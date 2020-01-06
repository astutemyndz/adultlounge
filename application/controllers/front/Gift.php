<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends Common_Controller {

    function __construct() {
        parent::__construct();
        $this->checkLogin();      
        
        $this->userId = $this->session->userdata('UserId');

        $this->lang->load( ['error', 'gift'], 'english');
        $this->load->model('User_model', 'user');
        $this->load->model('Gift_model', 'gift');
        $this->load->helper('inflector');
    }



    public function send()
    {
        $gift_id = decrypt_id( $this->input->post('gift_id') );
        $gift = $this->db->where(['id' => $gift_id])->from('gifts')->get()->row();
        
        if (! $gift) {
            json_error([
                'message' => $this->lang->line('gift_not_exists')
            ]);
        }

        $user_credit = $this->getUserDetails($this->userId)[0]['credit'];

        if ($user_credit < $gift->gift_point) {
            json_error([
                'message' => $this->lang->line('gift_credit_low')
            ]);
        }

        $values['sender_id']   = $this->userId;
        $values['receiver_id'] = decrypt_id( $this->input->post('receiver_id') );
        $values['gift_id']     = decrypt_id( $this->input->post('gift_id') );

        if ($this->gift->send_gift($values)) {
            if ($this->user->deductCredit( $gift->gift_point, $this->userId )) {
                $user_credit = $this->getUserDetails($this->userId)[0]['credit'];
                $credit_text = $user_credit < 2 ? singular('Credit') : plural('Credit');
                
                json_success( [
                    'message' => $this->lang->line('gift_sent'),
                    'credit'  => $user_credit . ' ' . $credit_text
                ] );
            } else {
                json_error( [
                    'message' => $this->lang->line('general_error_msg')
                ] );
            }
        } else {
            json_error( [
                'message' => $this->lang->line('general_error_msg')
            ] );
        }
    }



    public function received()
    {
        $this->checkAge();
        $this->checkLogin();

        $current_month = date('m');
        
        $this->data['header'] = 'two';
        $this->data['current_month_gift_totals'] = $this->db->select_sum('gift_point')->from('user_gifts UG')->join('gifts GT', 'UG.gift_id = GT.id', 'LEFT')->where('receiver_id', $this->session->userdata('UserId'))->where('Month(UG.created_at)', $current_month)->get()->row()->gift_point;
        $this->data['gift_points'] = $this->db->select_sum('gift_point')->from('user_gifts UG')->join('gifts GT', 'UG.gift_id = GT.id', 'LEFT')->where('receiver_id', $this->session->userdata('UserId'))->get()->row()->gift_point;
        $this->data['gifts'] = $this->gift->get_received();
        $this->data['current_user'] = $this->session->userdata('curr_user');

        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/gifts-received',$this->data);
        $this->load->view('frontend/layout/footer', $this->data);        
    }

}