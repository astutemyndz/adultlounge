<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends Common_Controller {

    public function __construct(){
        parent::__construct();
        $this->data['header'] = 'two';
    }



    public function index(){
        $this->checkAge();

        if($this->session->userdata('UserId')){
            redirect(base_url());
        }

        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/login');
        $this->load->view('frontend/layout/footer');
    }



    public function setAge(){
        $this->session->set_userdata('setAge', 'Done');
    }



    public function signUp() {

        $this->checkAge();
        if($this->session->userdata('UserId')){
            redirect(base_url());
        }
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/signup');
        $this->load->view('frontend/layout/footer');
    }



    public function doRegistration(){

        if(empty($this->cm->get_specific('users', array("email" => $this->input->post('reg_email'))))){
            if($this->input->post('reg_type') == 1){
                $status = 1;
                $verified = 'Yes';
            }else{
                $status = 0;
                $verified = 'No';
            }

            $user_type = in_array($this->input->post('reg_type'), [1, 2]) ? $this->input->post('reg_type') : 1;

            $in_array = [
                'name'              => $this->input->post('reg_name'),
                'email'             => $this->input->post('reg_email'),
                'login_type'        => $user_type,
                // 'login_password'    => md5($this->input->post('reg_pwd')),
                'login_password'    => password_hash($this->input->post('reg_pwd'), PASSWORD_DEFAULT),
                'gender'            => $this->input->post('reg_gender'),
                'status'            => $status,
                'account_verified'  => $verified
            ];
            //print_r($in_array);exit;
            $insert_id = $this->cm->insert('users', $in_array);
            if($insert_id){
                $this->cm->insert('user_preference', array("user_id" => $insert_id));
                print "ok";
            }else{
                print "notok";
            }
        }else{
            print 'Sorry !!! User already exists with this email !!!';
        }
    }



    public function doLogin() {

        $chk = $this->cm->get_all('users', array(
            "email"          => $this->input->post('login_email'),
            // "login_password" => md5($this->input->post('login_pwd'))
        ));

        if(empty($chk)){
            print 'Sorry !!! Email & Password mismatch !!!';   
        } else{
            if($chk[0]->status == 0){
                print 'Sorry '.$chk[0]->name.'!!! Your account is not activated yet !!!';
            } else if(! password_verify($this->input->post('login_pwd'), $chk[0]->login_password)) {
                die( 'Sorry!!! Invalid login credentials!!!' );
            } else{
                if($chk[0]->login_type == 0) {
                    die( 'Sorry!!! Invalid login credentials!!!' );
                }

                $this->cm->update('users', array(
                    "id" => $chk[0]->id
                ), array(
                    "isLogin"    => 1,
                    "login_time" => date('Y-m-d H:i:s')
                ));

                $this->session->set_userdata('curr_user', $this->getUserDetails($chk[0]->id)[0]);
                $this->session->set_userdata('UserId', $chk[0]->id);
                $this->session->set_userdata('UserName', $chk[0]->name);
                $this->session->set_userdata('UserType', $chk[0]->login_type);
                $this->session->set_userdata('UserCredit', $chk[0]->credit);
                $this->session->set_userdata('AccountVerified', $chk[0]->account_verified);
                print 'ok';   
            }
        }
    }



    public function logOut() {
        $this->cm->update('users', array("id" => $this->session->userdata('UserId')), array("isLogin" => 0));
        $this->session->set_userdata('UserId', '');
        $this->session->set_userdata('UserName', '');
        $this->session->set_userdata('UserType', '');
        $this->session->set_userdata('AccountVerified', '');
        $this->session->unset_userdata('UserId');
        $this->session->unset_userdata('UserName');
        $this->session->unset_userdata('UserType');
        $this->session->unset_userdata('AccountVerified');
        $this->session->unset_userdata('curr_user');
        $this->session->unset_userdata('UserCredit');
        $this->session->unset_userdata('credited_amount');
        redirect(base_url());
    }
}
