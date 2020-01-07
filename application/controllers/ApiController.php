<?php 

class ApiController extends Common_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('Performer_model', 'performer');
    }


    public function searchModel() {
        
        if(!$this->isPost()) {
            $this->setQ(($this->input->get('q')) ? $this->input->get('q') : '');
            if($this->q) {
                $this->setPerformer($this->performer->all('Yes','','','', $this->q));
            } else {
                $this->setPerformer($this->performer->all('Yes'));
            }
            if($this->performer) {
                foreach($this->performer as $performer) {
                    $this->data[] = array(
                        'id'            => $performer['id'],
                        'name'          => $performer['name'],
                        'slug'          => strtolower(str_replace(' ', '_', ($performer['name']))),
                        'profile_image_url_https'         => base_url().'assets/profile_image/'.$performer['image'],
                        'display_name'  => $performer['display_name'],
                    );
                }
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->data));
            } else {
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([]));
            }
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status'    => array(
                        'code' => Common_Controller::HTTP_METHOD_NOT_ALLOWED,
                        'text' => Common_Controller::$statusTexts[405],
                    ),
                    'message'   => Common_Controller::$statusTexts[405]
                )));
        }
    }
    public function filterModel() {
        
        if($this->isPost()) {
            $this->setRequest($this->input->post());
            if(!empty($this->request) && is_array($this->request)) {
                $this->setFilterData($this->request);
            }
            if($this->filterData) {
                $this->setPerformer($this->performer->filter($this->filterData));
            }
            if($this->performer) {
                $this->data = $this->performer;
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode($this->data));
            } else {
                return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([]));
            }
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'status'    => array(
                        'code' => Common_Controller::HTTP_METHOD_NOT_ALLOWED,
                        'text' => Common_Controller::$statusTexts[405],
                    ),
                    'message'   => Common_Controller::$statusTexts[405]
                )));
        }
    }

}