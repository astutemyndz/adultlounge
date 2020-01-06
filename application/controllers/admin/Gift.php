<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gift extends CI_Controller {

    function __construct() {

        parent::__construct();
        
        if (!$this->session->userdata('user_logged_in')) {
            redirect(base_url().'admin');
        }
        
        $this->data = array(
            'menu' => 'gift'
        );
        
        $this->userId = $this->session->userdata('user_logged_in')['id'];

        $this->lang->load( ['error', 'gift'], 'english');
        $this->load->model('User_model', 'user');
        $this->load->model('Gift_model', 'gift');
    }



    public function index() {                
        $data = $this->data;
        $data['sub_menu'] = 'gifts';
        $data['title'] = 'Admin | Gifts';        
        $data['gifts'] = $this->cm->select('gifts', [], '', 'id', 'desc');   
    
        $this->load->view('admin/gifts/listing', $data);
    }



    public function add()
    {
        $data = $this->data;
        $data['sub_menu'] = 'add-gift';
        $data['title'] = 'Admin | Add Gift';

        if ($this->input->method() == 'post') {
            $values['gift_name']  = $this->input->post('gift_name');
            $values['gift_point'] = $this->input->post('gift_point');
            $values['is_active']  = $this->input->post('is_active');
            $values['user_id']    = $this->userId;

            if (is_uploaded_file($_FILES['gift_image']['tmp_name'])) {
                $config['upload_path']          = './uploads/gifts/';
                $config['file_name']            = uniqid('gift-');
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10000;
                
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gift_image')) {
                    $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $values['gift_image_path'] = 'gifts/' . $upload_data['file_name'];                    
                }                
            } else {
                $values['gift_image_path'] = '';
            }

            if ($this->gift->add($values)) {
                $this->session->set_flashdata('success_msg', $this->lang->line('gift_created')); 
                redirect('admin/gift');
            } else {                
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));      
            }
        }

        $this->load->view('admin/gifts/form', $data);
    }



    public function edit($encoded_gift_id)
    {
        $data = $this->data;
        $data['sub_menu'] = 'add-gift';
        $data['title'] = 'Admin | Edit Gift';

        $gift_id = decrypt_id( $encoded_gift_id );
        $gift = $this->db->where('id', $gift_id)->get('gifts')->row();

        if(! $gift) {
            show_404();
        }

        $data['gift'] = $gift;

        if ($this->input->method() == 'post') {
            $values['gift_name']  = $this->input->post('gift_name');
            $values['gift_point'] = $this->input->post('gift_point');
            $values['is_active']  = $this->input->post('is_active');
            $values['user_id']    = $this->userId;

            if (is_uploaded_file($_FILES['gift_image']['tmp_name'])) {
                $config['upload_path']          = './uploads/gifts/';
                $config['file_name']            = uniqid('gift-');
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 10000;
                
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('gift_image')) {
                    $this->session->set_flashdata('error_msg', $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $values['gift_image_path'] = 'gifts/' . $upload_data['file_name'];                    
                }                
            } else {
                $values['gift_image_path'] = $this->input->post('saved_gift_image');
            }

            if ($this->gift->edit($values, ['id' => $gift_id])) {
                $this->session->set_flashdata('success_msg', $this->lang->line('gift_updated'));  
                redirect('admin/gifts/edit/' . $encoded_gift_id);       
            } else {                
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));                
            }
        }        

        $this->load->view('admin/gifts/form', $data);
    }



}