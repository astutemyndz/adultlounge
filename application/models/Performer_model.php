<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Performer_model extends CI_model {
    
    public $tables;
    public $conditions;
    public $data;

    public $categories;
    public $appearances;
    public $showTypes;
    public $willingness;
    public $userId;
    public $image = array();
    public $video = array();
    public $query;
    public $content;

    public $performerID;
    public $customerID;
    public $isFreeContent;

    public function __construct(){
        parent::__construct();
        $this->init();
    }

    public function init() {
        $this->tables['users']                   = 'users';
        $this->tables['categories']                   = 'categories';
        $this->tables['show_type']                   = 'show_type';
        $this->tables['appearance']                   = 'appearence';
        $this->tables['willingness']                   = 'willingness';

        // Mapping tables
        $this->tables['user_preference']       = 'user_preference';

        $this->tables['users_appearance']       = 'users_appearence';
        $this->tables['users_show_type']        = 'users_show_type';
        $this->tables['users_categories']       = 'users_categories';
        $this->tables['users_willingness']      = 'users_willingness';
        $this->tables['performer_gallery']      = 'performer_gallery';
        $this->tables['performer_video_gallery']      = 'performer_video_gallery';
        $this->tables['subscribe']      = 'subscribe';

    }
    
    public function setImage($value) {
        $this->image = $value;
        return $this;
    }
    public function setVideo($value) {
        $this->video = $value;
        return $this;
    }
    public function getContent() {
        return $this->content;
    }
    public function setCustomerID($value) {
        $this->customerID = $value;
        return $this;
    }
    public function setPerformerID($value) {
        $this->performerID = $value;
        return $this;
    }
    public function setIsFreeContent($value) {
        $this->isFreeContent = $value;
        return $this;
    }
    public function search() {
        
    }
    public function all($verifiedAccount = false, $option = array()){
        $condition = array(
            'u.login_type'          => '2',
            'u.status'              => '1'
        );
        // if($sexual_pref != '') {
        //     $condition['u.sexual_pref'] = $sexual_pref;
        // }
        if(!empty($option) && isset($option)) {
            if(is_array($option)) {
                if(array_key_exists('name', $option) && in_array($option['name'], $option)) {
                    $condition['up.display_name LIKE'] = '%'.$option['name'].'%';
                }
            }
        }
        
        
        if($verifiedAccount){
            $condition['u.account_verified'] = 'Yes';
        } else {
            $condition['u.account_verified'] = 'No';
        }
        // if($id != ''){
        //     $condition['u.id'] = $id;
        // }
        // if($type == '' && $checkId != ''){
        //     $condition['u.age'] = $checkId;
        // }
        // if($type != '' && $checkId != ''){
        //     $condition['up.'.$type.' LIKE '] = '%'.$checkId.'%';
        // }
        $join[] = ['table' => 'user_preference up', 'on' => 'up.user_id = u.id', 'type' => 'left'];        
        $performer = $this->cm->select('users u', $condition, 'u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, up.cup, up.pubic_hair, up.penis, up.description,up.currency, up.price_in_private,up.price_in_group, up.category, up.attribute, up.willingness, up.appearance, up.feature, (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images', 'u.id', 'desc', $join);

        return $performer;
    }
    public function getFreeContent($options = array()) {
        if(!empty($options) && is_array($options)) {
            if(array_key_exists('performer_id', $options) && isset($options['performer_id']) && !empty($options['performer_id'])) {
                $this->setPerformerID($options['performer_id']);
            }
            if(array_key_exists('customer_id', $options) && isset($options['customer_id']) && !empty($options['customer_id'])) {
                $this->setCustomerID($options['customer_id']);
            }
            if(array_key_exists('isFreeContent', $options) && isset($options['isFreeContent']) && !empty($options['isFreeContent'])) {
                $this->setIsFreeContent($options['isFreeContent']);
            }
        }

        $this->data['videos'] = array();
        $this->data['images'] = array();
        if($this->performerID && $this->customerID) {
                $imagRows = $this->db->from($this->tables['performer_gallery'].' as pg')
                                    ->select('pg.user_id as modelID,pg.image')
                                    ->where(array(
                                            'pg.type' => '1',
                                            'pg.user_id' => $this->performerID
                                        ))->get()
                                    ->result_array();
                if(!empty($imagRows)) {
                    foreach($imagRows as $imagRow) {
                        $this->data['images'][] = array(
                            'modelID'       => $imagRow['modelID'],
                            'customerID'    => $this->customerID,
                            'imagePath'     => 'assets/performer_gallery/'.$imagRow['image'],
                        );
                    }
                    $this->setImage($this->data);
                }

                $videoRows = $this->db->from($this->tables['performer_video_gallery'].' as pvg')
                                                    ->select('pvg.user_id as modelID,pvg.video')
                                                    ->where(array(
                                                            'pvg.type' => '1',
                                                            'pvg.user_id' => $this->performerID
                                                        ))->get()
                                                    ->result_array();
                if(!empty($videoRows)) {
                    foreach($videoRows as $videoRow) {
                        $this->data['videos'][] = array(
                            'modelID' => $videoRow['modelID'],
                            'customerID' => $this->customerID,
                            'videoPath' => 'assets/profile_videos/'.$videoRow['video'],
                        );
                    }
                    $this->setVideo($this->data);
                } 
            
            return $this->data;
        }
    }
    public function getPremiumContent($options = array()) {
        if(!empty($options) && is_array($options)) {
            if(array_key_exists('performer_id', $options) && isset($options['performer_id']) && !empty($options['performer_id'])) {
                $this->setPerformerID($options['performer_id']);
            }
            if(array_key_exists('customer_id', $options) && isset($options['customer_id']) && !empty($options['customer_id'])) {
                $this->setCustomerID($options['customer_id']);
            }
            if(array_key_exists('isFreeContent', $options) && isset($options['isFreeContent']) && !empty($options['isFreeContent'])) {
                $this->setIsFreeContent($options['isFreeContent']);
            }
        }
        $this->data['videos'] = array();
        $this->data['images'] = array();
        if($this->performerID && $this->customerID) {
            
            $subscribeVideos = $this->db->from($this->tables['performer_video_gallery'].' as pvg')
                                ->join('subscribe as sb', 'sb.performer_id = pvg.user_id')
                                ->select('pvg.user_id as modelID,sb.user_id as customerID, pvg.video')
                                ->where(array(
                                        'sb.user_id' => $this->customerID,
                                        'sb.performer_id' => $this->performerID,
                                        'pvg.type' => '2'
                                    ))->get()
                                ->result_array();
            if(!empty($subscribeVideos)) {
                foreach($subscribeVideos as $subscribeVideo) {
                    $this->data['videos'][] = array(
                        'modelID' => $subscribeVideo['modelID'],
                        'customerID' => $subscribeVideo['customerID'],
                        'videoPath' => 'assets/profile_videos/'.$subscribeVideo['video'],
                        'subscribe' => TRUE
                    );

                }
                $this->setVideo($this->data['videos']);
            } else {
                $nonSubscribeVideos = $this->db->from($this->tables['performer_video_gallery'].' as pvg')
                                                ->select('pvg.user_id as modelID,pvg.video')
                                                ->where(array(
                                                        'pvg.type' => '2',
                                                        'pvg.user_id' => $this->performerID,
                                                    ))->get()
                                                ->result_array();
                if(!empty($nonSubscribeVideos)) {
                    foreach($nonSubscribeVideos as $nonSubscribeVideo) {
                        $this->data['videos'][] = array(
                            'modelID' => $nonSubscribeVideo['modelID'],
                            'customerID' => $this->customerID,
                            'videoPath' => 'assets/profile_videos/'.$nonSubscribeVideo['video'],
                            'subscribe' => FALSE
                        );
                    }
                    $this->setVideo($this->data['videos']);
                }
            }

            $subscribeImages = $this->db->from($this->tables['performer_gallery'].' as pg')
                                    ->join('subscribe as sb', 'sb.performer_id = pg.user_id')
                                    ->select('pg.user_id as modelID,sb.user_id as customerID, pg.image')
                                    ->where(array(
                                            'sb.user_id' => $this->customerID,
                                            'sb.performer_id' => $this->performerID,
                                            'pg.type' => '2'
                                        ))->get()
                                    ->result_array();
            if(!empty($subscribeImages)) {
                foreach($subscribeImages as $subscribeImage) {
                    $this->data['images'][] = array(
                        'modelID' => $subscribeImage['modelID'],
                        'customerID' => $subscribeImage['customerID'],
                        'imagePath' => 'assets/performer_gallery/'.$subscribeImage['image'],
                        'subscribe' => TRUE
                    );
                }
                $this->setImage($this->data['images']);
            } else {
                $nonSubscribeImages = $this->db->from($this->tables['performer_gallery'].' as pg')
                                                ->select('pg.user_id as modelID,pg.image')
                                                ->where(array(
                                                        'pg.type' => '2',
                                                        'pg.user_id' => $this->performerID,
                                                    ))->get()
                                                ->result_array();
                if(!empty($nonSubscribeImages)) {
                    foreach($nonSubscribeImages as $nonsubscribeImage) {
                        $this->data['images'][] = array(
                            'modelID' => $nonsubscribeImage['modelID'],
                            'customerID' => $this->customerID,
                            'imagePath' => 'assets/performer_gallery/'.$nonsubscribeImage['image'],
                            'subscribe' => FALSE
                        );
                    }
                    $this->setImage($this->data['images']);
                }
            }
            
        }
       return $this->data;
    }
    /*
    public function getPremiumContent($performer_id, $user_id) {
        $videoData = array();
        $imageData = array();
        ############################ Premium Videos ########################################
        $subscribeVideos = $this->db->from($this->tables['performer_video_gallery'].' as pvg')
                                    ->join('subscribe as sb', 'sb.performer_id = pvg.user_id')
                                    ->select('pvg.user_id as modelID,sb.user_id as customerID, pvg.video')
                                    ->where(array(
                                            'sb.user_id' => $user_id,
                                            'sb.performer_id' => $performer_id,
                                            'pvg.type' => '2'
                                        ))->get()
                                    ->result_array();
        if(!empty($subscribeVideos)) {
            foreach($subscribeVideos as $subscribeVideo) {
                $videoData[] = array(
                    'modelID' => $subscribeVideo['modelID'],
                    'customerID' => $subscribeVideo['customerID'],
                    'videoPath' => 'assets/profile_videos/'.$subscribeVideo['video'],
                    'subscribe' => TRUE
                );
            }
           $this->setVideo($videoData);
        } else {
            $nonSubscribeVideos = $this->db->from($this->tables['performer_video_gallery'].' as pvg')
                                            ->select('pvg.user_id as modelID,pvg.video')
                                            ->where(array(
                                                    'pvg.type' => '2'
                                                ))->get()
                                            ->result_array();
            if(!empty($nonSubscribeVideos)) {
                foreach($nonSubscribeVideos as $nonSubscribeVideo) {
                    $imageData[] = array(
                        'modelID' => $nonSubscribeVideo['modelID'],
                        'customerID' => $user_id,
                        'videoPath' => 'assets/profile_videos/'.$nonSubscribeVideo['video'],
                        'subscribe' => FALSE
                    );
                }
                $this->setVideo($imageData);
                //return $premiumContent;
                
            }
            
        }
        ############################ Premium Videos ########################################
        $subscribeImages = $this->db->from($this->tables['performer_gallery'].' as pg')
                                    ->join('subscribe as sb', 'sb.performer_id = pg.user_id')
                                    ->select('pg.user_id as modelID,sb.user_id as customerID, pg.image')
                                    ->where(array(
                                            'sb.user_id' => $user_id,
                                            'sb.performer_id' => $performer_id,
                                            'pg.type' => '2'
                                        ))->get()
                                    ->result_array();
        if(!empty($subscribeImages)) {
            foreach($subscribeImages as $subscribeImage) {
                $imageData[] = array(
                    'modelID' => $subscribeImage['modelID'],
                    'customerID' => $subscribeImage['customerID'],
                    'imagePath' => 'assets/performer_gallery/'.$subscribeImage['image'],
                    'subscribe' => TRUE
                );
            }
           $this->setImage($imageData);
        } else {
            $nonSubscribeImages = $this->db->from($this->tables['performer_gallery'].' as pg')
                                            ->select('pg.user_id as modelID,pg.image')
                                            ->where(array(
                                                    'pg.type' => '2'
                                                ))->get()
                                            ->result_array();
            if(!empty($nonSubscribeImages)) {
                foreach($nonSubscribeImages as $nonsubscribeImage) {
                    $imageData[] = array(
                        'modelID' => $nonsubscribeImage['modelID'],
                        'customerID' => $user_id,
                        'imagePath' => 'assets/performer_gallery/'.$nonsubscribeImage['image'],
                        'subscribe' => FALSE
                    );
                }
                $this->setImage($imageData);
            }
        }

        $this->setContent(array(
                'images' => $this->image,
                'videos' => $this->video,
        ));
        return $this->content;
    }
    */

    
    public function filter($data) {
        if(!empty($data) && is_array($data)) {
            $this->data = $data;
            foreach($this->data as $key => $value) {
                if(array_key_exists('performer', $this->data) && isset($this->data['performer']) && !empty($this->data['performer'])) {
                    $this->conditions['up.performer_type'] = $this->data['performer'];
                }
                if(array_key_exists('category', $this->data) && isset($this->data['category']) && !empty($this->data['category'])) {
                    $this->conditions['c.name LIKE'] = '%'.$this->data['category'].'%';
                }
                if(array_key_exists('show_type', $this->data) && isset($this->data['show_type']) && !empty($this->data['show_type'])) {
                    $this->conditions['st.name LIKE'] = '%'.$this->data['show_type'].'%';
                }
                if(array_key_exists('age', $this->data) && isset($this->data['age']) && !empty($this->data['age'])) {
                    $this->conditions['u.age'] = $this->data['age'];
                }
                if(array_key_exists('willingness', $this->data) && isset($this->data['willingness']) && !empty($this->data['willingness'])) {
                    $this->conditions['wi.name LIKE'] = '%'.$this->data['willingness'].'%';
                }
                if(array_key_exists('appearances', $this->data) && isset($this->data['appearances']) && !empty($this->data['appearances'])) {
                    $this->conditions['ap.name LIKE'] = '%'.$this->data['appearances'].'%';
                }
                
                
                // if(array_key_exists('customer_id', $this->data) && isset($this->data['customer_id']) && !empty($this->data['customer_id']) && array_key_exists('id', $this->data) && isset($this->data['id']) && !empty($this->data['id'])) {
                    
                //     $this->conditions['sub.user_id']        = $this->data['customer_id'];
                //     $this->conditions['sub.performer_id']   = $this->data['id'];
                //     // $this->conditions['pg.type'] = 1;
                //     // $this->conditions['pvg.type'] = 1;
                // } else 
                
                if(array_key_exists('id', $this->data) && isset($this->data['id']) && !empty($this->data['id'])) {
                    $this->conditions['u.id'] = $this->data['id'];
                }
                
                
            }
           
        }
        // echo "<pre>";
        // print_r($this->conditions);
        // exit;
        // $this->conditions['pg.type'] = '0';
        // $this->conditions['pg.type'] = '0';

        if($this->conditions) {
            $this->db->from($this->tables['users'].' as u');
            $this->db->join($this->tables['user_preference'].' as up', 'up.user_id = u.id', 'left outer');
            $this->db->join($this->tables['users_categories'].' as uc', 'uc.id_users = u.id', 'left outer');
            $this->db->join($this->tables['categories'].' as c', 'c.id = uc.id_categories', 'left outer');
            $this->db->join($this->tables['users_show_type'].' as ust', 'ust.id_users = u.id', 'left outer');
            $this->db->join($this->tables['show_type'].' as st', 'st.id = ust.id_show_type', 'left outer');
            $this->db->join($this->tables['users_willingness'].' as uwi', 'uwi.id_users = u.id', 'left outer');
            $this->db->join($this->tables['willingness'].' as wi', 'wi.id = uwi.id_willingness', 'left outer');
            $this->db->join($this->tables['users_appearance'].' as uap', 'uap.id_users = u.id', 'left outer');
            $this->db->join($this->tables['appearance'].' as ap', 'ap.id = uap.id_appearence', 'left outer');
            $this->db->join($this->tables['performer_video_gallery'].' as pvg', 'pvg.user_id = u.id', 'left outer');
            $this->db->join($this->tables['performer_gallery'].' as pg', 'pg.user_id = u.id', 'left outer');
            
            $this->db->where($this->conditions);
            $this->db->group_by('u.id');
            $this->db->order_by('u.id', 'DESC');
            $this->db->select('u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, 
            u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, 
            up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, 
            up.cup, up.pubic_hair, up.penis, up.description,up.currency, 
            up.price_in_private,up.price_in_group, up.category, up.attribute, 
            up.willingness, up.appearance, up.feature, 
            up.performer_type,
            (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images,(select GROUP_CONCAT(pvg.video) from performer_video_gallery pvg where pvg.user_id = u.id) videos,
            c.id as categoryId, c.name as categoryName,st.id as showId, st.name as showName, ap.id as appearanceId, ap.name as appearanceName, wi.id as willingnessId, wi.name as willingness
            ');
            $this->setQuery($this->db->get());
        } else {
            $this->db->from($this->tables['users'].' as u');
            $this->db->join($this->tables['user_preference'].' as up', 'up.user_id = u.id', 'left outer');
            $this->db->join($this->tables['users_categories'].' as uc', 'uc.id_users = u.id', 'left outer');
            $this->db->join($this->tables['categories'].' as c', 'c.id = uc.id_categories', 'left outer');
            $this->db->join($this->tables['users_show_type'].' as ust', 'ust.id_users = u.id', 'left outer');
            $this->db->join($this->tables['show_type'].' as st', 'st.id = ust.id_show_type', 'left outer');
            $this->db->join($this->tables['users_willingness'].' as uwi', 'uwi.id_users = u.id', 'left outer');
            $this->db->join($this->tables['willingness'].' as wi', 'wi.id = uwi.id_willingness', 'left outer');
            $this->db->join($this->tables['users_appearance'].' as uap', 'uap.id_users = u.id', 'left outer');
            $this->db->join($this->tables['appearance'].' as ap', 'ap.id = uap.id_appearence', 'left outer');
            $this->db->group_by('u.id');
            $this->db->order_by('u.id', 'DESC');
            $this->db->select('u.id, u.name, u.email, u.phone_no, u.usernm, u.gender, u.sexual_pref, 
            u.age, u.image, u.isLogin, up.display_name, up.height, up.weight, 
            up.hair, up.eye, up.zodiac, up.build, up.chest, up.burst, 
            up.cup, up.pubic_hair, up.penis, up.description,up.currency, 
            up.price_in_private,up.price_in_group, up.category, up.attribute, 
            up.willingness, up.appearance, up.feature, 
            up.performer_type,
            (select GROUP_CONCAT(pg.image) from performer_gallery pg where pg.user_id = u.id) images,
            c.id as categoryId, c.name as categoryName,st.id as showId, st.name as showName, ap.id as appearanceId, ap.name as appearanceName, wi.id as willingnessId, wi.name as willingness
            ');
            $this->setQuery($this->db->get());
        }
        
        if($this->query) {
            return $this->query->result_array();
        }
        return array();
    }

    public function setQuery($query) {
        $this->query = $query;
        return $this;
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