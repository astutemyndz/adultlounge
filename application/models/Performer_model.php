<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performer_model extends CI_model {
    
    public function __construct(){
        parent::__construct();
       
    }

    public function search() {
        
    }
    public function all($isVerified = '', $id = '', $type = '', $checkId = '', $name = '', $sexual_pref = ''){
        $condition = array(
            'u.login_type'          => '2',
            'u.status'              => '1'
        );
        if($sexual_pref != '') {
            $condition['u.sexual_pref'] = $sexual_pref;
        }
        if($name != '') {
            $condition['u.name LIKE'] = '%'.$name.'%';
        }
        
        if($isVerified != ''){
            $condition['u.account_verified'] = 'Yes';
        }
        if($id != ''){
            $condition['u.id'] = $id;
        }
        if($type == '' && $checkId != ''){
            $condition['u.age'] = $checkId;
        }
        if($type != '' && $checkId != ''){
            $condition['up.'.$type.' LIKE '] = '%'.$checkId.'%';
        }
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];        
        $performer = $this->cm->select('users u', $condition, 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, up.cup, up.pubic_hair, up.penis, up.description,up.currency, up.price_in_private,up.price_in_group, up.category, up.attribute, up.willingness, up.appearance, up.feature, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images', 'u.id', 'desc', $join);

        return $performer;
    }

}