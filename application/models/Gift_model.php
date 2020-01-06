<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift_model extends CI_model 
{
    const TABLE = 'gifts';

    public function add($data)
    {
        if ( $this->db->insert(self::TABLE, $data) ) {
            return true;
        } else {
            write_log('Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }
    }


    public function edit($data, $where)
    {
        if ( $this->db->where($where)->update(self::TABLE, $data) ) {
            return true;
        } else {
            write_log('Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }        
    }


    public function send_gift($data)
    {
        if ( $this->db->insert('user_gifts', $data) ) {
            return true;
        } else {
            write_log('Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }        
    }



    public function get_received()
    {
        $this->db->select('UG.created_at, UT.name as username, UT.image, GT.gift_name as gift_name, GT.gift_image_path');
        $this->db->where('receiver_id', $this->session->userdata('UserId'));
        $this->db->join('users as UT', 'UG.sender_id = UT.id', 'left');
        $this->db->join('gifts as GT', 'UG.gift_id = GT.id', 'left');

        $gifts = $this->db->from('user_gifts as UG')->get()->result();

        return $gifts;
    }

}