<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Location extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Location';  
        $data['location'] = FALSE;
        $data['sub_location'] = FALSE;
        $data['locations'] = $this->admin_model->get_locations(0);
        $data['sub_locations'] = $this->admin_model->get_locations(1);
        $data['main_content'] = $this->load->view('admin/user/location',$data,TRUE);
        $this->load->view('admin/index',$data);
    }



    public function add()
    {   
        if($_POST)
        {   
            $id = $this->input->post('id', true);
            $data=array(
                'user_id' => user()->id,
                'business_id' => $this->business->uid,
                'parent_id' => 0,
                'name' => $this->input->post('name', true),
                'phone' => $this->input->post('phone', true),
                'address' => $this->input->post('address'),
                'status' => $this->input->post('status')
            );
            $data = $this->security->xss_clean($data);

            //if id available info will be edited
            if ($id != '') {

                check_status();

                $this->admin_model->edit_option($data, $id, 'locations');
                $this->session->set_flashdata('msg', trans('updated-successfully')); 
            } else {
                $id = $this->admin_model->insert($data, 'locations');
                $this->session->set_flashdata('msg', trans('inserted-successfully')); 
            }

            if($_POST['setupfirstLocation'] !== NULL ){
                // redirect to setupfirst page
                redirect(base_url('admin/setupfirst?activetab=services'));
            }else{
                redirect(base_url('admin/location'));
            }

        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['location'] = $this->admin_model->select_option($id, 'locations');
        $data['sub_location'] = $this->admin_model->select_option($id, 'locations');
        $data['main_content'] = $this->load->view('admin/user/location',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function edit_sub($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit Sub';   
        $data['location'] = $this->admin_model->select_option($id, 'locations');
        $data['locations'] = $this->admin_model->get_locations(0);
        $data['sub_location'] = $this->admin_model->select_option($id, 'locations');
        $data['main_content'] = $this->load->view('admin/user/location',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add_sub()
    {  
        if($_POST)
        {   
            //validate inputs
            $this->form_validation->set_rules('parent_id', trans('location'), 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/location'));
            } else {

                $id = $this->input->post('id', true);
                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'parent_id' => $this->input->post('parent_id', true),
                    'name' => $this->input->post('name', true),
                    'phone' => $this->input->post('phone', true),
                    'address' => $this->input->post('address'),
                    'status' => $this->input->post('status')
                );
                $data = $this->security->xss_clean($data);

                //if id available info will be edited
                if ($id != '') {

                    check_status();

                    $this->admin_model->edit_option($data, $id, 'locations');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $id = $this->admin_model->insert($data, 'locations');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }
            }
            redirect(base_url('admin/location'));

        }      
        
    }


    public function status_update($status) 
    {
        check_status();

        $data = array(
            'enable_location' => $status
        );
        $this->admin_model->edit_option($data, $this->business->id, 'business');
        $this->session->set_flashdata('msg', trans('updated-successfully'));
        echo json_encode(array('st' => 1));
    }

    
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'locations');
        $this->session->set_flashdata('msg', trans('activate-successfully')); 
        redirect(base_url('admin/pages'));
    }

    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'locations');
        $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        redirect(base_url('admin/pages'));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'locations'); 
        echo json_encode(array('st' => 1));
    }

}
    

