<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends Common_Controller {
    
    
    public function __construct() {

        parent::__construct();
        $this->getCommonMenu();
        $this->data['header'] = 'two';
        $this->data['plans'] = $this->cm->select('credit_plans', ['status'=>1], '', 'id', 'ASC');

        $this->load->model('Performer_model', 'performer');
    }

    

    public function index() {
        if($this->session->userdata('setAge')){
            if($this->session->userdata('UserType') && $this->session->userdata('UserType') == '2'){
                $this->data['user'] = $this->getPerformerDetails('', $this->session->userdata('UserId'));
                $this->data['vote'] = $this->getVoteDetails($this->session->userdata('UserId'));
                $this->data['newSubs'] = $this->getNewSubs(array('s.performer_id' => $this->session->userdata('UserId')));
                $this->data['showHistory'] = $this->getShowHistory(array('vc.performer_id' => $this->session->userdata('UserId')));
            }else{
                $this->data['header'] = 'one';
                $this->data['performer'] = $this->getPerformerDetails('Yes');
                $this->data['user'] = $this->getUserDetails($this->session->userdata('UserId'));
                // echo "<pre>";
                // print_r($this->data);
                // exit;
            }
            $this->load->view('frontend/layout/header', $this->data);
            $this->load->view('frontend/pages/index');
            $this->load->view('frontend/layout/footer', $this->data);
        }else{
            $this->load->view('frontend/layout/header', $this->data);
            $this->load->view('frontend/pages/startup');
            $this->load->view('frontend/layout/footer', $this->data);
        }
    }

    public function profile(){
        $this->checkAge();
        $this->checkLogin();
        $this->data['user'] = $this->getUserDetails($this->session->userdata('UserId'));
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/profile');
        $this->load->view('frontend/layout/footer', $this->data);
    }

    public function profileUpdate(){
        if(!empty($this->cm->get_specific('users', array("usernm" => '@'.$this->input->post('usernm_edit'), "id !=" => $this->input->post('editpro_id'))))){
            print 'notok~~Sorry !!! Username Already Exists!!!';
            die;
        }
        $pro_image = '';
        $files = $_FILES;
        if (!empty($files) && $files['editpro_image']['name'] != '') {
            $pro_image = $this->commonFileUpload('assets/profile_image/', $files['editpro_image']['name'], 'editpro_image', $this->input->post('old_editpro_image'));
        }else{
            $pro_image = $this->input->post('old_editpro_image');
        }
        $updateArray = array(
            'name'          => $this->input->post('name_edit'),
            'usernm'        => '@'.$this->input->post('usernm_edit'),
            'sexual_pref'   => $this->input->post('editpro_sexual_pref'),
            'age'           => $this->input->post('editpro_age'),
            'image'         => $pro_image,
            'updated_at'    => date('Y-m-d H:i:s')
        );
        if($this->input->post('editpro_id')) {
            $this->performer->setUserId($this->input->post('editpro_id'));
        }
        

       

        $this->cm->update('users', array("id" => $this->input->post('editpro_id')), $updateArray);
        $this->session->set_userdata('UserName', $this->input->post('name_edit'));
        $category = $this->input->post('editpro_category');
        $attribute = $this->input->post('editpro_attr');
        $feature = $this->input->post('editpro_ftr');
        $willing = $this->input->post('editpro_will');
        $appearence = $this->input->post('editpro_aprnc');
        $cat = '';
        $attr = '';
        $featr = '';
        $will = '';
        $apnc = '';
        if(!empty($category)){
            foreach($category as $categry){
                $cat .= $categry.',';
                $this->performer->categories[] = $categry;
            }
        }
        if(!empty($attribute)){
            foreach($attribute as $attribut){
                $attr .= $attribut.',';
                $this->performer->showTypes[] = $attribut;
            }
        }
        if(!empty($feature)){
            foreach($feature as $featur){
                $featr .= $featur.',';
            }
        }
        if(!empty($willing)){
            foreach($willing as $willing){
                $will .= $willing.',';
                $this->performer->willingness[] = $willing;
            }
        }
        if(!empty($appearence)){
            foreach($appearence as $aprnc){
                $apnc .= $aprnc.',';
                $this->performer->appearances[] = $aprnc;
            }
        }

        // if(isset($this->appearances) && !empty($this->appearances)) {
        //     foreach($this->appearances as $appearance) {
                
        //     }
        // }
        $this->performer->setAppearances($this->performer->appearances);
        $this->performer->setCategories($this->performer->categories);
        $this->performer->setShowTypes($this->performer->showTypes);
        $this->performer->setWillingness($this->performer->willingness);
        
        $this->performer->updateUserAppearance();
        $this->performer->updateUserCategory();
        $this->performer->updateUserShowType();
        $this->performer->updateUserWillingness();
        

        $cat = trim($cat, ",");
        $attr = trim($attr, ",");
        $featr = trim($featr, ",");
        $will = trim($will, ",");
        $apnc = trim($apnc, ",");
        $updateArrayTwo = array(
            'display_name'  => $this->input->post('display_name_edit'),
            'height'        => $this->input->post('editpro_height'),
            'weight'        => $this->input->post('editpro_weight'),
            'hair'          => $this->input->post('editpro_hair'),
            'eye'           => $this->input->post('editpro_eye'),
            'zodiac'        => $this->input->post('editpro_zodiac'),
            'build'         => $this->input->post('editpro_build'),
            'chest'         => $this->input->post('editpro_chest'),
            'burst'         => $this->input->post('editpro_burst'),
            'cup'           => $this->input->post('editpro_cup'),
            'pubic_hair'    => $this->input->post('editpro_pubic_hair'),
            'penis'         => $this->input->post('editpro_penis'),
            'description'   => $this->input->post('editpro_description'),
            'category'      => $cat,
            'attribute'     => $attr,
            'willingness'   => $will,
            'appearance'    => $apnc,
            'feature'       => $featr,
            'currency'       => $this->input->post('currency'),
            'price_in_private'       => $this->input->post('price_in_private'),
            'price_in_group'       => $this->input->post('price_in_group'),
            'performer_type'       => $this->input->post('performer_type'),
        );
        $chkTwo = $this->cm->get_all('user_preference', array("user_id" => $this->input->post('editpro_id')));
        if($this->session->userdata('UserType') == 2 && count($files['gallery']['name'])> 0){
            $this->galleryFilesUpload('assets/performer_gallery/', $files['gallery'], 'performer_gallery', array("user_id" => $this->input->post('editpro_id')));
        }
        if(empty($chkTwo)){
            $updateArrayTwo['user_id'] = $this->input->post('editpro_id');
            $this->cm->insert('user_preference', $updateArrayTwo);
        }else{
            $updateArrayTwo['updated_at'] = date('Y-m-d H:i:s');
            $this->cm->update('user_preference', array("user_id" => $this->input->post('editpro_id')), $updateArrayTwo);
        }
        print 'ok~~Profile Details Updated Successfully!!!';
    }

    public function personalDetails(){
        $this->checkAge();
        $this->checkLogin();
        
        if($this->input->post('editpro_name')){
            if(empty($this->cm->get_specific('users', array("email" => $this->input->post('editpro_email'), "id !=" => $this->input->post('UserId'))))){
                $updateArray = array(
                    'name'          => $this->input->post('editpro_name'),
                    'email'         => $this->input->post('editpro_email'),
                    'phone_no'      => $this->input->post('editpro_phone'),
                    'gender'        => $this->input->post('editpro_gender'),
                    'address_one'   => $this->input->post('editpro_address'),
                    'pincode'       => $this->input->post('editpro_pin'),
                    'updated_at'    => date('Y-m-d H:i:s')
                );
                if($this->input->post('editpro_pwd') != ''){
                    $updateArray['login_password'] = MD5($this->input->post('editpro_pwd'));
                }
                if($this->input->post('editpro_card') != ''){
                    $updateArray['card_no'] = $this->input->post('editpro_card');
                    $updateArray['card_month'] = $this->input->post('editpro_cardm');
                    $updateArray['card_year'] = $this->input->post('editpro_cardy');
                    $updateArray['card_cvv'] = $this->input->post('editpro_card_cvv');
                }
                $this->cm->update('users', array("id" => $this->session->userdata('UserId')), $updateArray);
                print 'Personal Details Updated Successfully!!!';
                die;
            }else{
                print 'Sorry!!! Email already exists !!!';
                die;
            }
        }
        $this->data['user'] = $this->getUserDetails($this->session->userdata('UserId'));
        $this->data['wallet'] = $this->getWalletAmonut($this->session->userdata('UserId'));
        $this->data['subs'] = $this->getSubsPerformer(array('s.user_id' => $this->session->userdata('UserId'), 's.status' => 1));
        $this->data['invoices'] = $this->getInvoices();        
        $this->data['history'] = $this->getHistoryPerformer(array('vc.user_id' => $this->session->userdata('UserId'), 'vc.status' => 2));
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/personal_details');
        $this->load->view('frontend/layout/footer', $this->data);
    }

    public function verification(){
        $this->checkAge();
        $this->checkLogin();
        if($this->input->post('verify_name')){
            if(empty($this->cm->select_row('user_verification uv', array('uv.user_id' => $this->session->userdata('UserId')), 'id'))){
                if(!empty($this->cm->select_row('users u', array('u.email' => $this->input->post('verify_email'), "id != " => $this->session->userdata('UserId')), 'id'))){
                    print 'notok~~Sorry !!! Email already exists !!!';
                    die;
                }else{
                    $updateData = array(
                        "name"          => $this->input->post('verify_full_name'),
                        "email"         => $this->input->post('verify_email'),
                        "phone_no"      => $this->input->post('verify_phone'),
                        "dob"           => $this->input->post('verify_dob'),
                        "address_one"   => $this->input->post('verify_add_one'),
                        "address_two"   => $this->input->post('verify_add_two'),
                        "city"          => $this->input->post('verify_city'),
                        "pincode"       => $this->input->post('verify_pincode'),
                        "country"       => $this->input->post('verify_country'),
                        "i_am_a"        => $this->input->post('i_am_a'),
                        "us_citizen"    => $this->input->post('us_citizen')
                    );
                    $this->cm->update('users', array("id" => $this->session->userdata('UserId')), $updateData);
                }
                $insertData = array();
                $files = $_FILES;
                for($g=0; $g<2; $g++ ){
                    if($g==0){
                        $nm='verify_pic';
                    }else{
                        $nm='verify_pic_id';
                    }
                    if (!empty($files) && $files[$nm]['name'] !='' ) {
                        $insertData[$nm] = $this->commonFileUpload('assets/verify_image/', $files[$nm]['name'], $nm);
                    }
                }
                $insertData['user_id'] = $this->session->userdata('UserId');
                $insertData['name'] = $this->input->post('verify_name');
                $insertData['verify_date'] = $this->input->post('verify_year').'-'.$this->input->post('verify_month').'-'.$this->input->post('verify_day');
                $this->cm->insert('user_verification', $insertData);
                print 'ok~~Verification Details Successfully Uploaded !!!';
                die;
            }else{
                print 'ok~~Verification Details Already Uploaded & Yet to be Approved !!!';
                die;
            }
        }
        $this->data['user'] = $this->getUserDetails($this->session->userdata('UserId'));
        $this->data['countries'] = $this->cm->get_all('add_countries', array("status" => 1));
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/verification');
        $this->load->view('frontend/layout/footer', $this->data);
    }

    public function viewProfile($id = '', $nm = ''){
        $this->checkAge();
        $this->checkLogin();
        $this->data['user'] = $this->getUserDetails($id);
        $this->data['current_user'] = $this->getUserDetails($this->session->userdata('UserId'))[0];
        
        if(!empty($this->data['user'])){
            if($this->data['user'][0]['willingness'] != ''){
                $this->data['user'][0]['willingness'] = $this->getPerformerWillingNess($this->data['user'][0]['willingness']);
            }
            if($this->data['user'][0]['attribute'] != ''){
                $this->data['user'][0]['attribute'] = $this->getPerformerAttribute($this->data['user'][0]['attribute']);
            }
        }

        $this->data['chat'] = $this->cm->get_chat($this->session->userdata('UserId'), $id);
        if($this->session->userdata('UserType') == 1){            
            $this->data['vote'] = $this->getVoteDetails($id);
            
        }

        $this->data['subs'] = $this->cm->get_specific('subscribe', array("user_id" => $this->session->userdata('UserId'), "performer_id" => $id));
        //$point = $this->db->query("select point from site_settings where id=1")->result_array();
        $point = $this->db->query("select point from site_settings where id=1")->row()->point;
        $this->data['gifts'] = $this->db->select('id, gift_name, gift_point, gift_image_path')->from('gifts')->where(['is_active' => '1'])->get()->result();
       
        $this->data['point'] = $point;
        
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/view_profile',$this->data);
        $this->load->view('frontend/layout/footer', $this->data);
    }

    public function search() {
        
    }
    public function filterPerformer(){
        $this->checkAge();
        if($this->input->post('type') == 'age'){
            $this->data['performer'] = $this->getPerformerDetails('Yes', '', '', $this->input->post('id'));
        }else{
            $this->data['performer'] = $this->getPerformerDetails('Yes', '', $this->input->post('type'), $this->input->post('id'));
        }
        if(!empty($this->data['performer'])){
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
            $this->html = 'ok~~'.$this->html;
        }else{
            $this->html = 'notok~~No Such Performer Found !!!';
        }
        print $this->html;
    }

    public function accountSettings(){
        $this->checkAge();
        $this->checkLogin();
        $updateArray = array(
            "receiveEmail"  => $this->input->post('ac_email'),
            "allowContact"  => $this->input->post('ac_contact'),
            "saveHistory"   => $this->input->post('ac_history'),
            "maxCredit"     => $this->input->post('ac_credit'),
            "blockMessage"  => $this->input->post('ac_block'),
            "updated_at"    => date('Y-m-d H:i:s')
        );
        if($this->input->post('ac_credit') == 'Y'){
            $updateArray['creditLimit'] = $this->input->post('ac_maxcrdt');
        }
        $this->cm->update('user_preference', array("user_id" => $this->session->userdata('UserId')), $updateArray);
        print 'Details Updated Successfully !!!';
    }

    public function dashBoard(){
        $this->checkAge();
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/dashboard');
        $this->load->view('frontend/layout/footer', $this->data);
    }

    public function getInvoices()
    {
        $this->load->model('Payment_model', 'pm');

        return $this->pm->getPayments();
    }

}
