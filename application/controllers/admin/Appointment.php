<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends Home_Controller {

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
        $this->all();
    }


    public function all()
    {
        $data = array();
        $data['page'] = 'Appointment';
        $data['page_title'] = 'Appointments';
        $data['appointment'] = FALSE;


        $my_days = $this->admin_model->get_my_days($this->business->uid);
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
        $data['my_days'] = $my_days;




        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/appointment/all');
        $total_row = $this->admin_model->get_appointments(user()->id, 1 , 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 15;
        $this->pagination->initialize($config);

        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['appointments'] = $this->admin_model->get_appointments(user()->id, 0 , $config['per_page'], $page * $config['per_page']);
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        //$data['customers'] = $this->admin_model->select_by_user('customers');
        $data['customers'] = $this->admin_model->get_customers();
        $cus_val = array();
        foreach($data['customers'] as $row)
        {
           $cus_val[] = $row->id;
        }
        $customer_array = implode (",", $cus_val);
        $data['customers_app'] = $this->admin_model->get_booking_customers($customer_array);

        $data['locations'] = $this->common_model->get_locations(0, $this->business->uid);
        $data['sub_locations'] = $this->common_model->get_locations(1, $this->business->uid);

        $data['main_content'] = $this->load->view('admin/user/appointments',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function calendars()
    {
        $data = array();
        $data['page'] = 'Appointment';
        $data['page_title'] = 'Calendars';
        $data['appointments'] = $this->admin_model->get_calendar_appointments(user()->id, 300);
        $data['main_content'] = $this->load->view('admin/user/calendars',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function sync($appointment_id)
    {
        $data['appointment'] = $this->common_model->get_appointment_md5($appointment_id);
        $data['company'] = $this->common_model->get_by_uid($data['appointment']->business_id, 'business');
        $this->session->set_userdata('appointment_id', $data['appointment']->id);
        $this->session->set_userdata('company_slug', $data['company']->slug);
        redirect(base_url('googlecalendar/login'));
    }



    public function edit($id)
    {
        $data = array();

        $my_days = $this->admin_model->get_my_days($this->business->uid);
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
        $data['my_days'] = $my_days;

        
        $data['page'] = 'Appointment';
        $data['page_title'] = 'Edit';
        $data['appointment'] = $this->admin_model->select_option($id, 'appointments');

        $data['locations'] = $this->common_model->get_locations(0, $this->business->uid);
        $data['sub_locations'] = $this->common_model->get_locations(1, $this->business->uid);
        $this->session->unset_userdata('staff_id');
        $this->session->set_userdata('staff_id', $data['appointment'][0]['staff_id']);

        $this->session->unset_userdata('service_id');
        $this->session->set_userdata('service_id', $data['appointment'][0]['service_id']);

        $data['services'] = $this->admin_model->select_by_user('services');
        $data['staffs'] = $this->admin_model->select_by_user('staffs');
        $data['customers'] = $this->admin_model->select_by_user('customers');
        $data['main_content'] = $this->load->view('admin/user/appointments',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    // load staff
    public function sess_staff($id)
    {
        $this->session->unset_userdata('staff_id');
        $this->session->set_userdata('staff_id', $id);

        $data = array();
        $my_days = $this->admin_model->get_staff_days($id);

        if (empty($my_days)) {
            $my_days = $this->admin_model->get_my_days($this->business->uid);
        }

        $data['company'] = $this->common_model->get_by_slug($this->business->slug, 'business');
        
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
        $data['my_days'] = $my_days;
        $data['page'] = 'Appointment';
        $data['page_title'] = 'Booking';
        $data['company_id'] = $data['company']->uid;
        $loaded = $this->load->view('admin/include/datepicker-js', $data, true);
        echo json_encode(array('st' => 1, 'loaded' => $loaded));
        

    }


    // load currency by ajax
    public function load_staff($id)
    {
        $services = $this->common_model->get_service_staffs($id);

        $data['company'] = $this->common_model->get_by_uid($services->business_id, 'business');

        $this->session->unset_userdata('service_id');
        $this->session->set_userdata('service_id', $id);

        $staffs = json_decode($services->staffs);
        
        if (empty($staffs)) {
            echo '<option value="0">'.trans('no-data-found').'</option>';
        }else{
            
            foreach ($staffs as $staff) { 
                echo '<option value="'. get_by_id($staff, 'staffs')->id.'">'. get_by_id($staff, 'staffs')->name.''. '</option>';
            }
        }
    }


    public function add()
    {	
        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('customer_id', 'Customer', 'required');
            $this->form_validation->set_rules('service_id', 'Service', 'required');
        	
            if(!empty($this->input->post('staff_id'))){$staff_id = $this->input->post('staff_id', true);}
            else{$staff_id = 0;}

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/appointment'));
            } else {

                if (empty($this->input->post('location_id'))) {
                    $location_id = 0;
                }else{
                   $location_id = $this->input->post('location_id'); 
                }

                if (empty($this->input->post('sub_location_id'))) {
                    $sub_location_id = 0;
                }else{
                    $sub_location_id = $this->input->post('sub_location_id'); 
                }

                $data = array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'customer_id' => $this->input->post('customer_id', true),
                    'service_id' => $this->input->post('service_id', true),
                    'staff_id' => $staff_id,
                    'location_id' => $location_id,
                    'sub_location_id' => $sub_location_id,
                    'date' => $this->input->post('date', true),
                    'time' => $this->input->post('time', true),
                    'status' => $this->input->post('status', true),
                    'created_at' => my_date_now()
                );
                
                if (date('Y-m-d') > $this->input->post('date')) {
                    $this->session->set_flashdata('error', trans('select-a-valid-date'));  
                    redirect(base_url('admin/appointment'));
                }

                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'appointments');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                    $this->status_update($this->input->post('status'), $id);
                } else {

                    $total = get_total_value('appointments');
                    if (ckeck_plan_limit('appointments', $total) == FALSE) {
                        $this->session->set_flashdata('error', trans('reached-maximum-limit'));
                        redirect(base_url('admin/appointments'));
                        exit();
                    }
                    
                    $this->admin_model->insert($data, 'appointments');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 

                    if (!empty($this->input->post('notify_customer')) && $this->input->post('notify_customer') == 1) {

                        if (user()->enable_sms_notify == 1) {
                            $this->load->model('sms_model');
                            $company = $this->admin_model->get_business($this->business->uid);
                            $message = trans('appointment').' '.$company->name.' - '.$service->name.' '.trans('booking-is-confirmed-at').' '.$this->input->post('date').' '.$this->input->post('start_time').'-'.$this->input->post('end_time');
                            $response = $this->sms_model->send($customer->phone, $message);
                        }
                        
                        $customer = $this->admin_model->get_by_id($this->input->post('customer_id'), 'customers');
                        $service = $this->admin_model->get_by_id($this->input->post('service_id'), 'services');
                        $subject = trans('appointment-confirmation').' - '.$this->settings->site_name;
                        $msg = trans('appointment-successfully-at').' '.$this->input->post('date').', '.trans('login-more-details').' <br>'.base_url('login');

                        $edata = array();
                        $edata['subject'] = $subject;
                        $edata['message'] = $msg;

                        $message = $this->load->view('email_template/appointment', $edata, true);
                        $this->email_model->send_email($customer->email, $subject, $message);
                        
                    }
                    
                }

                redirect(base_url('admin/appointment'));

            }

        } 
        
    }


    public function status_update($status, $id) 
    {
        $data = array(
            'status' => $status
        );
        $this->admin_model->update($data, $id, 'appointments');

        if($status == 1){
            $status_text = trans('confirmed');
        }

        if($status == 2){
            $status_text = trans('cancelled');
        }


        if ($status == 1 || $status == 2) {

            $appointment = $this->admin_model->get_by_id($id, 'appointments');
            $company = $this->admin_model->get_business($this->business->uid);
            $customer = $this->admin_model->get_by_id($appointment->customer_id, 'customers');
            $service = $this->admin_model->get_by_id($appointment->service_id, 'services');


            //notify customer
            $subject = trans('appointment').' - '.$status_text;
            $customer_msg = trans('dear').' '.$customer->name.', '.trans('thank-you-for-your-booking-at-our').' '.$company->name.', 
        '.$service->name.' '.trans('at').' '.my_date_show($appointment->date).' '.trans('at').' '.$appointment->time.' '.trans('is').' '.$status_text;

            $edata = array();
            $edata['subject'] = $subject;
            $edata['message'] = $customer_msg;

            $message = $this->load->view('email_template/appointment', $edata, true);
            $this->email_model->send_email($customer->email, $subject, $message);


            // notify staff
            $msg = trans('appointment').' '.$service->name.' '.trans('at').' '.my_date_show($appointment->date).' '.trans('at').' '.$appointment->time.' '.trans('is').' '.$status_text;

            if ($appointment->staff_id != 0) {
                $staff = $this->admin_model->get_by_id($appointment->staff_id, 'staffs');

                $edata = array();
                $edata['subject'] = $subject;
                $edata['message'] = $msg;

                $msg = $this->load->view('email_template/appointment', $edata, true);
                $this->email_model->send_email($staff->email, $subject, $msg);
            }

            //notify user
            $edata = array();
            $edata['subject'] = $subject;
            $edata['message'] = $msg;

            $message = $this->load->view('email_template/appointment', $edata, true);
            $this->email_model->send_email(user()->email, $subject, $msg);

            // send sms to customer
            if (user()->enable_sms_notify == 1) {
                $this->load->model('sms_model');
                $response = $this->sms_model->send_user($customer->phone, $customer_msg, user()->id);
            }
        }


        // if ($status == 1) {
        //     $service = $this->admin_model->get_by_id($appointment->service_id, 'services');
        //     $total_person = $appointment->total_person + 1;
        //     $sdata = array(
        //         'capacity_left' => $service->capacity - $total_person
        //     );
        //     if (!empty($service->capacity_left)) {
        //         $this->admin_model->update($sdata, $service->id, 'services');
        //     }
        // }

        
        echo json_encode(array('st' => 1));
    }
    

    public function notify_customer($id) 
    {
        $appointment = $this->common_model->get_appointment($id);
        $this->load->model('sms_model');
        $company = $this->admin_model->get_business($this->business->uid);
        $message = trans('appointment').' '.$company->name.' - '.$appointment->service_name.' '.my_date_show($appointment->date).' '.$appointment->time;
        $response = $this->sms_model->send($appointment->customer_phone, $message);
   
        if ($response != 1) {
            echo json_encode(array('st' => 0, 'msg' => $response));
        }else{
            echo json_encode(array('st' => 1));
        }
    }


    public function set()
    {   
        if(user()->role == 'staff'){$user_id = user()->user_id;}else{$user_id = user()->id;}
        $this->admin_model->delete_assaign_days($user_id, 'working_days');
        if($_POST)
        {   
            for ($i=0; $i < 7; $i++) { 
                if(empty($this->input->post("day_".$i))){
                    $day = 0;
                }else{
                    $day = $this->input->post("day_".$i);
                }
                $data = array(
                    'user_id' => $user_id,
                    'day' => $day,
                    'start' => $this->input->post("start_time_".$i),
                    'end' => $this->input->post("end_time_".$i)
                );
                $data = $this->security->xss_clean($data);
                $this->admin_model->insert($data, 'working_days');
            }

            $this->session->set_flashdata('msg', trans('schedule-assigned-successfully')); 
            redirect(base_url('admin/appointment/assign'));
        }      
        
    }

    public function delete_time($id)
    {
        $this->admin_model->delete($id,'working_time'); 
        echo json_encode(array('st' => 1));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'appointments'); 
        echo json_encode(array('st' => 1));
    }

}
	

