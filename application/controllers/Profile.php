<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index($slug){
        $this->user($slug);
    }


    public function user($slug)
    {   
        
        $data = array();
        $slug = $this->security->xss_clean($slug);
        $data['user'] = $this->common_model->get_user_by_slug($slug);
        $user_id =  $data['user']->id;
        $data['my_days'] =$this->admin_model->get_my_days($user_id);

        $my_days = $this->admin_model->get_my_days($user_id);
        
        foreach ($my_days as $day) {
            if ($day['day'] != 0) {
                $myday[] = $day['day'];
            }
        }

        $days = "1,2,3,4,5,6,7";         
        $days = explode(',', $days);
        $assign_days = $myday;

        $match = array();
        $nomatch = array();

        foreach($days as $v){     
            if(in_array($v, $assign_days))
                $match[]=$v;
            else
                $nomatch[]=$v;
        }

        $data['not_available'] = $nomatch;
        $data['chambers'] = $this->common_model->get_my_chambers($user_id);
        $data['educations'] = $this->common_model->get_my_educations($user_id);
        $data['experiences'] = $this->common_model->get_my_experiences($user_id);
        $data['patients'] = $this->common_model->get_my_total_patients($user_id);
        $data['prescriptions'] = $this->common_model->get_my_total_prescriptions($user_id);
        $data['page_title'] = $data['user']->name;
        $data['page'] = 'Profile';
        $data['menu'] = FALSE;
        $data['slug'] = $slug;
        $data['main_content'] = $this->load->view('profile', $data, TRUE);
        $this->load->view('index', $data);
    }


    

    //send comment
    public function book_appointment($slug)
    {     
        $id = $this->input->post('id');
        $check_patient = $this->input->post('check_patient');
        $user = $this->common_model->get_by_md5_id($id, 'users');
        $date = $this->input->post('date');
        $date = date("Y-m-d", strtotime($date));

        if ($_POST) {

            //check reCAPTCHA
            if (!$this->recaptcha_verify_request()) {
                echo json_encode(array('st'=>4)); exit();
            } else {

                if (date('Y-m-d') > $date) {  
                    echo json_encode(array('st'=>2)); exit();
                }
            
                $patient = $this->common_model->check_patient($this->input->post('user_name'));
                $chamber = $this->common_model->get_by_id($this->input->post('chamber'), 'chamber');

                if ($check_patient == FALSE) {

                    $this->form_validation->set_rules('email', trans('email'), 'required');
                    $this->form_validation->set_rules('mobile', trans('phone'), 'required');
                    $this->form_validation->set_rules('new_password', trans('password'), 'required');

                    if ($this->form_validation->run() === false) {
                        $error = strip_tags(validation_errors());
                        echo json_encode(array('st'=>3,'error'=> $error));
                        exit();
                    }
                    
                    $password = hash_password($this->input->post('new_password'));

                } else {
                    
                    if (empty($patient)) {
                        echo json_encode(array('st'=> 0)); exit();
                    }

                    $password = $patient->password;
                    $patient_id = $patient->id;
                }

                $newuser_data = array(
                    'chamber_id' => $chamber->uid,
                    'user_id' => $user->id,
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'mr_number' => random_string('numeric',5),
                    'email' => $this->input->post('email', true),
                    'mobile' => $this->input->post('mobile', true),
                    'password' => $password
                );

                $newuser_data = $this->security->xss_clean($newuser_data);
                if ($check_patient == FALSE) {
                    $patient_id = $this->admin_model->insert($newuser_data, 'patientses');

                    $subject = 'Welcome to '.$this->settings->site_name;
                    $msg = 'Your account has been created successfully, now you can login to your account using below access <br> Username:'.$this->input->post('email').' , and Password: '.$password;
                    $this->email_model->send_email($this->input->post('email'), $subject, $msg);
                }
                
                if (check_user_feature_access('online-consultation', $user->id) == TRUE && $this->input->post('type') == 1){
                    $consultation_type = 'online';
                }else{
                    $consultation_type = 'offline';
                }

                $serial_id = $this->common_model->get_my_last_serial($date, $chamber->id, $user->id);
                $data = array(
                    'chamber_id' => $chamber->uid,
                    'user_id' => $user->id,
                    'patient_id' => $patient_id,
                    'serial_id' => $serial_id,
                    'date' => $date,
                    'time' => $this->input->post('time', true),
                    'status' => 0,
                    'type' => $consultation_type,
                    'created_at' => my_date_now()
                );
                $amp_id = $this->admin_model->insert($data, 'appointments');


                if ($check_patient == TRUE) {
                   
                    $exist_patient = $this->auth_model->validate_patient();

                    if(password_verify($this->input->post('password'), $exist_patient->password)){
                        $data = array(
                            'id' => $exist_patient->id,
                            'name' => $exist_patient->name,
                            'slug' => $exist_patient->slug,
                            'thumb' => $exist_patient->thumb,
                            'email' =>$exist_patient->email,
                            'role' =>$exist_patient->role,
                            'parent' => 0,
                            'logged_in' => TRUE
                        );
                        $data = $this->security->xss_clean($data);
                        $this->session->set_userdata($data);
                    
                        if (check_user_feature_access('online-consultation', $user->id) == TRUE){
                            $url = base_url('admin/payment/patient/'.$amp_id);
                        }else{
                            $url = base_url('admin/dashboard/patient');
                        }
                    
                        echo json_encode(array('st'=>1,'url'=> $url));
                    }else{ 
                        echo json_encode(array('st'=> 0)); exit();
                    }
                }else {

                    $register = $this->common_model->get_by_id($patient_id, 'patientses');
                    $data = array(
                        'id' => $register->id,
                        'name' => $register->name,
                        'slug' => $register->slug,
                        'thumb' => $register->thumb,
                        'email' =>$register->email,
                        'role' =>$register->role,
                        'parent' => 0,
                        'logged_in' => TRUE
                    );
                    $data = $this->security->xss_clean($data);
                    $this->session->set_userdata($data);
                    
                    if ($this->input->post('type') == 1){
                        $url = base_url('admin/payment/patient/'.$amp_id);
                    }else{
                        $url = base_url('admin/dashboard/patient');
                    }
                    
                    echo json_encode(array('st'=>1,'url'=> $url));
                }
                
                

            }
        }
    }


    // not found page
    public function error_404()
    {
        $data['page_title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";
        $this->load->view('error_404');
    }


}