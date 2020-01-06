<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_Controller extends CI_Controller {
	protected $data = array();
    protected $html = '';
    
	function __construct() {
     	parent::__construct();
    }
    


    public function checkAge(){
        if(!$this->session->userdata('setAge')){
            redirect(base_url());
        }
    }



    public function checkLogin(){
        if(!$this->session->userdata('UserId')){
            redirect(base_url('login'));
        }
    }



    public function getUserDetails($id = ''){
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        $user = $this->cm->select('users u', array('u.id' => $id), 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.address_one, u.address_two, u.city, u.country, u.pincode, u.dob, u.i_am_a, u.us_citizen, u.isLogin, u.credit, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.pubic_hair, up.penis, up.description, up.burst, up.cup, up.display_name, up.category, up.attribute, up.willingness, up.appearance, up.feature, up.receiveEmail, up.allowContact, up.saveHistory, up.maxCredit, up.creditLimit, up.blockMessage, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images, (select GROUP_CONCAT(pvg.video) from performer_video_gallery pvg where pvg.user_id = u.id) videos', 'u.id', 'desc', $join);

        return $user;
    }



    public function getPerformerDetails($isVerified = '', $id = '', $type = '', $checkId = ''){
        $condition = array(
            'u.login_type'          => '2',
            'u.status'              => '1'
        );
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
        $performer = $this->cm->select('users u', $condition, 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, up.cup, up.pubic_hair, up.penis, up.description, up.category, up.attribute, up.willingness, up.appearance, up.feature, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images', 'u.id', 'desc', $join);

        return $performer;
    }



    public function getCommonMenu(){
        $this->data['show'] = $this->cm->get_specific('show_type', array("status" => 1));
        $this->data['service'] = $this->cm->get_specific('services', array("status" => 1));
        $this->data['age'] = $this->db->query("select distinct age from users where login_type = '2' ORDER BY age ASC")->result();
        $this->data['categories'] = $this->cm->get_specific('categories', array("status" => 1));
        $this->data['will'] = $this->cm->get_specific('willingness', array("status" => 1));
        $this->data['appearence'] = $this->cm->get_specific('appearence', array("status" => 1));
    }



    public function getNewSubs($condition = array()){
        $join[] = ['table' => 'users u', 'on' => 'u.id = s.user_id', 'type' => 'left'];
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        return $this->cm->select('subscribe s', $condition, 'u.name, u.usernm, u.image, up.display_name', 's.id', 'desc', $join, '10', '0');
    }



    public function getShowHistory($condition = array()){
        $join[] = ['table' => 'users u', 'on' => 'vc.user_id = u.id', 'type' => 'left'];
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        return $this->cm->select('video_chat vc', $condition, 'vc.user_id, vc.elapsed_time, vc.show_type, vc.created_at, u.image, u.name, u.usernm, up.display_name', 'vc.id', 'desc', $join, '10', '0');
    }



    public function getSubsPerformer($condition = array()){
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = s.performer_id', 'type' => 'left'];
        $join[] = ['table' => 'users u', 'on' => 's.performer_id = u.id', 'type' => 'left'];
        return $this->cm->select('subscribe s', $condition, 'u.id, u.name, u.image, up.display_name, u.usernm', 's.id', 'desc', $join, '5', '0');
    }



    public function getHistoryPerformer($condition = array()){
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = vc.performer_id', 'type' => 'left'];
        $join[] = ['table' => 'users u', 'on' => 'vc.performer_id = u.id', 'type' => 'left'];
        return  $this->cm->select('video_chat vc', $condition, 'u.id, u.name, u.image, up.display_name, u.usernm', 'vc.id', 'desc', $join, '5', '0');
    }



    public function getPerformerWillingNess($data = ''){
        $will = $this->db->query("select GROUP_CONCAT(w.name) will from willingness w where w.id IN (".$data.")")->result();
        if(!empty($will)){
            return $will[0]->will;
        }else{
            return $data;
        }
    }



    public function getPerformerAttribute($data = ''){
        $attr = $this->db->query("select GROUP_CONCAT(st.name) attr from show_type st where st.id IN (".$data.")")->result();
        if(!empty($attr)){
            return $attr[0]->attr;
        }else{
            return $data;
        }
    }



    public function getWalletAmonut($id = ''){
        return $this->cm->get_all('wallet', array('user_id' => $this->session->userdata('UserId')));
    }



    public function getVoteDetails($id = ''){
        $vote = array(
                    "rank" => 0,
                    "vote" => 0,
                );
        //$voting = $this->db->query('SELECT DISTINCT performer_id, count(id) vote FROM `vote` ORDER BY vote DESC')->result();
        $voting = $this->db->query('SELECT DISTINCT v.performer_id, (select count(vt.id) from vote vt where vt.performer_id = v.performer_id) vote FROM `vote` v ORDER BY vote DESC')->result();
        if(!empty($voting)){
            $rank = 1;
            foreach($voting as $vot){
                if($id == $vot->performer_id){
                    $vote = array(
                                "rank" => $rank,
                                "vote" => $vot->vote,
                            );
                    break;
                }
                $rank++;
            }
        }
        return $vote;
    }
    /*public function getPoint(){
        $data['edit_data'] = $this->cm->select_row('vote', ['id' => $edit_id], '');
        return $vote;
    }*/



    public function commonFileUpload($path = '', $imageName = '', $imageInputName = '', $oldImage = ''){
        $pro_image = '';
        $upPath = FCPATH . $path;
        if (!file_exists($upPath)) {
            mkdir($upPath, 0777, true);
        }
        $config = array(
            'upload_path' => $upPath,
            'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|GIF|PNG",
            'overwrite' => TRUE,
            // 'max_size' => "8192000",
            /*'max_height' => "1536",
            'max_width' => "2048",*/
            'encrypt_name' => TRUE
        );
        $config['file_name'] = time().$imageName;
        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($imageInputName)) {
            $imageDetailArray = $this->upload->data();
            $pro_image = $imageDetailArray['file_name'];
            if($oldImage != ''){
                if (file_exists($upPath.$oldImage)) {
                    unlink($upPath.$oldImage);
                }
            }
        }else{
            $res = $this->upload->display_errors();
        }
        return $pro_image;
    }



    public function commonFileArrayUpload($path = '', $fileArray = array(), $db = '', $oldArray = array()){
        $upPath = FCPATH . $path;
        if (!file_exists($upPath)) {
            mkdir($upPath, 0777, true);
        }
        $config = array(
            'upload_path' => $upPath,
            'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|GIF|PNG",
            'overwrite' => TRUE,
            'max_size' => "8192000",
            /*'max_height' => "1536",
            'max_width' => "2048",*/
            'encrypt_name' => TRUE
        );
        $newArray = array();
        for($p = 0; $p<count($fileArray); $p++){

            if($fileArray[$p] !='' ){
                $newArray = $oldArray;
                $_FILES['file']['name']     = $fileArray[$p];
                $_FILES['file']['type']     = $fileArray[$p];
                $_FILES['file']['tmp_name'] = $fileArray[$p];
                $_FILES['file']['error']    = $fileArray[$p];
                $_FILES['file']['size']     = $fileArray[$p];
                $config['file_name']        = time().$fileArray[$p];
                $this->upload->initialize($config);

                write_log($fileArray);                

                if($this->upload->do_upload('file')){
                    $imageDetailArray = $this->upload->data();
                    $newArray['image'] = $imageDetailArray['file_name'];
                    $this->cm->insert($db, $newArray);
                    // write_log($this->db->last_query());
                }
            }
        }
    }


    public function galleryFilesUpload( $path = '', $filesArray = array(), $tableName = '', $oldArray = array() ) {
        $upPath = FCPATH . $path;
        
        if (!file_exists($upPath)) {
            mkdir($upPath, 0755, true);
        }

        $config = array(
            'upload_path'   => $upPath,
            'allowed_types' => "gif|jpg|png|jpeg|JPEG|JPG|GIF|PNG",
            'overwrite'     => TRUE,
            'max_size'      => "8192000",
            'encrypt_name'  => TRUE
        );
        $newArray = array();
        
        foreach ($filesArray['name'] as $key => $name) {
            $newArray = $oldArray;
            $_FILES['images[]']['name']     = $name;
            $_FILES['images[]']['type']     = $filesArray['type'][$key];
            $_FILES['images[]']['tmp_name'] = $filesArray['tmp_name'][$key];
            $_FILES['images[]']['error']    = $filesArray['error'][$key];
            $_FILES['images[]']['size']     = $filesArray['size'][$key];            

            $this->upload->initialize($config);

            if ($this->upload->do_upload('images[]')) {
                $imageDetailArray = $this->upload->data();
                $newArray['image'] = $imageDetailArray['file_name'];
                $this->cm->insert($tableName, $newArray);
            } else {
                write_log('File not uploaded');
            }
        }
    }


    public function videoFileUpload($path = '', $videoName = '', $videoInputName = '', $oldVideo = ''){
        $video = '';
        $upPath = FCPATH . $path;

        if (!file_exists($upPath)) {
            mkdir($upPath, 0755, true);
        }

        $config = array(
            'upload_path'   => $upPath,
            'allowed_types' => "mp4|webm",
            'overwrite'     => TRUE,
            'encrypt_name'  => TRUE
        );

        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload($videoInputName)) {
            $videoDetailArray = $this->upload->data();
            $video = $videoDetailArray['file_name'];

            if($oldVideo != ''){
                if (file_exists($upPath.$oldVideo)) {
                    unlink($upPath.$oldVideo);
                }
            }

            return $video;
        } else{
            $res = $this->upload->display_errors();
            write_log($res);
            return $video;
        }

        return $video;
    }

}
?>