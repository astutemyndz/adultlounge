<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performer_model extends CI_model {
    
    public $tables;
    public $whereConditions;
    public $data;

    public $categories;
    public $appearances;
    public $showTypes;
    public $willingness;
    public $userId;

    

    public function __construct(){
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->tables['user']                   = 'users';

        // Mapping tables
        $this->tables['users_preference']       = 'users_preference';
        $this->tables['users_appearance']       = 'users_appearence';
        $this->tables['users_show_type']        = 'users_show_type';
        $this->tables['users_categories']       = 'users_categories';
        $this->tables['users_willingness']      = 'users_willingness';
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
    public function filter($data) {
        if(!empty($data) && is_array($data)) {
            $this->data = $data;
            foreach($this->data as $key => $value) {
                if(array_key_exists('sexual_pref', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('gender', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('age', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('country', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('city', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('hasWebcam', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('account_verified', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('us_citizen', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
                if(array_key_exists('country', $this->data) && isset($this->data[$key]) && !empty($this->data[$key])) {
                    $this->whereConditions['u.'.$key.''] = $value;
                }
            }

            echo "<pre>";
            print_r($this->whereConditions);
            exit;
        }
        // $this->db->from($this->tables['users'].' as u');
        // $this->db->join($this->tables['user_preference'].' as up', 'user_preference.user_id = users.id', 'left');
        // $this->db->where($this->whereCondition);
        // $this->db->select('u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, up.cup, up.pubic_hair, up.penis, up.description,up.currency, up.price_in_private,up.price_in_group, up.category, up.attribute, up.willingness, up.appearance, up.feature, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images');
        // $this->setQuery($this->db->get());

        // return $performer;
    }

    public function setUserId($value) {
        $this->userId = $value;
        return $this;
    }
    public function setAppearances($value) {
        $this->appearances = $value;
        return $this;
    }
    public function setCategories($value) {
        $this->categories = $value;
        return $this;
    }
    public function setShowTypes($value) {
        $this->showTypes = $value;
        return $this;
    }
    public function setWillingness($value) {
        $this->willingness = $value;
        return $this;
    }

    public function getAppearances() { return $this->appearances; }
    public function getCategories() { return $this->categories; }
    public function getShowTypes() { return $this->showTypes; }
    public function getWillingness() { return $this->willingness; }

    public function updateUserCategory() {
        $this->db->delete($this->tables['users_categories'], array('id_users' => $this->userId));
        if($this->categories) {
            foreach($this->categories as $category) {
                $this->db->insert($this->tables['users_categories'], array(
                    'id_users' => $this->userId,
                    'id_categories' => $category,
                ));
            }
        }
        return true;
    }
    public function updateUserAppearance() {
        $this->db->delete($this->tables['users_appearance'], array('id_users' => $this->userId));
        if($this->appearances) {
            foreach($this->appearances as $appearances) {
                $this->db->insert($this->tables['users_appearance'], array(
                    'id_users' => $this->userId,
                    'id_appearence' => $appearances,
                ));
            }
        }
        return true;
    }
    public function updateUserShowType() {
        $this->db->delete($this->tables['users_show_type'], array('id_users' => $this->userId));
        if($this->showTypes) {
            foreach($this->showTypes as $showType) {
                $this->db->insert($this->tables['users_show_type'], array(
                    'id_users' => $this->userId,
                    'id_show_type' => $showType,
                ));
            }
        }
        return true;
    }
    public function updateUserWillingness() {
        $this->db->delete($this->tables['users_willingness'], array('id_users' => $this->userId));
        if($this->willingness) {
            foreach($this->willingness as $willingness) {
                $this->db->insert($this->tables['users_willingness'], array(
                    'id_users' => $this->userId,
                    'id_willingness' => $willingness,
                ));
            }
        }
        return true;
    }
    /*
    public function categories() {
        return $this->db->get_where($this->tables['users_categories'], array('id_users' => $this->userId));
    }
    public function appearances() {
        return $this->db->get_where($this->tables['users_appearance'], array('id_users' => $this->userId));
    }
    public function showTypes() {
        return $this->db->get_where($this->tables['users_show_type'], array('id_users' => $this->userId));
    }
    public function willingness() {
        return $this->db->get_where($this->tables['users_willingness'], array('id_users' => $this->userId));
    }
    */

    public function test() {echo 1;}
}