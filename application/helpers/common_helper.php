<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Hashids\Hashids;

$CI =& get_instance();

if (! function_exists('write_log')) {
    /**
     * Log system message
     *
     * @param array|object|string $msg
     * @return void
     */
    function write_log($msg) {
        $log_path = APPPATH . '/logs/log-' . date('Y-m-d') . '.php';
        $timestamp = date('[Y-m-d H:i:s]: ');
        
        if( is_array($msg) || is_object($msg) ) {
            error_log( $timestamp . print_r( $msg, true ) . PHP_EOL, 3, $log_path );
        } else {
            error_log( $timestamp . $msg . PHP_EOL, 3, $log_path );
        }
    }
}



if (! function_exists('uploads_url')) {
    function uploads_url($path = null) {
        return base_url('uploads/' . $path);
    }
}



if (! function_exists('json_success')) {
    function json_success($data)
    {
        echo json_encode( [
            'success' => true,
            'data'    => $data
        ], JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
        exit;
    }
}



if (! function_exists('json_error')) {
    function json_error($data)
    {
        echo json_encode( [
            'success' => false,
            'data'    => $data
        ], JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT );
        exit;
    }
}


if (! function_exists('get_credit_plans')) {
    function get_credit_plans()
    {
        global $CI;        
        $CI->load->database();
        $credit_plans = $CI->db->where('status', 1)->from('credit_plans')->get()->result_array();
        
        return $credit_plans;
    }
}



if (! function_exists('encrypt_id')) {
    function encrypt_id($id)
    {
        $hashids = new Hashids('', 16);

        return $hashids->encode($id);
    }
}



if (! function_exists('decrypt_id')) {
    function decrypt_id($hashed_id)
    {
        $hashids = new Hashids('', 16);
        $decoded_data = $hashids->decode($hashed_id); 

        return isset($decoded_data[0]) ? $decoded_data[0] : null;
    }
}



if (! function_exists('currency_format')) {
    function currency_format($amount, $locale = 'en_GB')
    {
        $fmt = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        return $fmt->format($amount);
    }
}



if( ! function_exists('get_login_user')) {
    function get_login_user() {
        global $CI;
        $userDetails = $CI->getUserDetails($CI->session->userdata('UserId'));

        return isset($userDetails[0]) ? $userDetails[0] : [];
    }
}



if (! function_exists('db_val')) {
    function db_val($value) {
        return $value ? $value : '&mdash;';
    }
}