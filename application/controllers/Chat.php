<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Chat extends Common_Controller {

    public function __construct(){
        parent::__construct();
        $this->checkLogin();
    }
    


    public function index() {
        $join = array();
        $sender = $this->cm->select('chat c', array('c.receiver_id' => $this->session->userdata('UserId')), 'DISTINCT(sender_id)', 'c.id', 'DESC', $join);
        $receiver = $this->cm->select('chat c', array('c.sender_id' => $this->session->userdata('UserId')), 'DISTINCT(receiver_id)', 'c.id', 'DESC', $join);
        $user = array();
        $userList = '';

        //print_r($receiver); die;


        if(!empty($sender)){
            foreach($sender as $sndr){
                array_push($user, $sndr['sender_id']);
                if($userList == ''){
                    $userList .= $sndr['sender_id'];
                }else{
                    $userList .= ','.$sndr['sender_id'];
                }
            }
        }
        
        if(!empty($receiver)){
            foreach($receiver as $rcvr){
                if (!in_array($rcvr['receiver_id'], $user)){
                    array_push($user, $rcvr['receiver_id']);
                    if($userList == ''){
                        $userList .= $rcvr['receiver_id'];
                        }else{
                        $userList .= ','.$rcvr['receiver_id'];
                        }
                }
            }
        }
        if(!empty($user)){
            $sql = "SELECT u.id, u.name, u.image, u.usernm, up.display_name, 
            (select msg from chat where ((sender_id = u.id AND receiver_id = '".$this->session->userdata('UserId')."') OR (receiver_id = u.id AND sender_id = '".$this->session->userdata('UserId')."')) order by id desc limit 1) chat,
            (select created_at from chat where sender_id = u.id OR receiver_id = u.id order by id desc limit 1) time FROM `users` u 
            LEFT JOIN user_preference up ON up.user_id = u.id WHERE u.id in (".$userList.")";
            $this->data['chatList'] = $this->db->query($sql)->result();
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
        }else{
            $this->html = '<span class="no-msg-avlabl">No Chat Available !!!</span>';
        }
        print($this->html);
    }



    public function fullChatDetails() {
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        $this->data['sessImg'] = $this->cm->select('users u', array('u.id' => $this->session->userdata('UserId')), 'u.name, u.usernm, u.image, up.display_name', 'u.id', 'desc', $join);
        $this->data['usrImg'] = $this->cm->select('users u', array('u.id' => $this->input->post('user_id')), 'u.id, u.name, u.usernm, u.image, up.display_name', 'u.id', 'desc', $join);
        $this->data['fullChat'] = $this->cm->get_chat($this->session->userdata('UserId'), $this->input->post('user_id'));
        $this->data['user_id'] = $this->input->post('user_id');

        // write_log($this->data);

        $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
        print($this->html);
    }



    public function deleteChat() {
        $this->db->query("DELETE FROM `chat` WHERE (sender_id = '".$this->session->userdata('UserId')."' AND receiver_id = '".$this->input->post('user_id')."') OR (receiver_id = '".$this->session->userdata('UserId')."' AND sender_id = '".$this->input->post('user_id')."')");
    }



    public function sendChat() {
        if($this->input->post('chat_msg')){
            $insertData = array(
                "sender_id"     => $this->input->post('sender_id'),
                "sender_type"   => $this->input->post('sender_type'),
                "receiver_id"   => $this->input->post('receiver_id'),
                "receiver_type" => $this->input->post('receiver_type'),
                "msg"           => $this->input->post('chat_msg'),
                "send_stat"     => 0
            );

            $chat_id = $this->cm->insert('chat', $insertData);
            $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
            $this->data['sndrImg'] = $this->cm->select('users u', array('u.id' => $this->input->post('sender_id')), 'u.id, u.name, u.usernm, u.image, up.display_name', 'u.id', 'desc', $join);
            $this->data['msg'] = $this->input->post('chat_msg');
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
            print $chat_id.'~~'.$this->html;
        }
    }



    public function checkNewMsg() {
        $chat = $this->db->query("select * from chat where ((sender_id = '".$this->session->userdata('UserId')."' AND receiver_id = '".$this->input->post('rec_id')."') OR (receiver_id = '".$this->session->userdata('UserId')."' AND sender_id = '".$this->input->post('rec_id')."')) AND id > '".$this->input->post('last_chat_id')."' AND send_stat = 0 order by id ASC")->result();        
        if(!empty($chat)){
            $data['newChat'] = $chat;
            $html = $this->load->view('frontend/pages/ajax_load', $data, TRUE);
            $data['newChat'] = array();
            $data['newChatTwo'] = $chat;
            $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
            $data['sessImg'] = $this->cm->select('users u', array('u.id' => $this->session->userdata('UserId')), 'u.name, u.usernm, u.image, up.display_name', 'u.id', 'desc', $join);
            $data['usrImg'] = $this->cm->select('users u', array('u.id' => $this->input->post('rec_id')), 'u.id, u.name, u.usernm, u.image, up.display_name', 'u.id', 'desc', $join);
            $htmlTwo = $this->load->view('frontend/pages/ajax_load', $data, TRUE);
            $last_chat_id = '';
            for($i=0; $i<count($chat); $i++){
                $last_chat_id = $chat[$i]->id;
            }
			$data = array( 
				'send_stat'   => 1 
			);
			$this->db->where('id', $last_chat_id);
			$this->db->update('chat', $data);
        }else{
            $html = '';
            $htmlTwo = '';
            $last_chat_id = '';
        }
        print $last_chat_id.'~~'.$html.'~~'.$htmlTwo;
    }



    public function searchUser() {
        $usrnm = $this->db->query("select u.id, u.name, up.display_name, u.image, u.usernm from users u left join user_preference up on up.user_id = u.id where (u.name LIKE  '%".$this->input->post('user_sugg')."%' OR u.usernm LIKE '%@".$this->input->post('user_sugg')."%' OR up.display_name LIKE '%".$this->input->post('user_sugg')."%') AND u.status = '1' AND u.login_type = '2' order by u.id desc limit 10")->result();
        if(!empty($usrnm)){
            $this->data['userSugg'] = $usrnm;
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
        }
        print $this->html;
    }
}
