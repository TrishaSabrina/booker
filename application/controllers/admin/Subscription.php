<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription extends Home_Controller {

	public function __construct()
    {
        parent::__construct();

        if (!is_user()) {
            redirect(base_url());
        }
    }

    public function index()
    {
        $data = array();
        $data['page_title'] = 'Subscription';
        $data['user'] = $this->common_model->get_my_package();
        $data['features'] = $this->admin_model->get_features();
        $data['packages'] = $this->admin_model->get_package_features();
        $data['main_content'] = $this->load->view('admin/user/subscription', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function purchase($payment_id='', $slug, $billing_type)
    {   
        $data = array();
        $data['page_title'] = 'Payment';
        $data['package'] = $this->common_model->get_package_by_slug($slug);
        $data['payment'] = $this->common_model->get_payment($payment_id);
        $data['payment_id'] = $payment_id;
        $data['billing_type'] = $billing_type;
        $data['package'] = $this->common_model->get_by_id($data['package']->id, 'package'); 
        if (isset($_GET['coupon'])) {
            $data['coupon'] = $this->admin_model->get_coupon_by_code($_GET['coupon']);
        }

        $ses_data = array(
            'payment_id' => $payment_id,
            'billing_type' => $billing_type,
            'package_id' => $data['package']->id
        );
        $this->session->set_userdata($ses_data);
        $mercado = $this->mercado_api_link();
            $data['init'] = $mercado['init'];

        $data['main_content'] = $this->load->view('admin/user/purchase', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function upgrade($slug='', $status=0, $billing_type='')
    {
        if ($status == 0) {
            $data = array();
            $data['slug'] = $slug;      
            $data['billing_type'] = $billing_type;
            $data['package'] = $this->common_model->get_package_by_slug($slug);
            if (empty($data['package'])) {
                redirect(base_url('admin/subscription'));
            }
            $data['main_content'] = $this->load->view('admin/user/payment_confirm',$data,TRUE);
            $this->load->view('admin/index',$data);
        } else {
            
            $data = array();
            $data['page_title'] = 'Upgrade';      
            $data['page'] = 'Payment'; 
            $payment = $this->common_model->get_user_payment(user()->id);
            $uid = random_string('numeric',5);

            $data['payment_id'] =  $uid;
            $data['billing_type'] = $billing_type;
            $data['package'] = $this->common_model->get_package_by_slug($slug);
            if (empty($data['package'])) {
                redirect(base_url('admin/subscription'));
            }
            $package = $data['package'];

            if($billing_type =='monthly'):
                $amount = $package->monthly_price;
                $expire_on = date('Y-m-d', strtotime('+1 month'));
            endif;

            if($billing_type =='yearly'):
                $amount = $package->price;
                $expire_on = date('Y-m-d', strtotime('+12 month'));
            endif;

            if($billing_type =='lifetime'):
                $amount = $package->lifetime_price;
                $expire_on = date('Y-m-d', strtotime('+824832 day'));
            endif;


            if (number_format($amount, 0) == 0):
                $status = 'verified';
            else:
                $status = 'pending';
            endif;

            //create payment
            $pay_data=array(
                'user_id' => user()->id,
                'puid' => $uid,
                'package_id' => $package->id,
                'amount' => $amount,
                'billing_type' => $billing_type,
                'status' => $status,
                'created_at' => my_date_now(),
                'expire_on' => $expire_on
            );
            $pay_data = $this->security->xss_clean($pay_data);
            
            if (number_format($amount, 0) == 0){
                $payments = $this->admin_model->get_previous_payments(user()->id);
                foreach ($payments as $pay) {
                    $pays_data=array(
                        'status' => 'expired'
                    );
                    $this->common_model->edit_option($pays_data, $pay->id, 'payment');
                }

                $this->common_model->insert($pay_data, 'payment');
                redirect(base_url('admin/subscription'));
            }else{
                if (settings()->enable_payment == 1) {
                    redirect(base_url('admin/subscription/purchase/'.$uid.'/'.$slug.'/'.$billing_type));
                } else {
                    $payments = $this->admin_model->get_previous_payments(user()->id);
                    foreach ($payments as $pay) {
                        $pays_data=array(
                            'status' => 'expired'
                        );
                        $this->common_model->edit_option($pays_data, $pay->id, 'payment');
                    }

                    $this->common_model->insert($pay_data, 'payment');
                    redirect(base_url('admin/subscription'));
                }
            }
        }
        
    }


    public function mercado(){

        $access_token = settings()->mercado_token;
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
        redirect(base_url('admin/subscription/payment_success/'.$this->session->userdata('billing_type').'/'.$this->session->userdata('package_id').'/'.$this->session->userdata('payment_id').'/mercadopago'));

    }

    public function mercado_api_link(){

        $package = $this->common_model->get_by_id($this->session->userdata('package_id'), 'package');
        if ($this->session->userdata('billing_type') == 'monthly'):
            $price = round($package->monthly_price);
            $billing_type = 'monthly';
        else:
            $price = round($package->price);
            $billing_type = 'yearly';
        endif;
       
        $data = [];
        MercadoPago\SDK::setAccessToken(settings()->mercado_token);
        $preference = new MercadoPago\Preference();
        // Create a preference item
        $item = new MercadoPago\Item();
        $item->title = $package->name;
        $item->quantity = 1;
        $item->unit_price = $price;
        $item->currency_id = settings()->mercado_currency;
        $preference->items = array($item);
        $preference->back_urls = array(
            "success" => base_url("admin/subscription/mercado"),
            "failure" => base_url("admin/subscription/mercado"),
            "pending" => base_url("admin/subscription/mercado")
        );
        $preference->auto_return = "approved";

        $preference->save();
        $data['f_id'] = $preference->id;
        $data['init'] = $preference->init_point;
        return $data;
    }


    //stripe payment
    public function stripe_payment()
    {

        $id = $this->input->post('package_id');
        $puid = $this->input->post('payment_id');
        $package = $this->common_model->get_by_id($id, 'package');
        $billing_type = $this->input->post('billing_type');
        
        if($billing_type =='monthly'):
            $amount = round($package->monthly_price); 
            $expire_on = date('Y-m-d', strtotime('+1 month'));
        else:
            $amount = round($package->price); 
            $expire_on = date('Y-m-d', strtotime('+12 month'));
        endif;

        $amount = get_tax($amount, settings()->tax_value);
        
        require_once('application/libraries/stripe-php/init.php');
        \Stripe\Stripe::setApiKey(settings()->secret_key);
        
        try {
            $charge = \Stripe\Charge::create ([
                "amount" => $amount*100,
                "currency" => settings()->currency_code,
                "source" => $this->input->post('stripeToken'),
                "description" => "Payment from ".settings()->site_name 
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
            redirect(base_url('admin/subscription/payment_success/'.$billing_type.'/'.$id.'/'.$puid.'/stripe'));
        else:
            redirect(base_url('admin/subscription/payment_cancel/'.$billing_type.'/'.$id.'/'.$puid));
        endif;
    }


    //payment success
    public function payment_success($billing_type, $package_id, $payment_id, $payment_method='')
    {   
        if (settings()->type != 'live') {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $payments = $this->admin_model->get_previous_payments(user()->id);
        foreach ($payments as $pay) {
            $pays_data=array(
                'status' => 'expired'
            );
            $this->common_model->edit_option($pays_data, $pay->id, 'payment');
        }


        $package = $this->common_model->get_by_id($package_id, 'package');
        //$payment = $this->common_model->get_payment($payment_id);
        $uid = random_string('numeric',5);
        
        if($billing_type =='monthly'):
            $amount = $package->monthly_price;
            $expire_on = date('Y-m-d', strtotime('+1 month'));
        else:
            $amount = $package->price;
            $expire_on = date('Y-m-d', strtotime('+12 month'));
        endif;
        $amount = get_tax($amount, settings()->tax_value);

        if (empty($payment_method)) {
            $payment_method = 'paypal';
        }

        if (settings()->tax_value > 0) {
            $tax_value = settings()->tax_value;
        } else {
            $tax_value = '0';
        }

        $pay_data = array(
            'user_id' => user()->id,
            'package_id' => $package->id,
            'puid' => $payment_id,
            'status' => 'verified',
            'billing_type' => $billing_type,
            'amount' => $amount,
            'expire_on' => $expire_on,
            'payment_method' => $payment_method,
            'tax' => $tax_value,
            'created_at' => my_date_now()
        );
        $pay_data = $this->security->xss_clean($pay_data);
        $this->common_model->insert($pay_data, 'payment');

        if (user()->user_type == 'trial') {
            //update user type
            $user_data=array(
                'user_type' => 'registered',
                'trial_expire' => '0000-00-00'
            );
            $this->common_model->edit_option($user_data, user()->id, 'users');
        }
        

        $data = array();
        $data['success_msg'] = 'Success';
        $data['main_content'] = $this->load->view('admin/user/payment_msg',$data,TRUE);
        $this->load->view('admin/index',$data);

    }


    public function offline_payment()
    {   
        if($_POST)
        {   
            $package = $this->admin_model->get_by_id($this->input->post('package_id'), 'package');

            if($this->input->post('billing_type') =='monthly'):
                $amount = round($package->monthly_price); 
                $expire_on = date('Y-m-d', strtotime('+1 month'));
            else:
                $amount = round($package->price); 
                $expire_on = date('Y-m-d', strtotime('+12 month'));
            endif;

            $amount = get_tax($amount, settings()->tax_value);
            if (settings()->tax_value > 0) {
                $tax_value = settings()->tax_value;
            } else {
                $tax_value = '0';
            }

            $file_name = 'proof_'.random_string('numeric',6).'.'.pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

            if (empty($_FILES['file']['name'])) {
                $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                redirect($_SERVER['HTTP_REFERER']); exit();
            } else {
                $file_name = $file_name;
            }

            if (!empty($_FILES['file']['name'])) {
                $config['upload_path']          = './uploads/files'; //file save path
                $config['allowed_types']        = 'pdf|gif|jpg|png|JPG|GIF|PNG|jpeg|JPEG';
                $config['max_size']             = 10000;
                $config['file_name'] = $file_name;


                $this->load->library('upload', $config);
                if ( ! $this->upload->do_upload('file')){
                    $error = array('error' => $this->upload->display_errors());
                }else{
                    $data = array('upload_data' => $this->upload->data());
                }
            }

            $data=array(
                'user_id' => user()->id,
                'puid' => $payment_id,
                'package_id' => $package->id,
                'billing_type' => $this->input->post('billing_type', true),
                'amount' => $amount,
                'status' => 'pending',
                'created_at' => my_date_now(),
                'tax' => $tax_value,
                'payment_method' => 'offline',
                'proof' => $file_name,
                'expire_on' => $expire_on
            );
            $data = $this->security->xss_clean($data);
            $this->admin_model->insert($data, 'payment');
            
            $this->session->set_flashdata('msg', trans('inserted-successfully')); 
            redirect(base_url('admin/subscription'));

            
        }      
        
    }


    //payment cancel
    public function payment_cancel($billing_type, $package_id, $payment_id)
    {   
        $data = array();
        $data['error_msg'] = 'Error';
        $data['main_content'] = $this->load->view('admin/user/payment_msg',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

}