<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Home_Controller {

	public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_staff() && !is_user()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Profile';
        $data['user'] = $this->admin_model->get_user_info();
        $data['main_content'] = $this->load->view('admin/user/profile/profile', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    //update user profile
    public function update(){
        
        check_status();

        if ($_POST) {

            if(!empty($this->input->post('enable_appointment', true))){ $enable_appointment = 1;}else{$enable_appointment = 0;}

            $data = array(
                'name' => $this->input->post('name', true),
                'specialist' => $this->input->post('specialist', true),
                'degree' => $this->input->post('degree', true),
                'address' => $this->input->post('address', true),
                'skype' => $this->input->post('skype', true),
                'whatsapp' => $this->input->post('whatsapp', true),
                'phone' => $this->input->post('phone', true),
                'exp_years' => $this->input->post('exp_years', true),
                'about_me' => $this->input->post('about_me', true),
                'email' => $this->input->post('email', true),
                'facebook' => $this->input->post('facebook', true),
                'twitter' => $this->input->post('twitter', true),
                'linkedin' => $this->input->post('linkedin', true),
                'instagram' => $this->input->post('instagram', true),
                'enable_appointment' => $enable_appointment
            );
            
            if(user()->role == 'staff'){$user_id = user()->user_id;}else{$user_id = user()->id;}

            // insert photos
            if($_FILES['photo']['name'] != ''){
                $up_load = $this->admin_model->upload_image('800');
                $data_img = array(
                    'image' => $up_load['images'],
                    'thumb' => $up_load['thumb']
                );
                $this->admin_model->edit_option($data_img, $user_id, 'users');   
            }

            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, $user_id, 'users');
            $this->session->set_flashdata('msg', trans('updated-successfully')); 
            redirect(base_url('admin/profile'));
        }
    }



    public function change_password()
    {
        $data = array();
        $data['page_title'] = 'Change Password';
        $data['main_content'] = $this->load->view('admin/change_password', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    

    //change password
    public function change()
    {   
        check_status();

        if($_POST){
            
            $id = user()->id;
            $user = $this->admin_model->get_by_id($id, 'staffs');

            if(password_verify($this->input->post('old_pass', true), $user->password)){
                if ($this->input->post('new_pass', true) == $this->input->post('confirm_pass', true)) {
                    $data=array(
                        'password' => hash_password($this->input->post('new_pass', true))
                    );
                    $data = $this->security->xss_clean($data);
                    $this->admin_model->edit_option($data, $id, 'staffs');
                    echo json_encode(array('st'=>1));
                } else {
                    echo json_encode(array('st'=>2));
                }
            } else {
                echo json_encode(array('st'=>0));
            }
        }
    }


}