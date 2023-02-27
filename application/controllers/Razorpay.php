<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Razorpay extends Home_Controller 
{

    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {  
        $data = array();
        $data['main_page'] = 'Addons';
        $data['page_title'] = 'Razorpay';
        $data['main_content'] = $this->load->view('admin/addons/setup', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

   
    // initialized cURL Request
    private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = settings()->razorpay_key_id;
        $key_secret = settings()->razorpay_key_secret;
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }   
        
    // callback method
    public function payment() {        
        
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {
            
            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $package_id = $this->input->post('merchant_order_id');
            $currency_code = settings()->currency_code;
            //$amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';

            $package = $this->common_model->get_by_id($package_id, 'package');
            $puid = random_string('numeric',5);
            $billing_type = $this->input->post('billing_type');
            
            $uid = random_string('numeric',5);
        
            if($billing_type =='monthly'):
                $amount = $package->monthly_price;
                $expire_on = date('Y-m-d', strtotime('+1 month'));
            else:
                $amount = $package->price;
                $expire_on = date('Y-m-d', strtotime('+12 month'));
            endif;
            $amount = get_tax($amount, settings()->tax_value);

            if (settings()->tax_value > 0) {
                $tax_value = settings()->tax_value;
            } else {
                $tax_value = '0';
            }


            try {                

                $ch = $this->get_curl_handle($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);

                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            
            if ($success === false) {

                $payments = $this->admin_model->get_previous_payments(user()->id);
                foreach ($payments as $pay) {
                    $pays_data=array(
                        'status' => 'expired'
                    );
                    $this->common_model->edit_option($pays_data, $pay->id, 'payment');
                }

                $pay_data = array(
                    'user_id' => user()->id,
                    'package_id' => $package->id,
                    'puid' => $uid,
                    'status' => 'verified',
                    'billing_type' => $billing_type,
                    'amount' => $amount,
                    'expire_on' => $expire_on,
                    'payment_method' => 'razorpay',
                    'tax' => $tax_value,
                    'created_at' => my_date_now()
                );
                $pay_data = $this->security->xss_clean($pay_data);
                $result = $this->common_model->insert($pay_data, 'payment');

                if (user()->user_type == 'trial') {
                    $user_data=array(
                        'user_type' => 'registered',
                        'trial_expire' => '0000-00-00'
                    );
                    $this->common_model->edit_option($user_data, user()->id, 'users');
                }



                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                
                redirect(base_url('razorpay/payment_msg/success'));
                
 
            } else {
                redirect(base_url('razorpay/payment_msg/failed'));
            }
        } else {
            redirect(base_url('razorpay/payment_msg/failed'));
        }
    } 


    public function payment_msg($type='')
    {
        if ($type == 'success') {
            $data = array();
            $data['success_msg'] = 'Success';
            $data['main_content'] = $this->load->view('admin/user/payment_msg',$data,TRUE);
            $this->load->view('admin/index',$data);
        }else{
            $data = array();
            $data['error_msg'] = 'Error';
            $data['main_content'] = $this->load->view('admin/user/payment_msg',$data,TRUE);
            $this->load->view('admin/index',$data);
        }
    }


    // initialized cURL Request
    private function get_user_curl_handle($payment_id, $amount, $user_id)  {
    	$user = $this->common_model->get_by_id($user_id, 'users');

        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
        $key_id = $user->razorpay_key_id;
        if (settings()->enable_wallet == 1) {
            $key_secret = settings()->razorpay_key_secret;
        }else{
            $key_secret = $user->razorpay_key_secret;
        }
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }   
        
    // callback method
    public function user_payment() {        
        
        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {

            $appointment = $this->admin_model->get_appointment_by_id($this->input->post('appointment_id'));
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


            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $currency_code = $this->input->post('currency_code');;
            $success = false;
            $error = '';

            try {                

                $ch = $this->get_user_curl_handle($razorpay_payment_id, $amount, $appointment->user_id);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: '.curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);

                        //Check success response
                        if ($http_status === 200 and isset($response_array['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response_array['error']['code'])) {
                                $error = $response_array['error']['code'].':'.$response_array['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$result;
                            }
                        }
                }
                //close connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'OPENCART_ERROR:Request to Razorpay Failed';
            }
            
            if ($success === false) {

                if(!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                

                redirect(base_url('admin/payment/payment_success/'.$appointment->id.'/razorpay'));
                
 
            } else {
                redirect(base_url('admin/payment/payment_cancel/'.$appointment->id));
            }
        } else {
            redirect(base_url('admin/payment/payment_cancel/'.$appointment->id));
        }
    } 


}