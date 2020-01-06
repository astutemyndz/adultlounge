<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_model 
{
    const TABLE = 'users';

    public function deductCredit($credit_value, $user_id)
    {
        $this->db->set('credit', 'credit-' . $credit_value, FALSE);
        $this->db->where('id', $user_id);
        
        if ( $this->db->update(self::TABLE) ) {         
            return true;
        } else {
            write_log( 'Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }         
    }



    public function addCredit($credit_value, $user_id)
    {
        $this->db->set('credit', 'credit+' . $credit_value, FALSE);
        $this->db->where('id', $user_id);
        
        if ( $this->db->update(self::TABLE) ) {         
            return true;
        } else {
            write_log( 'Line ' . __LINE__ . ' : ' . __FILE__ . PHP_EOL);
            write_log($this->db->error());         
            return false;   
        }         
    }



    public function getUser($user_id)
    {
        return $this->db->where('id' , $user_id)->from(self::TABLE)->get()->row();
    }



    public function applyForLoyaltyPoints($user_id)
    {        
        $this->db->select_sum('amount');
        $this->db->where('user_id', $user_id);
        $row = $this->db->from('user_payments')->get()->row(0);
        $total_amount = $row->amount ? $row->amount : 0;
        // write_log('total_amount: ' . $total_amount);

        $this->db->where('user_id', $user_id);
        $row = $this->db->from('user_loyalty_points')->get()->row();
        $last_points_on_amount = $row ? $row->last_points_given_on_amount : 0;
        // write_log('last_points_on_amount: ' . $last_points_on_amount);

        // SELECT * FROM `loyalty_plans` WHERE `sell_price` <= 40000 ORDER BY sell_price DESC LIMIT 0,1  
        $this->db->where('sell_price <=', $total_amount, false);
        $this->db->order_by('sell_price', 'DESC');
        $plan = $this->db->from('loyalty_plans')->limit(1)->get()->row();
        // write_log('plan');
        // write_log($plan);
        
        if ($plan) {
            if($plan->sell_price > $last_points_on_amount ) {
                $this->addCredit($plan->credit, $user_id); 
                
                if($last_points_on_amount) {
                    $this->db->set('amount_spent', $total_amount);
                    $this->db->set('loyalty_points', 'loyalty_points+' . $plan->credit, FALSE);
                    $this->db->set('last_points_given_on_amount', $plan->sell_price);
                    $this->db->where('user_id', $user_id);
                    $this->db->update('user_loyalty_points');
                } else {
                    $this->db->insert('user_loyalty_points', [
                        'user_id'                     => $user_id,
                        'amount_spent'                => $total_amount,
                        'loyalty_points'              => $plan->credit,
                        'last_points_given_on_amount' => $plan->sell_price
                    ]);
                }
            }                
        }
    }

}