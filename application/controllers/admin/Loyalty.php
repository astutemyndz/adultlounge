<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loyalty extends CI_Controller {

    function __construct() {
        parent::__construct();
        
        if(!$this->session->userdata('user_logged_in')){
            redirect(base_url() . 'admin');
        }
        
        $this->data = array(
            'menu' => 'loyalty'
        );
        
        $this->userId = $this->session->userdata('user_logged_in')['id'];

        $this->lang->load(['error', 'loyalty_plan'], 'english');
        $this->load->model('User_model', 'user');
        $this->load->model('Loyalty_model', 'loyalty');
    }



    public function index(){
        $data = $this->data = array(
            'menu' => 'loyalty'
        );
        $data['sub_menu'] = 'loyalty_plan_list';
        $data['title'] = 'Admin | Loyalty Plans';
        $data['loyalty_plans'] = $this->cm->select('loyalty_plans', [], '', 'id', 'desc');   
    
        $this->load->view('admin/loyalty-plans/listing', $data);
    }



    public function add()
    {
        $data = $this->data;
        $data['sub_menu'] = 'add-loyalty-plan';
        $data['title'] = 'Admin | Add Loyalty Plan';

        if ($this->input->method() == 'post') {
            $values['title']       = $this->input->post('title');
            $values['description'] = $this->input->post('description');
            $values['credit']      = $this->input->post('credit');
            $values['sell_price']  = $this->input->post('sell_price');
            $values['status']      = $this->input->post('is_active');
            $values['user_id']     = $this->userId;

            if ($this->loyalty->add($values)) {
                $this->session->set_flashdata('success_msg', $this->lang->line('loyalty_plan_created')); 
                redirect('admin/loyalty/plans');
            } else {                
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));      
            }
        }

        $this->load->view('admin/loyalty-plans/form', $data);
    }



    public function edit($encoded_loyalty_plan_id)
    {
        $data = $this->data;
        $data['sub_menu'] = 'add-loyalty-plan';
        $data['title'] = 'Admin | Edit Loyalty Plan';

        $loyalty_plan_id = decrypt_id( $encoded_loyalty_plan_id );
        $loyalty_plan = $this->db->where('id', $loyalty_plan_id)->get('loyalty_plans')->row();

        if(! $loyalty_plan) {
            show_404();
        }

        $data['loyalty_plan'] = $loyalty_plan;

        if ($this->input->method() == 'post') {
            $values['title']       = $this->input->post('title');
            $values['description'] = $this->input->post('description');
            $values['credit']      = $this->input->post('credit');
            $values['sell_price']  = $this->input->post('sell_price');
            $values['status']      = $this->input->post('is_active');
            $values['user_id']     = $this->userId;

            if ($this->loyalty->edit($values, ['id' => $loyalty_plan_id])) {
                $this->session->set_flashdata('success_msg', $this->lang->line('loyalty_plan_updated'));  
                redirect('admin/loyalty/edit/' . $encoded_loyalty_plan_id);       
            } else {                
                $this->session->set_flashdata('error_msg', $this->lang->line('general_error_msg'));                
            }
        }        

        $this->load->view('admin/loyalty-plans/form', $data);
    } 


}