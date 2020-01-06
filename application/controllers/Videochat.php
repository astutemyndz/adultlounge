<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Videochat extends Common_Controller {
    public function __construct(){
        parent::__construct();
        $this->checkLogin();
        $this->data['header'] = 'two';
    }
    public function index() {
        $this->data['chat'] = $this->db->query("select c.id, c.sender_id, u.usernm sender_unm, c.receiver_id, up.usernm receiver_unm, c.msg, c.created_at from chat c left JOIN users u ON u.id = c.sender_id left JOIN users up ON up.id = c.receiver_id where (c.sender_id = '".$this->session->userdata('UserId')."' AND c.receiver_id = '".$this->session->userdata('vcPerformerId')."') OR (c.sender_id = '".$this->session->userdata('vcPerformerId')."' AND c.receiver_id = '".$this->session->userdata('UserId')."') order by c.id ASC")->result();
        $this->data['subs'] = $this->cm->get_all('subscribe', array("user_id" => $this->session->userdata('UserId'), "performer_id" => $this->session->userdata('vcPerformerId')));
        $this->data['usrnm'] = $this->db->query("select u.name, up.display_name from users u left join user_preference up on up.user_id = u.id where u.id = '".$this->session->userdata('UserId')."'")->result();       
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/video_chat');
        $this->load->view('frontend/layout/footer');
    }
    public function videoChatStart(){
        $chk = $this->cm->get_specific('users', array("id" => $this->input->post('performer_id')));
        if($chk[0]->isLogin == '1' && $chk[0]->hasWebcam == 'Y'){
            if(empty($this->db->query("select id from video_chat where performer_id = '".$this->input->post('performer_id')."' AND (status = '0' OR status = '1') order by id asc limit 0, 1")->result())){
                $insertArray = array(
                    "user_id"       => $this->session->userdata('UserId'),
                    "performer_id"  => $this->input->post('performer_id'),
                    "url_hash"      => $this->input->post('url_hash')
                );
                $chat_id = $this->cm->insert('video_chat', $insertArray);
                $this->session->set_userdata('vcPerformerId', $this->input->post('performer_id'));
                $this->session->set_userdata('vcPerformerId', $this->input->post('performer_id'));
                $this->session->set_userdata('vcChatId', $chat_id);
                print 'ok';
            }else{
                print 'busy';
            }
        }else{
            print 'notok';
        }
    }
    public function checkNewVideoChatRequest(){
        $chk = $this->cm->get_all('video_chat', array("performer_id" => $this->input->post('performer_id'), "status" => '0'), '1', '0');
        if(!empty($chk)){
            $usrnm = $this->db->query("select u.id, u.name, up.display_name from users u left join user_preference up on up.user_id = u.id where u.id = '".$chk[0]->user_id."'")->result();
            if($usrnm[0]->display_name != ''){
                $nm = $usrnm[0]->display_name;
            }else{
                $nm = $usrnm[0]->name;
            }
            print $chk[0]->url_hash.'~~'.$nm.'~~'.$usrnm[0]->id;
        }else{
            print 'no-request';
        }
    }
    public function cancelVideoChat(){
        $this->cm->update('video_chat', array("performer_id" => $this->input->post('performer_id'), "url_hash" => $this->input->post('url_hash'), "user_id" => $this->input->post('user_id')), array("elapsed_time" => '0', "status" => '3'));
    }
    public function acceptVideoChat(){
        $this->session->set_userdata('vcUserId', $this->input->post('user_id'));        
        $this->cm->update('video_chat', array("performer_id" => $this->input->post('performer_id'), "url_hash" => $this->input->post('url_hash'), "user_id" => $this->input->post('user_id')), array("status" => '1'));
    }
    public function checkVideoChatStatus(){
        $chk = $this->cm->get_specific('video_chat', array("id" => $this->input->post('chat_id')));
        if($chk[0]->status == '3'){
            $usrnm = $this->db->query("select u.name, up.display_name from users u left join user_preference up on up.user_id = u.id where u.id = '".$chk[0]->performer_id."'")->result();
            if($usrnm[0]->display_name != ''){
                $nm = $usrnm[0]->display_name;
            }else{
                $nm = $usrnm[0]->name;
            }
            print 'notok~~'.$chk[0]->performer_id.'~~'.strtolower(str_replace(' ', '_', $nm));
        }
    }
    public function checkVideoChatStatusPerformer(){
        $chk = $this->cm->get_specific('video_chat', array("performer_id" => $this->input->post('performer_id'), "url_hash" => $this->input->post('url_hash'), "user_id" => $this->input->post('user_id')));
        if($chk[0]->status == '2'){
            print 'ok';
        }
    }
    public function hangupVideoChat(){
        $tmp = $this->input->post('elapsedTime');
        $time = floor(((int)$tmp)/60) .' min '. (((int)$tmp)%60). ' sec';
        $this->cm->update('video_chat', array("id" => $this->input->post('chat_id')), array("elapsed_time" => $time, "status" => '2'));
        $usrnm = $this->db->query("select u.name, up.display_name from users u left join video_chat vc on vc.performer_id = u.id left join user_preference up on up.user_id = u.id where vc.performer_id = '".$this->input->post('vcPerformerId')."'")->result();
        if($usrnm[0]->display_name != ''){
            $nm = $usrnm[0]->display_name;
        }else{
            $nm = $usrnm[0]->name;
        }
        print $this->input->post('vcPerformerId').'~~'.strtolower(str_replace(' ', '_', $nm));
    }
    public function vcSendChat(){
        $insertData = array(
            "sender_id"     => $this->input->post('sender_id'),
            "sender_type"   => $this->input->post('sender_type'),
            "receiver_id"   => $this->input->post('receiver_id'),
            "receiver_type" => $this->input->post('receiver_type'),
            "msg"           => $this->input->post('chat_msg')
        );
        $chat_id = $this->cm->insert('chat', $insertData);
        $usrnm = $this->cm->get_specific('users', array("id" => $this->input->post('sender_id')));
        print $chat_id.'~~'.$usrnm[0]->usernm;
    }
    public function vcCheckNewText(){
        $vcNewChat = $this->db->query("select c.id, c.sender_id, u.usernm sender_unm, c.receiver_id, up.usernm receiver_unm, c.msg, c.created_at from chat c left JOIN users u ON u.id = c.sender_id left JOIN users up ON up.id = c.receiver_id where ((c.sender_id = '".$this->input->post('receiver_id')."' AND c.receiver_id = '".$this->input->post('sender_id')."') OR (c.sender_id = '".$this->input->post('sender_id')."' AND c.receiver_id = '".$this->input->post('receiver_id')."')) AND c.id > '".$this->input->post('last_id')."' order by c.id ASC")->result();
        $last_chat_id = '';
        if(!empty($vcNewChat)){
            $this->data['vcNewChat'] = $vcNewChat;
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
            for($i=0; $i<count($vcNewChat); $i++){
                $last_chat_id = $vcNewChat[$i]->id;
            }
        }
        print $last_chat_id.'~~'.$this->html;
    }
    public function checkWebcamPerformer(){
        $this->cm->update('users', array("id" => $this->input->post('performer_id')), array("hasWebcam" => $this->input->post('hasCamera')));
    }
}
