<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Home_Controller {

    public function __construct()
    {
        parent::__construct();

        if (!is_customer()) {
            redirect(base_url());
        }
    }

    public function appointments()
    {   
        $data = array();
        $data['page'] = 'Customers';
        $data['page_title'] = 'Appointments';
        $data['page_lang'] = 'appointments';
        $data['menu'] = FALSE;
        $data['appointments'] = $this->common_model->get_customer_appointments();
        $data['customer'] = $this->common_model->get_by_id(customer()->id, 'customers');
        $data['company'] = $this->common_model->get_by_uid($data['customer']->business_id, 'business');
        $data['main_content'] = $this->load->view('customers/appointments', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function payment($id)
    {   
        $data = array();
        $data['page'] = 'Customers';
        $data['page_title'] = 'Payment';
        $data['page_lang'] = 'payment';
        $data['menu'] = FALSE;
        $data['appointment'] = $this->common_model->get_appointment_md5($id);
        $data['company'] = $this->common_model->get_by_uid($data['appointment']->business_id, 'business');
        $data['appointment_id'] = $data['appointment']->user_id;
        $this->session->set_userdata('appointment_id', $data['appointment']->id);
        $this->session->set_userdata('company_slug', $data['company']->slug);

        $ses_data = array(
            'appointment_id' => $data['appointment']->id
        );
        $this->session->set_userdata($ses_data);
        $mercado = $this->mercado_api_link();
        $data['init'] = $mercado['init'];

        $data['user'] = $this->common_model->get_by_id($data['appointment']->user_id, 'users');
        $data['main_content'] = $this->load->view('customers/payment', $data, TRUE);
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
        //echo "<pre>"; print_r($appointment); exit();

        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');

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


    public function payment_msg($type, $id){
        $data = array();
        $data['menu'] = FALSE;
        $data['type'] = ucfirst($type);
        $data['id'] = $id;
        $data['main_content'] = $this->load->view('customers/payment_msg',$data,TRUE);
        $this->load->view('index',$data);
    }


    public function account()
    {   
        $data = array();
        $data['page'] = 'Customers';
        $data['page_title'] = 'Account';
        $data['page_lang'] = 'account';
        $data['menu'] = FALSE;
        $data['customer'] = $this->common_model->get_by_id(customer()->id, 'customers');
        $data['main_content'] = $this->load->view('customers/account', $data, TRUE);
        $this->load->view('index', $data);
    }


    //update user profile
    public function update(){
        
        check_status();

        if ($_POST) {

            $id = $this->input->post('id', true);
            $data = array(
                'name' => $this->input->post('name', true),
                'phone' => $this->input->post('phone', true),
                'email' => $this->input->post('email', true)
            );

            // insert photos
            if($_FILES['photo']['name'] != ''){
                $up_load = $this->admin_model->upload_image('800');
                $data_img = array(
                    'image' => $up_load['images'],
                    'thumb' => $up_load['thumb']
                );
                $this->admin_model->edit_option($data_img, $id, 'customers');   
            }

            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, $id, 'customers');
            $this->session->set_flashdata('msg', 'Updated Successfully'); 
            redirect(base_url('customer/account'));
        }
    }


    //cancel appointment
    public function cancel_appointment($status, $id){
        $data = array(
            'status' => $status
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'appointments');
        $this->session->set_flashdata('msg', 'Updated Successfully'); 
        redirect(base_url('customer/appointments'));
    }


    public function cancel($id)
    {
        $data = array(
            'status' => 2
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option_md5($data, $id, 'appointments');


        $status_text = trans('cancelled');
        $appointment = $this->admin_model->get_by_md5_id($id, 'appointments');
  
        $company = $this->admin_model->get_business($appointment->business_id);
        //notify customer
        $customer = $this->admin_model->get_by_id($appointment->customer_id, 'customers');
        $service = $this->admin_model->get_by_id($appointment->service_id, 'services');

        $subject = trans('appointment').' - '.$status_text;
        $msg = trans('appointment').' '.$service->name.' '.trans('at').' '.my_date_show($appointment->date).' '.trans('at').' '.$appointment->time.' '.trans('is').' '.$status_text;

        $edata = array();
        $edata['subject'] = $subject;
        $edata['message'] = $msg;

        $message = $this->load->view('email_template/appointment', $edata, true);
        $this->email_model->send_email($customer->email, $subject, $message);


        $user_msg = trans('customer').' '.$customer->name.', '.$status_text.' '.trans('appointment').' '.$service->name.' '.trans('at').' '.my_date_show($appointment->date).' '.trans('at').' '.$appointment->time;
        $edata['message'] = $user_msg;
        $user_msg = $this->load->view('email_template/appointment', $edata, true);

        //notify user
        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');
        $this->email_model->send_email($user->email, $subject, $user_msg);

        if ($appointment->staff_id != 0) {
            $staff = $this->admin_model->get_by_id($appointment->staff_id, 'staffs');
            $user_msg = $this->load->view('email_template/appointment', $edata, true);
            $this->email_model->send_email($staff->email, $subject, $user_msg);
        }

        // send sms to customer
        if ($user->enable_sms_notify == 1) {
            $this->load->model('sms_model');
            $response = $this->sms_model->send_user($customer->phone, $msg, $user->id);
        }

        echo json_encode(array('st' => 1));
    }



    public function change_password()
    {
        $data = array();
        $data['page'] = 'Customers';
        $data['menu'] = FALSE;
        $data['page_title'] = 'Change Password';
        $data['page_lang'] = 'change-password';
        $data['customer'] = $this->common_model->get_by_id($this->session->userdata('id'), 'customers');
        $data['main_content'] = $this->load->view('customers/account', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function customer_receipt($puid)
    {
        $data = array();
        $data['page_title'] = 'Payment Receipt'; 
        $data['user'] = $this->admin_model->get_customer_payment_details($puid);
        $this->load->view('admin/payment/customer_invoice_receipt',$data);
    }


    public function add_rating() 
    {
        if ($_POST) {
            
            $id = $this->input->post('appointment_id');
            $appointment = $this->common_model->get_by_id($id, 'appointments');
          
            $data = array(
                'user_id' => $appointment->user_id,
                'business_id' => $appointment->business_id,
                'service_id' => $appointment->service_id,
                'appointment_id' => $id,
                'customer_id' => $appointment->customer_id,
                'rating' => $this->input->post('rating'),
                'feedback' => $this->input->post('feedback'),
                'created_at' => my_date_now()
            );
            $data = $this->security->xss_clean($data);
            $this->admin_model->insert($data, 'ratings');
            $this->session->set_flashdata('msg', trans('inserted-successfully')); 
            redirect(base_url('customer/appointments'));
        }
    }
    

    //change password
    public function change()
    {   
        check_status();

        if($_POST){
            
            $id = $this->session->userdata('id');
            $user = $this->admin_model->get_by_id($id, 'customers');

            if(password_verify($this->input->post('old_pass', true), $user->password)){
                if ($this->input->post('new_pass', true) == $this->input->post('confirm_pass', true)) {
                    $data=array(
                        'password' => hash_password($this->input->post('new_pass', true))
                    );
                    $data = $this->security->xss_clean($data);
                    $this->admin_model->edit_option($data, $id, 'customers');
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