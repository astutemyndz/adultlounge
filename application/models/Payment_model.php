<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_model 
{
    public function add($data)
    {
        if ( $this->db->insert('user_payments', $data) ) {
            return true;
        } else {
            write_log('Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }
    }


    public function edit($data, $where)
    {
        if ( $this->db->where($where)->update('user_payments', $data) ) {
            return true;
        } else {
            write_log('Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }        
    }   
    
    
    public function removeCancel($token_id)
    {
        $this->db->where('token', $token_id);
        $this->db->delete('user_payments');
    }


    public function addCredit($user_id, $credit_value)
    {
        $this->db->where('id', $user_id);
        $this->db->set('credit', 'credit+' . $credit_value, FALSE);

        if (! $this->db->update('users') ) {
            write_log("Credit not added for user $user_id");
        }

        return true;
    }


    public function getPayments()
    {
        $this->db->where('user_id', $this->session->userdata('UserId'));
        $this->db->from('user_payments');
        $this->db->order_by('created_at', 'desc');

        return $this->db->get()->result();
    }
}