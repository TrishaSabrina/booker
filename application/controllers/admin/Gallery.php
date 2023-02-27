<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends Home_Controller {

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
        $data['page_title'] = 'Gallery';     
        $data['page'] = 'Gallery';   
        $data['gallery'] = FALSE;
        $data['galleries'] = $this->admin_model->select_by_user('gallery');
        $data['main_content'] = $this->load->view('admin/user/gallery',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
        check_status();
        
        if($_POST)
        {   
            $id = $this->input->post('id', true);
            //validate inputs
            $this->form_validation->set_rules('title', trans('title'), 'required');
            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/gallery'));
            } else {

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'title' => $this->input->post('title', true),
                    'status' => $this->input->post('status', true)
                );
                $data = $this->security->xss_clean($data);
                
                //if id available info will be edited
                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'gallery');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $id = $this->admin_model->insert($data, 'gallery');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }


                //upload image
                $data_img = $this->admin_model->do_upload('photo');
                if($data_img){
                    $data_img = array(
                        'image' => $data_img['medium'],
                        'thumb' => $data_img['thumb']
                    );
                    $this->admin_model->edit_option($data_img, $id, 'gallery'); 
                 }

                redirect(base_url('admin/gallery'));

            }
        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['gallery'] = $this->admin_model->select_option($id, 'gallery');
        $data['main_content'] = $this->load->view('admin/user/gallery',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function delete($id)
    {
        $this->admin_model->delete($id,'gallery'); 
        echo json_encode(array('st' => 1));
    }


}
	

