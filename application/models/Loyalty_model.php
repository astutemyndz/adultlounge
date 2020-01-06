<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loyalty_model extends CI_model 
{

    const TABLE = 'loyalty_plans';

    public function all()
    {
        $this->db->select(['title', 'description', 'credit', 'sell_price']); 
        $this->db->where('status', 1)->order_by('sell_price');
        $loyalty_plans = $this->db->from(self::TABLE)->get()->result();
        
        return $loyalty_plans;
    }



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



    public function user_spent_total($user_id)
    {
        $this->db->where('user_id', $user_id);
        $row = $this->db->from('user_loyalty_points')->get()->row();

        return $row ? $row->amount_spent : 0;
    }

}