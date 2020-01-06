<?php
class Paypal
{
    private $apiContext;

    const SANDBOX_MODE = 'sandbox';

    const PRODUCTION_MODE = 'production';

    public function getApiContext($payment_mode)
    {
        $this->apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $payment_mode == self::SANDBOX_MODE ? PAYPAL_SANDBOX_CLIENT_ID : PAYPAL_LIVE_CLIENT_ID,     
                $payment_mode == self::SANDBOX_MODE ? PAYPAL_SANDBOX_CLIENT_SECRET : PAYPAL_LIVE_CLIENT_SECRET
            )
        );

        if ( $payment_mode == self::PRODUCTION_MODE ) {
            $this->apiContext->setConfig(
                array(
                    'mode' => 'live'
                )
            );
        }  
        
        return $this->apiContext;
    }


    public function getPayment($payment_id, $payment_mode)
    {
        $payment = PayPal\Api\Payment::get($payment_id, $this->getApiContext($payment_mode));

        return $payment;
    }


    public function getAllPayments($payment_mode, $limit = 10, $offset = 0)
    {
        try {
            $params = [
                'count'       => $limit,
                'start_index' => $offset
            ];
        
            $payments = PayPal\Api\Payment::all($params, $this->getApiContext($payment_mode));

            return $payments;
        } catch (Exception $ex) {
            write_log($ex->getMessage());
        }
    }


}