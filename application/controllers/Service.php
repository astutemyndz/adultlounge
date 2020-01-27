<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Service extends Common_Controller 
{
    public function __construct(){
        parent::__construct();
        $this->data['header'] = 'two';
        $this->checkAge();
        $this->checkLogin();
        $this->lang->load( ['error', 'profile'], 'english');
    }



    public function index() {
        
    }



    public function subscribe(){
        /*$credit = $this->db->query("select credit from users where id = '".$this->input->post('user_id')."'")->result();
        if($credit[0]->credit == 0){
            print 'notok~~Sorry !!! You\'ve No Credit to Subscribe !!!';
            die;
        }*/
        $chk = $this->cm->get_all('subscribe', array("user_id" => $this->input->post('user_id'), "performer_id" => $this->input->post('performer_id')));
        if(empty($chk)){
            $insertData = array(
                "user_id" => $this->input->post('user_id'),
                "performer_id" => $this->input->post('performer_id')
            );
            $this->cm->insert('subscribe', $insertData);
            print 'ok~~Successfully subscribed !!!~~Unsubscribe';
        }else{
            if($chk[0]->status == 0){
                $updateData = array(
                    "status" => 1,
                    "updated_at" => date('Y-m-d H:i:s')
                );
                $this->cm->update('subscribe', array("user_id" => $this->input->post('user_id'), "performer_id" => $this->input->post('performer_id')), $updateData);
                print 'ok~~Successfully subscribed !!!~~Unsubscribe';
            }else{
                $updateData = array(
                    "status" => 0,
                    "updated_at" => date('Y-m-d H:i:s')
                );
                $this->cm->update('subscribe', array("user_id" => $this->input->post('user_id'), "performer_id" => $this->input->post('performer_id')), $updateData);
                print 'ok~~Successfully un-subscribed !!!~~Subscribe';
            }
        }
    }



    public function vote(){
        if(empty($this->cm->get_all('vote', 
                                    array(
                                        "user_id" => $this->session->userdata('UserId'),
                                        "performer_id" => $this->input->post('performer_id'),
                                        "point" => $this->input->post('point')
                                    )))){
            $insertData = array(
                "user_id" => $this->session->userdata('UserId'),
                "performer_id" => $this->input->post('performer_id'),
                "point" => $this->input->post('point')
            );
            $this->cm->insert('vote', $insertData);
            print 'ok~~Thank you for your vote !!!';
        }else{
            print "notok~~You've already given vote to this performer !!!";
        }
    }



    public function subscriptionsList(){
        $join = array();
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = s.performer_id', 'type' => 'left'];
        $join[] = ['table' => 'users u', 'on' => 's.performer_id = u.id', 'type' => 'left'];
        $this->data['subs'] = $this->cm->select('subscribe s', array('s.user_id' => $this->session->userdata('UserId'), 's.status' => 1), 'u.id, u.name, u.image, up.display_name, u.usernm', 's.id', 'desc', $join);
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/my_subscriptions');
        $this->load->view('frontend/layout/footer');
    }



    public function subsSuggestion(){
        $query = "select u.id, u.name, u.image, u.usernm, up.display_name from subscribe s left join user_preference up ON up.user_id = s.performer_id left join users u ON s.performer_id = u.id where s.user_id = '".$this->session->userdata('UserId')."' AND s.status = 1";
        if($this->input->post('subs_search') != 'tmp'){
            $query .= " AND (up.display_name LIKE '%".$this->input->post('subs_search')."%' OR u.name LIKE '%".$this->input->post('subs_search')."%')";
        }
        $query .= " order by s.id desc limit 10";
        $this->data['subs'] = $this->db->query($query)->result_array();
        if(!empty($this->data['subs'])){
            $this->html = $this->load->view('frontend/pages/ajax_load', $this->data, TRUE);
            print $this->html;
        }else{
            print '<h3 class="no-subs">No Such Performer Found !!!</h3>';
        }
    }



    public function awards(){
        $this->db->select('PV.*, UT.name');
        $this->db->from('performer_video_gallery PV');
        $this->db->join('users UT', 'PV.user_id = UT.id');
        $this->data['performer_videos'] = $this->db->where('is_showing', '1')->get()->result();
        
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/awards');
        $this->load->view('frontend/layout/footer');
    }



    public function mySubscriptions(){
        $join[] = ['table' => 'users u', 'on' => 's.user_id = u.id', 'type' => 'left'];
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        $this->data['mySubs'] = $this->cm->select('subscribe s', array('s.performer_id' => $this->session->userdata('UserId'), 's.status' => 1), 'u.id, u.name, u.image, up.display_name, u.usernm', 's.id', 'desc', $join);
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/my-subscriptions');
        $this->load->view('frontend/layout/footer');
    }



    public function myShows(){
        if($this->session->userdata('UserType') == 1){
            $join[] = ['table' => 'users u', 'on' => 'vc.performer_id = u.id', 'type' => 'left'];
            $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = vc.performer_id', 'type' => 'left'];
            $this->data['myShows'] = $this->cm->select('video_chat vc', array('vc.user_id' => $this->session->userdata('UserId'), 'vc.status' => 2), 'u.id, u.name, u.image, up.display_name, u.usernm, vc.show_type, vc.created_at, vc.elapsed_time', 'vc.id', 'desc', $join);
        }else{
            $join[] = ['table' => 'users u', 'on' => 'vc.user_id = u.id', 'type' => 'left'];
            $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
            $this->data['myShows'] = $this->cm->select('video_chat vc', array('vc.performer_id' => $this->session->userdata('UserId'), 'vc.status' => 2), 'u.id, u.name, u.image, up.display_name, u.usernm, vc.show_type, vc.created_at, vc.elapsed_time', 'vc.id', 'desc', $join);
        }
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/my-shows');
        $this->load->view('frontend/layout/footer');
    }
    
    public function content(){
        $this->data['page'] = $this->db->where('id', 17)->from('static_pages')->get()->row();

        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/content');
        $this->load->view('frontend/layout/footer');
    }



    public function manageUsers(){
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/manageUsers');
        $this->load->view('frontend/layout/footer');
    }



    public function financial(){
        $this->data['page'] = $this->db->where('id', 16)->from('static_pages')->get()->row();

        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/financial');
        $this->load->view('frontend/layout/footer');
    }



    public function myNetwork(){
        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/myNetwork');
        $this->load->view('frontend/layout/footer');
    }



    public function loyalty(){
        $this->load->model('Loyalty_model', 'LP');
        $this->load->model('User_model', 'UT');
        $this->data['loyalty_plans'] = $this->LP->all();
        $this->data['current_user']  = $this->session->userdata('curr_user');
        $this->data['user_spent']    = $this->LP->user_spent_total($this->session->userdata('UserId'));

        $this->UT->applyForLoyaltyPoints($this->session->userdata('UserId'));

        $this->load->view('frontend/layout/header', $this->data);
        if($this->session->userdata('UserType') == 2) {
            $this->load->view('frontend/pages/loyalty-performer');
        } else {
            $this->load->view('frontend/pages/loyalty');
        }
        $this->load->view('frontend/layout/footer');
    }



    public function help(){        
        $this->data['page'] = $this->db->where('id', 11)->from('static_pages')->get()->row();

        $this->load->view('frontend/layout/header', $this->data);
        $this->load->view('frontend/pages/help');
        $this->load->view('frontend/layout/footer');
    } 


    public function uploadVideo()
    {
        $user_id = $this->session->userdata('UserId');
        $files = $_FILES;
        $filename = $this->videoFileUpload(
            'assets/profile_videos/', 
            $files['video_file']['name'], 
            'video_file'
        );

        if ($filename) {
            $this->cm->insert('performer_video_gallery', [
                'user_id'    => $user_id,
                //'video_type' => $this->input->post('video_type'),
                'type'       => $this->input->post('type'),
                'video'      => $filename,
            ]);

            echo json_encode([
                'success'   => true,
                'message'   => $this->lang->line('video_upload_ok'),
                'video_url' => base_url('assets/profile_videos/' . $filename)
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => $this->lang->line('general_error_msg')
            ]);
        }


    }

}
