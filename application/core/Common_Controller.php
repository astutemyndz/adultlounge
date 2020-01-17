<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Common_Controller extends CI_Controller {
    protected $data = array();
    public $performer;
    public $sexualPref;
    protected $html = '';
    protected $request      			= array();
    protected $response     			= array();
    protected $option     			= array();
    protected $filterData;
    public $q;
    const HTTP_CONTINUE = 100;
    const HTTP_SWITCHING_PROTOCOLS = 101;
    const HTTP_PROCESSING = 102;            // RFC2518
    const HTTP_EARLY_HINTS = 103;           // RFC8297
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_ACCEPTED = 202;
    const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
    const HTTP_NO_CONTENT = 204;
    const HTTP_RESET_CONTENT = 205;
    const HTTP_PARTIAL_CONTENT = 206;
    const HTTP_MULTI_STATUS = 207;          // RFC4918
    const HTTP_ALREADY_REPORTED = 208;      // RFC5842
    const HTTP_IM_USED = 226;               // RFC3229
    const HTTP_MULTIPLE_CHOICES = 300;
    const HTTP_MOVED_PERMANENTLY = 301;
    const HTTP_FOUND = 302;
    const HTTP_SEE_OTHER = 303;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_USE_PROXY = 305;
    const HTTP_RESERVED = 306;
    const HTTP_TEMPORARY_REDIRECT = 307;
    const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_PAYMENT_REQUIRED = 402;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    const HTTP_REQUEST_TIMEOUT = 408;
    const HTTP_CONFLICT = 409;
    const HTTP_GONE = 410;
    const HTTP_LENGTH_REQUIRED = 411;
    const HTTP_PRECONDITION_FAILED = 412;
    const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
    const HTTP_REQUEST_URI_TOO_LONG = 414;
    const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    const HTTP_EXPECTATION_FAILED = 417;
    const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
    const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
    const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
    const HTTP_LOCKED = 423;                                                      // RFC4918
    const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918

    /**
     * @deprecated
     */
    const HTTP_RESERVED_FOR_WEBDAV_ADVANCED_COLLECTIONS_EXPIRED_PROPOSAL = 425;   // RFC2817
    const HTTP_TOO_EARLY = 425;                                                   // RFC-ietf-httpbis-replay-04
    const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    const HTTP_PRECONDITION_REQUIRED = 428;                                       // RFC6585
    const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = 451;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_NOT_IMPLEMENTED = 501;
    const HTTP_BAD_GATEWAY = 502;
    const HTTP_SERVICE_UNAVAILABLE = 503;
    const HTTP_GATEWAY_TIMEOUT = 504;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
    const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = 506;                        // RFC2295
    const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    const HTTP_NOT_EXTENDED = 510;                                                // RFC2774
    const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;                             // RFC6585
    const HTTP_NOT_CHANGED = 512;                             // RFC6585
    const HTTP_INVALID_RESET_PASSWORD_LINK = 513;                             // RFC6585

    

    /**
     * Status codes translation table.
     *
     * The list of codes is complete according to the
     * {@link https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml Hypertext Transfer Protocol (HTTP) Status Code Registry}
     * (last updated 2016-03-01).
     *
     * Unless otherwise noted, the status code is defined in RFC2616.
     *
     * @var array
     */
    public static $statusTexts = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',            // RFC2518
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',          // RFC4918
        208 => 'Already Reported',      // RFC5842
        226 => 'IM Used',               // RFC3229
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',    // RFC7238
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',                                               // RFC2324
        421 => 'Misdirected Request',                                         // RFC7540
        422 => 'Unprocessable Entity',                                        // RFC4918
        423 => 'Locked',                                                      // RFC4918
        424 => 'Failed Dependency',                                           // RFC4918
        425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
        426 => 'Upgrade Required',                                            // RFC2817
        428 => 'Precondition Required',                                       // RFC6585
        429 => 'Too Many Requests',                                           // RFC6585
        431 => 'Request Header Fields Too Large',                             // RFC6585
        451 => 'Unavailable For Legal Reasons',                               // RFC7725
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
		511 => 'Network Authentication Required',
		512 => 'Not Changed',                    // RFC6585
		513 => 'Reset Password Link is Invalid!'                            // RFC6585
    ];
	function __construct() {
     	parent::__construct();
    }
    
    public function setPerformer($value) {
        $this->performer = $value;
        return $this;
    }
    public function setQ($value) {
        $this->q = $value;
        return $this;
    }
    public function setSexualPref($value) {
        $this->sexualPref = $value;
        return $this;
    }
    
    protected function get($key)
	{
		if ($this->has($key))
		{
			return $this->input->get($key);
		}
		return false;
	}
	protected function post($key)
	{
		if ($this->has($key))
		{
			return $this->input->post($key);
		}
		return false;
	}
	protected function setCookie($array = array(), $XSSFilter  = TRUE)
	{
		$this->input->cookie($array, $XSSFilter); // with XSS filter
		return $this;
	}
	
	
	protected function has($key)
	{
		return (!empty($key) && $key !== NULL);
	}

	protected function getSession($key)
	{
		return $this->session->userdata($key);
	}
	
	protected function hasSession($key)
	{
		if($this->getSession($key)) {
			return true;
		}
		return false;
	}
	
	protected function setSession($key, $value)
	{
		$this->session->set_userdata($key, $value);
		return $this;
	}
	protected function unsetSession($key) {
		if($this->hasSession($key)) {
			return $this->session->unset_userdata($key);
		}
		return false;
	}
	public function isXHR()
    {
       
        return @$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }
	public function getForeignId()
    {
    	return 1;
	}
	public function setAjax($value)
    {
        
        $this->ajax = (bool) $value;
        return $this;
    }
    public function setRequest(array $request) 
	{
		foreach($request as $key => $value){
			$this->request[$key] = $request[$key];
		}
    	return $this;
	}
    public function setResponse($response) {
        $this->response = $response;
        return $this;
    }
    
    public function setFilterData($value) {
        $this->filterData = $value;
        return $this;
    }
    public function checkAge(){
        if(!$this->session->userdata('setAge')){
            redirect(base_url());
        }
    }
    public function isAjaxRequest() {
        if ($this->input->is_ajax_request()) {
            return true;
        }
         return false;
    }
    public function isPost() {
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            return true;
        }
        return false;
	}
	public function setUserId($userId) {
        $this->userId = $userId;
        return $this;
	}
	public function setUser($user) {
		$this->user = $user;
		return $this;
	}

    public function checkLogin(){
        if(!$this->session->userdata('UserId')){
            redirect(base_url('login'));
        }
    }
    public function setOption($option) {
        $this->option = $option;
        return $this;
    }

    public function getUserDetails($id = ''){
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];
        $user = $this->cm->select('users u', array('u.id' => $id), 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.address_one, u.address_two, u.city, u.country, u.pincode, u.dob, u.i_am_a, u.us_citizen, u.isLogin, u.credit, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.pubic_hair, up.penis, up.description,up.currency, up.price_in_private,up.price_in_group,up.performer_type, up.burst, up.cup, up.display_name, up.category, up.attribute, up.willingness, up.appearance, up.feature, up.receiveEmail, up.allowContact, up.saveHistory, up.maxCredit, up.creditLimit, up.blockMessage, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images, (select GROUP_CONCAT(pvg.video) from performer_video_gallery pvg where pvg.user_id = u.id) videos', 'u.id', 'desc', $join);
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
        $performer = $this->cm->select('users u', $condition, 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, up.cup, up.pubic_hair, up.penis, up.description,up.currency, up.price_in_private,up.price_in_group, up.category, up.attribute, up.willingness, up.appearance, up.feature, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images', 'u.id', 'desc', $join);
        return $performer;
    }

    public function getCommonMenu(){
        $this->data['show'] = $this->cm->get_specific('show_type', array("status" => 1));
        $this->data['service'] = $this->cm->get_specific('services', array("status" => 1));
        $this->data['age'] = $this->db->query("select distinct age from users where login_type = '2' ORDER BY age ASC")->result();
        $this->data['categories'] = $this->cm->get_specific('categories', array("status" => 1));
        $this->data['will'] = $this->cm->get_specific('willingness', array("status" => 1));
        $this->data['appearence'] = $this->cm->get_specific('appearence', array("status" => 1));

        // echo "<pre>";
        // print_r($this->data);

        // exit;
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