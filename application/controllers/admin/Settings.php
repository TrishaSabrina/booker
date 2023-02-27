<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    
    public function index()
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        $data = array();
        $data['page_title'] = 'System Settings';
        $data['page'] = 'Settings';
        $data['settings'] = $this->admin_model->get('settings');
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['time_zones'] = $this->admin_model->select_asc('time_zone');
        $data['main_content'] = $this->load->view('admin/settings', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function company()
    {
        if (!is_user()) {
            redirect(base_url());
        }
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'System Settings';
        $data['company'] = $this->admin_model->get_company(user()->id);
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['main_content'] = $this->load->view('admin/user/settings', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function general()
    {

        if (!is_user()) {
            redirect(base_url());
        }
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'General Settings';
        $data['company'] = $this->admin_model->get_company(user()->id);
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['time_zones'] = $this->admin_model->select_asc('time_zone');
        $data['main_content'] = $this->load->view('admin/user/general_settings', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    
    function searchForId($value, $array) {
       foreach ($array as $key => $val) {
           if ($val == $value) {
               return $key;
           }
       }
       return 'null';
    }


    public function holidays()
    {
        if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
            $this->session->set_flashdata('msg', trans('updated-successfully')); 
        }

        if (!is_user()) {
            redirect(base_url());
        }
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'Holidays';
        $data['company'] = $this->admin_model->get_company(user()->id);
        $data['main_content'] = $this->load->view('admin/user/holidays', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    
    public function add_holidays($date){

        $holidays = json_decode($this->business->holidays, true);
      
        if (!empty($holidays)) {
            
            if (($key = array_search($date, $holidays)) !== false) {
                unset($holidays[$key]);
                $holidays = array_values($holidays);
            }else{
                array_push($holidays, $date);
            }
        } else {
            $holidays = array($date);
        }
        //echo "<pre>"; print_r($holidays); exit();

        $data = array(
            'holidays' => json_encode($holidays)
        );
        $this->admin_model->edit_option($data, $this->business->id, 'business');

        $data['status'] = 1;
        die(json_encode($data));
    }
    


    public function sms()
    {
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'SMS Settings';
        $data['main_content'] = $this->load->view('admin/user/sms_settings', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function embedded_code()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'Embedded Settings';
        $data['company'] = $this->admin_model->get_company(user()->id);
        $data['main_content'] = $this->load->view('admin/user/embd_code', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function qr_code()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        if ($this->business->qr_code == '') {
            $this->generate_qucode($this->business->slug);
        }

        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'QR Settings';
        $data['company'] = $this->admin_model->get_company(user()->id);
        $data['main_content'] = $this->load->view('admin/user/generate_code', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function generate_qucode($slug)
    {
        $this->load->library('ciqrcode');
        $qr_image= 'qrcode_'.rand().'.png';
        $params['data'] = base_url().$slug;
        $params['level'] = 'H';
        $params['size'] = 8;
        $params['savename'] = FCPATH."uploads/files/".$qr_image;
        if($this->ciqrcode->generate($params))
        {
           $data = array(
            'qr_code' => 'uploads/files/'.$qr_image
           );
           $this->admin_model->edit_option($data, $this->business->id, 'business');
        }
    }

    public function download_qrcode()
    {
        $this->load->helper('download');
        $file_name = basename($this->business->qr_code);
        $data = file_get_contents($this->business->qr_code);
        $name = $file_name;

        force_download($name, $data); 
        $this->session->set_flashdata('msg', $file.' '.trans('downloaded-successfully'));
    }


    public function profile()
    {
        if (!is_user()) {
            redirect(base_url());
        }
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'Profile';
        $data['main_content'] = $this->load->view('admin/user/profile', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function update_company(){

        check_status();

        $id = $this->input->post('id');

        if(!empty($this->input->post('enable_gallery'))){$enable_gallery = $this->input->post('enable_gallery', true);}
        else{$enable_gallery = 0;}

        if(!empty($this->input->post('enable_staff'))){$enable_staff = $this->input->post('enable_staff', true);}
        else{$enable_staff = 0;}

        if(!empty($this->input->post('enable_rating'))){$enable_rating = $this->input->post('enable_rating', true);}
        else{$enable_rating = 0;}

        if(!empty($this->input->post('time_interval'))){$time_interval = $this->input->post('time_interval', true);}
        else{$time_interval = 0;}

        $data = array(
            'country' => $this->input->post('country', true),
            'name' => $this->input->post('name'),
            'title' => $this->input->post('title'),
            'email' => $this->input->post('email', true),
            'phone' => $this->input->post('phone', true),
            'address' => $this->input->post('address'),
            'keywords' => $this->input->post('keywords'),
            'description' => $this->input->post('description'),
            'details' => $this->input->post('details'),
            'date_format' => $this->input->post('date_format', true),
            'time_format' => $this->input->post('time_format', true),
            'time_interval' => $time_interval,
            'interval_type' => $this->input->post('interval_type', true),
            'interval_settings' => $this->input->post('interval_settings', true),
            'curr_locate' => $this->input->post('curr_locate', true),
            'num_format' => $this->input->post('num_format', true),
            'facebook' => $this->input->post('facebook', true),
            'twitter' => $this->input->post('twitter', true),
            'instagram' => $this->input->post('instagram', true),
            'whatsapp' => $this->input->post('whatsapp', true),
            'enable_gallery' => $enable_gallery,
            'enable_rating' => $enable_rating,
            'enable_staff' => $enable_staff
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'business');

        // upload logo
        $data_img = $this->admin_model->do_upload('photo1');
        if($data_img){
            $data_img = array(
                'logo' => $data_img['medium']
            );            
            $this->admin_model->edit_option($data_img, $id, 'business');
        }

        if($_FILES['photo']['name'] != ''){
            $up_load = $this->admin_model->upload_image('1600');
            $data_img_banner = array(
                'image' => $up_load['images'],
                'thumb' => $up_load['thumb']
            );
            $this->admin_model->edit_option($data_img_banner, $id, 'business');   
        }

        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/settings/company'));
    }


    public function general_settings(){

        check_status();

        $id = $this->input->post('id');

        if(!empty($this->input->post('enable_gallery'))){$enable_gallery = $this->input->post('enable_gallery', true);}
        else{$enable_gallery = 0;}

        if(!empty($this->input->post('enable_staff'))){$enable_staff = $this->input->post('enable_staff', true);}
        else{$enable_staff = 0;}

        if(!empty($this->input->post('enable_rating'))){$enable_rating = $this->input->post('enable_rating', true);}
        else{$enable_rating = 0;}

        if(!empty($this->input->post('enable_group'))){$enable_group = $this->input->post('enable_group', true);}
        else{$enable_group = 0;}

        if(!empty($this->input->post('time_interval'))){$time_interval = $this->input->post('time_interval', true);}
        else{$time_interval = 0;}

        if(!empty($this->input->post('enable_payment'))){$enable_payment = $this->input->post('enable_payment', true);}
        else{$enable_payment = 0;}

        if(!empty($this->input->post('enable_onsite'))){$enable_onsite = $this->input->post('enable_onsite', true);}
        else{$enable_onsite = 0;}

        if(!empty($this->input->post('enable_guest'))){$enable_guest = $this->input->post('enable_guest', true);}
        else{$enable_guest = 0;}

        $data = array(
            'country' => $this->input->post('country', true),
            'date_format' => $this->input->post('date_format', true),
            'time_format' => $this->input->post('time_format', true),
            'time_zone' => $this->input->post('time_zone', true),
            'template_style' => $this->input->post('template_style', true),
            'time_interval' => $time_interval,
            'enable_onsite' => $enable_onsite,
            'enable_payment' => $enable_payment,
            'time_interval' => $time_interval,
            'interval_type' => $this->input->post('interval_type', true),
            'interval_settings' => $this->input->post('interval_settings', true),
            'curr_locate' => $this->input->post('curr_locate', true),
            'num_format' => $this->input->post('num_format', true),
            'total_person' => $this->input->post('total_person', true),
            'enable_gallery' => $enable_gallery,
            'enable_rating' => $enable_rating,
            'enable_group' => $enable_group,
            'enable_guest' => $enable_guest,
            'enable_staff' => $enable_staff
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'business');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/settings/general'));
    }



    public function update_time_format(){

        check_status();

        $data = array(
            'time_format' => $this->input->post('time_format', true)
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $this->business->id, 'business');

        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/settings/working_hours'));
    }


    public function update_profile(){

        check_status();

        $data = array(
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'phone' => $this->input->post('phone', true)
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, user()->id, 'users');

        if($_FILES['photo']['name'] != ''){
            $up_load = $this->admin_model->upload_image('800');
            $data_img = array(
                'image' => $up_load['images'],
                'thumb' => $up_load['thumb']
            );
            $this->admin_model->edit_option($data_img, user()->id, 'users');   
        }

        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/settings/profile'));
    }

    public function update_sms(){

        $data = array(
            'twillo_account_sid' => $this->input->post('twillo_account_sid', true),
            'twillo_auth_token' => $this->input->post('twillo_auth_token', true),
            'twillo_number' => $this->input->post('twillo_number', true),
            'enable_sms_notify' => $this->input->post('enable_sms_notify', true),
            'enable_sms_alert' => $this->input->post('enable_sms_alert', true)
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, user()->id, 'users');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/settings/sms'));
    }


    //set default language
    public function set_language()
    {
        check_status();

        if ($_POST) {

            if(!empty($this->input->post('enable_multilingual'))){$enable_multilingual = $this->input->post('enable_multilingual', true);}else{$enable_multilingual = 0;}

            $data = array(
                'enable_multilingual' => $enable_multilingual,
                'lang' => $this->input->post('language', true)
            );
            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, 1, 'settings');
            $this->session->set_flashdata('msg', trans('updated-successfully')); 
            redirect(base_url('admin/language'));
        }
    }

    
    //update settings
    public function update(){

        check_status();

        if ($_POST) {

            
            if(!empty($this->input->post('enable_multilingual'))){$enable_multilingual = $this->input->post('enable_multilingual', true);}
            else{$enable_multilingual = 0;}

            if(!empty($this->input->post('enable_registration'))){$enable_registration = $this->input->post('enable_registration', true);}
            else{$enable_registration = 0;}

            if(!empty($this->input->post('enable_email_verify'))){$enable_email_verify = $this->input->post('enable_email_verify', true);}
            else{$enable_email_verify = 0;}

            if(!empty($this->input->post('enable_sms'))){$enable_sms = $this->input->post('enable_sms', true);}
            else{$enable_sms = 0;}

            if(!empty($this->input->post('enable_captcha'))){$enable_captcha = $this->input->post('enable_captcha', true);}
            else{$enable_captcha = 0;}

            if(!empty($this->input->post('enable_payment'))){$enable_payment = $this->input->post('enable_payment', true);}
            else{$enable_payment = 0;}

            if(!empty($this->input->post('enable_blog'))){$enable_blog = $this->input->post('enable_blog', true);}
            else{$enable_blog = 0;}

            if(!empty($this->input->post('enable_faq'))){$enable_faq = $this->input->post('enable_faq', true);}
            else{$enable_faq = 0;}

            if(!empty($this->input->post('enable_users'))){$enable_users = $this->input->post('enable_users', true);}
            else{$enable_users = 0;}

            if(!empty($this->input->post('enable_workflow'))){$enable_workflow = $this->input->post('enable_workflow', true);}
            else{$enable_workflow = 0;}

            if(!empty($this->input->post('enable_feature'))){$enable_feature = $this->input->post('enable_feature', true);}
            else{$enable_feature = 0;}

            if(!empty($this->input->post('enable_frontend'))){$enable_frontend = $this->input->post('enable_frontend', true);}
            else{$enable_frontend = 0;}

            if(!empty($this->input->post('enable_lifetime'))){$enable_lifetime = $this->input->post('enable_lifetime', true);}
            else{$enable_lifetime = 0;}

            if(!empty($this->input->post('enable_coupon'))){$enable_coupon = $this->input->post('enable_coupon', true);}
            else{$enable_coupon = 0;}

            if(!empty($this->input->post('enable_animation'))){$enable_animation = $this->input->post('enable_animation', true);}
            else{$enable_animation = 0;}

            
            
            $data = array(
                'site_name' => $this->input->post('site_name', true),
                'site_title' => $this->input->post('site_title', true),
                'keywords' => $this->input->post('keywords', true),
                'description' => $this->input->post('description', true),
                'footer_about' => $this->input->post('footer_about', true),
                'admin_email' => $this->input->post('admin_email', true),
                'copyright' => $this->input->post('copyright', true),
                'time_zone' => $this->input->post('time_zone', true),
                'pagination_limit' => 0,
                'country' => $this->input->post('country', true),
                'trial_days' => $this->input->post('trial_days', true),
                'facebook' => $this->input->post('facebook', true),
                'twitter' => $this->input->post('twitter', true),
                'instagram' => $this->input->post('instagram', true),
                'linkedin' => $this->input->post('linkedin', true),
                'chart_style' => $this->input->post('chart_style', true),
                'curr_locate' => $this->input->post('curr_locate', true),
                'num_format' => $this->input->post('num_format', true),
                'enable_multilingual' => $enable_multilingual,
                'enable_registration' => $enable_registration,
                'enable_captcha' => $enable_captcha,
                'enable_payment' => $enable_payment,
                'enable_blog' => $enable_blog,
                'enable_faq' => $enable_faq,
                'enable_users' => $enable_users,
                'enable_workflow' => $enable_workflow,
                'enable_feature' => $enable_feature,
                'enable_frontend' => $enable_frontend,
                'enable_lifetime' => $enable_lifetime,
                'enable_coupon' => $enable_coupon,
                'enable_animation' => $enable_animation,
                'enable_email_verify' => $enable_email_verify,
                'enable_sms' => $enable_sms,
                'google_analytics' => base64_encode($this->input->post('google_analytics')),
                'site_color' => str_replace('#', '', $this->input->post('site_color')),
                'layout' => $this->input->post('layout', true),
                'site_font' => 'Alata',
                'captcha_site_key' => $this->input->post('captcha_site_key', true),
                'captcha_secret_key' => $this->input->post('captcha_secret_key', true),
                'google_client_id' => trim($this->input->post('google_client_id', true)),
                'google_client_secret' => trim($this->input->post('google_client_secret', true)),
                'mail_protocol' => $this->input->post('mail_protocol', true),
                'sender_mail' => $this->input->post('sender_mail', true),
                'mail_title' => $this->input->post('mail_title', true),
                'mail_host' => $this->input->post('mail_host', true),
                'mail_port' => $this->input->post('mail_port', true),
                'mail_username' => $this->input->post('mail_username', true),
                'mail_password' => base64_encode($this->input->post('mail_password')),
                'mail_encryption' => $this->input->post('mail_encryption'),
                'twillo_account_sid' => $this->input->post('twillo_account_sid', true),
                'twillo_auth_token' => $this->input->post('twillo_auth_token', true),
                'twillo_number' => $this->input->post('twillo_number', true),
                'tax_name' => $this->input->post('tax_name', true),
                'tax_value' => $this->input->post('tax_value', true)
            );
            
            // upload favicon image
            $data_img = $this->admin_model->do_upload('photo1');
            if($data_img){
                $data_img_1 = array(
                    'favicon' => $data_img['thumb']
                );
                $this->admin_model->edit_option($data_img_1, 1, 'settings'); 
             }

            // upload logo
            $data_img2 = $this->admin_model->do_upload('photo2');
            if($data_img2){
                $data_img_2 = array(
                    'logo' => $data_img2['medium']
                );            
                $this->admin_model->edit_option($data_img_2, 1, 'settings');
            }

            // upload home hero image
            $data_img3 = $this->admin_model->do_upload('photo3');
            if($data_img3){
                $data_img_3 = array(
                    'hero_img' => $data_img3['medium']
                );            
                $this->admin_model->edit_option($data_img_3, 1, 'settings');
            }

            $user_data = array(
                'email' => $this->input->post('admin_email', true)        
            );
            
            $user_data = $this->security->xss_clean($user_data);
            $this->admin_model->edit_option($user_data, user()->id, 'users');

            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, 1, 'settings');
            $this->session->set_flashdata('msg', trans('updated-successfully')); 
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function license()
    {
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'License';
        $data['main_content'] = $this->load->view('admin/license', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function change_password()
    {
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'Change Password';
        $data['main_content'] = $this->load->view('admin/user/change_password', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    //change password
    public function change()
    {   
        check_status();

        if($_POST){
            
            $id = user()->id;
            $user = $this->admin_model->get_by_id($id, 'users');

            if(password_verify($this->input->post('old_pass', true), $user->password)){
                if ($this->input->post('new_pass', true) == $this->input->post('confirm_pass', true)) {
                    $data=array(
                        'password' => hash_password($this->input->post('new_pass', true))
                    );
                    $data = $this->security->xss_clean($data);
                    $this->admin_model->edit_option($data, $id, 'users');
                    echo json_encode(array('st'=>1));
                } else {
                    echo json_encode(array('st'=>2));
                }
            } else {
                echo json_encode(array('st'=>0));
            }
        }
    }



    //user settings
    public function working_hours()
    {
        $data = array();
        $data['page'] = 'Settings';
        $data['page_title'] = 'Working Hours';
        $data['my_days'] = $this->admin_model->get_user_days(0);
        $data['main_content'] = $this->load->view('admin/user/working_hours',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function set()
    {   
        check_status();

        $user_id = user()->id;
        $this->admin_model->delete_assaign_days($user_id, 'working_days');
        $this->admin_model->delete_assaign_time($user_id, 'working_time');

        if($_POST)
        {   
            for ($i=0; $i < 7; $i++) { 
                if(empty($this->input->post("day_".$i))){
                    $day = 0;
                }else{
                    $day = $this->input->post("day_".$i);
                }

                if ($day == 0) {
                    $start = '';
                    $end = '';
                }else{
                    $start = $this->input->post("start_hour_".$i);
                    $end = $this->input->post("end_hour_".$i);
                    $start = date("H:i", strtotime($start));
                    $end = date("H:i", strtotime($end));
                }


                $data = array(
                    'user_id' => $user_id,
                    'business_id' => $this->business->uid,
                    'day' => $day,
                    'start' => $start,
                    'end' => $end,
                );
                $data = $this->security->xss_clean($data);
                $this->admin_model->insert($data, 'working_days');

                if ($day != 0) {
                    
                    if ($day == 0) {
                        $start_time = '';
                        $end_time = '';
                    }else{
                        $start_time = $this->input->post("start_time_".$i);
                        $end_time = $this->input->post("end_time_".$i);
                    }

                    for ($a=0; $a < is_countable($start_time) && count($start_time); $a++) { 
                        $time_data = array(
                            'user_id' => $user_id,
                            'business_id' => $this->business->uid,
                            'day_id' => $day,
                            'time' => date("H:i", strtotime($start_time[$a])).'-'.date("H:i", strtotime($end_time[$a])),
                            'start' => date("H:i", strtotime($start_time[$a])),
                            'end' => date("H:i", strtotime($end_time[$a]))
                        );
                        $time_data = $this->security->xss_clean($time_data);
                        $this->admin_model->insert($time_data, 'working_time');
                    }
                }
            }


            $this->session->set_flashdata('msg', trans('updated-successfully')); 
            if($_POST['setupfirst'] !== NULL ){
                // redirect to setupfirst page
                redirect(base_url('admin/setupfirst?activetab=staff'));
            }else{
                redirect(base_url('admin/settings/working_hours'));
            }
        }      
        
    }


    public function set_time()
    {   
        check_status();
        
        $this->admin_model->delete_assaign_time($user_id, 'working_time');
        $data = array(
            'user_id' => $user_id,
            'business_id' => $this->business->uid,
            'day_id' => $day,
            'start' => $day,
            'end' => $day
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->insert($data, 'working_time');
    }

    public function delete_time($id)
    {
        $this->admin_model->delete($id,'working_time'); 
        echo json_encode(array('st' => 1));
    }


}