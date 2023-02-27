<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Payment';      
        $data['page'] = 'Settings'; 
        $payment = $this->admin_model->get_my_payment();
        $data['payment_id'] = $payment->puid;
        $data['my_payment'] = $payment;
        $data['package'] = $this->common_model->get_package_by_slug($payment->package);
        $data['main_content'] = $this->load->view('admin/payment',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function settings(){
        if (get_user_info() == FALSE) {
            redirect(base_url('404_override'));
        }
        $data = array();
        $data['page_title'] = 'Payment Settings';      
        $data['page'] = 'Settings';   
        $data['packages'] = $this->admin_model->select_asc('package');
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['users'] = $this->common_model->get_users();
        $data['main_content'] = $this->load->view('admin/payment_settings',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    //update settings
    public function update(){

        if ($_POST) {
            
            if(!empty($this->input->post('enable_payment'))){$enable_payment = $this->input->post('enable_payment', true);}
            else{$enable_payment = 0;}

            if(!empty($this->input->post('paypal_payment'))){$paypal_payment = $this->input->post('paypal_payment', true);}
            else{$paypal_payment = 0;}

            if(!empty($this->input->post('stripe_payment'))){$stripe_payment = $this->input->post('stripe_payment', true);}
            else{$stripe_payment = 0;}

            if(!empty($this->input->post('razorpay_payment'))){$razorpay_payment = $this->input->post('razorpay_payment', true);}
            else{$razorpay_payment = 0;}

            if(!empty($this->input->post('paystack_payment'))){$paystack_payment = $this->input->post('paystack_payment', true);}
            else{$paystack_payment = 0;}

            if(!empty($this->input->post('flutterwave_payment'))){$flutterwave_payment = $this->input->post('flutterwave_payment', true);}
            else{$flutterwave_payment = 0;}

            if(!empty($this->input->post('enable_offline_payment'))){$enable_offline_payment = $this->input->post('enable_offline_payment', true);}
            else{$enable_offline_payment = 0;}

            if(!empty($this->input->post('mercado_payment'))){$mercado_payment = $this->input->post('mercado_payment', true);}
            else{$mercado_payment = 0;}

            
            $data = array(
                'country' => $this->input->post('country', true),
                'offline_details' => $this->input->post('offline_details'),
                'paypal_mode' => $this->input->post('paypal_mode', true),
                'paypal_email' => $this->input->post('paypal_email', true),
                'publish_key' => $this->input->post('publish_key', true),
                'secret_key' => $this->input->post('secret_key', true),
                'paystack_secret_key' => $this->input->post('paystack_secret_key', true),
                'paystack_public_key' => $this->input->post('paystack_public_key', true),
                'razorpay_key_id' => $this->input->post('razorpay_key_id', true),
                'razorpay_key_secret' => $this->input->post('razorpay_key_secret', true),
                'enable_payment' => $enable_payment,
                'paypal_payment' => $paypal_payment,
                'stripe_payment' => $stripe_payment,
                'razorpay_payment' => $razorpay_payment,
                'paystack_payment' => $paystack_payment,
                'enable_offline_payment' => $enable_offline_payment,
                'flutterwave_payment' => $flutterwave_payment,
                'flutterwave_public_key' => $this->input->post('flutterwave_public_key', true),
                'flutterwave_secret_key' => $this->input->post('flutterwave_secret_key', true),
                'mercado_payment' => $mercado_payment,
                'mercado_api_key' => $this->input->post('mercado_api_key', true),
                'mercado_token' => $this->input->post('mercado_token', true),
                'mercado_currency' => $this->input->post('mercado_currency', true)
            );
            $this->admin_model->edit_option($data, 1, 'settings');
            $this->session->set_flashdata('msg', trans('updated-successfully'));
            redirect($_SERVER['HTTP_REFERER']);
        }
    }



    public function offline()
    {   
        if($_POST)
        {   
            $package = $this->admin_model->get_by_id($this->input->post('package'), 'package');
            $payment = $this->admin_model->get_user_payment($this->input->post('user'));

            if($this->input->post('billing_type') =='monthly'):
                $amount = round($package->monthly_price); 
                $expire_on = date('Y-m-d', strtotime('+1 month'));
            else:
                $amount = round($package->price); 
                $expire_on = date('Y-m-d', strtotime('+12 month'));
            endif;
            
            //validate inputs
            $this->form_validation->set_rules('user', trans('user'), 'required');
            $this->form_validation->set_rules('package', trans('package'), 'required');
            $this->form_validation->set_rules('status', trans('payment-status'), 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('errors', validation_errors());
                redirect(base_url('admin/payment'));
            } else {

                $data=array(
                    'user_id' => $this->input->post('user', true),
                    'package_id' => $package->id,
                    'billing_type' => $this->input->post('billing_type', true),
                    'amount' => $amount,
                    'status' => $this->input->post('status', true),
                    'created_at' => my_date_now(),
                    'expire_on' => $expire_on
                );
                $data = $this->security->xss_clean($data);

                if (empty($payment)) {
                    $this->admin_model->insert($data, 'payment');
                } else {
                    $this->admin_model->update_payment($data, $this->input->post('user'), 'payment');
                }

                $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                redirect(base_url('admin/users'));

            }
        }      
        
    }


    public function approve_offline($id) 
    {
        $data = array(
            'status' => 'verified'
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id, 'payment');
        $this->session->set_flashdata('msg','Updated Successfully'); 
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function receipt($puid)
    {
        //check auth
        if (!is_admin() && !is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Payment Receipt'; 
        $data['user'] = $this->admin_model->get_user_payment_details($puid);

        if (!is_admin()) {
            if ($data['user']->user_id != $this->session->userdata('id')) {
                redirect(base_url());
            }
        }

        $this->load->view('admin/payment/payment_invoice_receipt',$data);
    }

    public function lists()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Payment list';
        $data['payments'] = $this->admin_model->get_users_payment_lists(user()->id);
        $data['main_content'] = $this->load->view('admin/payment/payment_invoice_lists',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function transactions()
    {
        //check auth
        if (!is_admin()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Transactions';
        $data['payments'] = $this->admin_model->get_payment_lists(0);
        $data['main_content'] = $this->load->view('admin/payment/transactions',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function customer_transactions()
    {
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Transactions';
        $data['payments'] = $this->admin_model->get_customer_payment_lists(0);
        $data['main_content'] = $this->load->view('admin/payment/customer_transactions',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function customer_receipt($puid)
    {
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Payment Receipt'; 
        $data['user'] = $this->admin_model->get_customer_payment_details($puid);

        if ($data['user']->user_id != $this->session->userdata('id')) {
            redirect(base_url());
        }
            
        $this->load->view('admin/payment/customer_invoice_receipt',$data);
    }


    public function upgrade()
    {
        $data = array();
        $data['page_title'] = 'Upgrade';      
        $data['page'] = 'Payment'; 
        $payment = $this->admin_model->get_my_payment();
        $data['payment_id'] = $payment->puid;
        $data['package'] = $this->common_model->get_package_by_slug($payment->package);
        $data['main_content'] = $this->load->view('admin/upgrade',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function upgrade_operation() 
    {
        $data = array(
            'account_type' => 'pro'
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, user()->id, 'users');

        $pkg = $this->common_model->get_package_price('pro');
        $payment = $this->common_model->get_user_payment(user()->id);

        //create payment
        $pay_data=array(
            'package' => 'pro',
            'amount' => $pkg->price,
            'status' => 'pending',
            'created_at' => my_date_now()
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $this->admin_model->update($pay_data, $payment->id, 'payment');

        if (get_settings()->enable_paypal == 1) {
            redirect(base_url('admin/payment'));
        } else {
            redirect(base_url('admin/profile'));
        }
        
    }

    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'testimonials');
        $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        redirect(base_url('admin/testimonial'));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'testimonials'); 
        echo json_encode(array('st' => 1));
    }






    //******* User Payments *******//

    public function user()
    {
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
        
        $data = array();
        $data['page_title'] = 'Payment Settings'; 
        $data['page'] = 'Settings';
        $data['settings'] = $this->admin_model->get('settings');
        $data['currencies'] = $this->admin_model->select_asc('country');
        $data['packages'] = $this->admin_model->select_asc('package');
        $data['main_content'] = $this->load->view('admin/user/user_payment_settings',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    //update payment settings
    public function user_update(){
        //check auth
        if (!is_user()) {
            redirect(base_url());
        }
        
        if ($_POST) {
            
            if(!empty($this->input->post('paypal_payment'))){$paypal_payment = $this->input->post('paypal_payment', true);}
            else{$paypal_payment = 0;}

            if(!empty($this->input->post('stripe_payment'))){$stripe_payment = $this->input->post('stripe_payment', true);}
            else{$stripe_payment = 0;}

            if(!empty($this->input->post('razorpay_payment'))){$razorpay_payment = $this->input->post('razorpay_payment', true);}
            else{$razorpay_payment = 0;}

            if(!empty($this->input->post('paystack_payment'))){$paystack_payment = $this->input->post('paystack_payment', true);}
            else{$paystack_payment = 0;}

            if(!empty($this->input->post('flutterwave_payment'))){$flutterwave_payment = $this->input->post('flutterwave_payment', true);}
            else{$flutterwave_payment = 0;}

            if(!empty($this->input->post('mercado_payment'))){$mercado_payment = $this->input->post('mercado_payment', true);}
            else{$mercado_payment = 0;}
            
            $country = $this->admin_model->get_by_id($this->input->post('country'), 'country');

            $data = array(
                'country' => 0,
                'currency' => 'USD',
                'paypal_mode' => $this->input->post('paypal_mode', true),
                'paypal_email' => $this->input->post('paypal_email', true),
                'publish_key' => $this->input->post('publish_key', true),
                'secret_key' => $this->input->post('secret_key', true),
                'razorpay_key_id' => $this->input->post('razorpay_key_id', true),
                'razorpay_key_secret' => $this->input->post('razorpay_key_secret', true),
                'paystack_secret_key' => $this->input->post('paystack_secret_key', true),
                'paystack_public_key' => $this->input->post('paystack_public_key', true),
                'paystack_payment' => $paystack_payment,
                'paypal_payment' => $paypal_payment,
                'stripe_payment' => $stripe_payment,
                'razorpay_payment' => $razorpay_payment, 
                'flutterwave_payment' => $flutterwave_payment,
                'flutterwave_public_key' => $this->input->post('flutterwave_public_key', true),
                'flutterwave_secret_key' => $this->input->post('flutterwave_secret_key', true), 
                'mercado_payment' => $mercado_payment,
                'mercado_api_key' => $this->input->post('mercado_api_key', true),
                'mercado_token' => $this->input->post('mercado_token', true),
                'mercado_currency' => $this->input->post('mercado_currency', true)
            );
            $data = $this->security->xss_clean($data);
            $this->admin_model->edit_option($data, user()->id, 'users');
            $this->session->set_flashdata('msg', 'Updated Successfully'); 
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    // service payment
    public function record_payment($amp_id)
    {   
        $appointment = $this->admin_model->get_appointment_by_id($amp_id);
        $uid = random_string('numeric',5);
        
        $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
        if ($check_coupon != FALSE):
            if (!empty($check_coupon)):
                $price = $appointment->price;
                $discount = $check_coupon->discount;
                $amount = $price - ($price * ($discount / 100));
                $discount_amount = $price - $totalCost;
            else:
                $price = $appointment->price;
                $discount = 0;
                $discount_amount = 0;
                $amount = $price;
            endif;
        else:
            $amount = $appointment->price;
        endif;
        
        $pay_data = array(
            'user_id' => $appointment->user_id,
            'customer_id' => $appointment->customer_id,
            'appointment_id' => $appointment->id,
            'puid' => $uid,
            'status' => 'verified',
            'amount' => $amount,
            'payment_method' => 'offline',
            'created_at' => my_date_now()
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $response = $this->common_model->insert($pay_data, 'payment_user');
        $this->session->set_flashdata('msg', trans('inserted-successfully')); 
        redirect($_SERVER['HTTP_REFERER']);
    }











    //** ------ customer Payments ------ **//

    public function customer($amp_id){
        $data = array();
        $data['appointment'] = $this->admin_model->get_by_id($amp_id, 'appointments');
        $data['appointment_id'] = $data['appointment']->id;
        $data['user'] = $this->admin_model->get_by_id($data['appointment']->user_id, 'users');
        $data['main_content'] = $this->load->view('admin/user/patient_payment', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function stripe_appointment_payment()
    {
        
        $id = $this->input->post('appointment_id');
        $appointment = $this->common_model->get_appointment($id);
        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');
        $company = $this->admin_model->get_business_uid($appointment->business_id);
        $currency = get_currency_by_country($company->country)->currency_code;

        $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
        if ($check_coupon != FALSE):
            if (!empty($check_coupon)):
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = $check_coupon->discount;
                $amount = $price - ($price * ($discount / 100));
                $discount_amount = $price - $totalCost;
            else:
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = 0;
                $discount_amount = 0;
                $amount = $price;
            endif;
        else:
            $amount = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
        endif;

        if (settings()->enable_wallet == 1) {
            $secret_key = settings()->secret_key;
        }else{
            $secret_key = $user->secret_key;
        }

        require_once('application/libraries/stripe-php/init.php');
        \Stripe\Stripe::setApiKey($secret_key);
        
        try {
            $charge = \Stripe\Charge::create ([
                "amount" => $amount*100,
                "currency" => $currency,
                "source" => $this->input->post('stripeToken'),
                "description" => "Service payment ".get_settings()->site_name 
            ]);
            $chargeJson = $charge->jsonSerialize();
            
            $amount                  = $chargeJson['amount']/100;
            $balance_transaction     = $chargeJson['balance_transaction'];
            $currency                = $chargeJson['currency'];
            $status                  = $chargeJson['status'];
            $payment = 'success';
        }catch(Exception $e) { 
            $error = $e->getMessage(); 
            $this->session->set_flashdata('error', $error);
            $payment = 'failed';
        }

        if($payment == 'success'):  
            redirect(base_url('admin/payment/payment_success/'.$appointment->id.'/stripe'));
        else:
            redirect(base_url('customer/payment_msg/failed/'.$appointment->id));
        endif;
    }


    //payment success
    public function payment_success($amp_id, $payment_method='')
    {   

        if (settings()->type != 'live') {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $appointment = $this->common_model->get_appointment($amp_id);
        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');

        $check_coupon = check_coupon($appointment->id, $appointment->service_id, $appointment->business_id);
        if ($check_coupon != FALSE):
            if (!empty($check_coupon)):
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = $check_coupon->discount;
                $amount = $price - ($price * ($discount / 100));
                $discount_amount = $price - $totalCost;
            else:
                $price = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
                $discount = 0;
                $discount_amount = 0;
                $amount = $price;
            endif;
        else:
            $amount = get_price($appointment->price, $appointment->group_booking, $appointment->total_person);
        endif;

        $uid = random_string('numeric',5);
       
        if (isset($payment_method) && $payment_method == 'stripe') {
            $payment_method = 'stripe';
        }else if(isset($payment_method) && $payment_method == 'razorpay'){
            $payment_method = 'razorpay';
        }else if(isset($payment_method) && $payment_method == 'paystack'){
            $payment_method = 'paystack';
        }else if(isset($payment_method) && $payment_method == 'flutterwave'){
            $payment_method = 'flutterwave';
        }else if(isset($payment_method) && $payment_method == 'mercadopago'){
            $payment_method = 'mercadopago';
        }else {
            $payment_method = 'paypal';
        }

        if (settings()->enable_wallet == 1) {
            $type = 'wallet';
            $total_amount = get_commission($amount, settings()->commission_rate);
            $commission_amount = get_commission_rate($amount, settings()->commission_rate);
            $commission_rate = settings()->commission_rate;
        }else{
            $type = 'user';
            $total_amount = '0.00';
            $commission_amount = '0.00';
            $commission_rate = 0;
        }

        $pay_data = array(
            'user_id' => $user->id,
            'customer_id' => $appointment->customer_id,
            'appointment_id' => $appointment->id,
            'puid' => $uid,
            'status' => 'verified',
            'amount' => $amount,
            'total_amount' => $total_amount,
            'commission_amount' => $commission_amount,
            'commission_rate' => $commission_rate,
            'payment_method' => $payment_method,
            'type' => $type,
            'created_at' => my_date_now()
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $response = $this->common_model->insert($pay_data, 'payment_user');

        if ($response) {
            
            if (settings()->enable_wallet == 1) {
                $balance = $total_amount * 100;
                $user_data = array(
                    'balance' => $balance + $user->balance,
                    'total_sales' => $user->total_sales + 1
                );
                $this->common_model->edit_option($user_data, $user->id, 'users');
            }

            redirect(base_url('customer/payment_msg/success/'.$appointment->id));
        }
    }

    //payment cancel
    public function payment_cancel($amp_id='')
    {   
        redirect(base_url('customer/payment_msg/failed/'.$amp_id));

        // $data = array();
        // $data['error_msg'] = 'Error';
        // $data['main_content'] = $this->load->view('admin/user/payment_user_msg',$data,TRUE);
        // $this->load->view('admin/index',$data);
    }


    //payment cancel
    public function offline_payment($amp_id)
    {   
        $appointment = $this->admin_model->get_by_id($amp_id, 'appointments');
        $user = $this->admin_model->get_by_id($appointment->user_id, 'users');
        $amount = evisit_settings($user->id)->price;
        $uid = random_string('numeric',5);
        $payment_method = 'offline';
        
        $pay_data = array(
            'user_id' => $user->id,
            'patient_id' => $appointment->patient_id,
            'appointment_id' => $appointment->id,
            'puid' => $uid,
            'status' => 'verified',
            'amount' => $amount,
            'payment_method' => $payment_method,
            'created_at' => my_date_now()
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $response = $this->common_model->insert($pay_data, 'payment_user');
        $this->session->set_flashdata('msg', trans('inserted-successfully')); 
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function success_msg(){
        $data = array();
        $data['success_msg'] = 'Success';
        $data['main_content'] = $this->load->view('admin/user/payment_user_msg',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

}
	

