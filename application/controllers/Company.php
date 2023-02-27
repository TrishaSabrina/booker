<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }


    public function home($slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Company Home';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $user = $this->common_model->get_by_id($data['company']->user_id, 'users');
        if ($user->status == 2) {
            redirect(base_url());
            exit();
        }
        if(empty($data['company'])){
            redirect(base_url('404_override'));
        }
        
        if ($template == 1) {
            $data['services'] = $this->common_model->get_company_services($data['company']->uid, 6);
        }else{
            if ($data['company']->enable_category == 1) {
                $data['categories'] = $this->common_model->get_category_services($data['company']->uid);
            }else{
                $data['services'] = $this->common_model->get_company_services($data['company']->uid, 6);
            }
        }
        
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/home', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function services($slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Services';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $user = $this->common_model->get_by_id($data['company']->user_id, 'users');
        if ($user->status == 2) {
            redirect(base_url());
            exit();
        }
        $data['services'] = $this->common_model->get_company_services($data['company']->uid, 0);
        $data['staffs'] = $this->common_model->get_by_status($data['company']->uid, 'staffs');
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/services', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function staff($slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Staff';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $user = $this->common_model->get_by_id($data['company']->user_id, 'users');
        if ($user->status == 2) {
            redirect(base_url());
            exit();
        }
        $data['staffs'] = $this->common_model->get_by_company($data['company']->uid, 'staffs');
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/staff', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function service($service_slug, $slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Service';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $user = $this->common_model->get_by_id($data['company']->user_id, 'users');
        if ($user->status == 2) {
            redirect(base_url());
            exit();
        }
        $data['service'] = $this->common_model->get_id_by_company($service_slug, 'services', $data['company']->uid);
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/service_details', $data, TRUE);
        $this->load->view('index', $data);
    }

    public function gallery($slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Gallery';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $data['galleries'] = $this->common_model->get_by_status($data['company']->uid, 'gallery');
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/gallery', $data, TRUE);
        $this->load->view('index', $data);
    }

    //show pages
    public function page($slug, $page_slug)
    {   
        $data = array();
        $data['page'] = 'Company';
        $data['page_title'] = 'Page';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $data['pages'] = $this->common_model->get_single_page($page_slug);
        if (empty($data['page'])) {
            redirect(base_url());
        }
        $data['page_name'] = $data['pages']->title;
        $data['my_days'] =$this->admin_model->get_my_days($data['company']->uid);
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/page', $data, TRUE);
        $this->load->view('index', $data);
    }


    // get time slots
    public function get_time($date, $business_id, $service_id='')
    {
        ini_set('memory_limit', '-1');

        if(empty($service_id)){
            $service_id = $this->session->userdata('service_id');
        }
        
        $day = date('l', strtotime($date));
        $day_id = get_day_id($day);
        $value = array();
        $value['company'] = $this->admin_model->get_business_uid($business_id);
        $template = $data['company']->template_style;

        if ($value['company']->interval_settings == 2) {
            if ($value['company']->interval_type == 'minute') {
                $interval = $value['company']->time_interval;
            }else if($value['company']->interval_type == 'hour'){
                $interval = $value['company']->time_interval * 60;
            }else{
                $interval = 'day';
            }
        }else{
            $service = $this->admin_model->get_by_id($service_id, 'services');
           
            if ($service->duration_type == 'minute') {
                $interval = $service->duration;
            }else if($service->duration_type == 'hour'){
                $interval = $service->duration * 60;
            }else{
                $interval = 'day';
            }
        }

        // staff days
        if (!empty($this->session->userdata('staff_id'))) {
            $staff_id = $this->session->userdata('staff_id');
        }else{
            $staff_id = session_get($business_id, 'staff_id');
        }

        //***** old code
        // $staff_days = $this->admin_model->get_staff_days($staff_id);
        // if (empty($staff_days)) {
        //     $staff_id = 0;
        // } else {
        //     $staff_id = $staff_id;
        // }

        //***** new code
        $staff_days = $this->check_staff_schedule($staff_id);
        if ($staff_days == 'company') {
            $staff_id = 0;
        } else {
            $staff_id = $staff_id;
        }
        
        // staff days for day interval
        if ($interval != 'day') {
            $slot = $this->admin_model->get_timeslot_by_day($day_id, $business_id, $staff_id);
            $value['times'] = get_time_slots($interval, $slot->start, $slot->end);
            $value['breaks'] = get_time_by_days($day_id, $business_id);
        }

        $value['service_id'] = $service_id;
        $value['day_id'] = $day_id;
        $value['date'] = $date;
        $value['interval'] = $interval;
        $data = array();
        $data['result'] = $this->load->view('include/time_loop', $value, TRUE);

        if ($interval != 'day') {
            if (empty($value['times'])) {
                $data['status'] = 0;
            } else {
                $data['status'] = 1;
            }
        }else{
            $data['status'] = 1;
        }
        die(json_encode($data));
    }



    public function booking($slug)
    {   
        $data = array();

        if( !empty($this->input->get('embed')) && $this->input->get('embed') == 'true'){
          $is_embed = true;
        }else{
          $is_embed = false;
        }

        $data['is_embed'] = $is_embed;
        if($is_embed == true){
          $data['page'] = FALSE;
        }


        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $this->session->set_userdata('business_slug', $slug);
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        session_insert($data['company']->uid);

        $user = $this->common_model->get_by_id($data['company']->user_id, 'users');
        if ($user->status == 2) {
            redirect(base_url());
            exit();
        }
        $data['user'] = $this->common_model->get_by_id($data['company']->user_id, 'users');
        
        $my_days = $this->admin_model->get_my_days($data['company']->uid);
        //echo "<pre>"; print_r($my_days); exit();
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


        $data['page'] = 'Company';
        $data['page_title'] = 'Booking';
        $data['company_id'] = $data['company']->uid;
        if ($data['company']->enable_category == 1) {
            $data['categories'] = $this->common_model->get_category_services($data['company']->uid);
        }else{
            $data['services'] = $this->common_model->get_by_company($data['company']->uid, 'services');
        }

        $data['locations'] = $this->common_model->get_locations(0, $data['company']->uid);
        $data['sub_locations'] = $this->common_model->get_locations(1, $data['company']->uid);

        $data['dialing_codes'] = $this->common_model->select_asc('dialing_codes');
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/booking', $data, TRUE);
        $this->load->view('index', $data);
        
    }


    // load currency by ajax
    public function load_sub_location($location_id)
    {
        $location = $this->common_model->get_by_id($location_id, 'locations');
        $sub_locations = $this->common_model->get_sub_locations($location_id);
        $this->session->set_userdata('location_id', $location_id);
        session_store($location->business_id, $location_id, 'location_id');

        if (empty($sub_locations)) {
            echo '<option value="0">'.trans('no-data-found').'</option>';
        }else{
            foreach ($sub_locations as $location) { 
                echo '<option value="'.$location->id.'">'.$location->name.' '.$location->address.''. '</option>';
            }

            if (!empty($sub_locations)) {
                $this->session->set_userdata('sub_location_id', $sub_locations[0]->id);
                session_store($location->business_id, $sub_locations[0]->id, 'sub_location_id');
            }
        }
    }


    // load sub_location
    public function sess_sub_location($sub_location_id)
    {
        $this->session->set_userdata('sub_location_id', $sub_location_id);
        $sub_location = $this->common_model->get_by_id($sub_location_id, 'locations');
        if (!empty($sub_location)) {
            session_store($sub_location->business_id, $sub_location_id, 'sub_location_id');
        }
    }


    // load staff
    public function sess_staff($id, $business_id)
    {

        $company = $this->common_model->get_by_uid($business_id, 'business');
        session_store($company->uid, $id, 'staff_id');

        $this->session->unset_userdata('staff_id');
        $this->session->set_userdata('staff_id', $id);
        
        $data = array();
        $staff_days = $this->check_staff_schedule($id);
      
        // if staff have schedules
        if ($staff_days == 'staff') {
            $my_days = $this->admin_model->get_staff_days($id);
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
            $data['page'] = 'Company';
            $data['page_title'] = 'Booking';
            $data['company_id'] = $company->uid;
            $data['company'] = $company;
            $loaded = $this->load->view('include/custom-js', $data, true);
            echo json_encode(array('st' => 1, 'loaded' => $loaded));
        }else{
            $my_days = $this->admin_model->get_my_days($company->uid);
            //echo "<pre>"; print_r($my_days); exit();

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
            $data['page'] = 'Company';
            $data['page_title'] = 'Booking';
            $data['company_id'] = $company->uid;
            $data['company'] = $company;
            $loaded = $this->load->view('include/custom-js', $data, true);
            echo json_encode(array('st' => 1, 'loaded' => $loaded));
        }

    }
    

    public function check_staff_schedule($id)
    {
        $days = $this->admin_model->get_staff_days($id);
        if (!empty($days)) {
            if (empty($days[0]['start']) && empty($days[1]['start']) && empty($days[2]['start']) && empty($days[3]['start']) && empty($days[4]['start']) && empty($days[5]['start']) && empty($days[6]['start'])) {
                return 'company';
            }elseif (!empty($days[0]['start']) || !empty($days[1]['start']) || !empty($days[2]['start']) || !empty($days[3]['start']) || !empty($days[4]['start']) || !empty($days[5]['start']) || !empty($days[6]['start'])) {
                return 'staff';
            }else{
                return 'company';
            }
        }else{
            return 'company';
        }
    }


    public function load_staff($id)
    {
        $data = array();
        $data['service'] = $this->common_model->get_service_staffs($id);
        $data['company'] = $this->common_model->get_by_uid($data['service']->business_id, 'business');
        session_store($data['service']->business_id, $id, 'service_id');

        $this->session->set_userdata('service_id', $id);

        if (!empty($data['service'])) {
            $loaded = $this->load->view('include/staff_item', $data, true);
            echo json_encode(array('st' => 1, 'loaded' => $loaded));
        }else{
            $loaded = $this->load->view('include/staff_item', $data, true);
            echo json_encode(array('st' => 0, 'loaded' => $loaded));
        }
    }


    public function confirm_booking($slug, $appointment_id)
    {
        $data = array();

        if(!empty($this->input->get('embed')) && $this->input->get('embed') == 'true'){
          $is_embed = true;
        }else{
            $is_embed = false;

            if (!is_customer() && !is_guest()) {
                redirect(base_url());
            }
        }
        
        if($is_embed == true){
          $data['page'] = FALSE;
        }
       
        $data['is_embed'] = $is_embed;
        $data['page'] = 'Company';
        $data['page_title'] = 'Booking Confirm';
        $data['menu'] = FALSE;
        $data['slug'] = $slug;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $data['appointment'] = $this->common_model->get_appointment_md5($appointment_id);

        $data['appointment_id'] = $data['appointment']->user_id;

        $this->session->set_userdata('appointment_id', $data['appointment']->id);
        $this->session->set_userdata('company_slug', $slug);

        $ses_data = array(
            'appointment_id' => $data['appointment']->id
        );
        $this->session->set_userdata($ses_data);
        $mercado = $this->mercado_api_link();
        $data['init'] = $mercado['init'];

        $data['user'] = $this->common_model->get_by_id($data['appointment']->user_id, 'users');
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/booking', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function mercado(){

        $appointment = $this->admin_model->get_by_id($this->session->userdata('appointment_id'), 'appointments');
        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');

        if (settings()->enable_wallet == 1) {
            $mercado_token = settings()->mercado_token;
        }else{
            $mercado_token = $user->mercado_token;
        }

        $access_token = $mercado_token;
        $respuesta = array(
            'Payment' => $_GET['payment_id'],
            'Status' => $_GET['status'],
            'MerchantOrder' => $_GET['merchant_order_id']        
        ); 
        MercadoPago\SDK::setAccessToken($access_token);
        $merchant_order = $_GET['payment_id'];

        $payment = MercadoPago\Payment::find_by_id($merchant_order);
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order->id);

        //$merchant_order->payments
        redirect(base_url('admin/payment/payment_success/'.$appointment->id.'/mercadopago'));

    }

    public function mercado_api_link(){

        $appointment = $this->common_model->get_appointment_md5(md5($this->session->userdata('appointment_id')));

        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');
        //echo "<pre>"; print_r($user); exit();

        if (settings()->enable_wallet == 1) {
            $mercado_token = settings()->mercado_token;
            $mercado_currency = settings()->mercado_currency;
        }else{
            $mercado_token = $user->mercado_token;
            $mercado_currency = $user->mercado_currency;
        }

        $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
        if ($check_coupon != FALSE):
            if (!empty($check_coupon)):
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = $check_coupon->discount;
                $totalCost = $price - ($price * ($discount / 100));
                $discount_amount = $price - $totalCost;
            else:
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = 0;
                $discount_amount = 0;
                $totalCost = $price;
            endif;
        else:
            $totalCost = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
        endif;
       
        $data = [];
        MercadoPago\SDK::setAccessToken($mercado_token);
        $preference = new MercadoPago\Preference();
        // Create a preference item
        $item = new MercadoPago\Item();
        $item->title = 'Appointment Payment';
        $item->quantity = 1;
        $item->unit_price = $totalCost;
        $item->currency_id = $mercado_currency;
        $preference->items = array($item);
        $preference->back_urls = array(
            "success" => base_url("company/mercado"),
            "failure" => base_url("company/mercado"),
            "pending" => base_url("company/mercado")
        );
        $preference->auto_return = "approved";

        $preference->save();
        $data['f_id'] = $preference->id;
        $data['init'] = $preference->init_point;
        return $data;
    }




    public function check_coupon($code, $appointment_id)
    {
        if (empty($code)) {
            echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code'))); exit();
        }
        $appointment = $this->common_model->get_by_id($appointment_id, 'appointments');
        $service = $this->common_model->get_by_id($appointment->service_id, 'services');
        $coupon = $this->common_model->get_coupon($code, $appointment->service_id, $appointment->business_id);
        $company = $this->admin_model->get_business_uid($appointment->business_id);

        if (empty($coupon)) {
            echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code')));
        } else {
            if (date('Y-m-d') >= $coupon->start_date && date('Y-m-d') <= $coupon->end_date) {
                
                //check coupon limit
                if ($coupon->usages_limit == 0) {
                    echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code'))); exit();
                }

                if ($coupon->once_per_customer == 1) {
                    $check = $this->common_model->check_coupon_apply($code, $appointment->service_id, $service->business_id, $appointment->customer_id);
                    if (isset($check)) {
                        echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('already-applied-code'))); exit();
                    }
                }

                if ($appointment->group_booking != 0) {
                    $price = ($appointment->total_person + 1) * $service->price;
                }else{
                    $price = $service->price;
                }

                //insert apply coupon data
                $data = array(
                    'code' => $code,
                    'discount' => $coupon->discount,
                    'appointment_id' => $appointment->id,
                    'business_id' => $service->business_id,
                    'service_id' => $appointment->service_id,
                    'customer_id' => $appointment->customer_id,
                    'created_at' => my_date_now()
                    //'created_at' => user_date_now($company->time_zone)
                );
                $this->admin_model->insert($data, 'coupons_apply');

                //update coupon
                $coupon_data = array(
                    'usages_limit' => $coupon->usages_limit - 1,
                    'used' => $coupon->used + 1
                );
                $this->admin_model->edit_option($coupon_data, $coupon->id, 'coupons');
                echo json_encode(array('st' => 1, 'discount' => $coupon->discount, 'total_price' => $price, 'msg' => '<i class="fas fa-check-circle"></i> '.trans('coupon-applied-successfully')));

            }else{
                echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code')));
            }
        }exit();
        
    }


    public function confirm_pay_info($slug, $id)
    {
        if ($_POST) {
            
            if (is_customer()) {
                $url = base_url('customer/appointments');
            }
            if (is_guest()) {
                $url = base_url('company/booking_success/'.$slug);
            }

            $data = array(
                'pay_info' => 2,
            );
            $this->admin_model->edit_option($data, $id, 'appointments');
            echo json_encode(array('st' => 1, 'url' => $url));
        }
    }


    public function confirm_embed_pay($slug, $id, $status)
    {
        $url = base_url('company/booking_success/'.$slug.'?embed=true');
        $data = array(
            'pay_info' => $status,
        );
        $this->admin_model->edit_option($data, $id, 'appointments');
        echo json_encode(array('st' => 1, 'url' => $url));
        
    }

    public function booking_success($slug)
    {   
        $data = array();
        if(!empty($this->input->get('embed')) && $this->input->get('embed') == 'true'){
          $is_embed = true;
        }else{
          $is_embed = false;
        }

        if (is_guest()) {
            $this->session->unset_userdata('id');
            $this->session->unset_userdata('name');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('role');
            $this->session->unset_userdata('logged_in');
        }
      
        $data['is_embed'] = $is_embed;
        $data['page'] = 'Company';
        $data['page_title'] = 'Appointment Confirmation';
        $data['slug'] = $slug;
        $data['menu'] = FALSE;
        $data['company'] = $this->common_model->get_by_slug($slug, 'business');
        $template = $data['company']->template_style;
        $data['main_content'] = $this->load->view('templates/style_'.$template.'/booking_msg', $data, TRUE);
        $this->load->view('index', $data);
    }


    //book embedded appointment
    public function book_appointment($slug)
    {   
        $company = $this->common_model->get_by_slug($slug, 'business');
        $id = $company->user_id;
        $is_customer_exist = $this->input->post('is_customer_exist');
        //echo $is_customer_exist; exit();

        $user = $this->common_model->get_by_id($id, 'users');
        $date = $this->input->post('date');
        $date = date("Y-m-d", strtotime($date));

        if ($_POST) {

            //check reCAPTCHA
            if (!$this->recaptcha_verify_request()) {
                $msg = trans('recaptcha-is-required');
                echo json_encode(array('st'=> 4, 'msg' => $msg)); exit();
            } else {

                if (date('Y-m-d') > $date) {  
                    $msg = trans('please-enter-a-valid-date');
                    echo json_encode(array('st'=>2, 'msg' => $msg)); exit();
                }

                if ($is_customer_exist == 0 || $is_customer_exist == 2) {
                    $this->form_validation->set_rules('email', trans('email'), 'required');
                    $this->form_validation->set_rules('phone', trans('phone'), 'required');

                    if ($is_customer_exist != 2) {
                        $this->form_validation->set_rules('new_password', trans('password'), 'required');
                    }

                    if ($this->form_validation->run() === false) {
                        $error = strip_tags(validation_errors());
                        echo json_encode(array('st'=>3,'error'=> $error));
                        exit();
                    }
                    
                    $password = hash_password($this->input->post('new_password'));
                    $role = 'customer';

                    if ($is_customer_exist == 2) {
                        $password = hash_password('1234');
                        $role = 'guest';
                    }

                } else {
                    $role = 'customer';

                    if (empty(customer())) {
                        $customer = $this->common_model->check_customer($this->input->post('user_name'));
                        if (empty($customer)) {
                            $msg = trans('incorrect-username-or-password');
                            echo json_encode(array('st'=>0, 'msg' => $msg)); exit();
                        }

                        $password = $customer->password;
                        $customer_id = $customer->id;
                    }else{
                        $customer_id = customer()->id;
                        $password = customer()->password;
                    }

                }

   
                $mail =  strtolower(trim($this->input->post('email', true)));
                $phone = '+'.$this->input->post('carrierCode', true).''.$this->input->post('phone', true);
                
                $newuser_data=array(
                    'user_id' => $company->user_id,
                    'business_id' => $company->uid,
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'phone' => $phone,
                    'role' => $role,
                    'status' => 1,
                    'image' => 'assets/images/no-photo.png',
                    'thumb' => 'assets/images/no-photo-sm.png',
                    'password' => $password,
                    'created_at' => user_date_now($company->time_zone),
                );

                //insert new customer
                $newuser_data = $this->security->xss_clean($newuser_data);
                if ($is_customer_exist == 0) {
                    $check_phone = $this->auth_model->check_customer_phone($phone);
                    $check_email = $this->auth_model->check_duplicate_email($mail);

                    if (!empty($phone) && $check_phone){
                        $msg = trans('phone-exist');
                        echo json_encode(array('st'=>6, 'msg' => $msg));
                        exit();
                    } 

                    if (!empty($mail) && $check_email){
                        $msg = trans('email-exist');
                        echo json_encode(array('st'=>6, 'msg' => $msg));
                        exit();
                    } 
                    $customer_id = $this->admin_model->insert($newuser_data, 'customers');
                }

                //insert guest
                if ($is_customer_exist == 2) {
                    $customer_id = $this->admin_model->insert($newuser_data, 'customers');
                }


                if ($this->input->post('staff_id') == 0) {
                    //$random_staff = $this->common_model->get_random_staffs($company->uid, $this->input->post('service_id'), 'services');
                    //$staff_id = $random_staff->id;
                    $staff_id = 0;
                } else {
                    $staff_id = $this->input->post('staff_id');
                }

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

                if (empty($this->input->post('group_booking'))) {
                    $group_booking = 0;
                    $total_person = 0;
                }else{
                    $group_booking = $this->input->post('group_booking'); 
                    $total_person = $this->input->post('total_person'); 
                }
                

                $booking_data = array(
                    'number' => random_string('numeric',5),
                    'user_id' => $company->user_id,
                    'business_id' => $company->uid,
                    'customer_id' => $customer_id,
                    'service_id' => $this->input->post('service_id', true),
                    'note' => $this->input->post('note'),
                    'location_id' => $location_id,
                    'sub_location_id' => $sub_location_id,
                    'group_booking' => $group_booking,
                    'total_person' => $total_person,
                    'staff_id' => $staff_id,
                    'date' => $this->input->post('date', true),
                    'time' => $this->input->post('time', true),
                    'status' => 0,
                    'pay_info' => $this->input->post('pay_info', true),
                    'created_at' => user_date_now($company->time_zone)
                );
                
                // send sms to customer
                if ($user->enable_sms_notify == 1) {
                    $this->load->model('sms_model');
                    $customer = $this->admin_model->get_by_id($customer_id, 'customers');
                    $service = $this->admin_model->get_by_id($this->input->post('service_id'), 'services');
                    $message = trans('appointment').' '.$company->name.' - '.$service->name.' '.trans('booking-is-confirmed-at').' '.$this->input->post('date').' '.$this->input->post('time');
                    
                    //check twillo api keys
                    if (!empty($user->twillo_account_sid) && !empty($user->twillo_auth_token)) {
                        $response = $this->sms_model->send_user($customer->phone, $message, $user->id);
                    }
                }


                
                // send email to customer
                $customer = $this->admin_model->get_by_id($customer_id, 'customers');
                $location = $this->admin_model->get_by_id($location_id, 'locations');
                if (!empty($location)) {
                    $app_location = ' on '.$location->name.' ('.$location->address.')';
                }else{
                    $app_location = '';
                }
                $service = $this->admin_model->get_by_id($this->input->post('service_id'), 'services');


                if(!empty($service->zoom_link)){$zoom_link = trans('zoom-meeting-link').': <a href='.$service->zoom_link.'>'.$service->zoom_link.'</a>';}
                if(!empty($service->google_meet)){$google_meet = trans('google-meet-link').': <a href='.$service->google_meet.'>'.$service->google_meet.'</a>';}
                $meeting = $zoom_link .'<br>'.$google_meet;

                $subject = trans('appointment-confirmation').' - '.$company->name;
                $content = trans('appointment').' '.$company->name.' - '.$service->name.' '.trans('booking-is-confirmed-at').' '.$this->input->post('date').' '.$this->input->post('time').$app_location.'<br>'.$meeting;
                
                $edata = array();
                $edata['subject'] = $subject;
                $edata['message'] = $content;

                $message = $this->load->view('email_template/appointment', $edata, true);
                $this->email_model->send_email($customer->email, $subject, $message);


                // send email to user
                $subject = $service->name.' - '.trans('new-appointment-is-booked');
                $content = $customer->name.', '.trans('recently-booked-an-appointment').' '.$this->input->post('date').' '.$this->input->post('time');

                $edata = array();
                $edata['subject'] = $subject;
                $edata['message'] = $content;

                $message = $this->load->view('email_template/appointment', $edata, true);
                $this->email_model->send_email($company->email, $subject, $message);


                // send email to staff
                $staff_info = $this->admin_model->get_by_id($staff_id, 'staffs');
                $subject = $service->name.' - '.trans('new-appointment-is-booked');
                $content = $customer->name.', '.trans('recently-booked-an-appointment').' '.$this->input->post('date').' '.$this->input->post('time');

                $edata = array();
                $edata['subject'] = $subject;
                $edata['message'] = $content;

                $message = $this->load->view('email_template/appointment', $edata, true);
                $this->email_model->send_email($staff_info->email, $subject, $message);
                

                // old user
                if ($is_customer_exist == 1) {
                    $exist_customer = $this->auth_model->validate_customer();
                    
                    if (empty(customer())) {
                        if(password_verify($this->input->post('old_password'), $exist_customer->password)){
                            $data = array(
                                'id' => $exist_customer->id,
                                'name' => $exist_customer->name,
                                'thumb' => $exist_customer->thumb,
                                'email' =>$exist_customer->email,
                                'role' => 'customer',
                                'parent' => 0,
                                'logged_in' => TRUE
                            );
                            $data = $this->security->xss_clean($data);
                            $this->session->set_userdata($data);
                        
                            $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                            $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id));
                            $msg = trans('appointment-booked-successfully');

                            echo json_encode(array('st'=>1,'url'=> $url, 'msg' => $msg));
                        }else{ 
                            $msg = trans('incorrect-username-or-password');
                            echo json_encode(array('st'=>0, 'msg' => $msg));
                        }
                    }else{
                        $ses_data = array(
                            'id' => customer()->id,
                            'name' => customer()->name,
                            'thumb' => customer()->thumb,
                            'email' =>customer()->email,
                            'role' => 'customer',
                            'parent' => 0,
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($ses_data);

                        $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                        $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id));
                        $msg = trans('appointment-booked-successfully');
                        echo json_encode(array('st'=>1,'url'=> $url, 'msg' => $msg));
                    }

                }else {

                    $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                    $register = $this->common_model->get_by_id($customer_id, 'customers');
                    $data = array(
                        'id' => $register->id,
                        'name' => $register->name,
                        'thumb' => $register->thumb,
                        'email' =>$register->email,
                        'role' => $register->role,
                        'parent' => 0,
                        'logged_in' => TRUE
                    );
                    $data = $this->security->xss_clean($data);
                    $this->session->set_userdata($data);

                    $msg = trans('appointment-booked-successfully');
                    $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id));
                    echo json_encode(array('st'=>1, 'msg' => $msg, 'url'=> $url));
                }
                

            }
        }
    }



    //book embedded appointment
    public function book_embed_appointment($slug)
    {   
        $company = $this->common_model->get_by_slug($slug, 'business');
        $id = $company->user_id;
        $is_customer_exist = $this->input->post('is_customer_exist');
        $user = $this->common_model->get_by_id($id, 'users');
        $date = $this->input->post('date');
        $date = date("Y-m-d", strtotime($date));

        if ($_POST) {

            

                if (date('Y-m-d') > $date) {  
                    $msg = trans('please-enter-a-valid-date');
                    echo json_encode(array('st'=>2, 'msg' => $msg)); exit();
                }

                if ($is_customer_exist == 0 || $is_customer_exist == 2) {
                    $this->form_validation->set_rules('email', trans('email'), 'required');
                    $this->form_validation->set_rules('phone', trans('phone'), 'required');

                    if ($is_customer_exist != 2) {
                        $this->form_validation->set_rules('new_password', trans('password'), 'required');
                    }

                    if ($this->form_validation->run() === false) {
                        $error = strip_tags(validation_errors());
                        echo json_encode(array('st'=>3,'error'=> $error));
                        exit();
                    }
                    
                    $password = hash_password($this->input->post('new_password'));
                    $role = 'customer';

                    if ($is_customer_exist == 2) {
                        $password = hash_password('1234');
                        $role = 'guest';
                    }

                } else {

                    $role = 'customer';
                    if (empty(customer())) {
                        $customer = $this->common_model->check_customer($this->input->post('user_name'));
                        if (empty($customer)) {
                            $msg = trans('incorrect-username-or-password');
                            echo json_encode(array('st'=>0, 'msg' => $msg)); exit();
                        }

                        $password = $customer->password;
                        $customer_id = $customer->id;
                    }else{
                        $customer_id = customer()->id;
                        $password = customer()->password;
                    }
                }

   
                $mail =  strtolower(trim($this->input->post('email', true)));
                $phone = '+'.$this->input->post('carrierCode', true).''.$this->input->post('phone', true);
                
                $newuser_data=array(
                    'user_id' => $company->user_id,
                    'business_id' => $company->uid,
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'phone' => $phone,
                    'role' => $role,
                    'status' => 1,
                    'image' => 'assets/images/no-photo.png',
                    'thumb' => 'assets/images/no-photo-sm.png',
                    'password' => $password,
                    'created_at' => user_date_now($company->time_zone),
                );

                //insert new customer
                $newuser_data = $this->security->xss_clean($newuser_data);
                if ($is_customer_exist == 0) {
                    $check_phone = $this->auth_model->check_customer_phone($phone);
                    $check_email = $this->auth_model->check_duplicate_email($mail);

                    if (!empty($phone) && $check_phone){
                        $msg = trans('phone-exist');
                        echo json_encode(array('st'=>6, 'msg' => $msg));
                        exit();
                    } 

                    if (!empty($mail) && $check_email){
                        $msg = trans('email-exist');
                        echo json_encode(array('st'=>6, 'msg' => $msg));
                        exit();
                    } 
                    $customer_id = $this->admin_model->insert($newuser_data, 'customers');
                }

                //insert guest
                if ($is_customer_exist == 2) {
                    $customer_id = $this->admin_model->insert($newuser_data, 'customers');
                }


                if ($this->input->post('staff_id') == 0) {
                    //$random_staff = $this->common_model->get_random_staffs($company->uid, $this->input->post('service_id'), 'services');
                    //$staff_id = $random_staff->id;
                    $staff_id = 0;
                } else {
                    $staff_id = $this->input->post('staff_id');
                }

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

                if (empty($this->input->post('group_booking'))) {
                    $group_booking = 0;
                    $total_person = 0;
                }else{
                    $group_booking = $this->input->post('group_booking'); 
                    $total_person = $this->input->post('total_person'); 
                }
                

                $booking_data = array(
                    'number' => random_string('numeric',5),
                    'user_id' => $company->user_id,
                    'business_id' => $company->uid,
                    'customer_id' => $customer_id,
                    'service_id' => $this->input->post('service_id', true),
                    'note' => $this->input->post('note'),
                    'location_id' => $location_id,
                    'sub_location_id' => $sub_location_id,
                    'group_booking' => $group_booking,
                    'total_person' => $total_person,
                    'staff_id' => $staff_id,
                    'date' => $this->input->post('date', true),
                    'time' => $this->input->post('time', true),
                    'status' => 0,
                    'pay_info' => $this->input->post('pay_info', true),
                    'created_at' => user_date_now($company->time_zone)
                );
                
                // send sms to customer
                if ($user->enable_sms_notify == 1) {
                    $this->load->model('sms_model');
                    $customer = $this->admin_model->get_by_id($customer_id, 'customers');
                    $service = $this->admin_model->get_by_id($this->input->post('service_id'), 'services');
                    $message = trans('appointment').' '.$company->name.' - '.$service->name.' '.trans('booking-is-confirmed-at').' '.$this->input->post('date').' '.$this->input->post('time');
                    
                    //check twillo api keys
                    if (!empty($user->twillo_account_sid) && !empty($user->twillo_auth_token)) {
                        //$response = $this->sms_model->send_user($customer->phone, $message, $user->id);
                    }
                }
                
                // send email to customer
                $customer = $this->admin_model->get_by_id($customer_id, 'customers');
                $service = $this->admin_model->get_by_id($this->input->post('service_id'), 'services');
                $subject = trans('appointment-confirmation').' - '.$this->settings->site_name;
                $message = trans('appointment').' '.$company->name.' - '.$service->name.' '.trans('booking-is-confirmed-at').' '.$this->input->post('date').' '.$this->input->post('time');
                //$this->email_model->send_email($customer->email, $subject, $message);


                // send email to user
                $subject = $service->name.' - '.trans('new-appointment-is-booked');
                $message = $customer->name.', '.trans('recently-booked-an-appointment').' '.$this->input->post('date').' '.$this->input->post('time');
                //$this->email_model->send_email($company->email, $subject, $message);


                // send email to staff
                $staff_info = $this->admin_model->get_by_id($staff_id, 'staffs');
                $subject = $service->name.' - '.trans('new-appointment-is-booked');
                $message = $customer->name.', '.trans('recently-booked-an-appointment').' '.$this->input->post('date').' '.$this->input->post('time');
                //$this->email_model->send_email($staff_info->email, $subject, $message);
                

                // old user
                if ($is_customer_exist == 1) {
                    $exist_customer = $this->auth_model->validate_customer();
                    
                    if (empty(customer())) {
                        if(password_verify($this->input->post('old_password'), $exist_customer->password)){
                            $data = array(
                                'id' => $exist_customer->id,
                                'name' => $exist_customer->name,
                                'thumb' => $exist_customer->thumb,
                                'email' =>$exist_customer->email,
                                'role' => 'customer',
                                'parent' => 0,
                                'logged_in' => TRUE
                            );
                            $data = $this->security->xss_clean($data);
                            $this->session->set_userdata($data);
                        
                            $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                            $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id).'?embed=true');
                            $msg = trans('appointment-booked-successfully');

                            echo json_encode(array('st'=>1,'url'=> $url, 'msg' => $msg));
                        }else{ 
                            $msg = trans('incorrect-username-or-password');
                            echo json_encode(array('st'=>0, 'msg' => $msg));
                        }
                    }else{
                        $ses_data = array(
                            'id' => customer()->id,
                            'name' => customer()->name,
                            'thumb' => customer()->thumb,
                            'email' =>customer()->email,
                            'role' => 'customer',
                            'parent' => 0,
                            'logged_in' => TRUE
                        );
                        $this->session->set_userdata($ses_data);

                        $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                        $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id).'?embed=true');
                        $msg = trans('appointment-booked-successfully');
                        echo json_encode(array('st'=>1,'url'=> $url, 'msg' => $msg));
                    }

                }else {

                    $appointment_id = $this->admin_model->insert($booking_data, 'appointments');
                    $register = $this->common_model->get_by_id($customer_id, 'customers');
                    $data = array(
                        'id' => $register->id,
                        'name' => $register->name,
                        'thumb' => $register->thumb,
                        'email' =>$register->email,
                        'role' => $register->role,
                        'parent' => 0,
                        'logged_in' => TRUE
                    );
                    $data = $this->security->xss_clean($data);
                    $this->session->set_userdata($data);

                    $msg = trans('appointment-booked-successfully');
                    $url = base_url('company/confirm_booking/'.$slug.'/'.md5($appointment_id).'?embed=true');
                    echo json_encode(array('st'=>1, 'msg' => $msg, 'url'=> $url));
                }

            
        }
    }

}

