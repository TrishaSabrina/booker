<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupons extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_admin() && !is_user()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $data = array();
        $data['page_title'] = 'Coupons';      
        $data['page'] = 'Coupons';   
        $data['coupon'] = FALSE;
        $data['coupons'] = $this->admin_model->select_by_user('coupons');
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['main_content'] = $this->load->view('admin/user/coupons',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
        if($_POST)
        {   
            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('code', trans('code'), 'required|max_length[100]');
            $this->form_validation->set_rules('discount', trans('discount'), 'required');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/coupons'));
            } else {
                if (empty($this->input->post('once_per_customer'))) {
                    $once_per_customer = 0;
                }else {
                    $once_per_customer = $this->input->post('once_per_customer');
                }
                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'service_id' => $this->input->post('service_id', true),
                    'code' => $this->input->post('code', true),
                    'discount' => $this->input->post('discount', true),
                    'start_date' => $this->input->post('start_date', true),
                    'end_date' => $this->input->post('end_date', true),
                    'usages_limit' => $this->input->post('usages_limit', true),
                    'once_per_customer' => $once_per_customer,
                    'status' => $this->input->post('status'),
                    'created_at' => my_date_now()
                );
                $data = $this->security->xss_clean($data);

                if (!empty($id)) {
                    $this->admin_model->edit_option($data, $id, 'coupons');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {
                    $this->admin_model->insert($data, 'coupons');
                    $this->session->set_flashdata('msg', trans('inserted-successfully')); 
                }

                redirect(base_url('admin/coupons'));

            }
        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['coupon'] = $this->admin_model->select_option($id, 'coupons');
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['main_content'] = $this->load->view('admin/user/coupons',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function update_status($status, $id) 
    {
        $data = array(
            'status' => $status
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'coupons');
        $this->session->set_flashdata('msg', trans('activate-successfully')); 
        redirect(base_url('admin/staff'));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'coupons'); 
        echo json_encode(array('st' => 1));
    }












    // plan coupons

    public function delete_plan_coupons($id)
    {
        $this->admin_model->delete($id,'plan_coupons'); 
        echo json_encode(array('st' => 1));
    }

    public function delete_uid($id)
    {
        $this->admin_model->delete_uid($id,'plan_coupons'); 
        echo json_encode(array('st' => 1));
    }



    public function apply()
    {  
        $data = array();
        $data['page_title'] = 'Redeem Coupon';
        $data['packages'] = $this->admin_model->get_admin_package_features(1);
        $data['features'] = $this->admin_model->get_features();
        $data['main_content'] = $this->load->view('admin/user/coupons_apply',$data,TRUE);
        $this->load->view('admin/index',$data);
    }



    public function plan()
    {
        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/coupons/plan');
        $total_row = $this->admin_model->get_plan_coupons(1, 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 20;
        $this->pagination->initialize($config);

        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['page_title'] = 'Coupons';      
        $data['page'] = 'Coupons';
        $data['coupons'] = $this->admin_model->get_plan_coupons(0, $config['per_page'], $page * $config['per_page']);
        $data['coupons_ext'] = $this->admin_model->select('plan_coupons');
        $data['plans'] = $this->admin_model->select_by_status('package');
        $data['main_content'] = $this->load->view('admin/user/plan_coupons',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function code($uid)
    {
       
        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/coupons/plan');
        $total_row = $this->admin_model->get_plan_coupons_by_uid($uid, 1, 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 20;
        $this->pagination->initialize($config);

        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['page_title'] = 'Plan Coupons';      
        $data['page'] = 'Coupons';
        $data['uid'] = $uid;
        $data['coupons'] = $this->admin_model->get_plan_coupons_by_uid($uid, 0, $config['per_page'], $page * $config['per_page']);
        $data['coupons_ext'] = $this->admin_model->select('plan_coupons');
        $data['plans'] = $this->admin_model->select_by_status('package');
        $data['main_content'] = $this->load->view('admin/user/plan_coupons_details',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function edit_plan_coupon($id){

        $data['page_title'] = 'Edit';      
        $data['page'] = 'Coupons';
        $data['plans'] = $this->admin_model->select_by_status('package');
        $data['coupon'] = $this->admin_model->select_option($id, 'plan_coupons');
        $data['main_content'] = $this->load->view('admin/user/plan_coupons',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function add_coupon()
    {   
        if($_POST)
        {   
            $discount = $this->input->post('discount');
            if ($discount < 1 || $discount > 100) {
                $this->session->set_flashdata('error', trans('discount-must-be-between')); 
                redirect(base_url('admin/coupons/plan'));
            }

            $id = $this->input->post('id', true);
            $uid = random_string('numeric', 4);
            $data=array(
                'uid' => $uid,
                'plan' => $this->input->post('plan'),
                'plan_type' => $this->input->post('plan_type'),
                'name' => $this->input->post('name'),
                'code' => $this->input->post('code'),
                'days' => $this->input->post('days', true),
                'discount' => $this->input->post('discount', true),
                'quantity' => $this->input->post('quantity', true),
                'discount_type' => $this->input->post('discount_type', true),
                'status' => 1,
                'created_at' => my_date_now()
            );
            
            if (!empty($id)) {
                $this->admin_model->edit_option($data, $id, 'plan_coupons');
                $this->session->set_flashdata('msg', trans('updated-successfully')); 
            } else {
                $this->admin_model->insert($data, 'plan_coupons');
                $this->session->set_flashdata('msg', trans('inserted-successfully')); 
            }
            redirect(base_url('admin/coupons/plan'));
        }      
        
    }


    public function plan_status_action($status, $id) 
    {
        $data = array(
            'status' => $status
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id, 'plan_coupons');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/coupons/plan'));
    }


    public function export($uid)
    {
         $file_name = 'coupon_codes_'.date('ymd').'-'.random_string('numeric',4).'.csv'; 
         header("Content-Description: File Transfer"); 
         header("Content-Disposition: attachment; filename=$file_name"); 
         header("Content-Type: application/csv;");
       
         // get data 
         $coupons_data = $this->fetch_data($uid);

         // file creation 
         $file = fopen('php://output', 'w');
     
         $header = array("code"); 
         fputcsv($file, $header);
         foreach ($coupons_data->result_array() as $key => $value)
         { 
           fputcsv($file, $value); 
         }
         fclose($file); 
         exit; 
    }


    function fetch_data($uid)
    {
      $this->db->select("code");
      $this->db->from('plan_coupons');
      $this->db->where('uid', $uid);
      return $this->db->get();
    }


    public function apply_coupon($code, $plan, $plan_type)
    {
       
        if (empty($code)) {
            echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code'))); exit();
        }

        $coupon = $this->admin_model->get_coupon_code($code, $plan, $plan_type);

        if (empty($coupon)) {
            echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code'))); exit();
        } else {
              
            $coupon_apply = $this->admin_model->check_coupon_code_apply($coupon->id, user()->id);
            if ($coupon_apply) {
                echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('coupon-code-already-applied'))); exit();
            }

            //check coupon limit
            if ($coupon->quantity == 0) {
                echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code'))); exit();
            }

            //insert apply coupon data
            $data = array(
                'user_id' => user()->id,
                'coupon_id' => $coupon->id,
                'created_at' => my_date_now()
            );
            $this->admin_model->insert($data, 'plan_coupons_apply');

            //update coupon
            $coupon_data = array(
                'quantity' => $coupon->quantity - 1,
                'used' => $coupon->used + 1
            );
            $this->admin_model->edit_option($coupon_data, $coupon->id, 'plan_coupons');
            echo json_encode(array('st' => 1, 'msg' => '<i class="fas fa-check-circle"></i> '.trans('coupon-applied-successfully')));

            
        }exit();
        
    }


    public function apply_coupon_old($code)
    {

        $coupon = $this->admin_model->get_coupon_code($code);
        
        if (empty($coupon)) {
            echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.trans('invalid-code')));
        } else {
            $plan = $this->admin_model->get_by_id($coupon->plan, 'package'); 
            $check_coupon = $this->admin_model->get_by_user_id('plan_coupons');

            if (isset($check_coupon)) {
                echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.'Coupon code already applied')); exit();
            }
                
            //check coupon limit
            if ($coupon->used == 1) {
                echo json_encode(array('st' => 0, 'msg' => '<i class="fas fa-times-circle"></i> '.'Coupon code already applied')); exit();
            }

            //insert apply coupon data
            $data = array(
                'apply_date' => my_date_now(),
                'user_id' => user()->id,
                'used' => 1
            );
            $this->admin_model->edit_option($data, $coupon->id, 'plan_coupons');

            $billing_type = $coupon->plan_type;
            $type_price = $billing_type.'_price';
            $price = $plan->$type_price;

            //create payment
            $pay_data=array(
                'user_id' => user()->id,
                'puid' => random_string('numeric',5),
                'package_id' => $plan->id,
                'amount' => $price,
                'billing_type' => $billing_type,
                'status' => 'verified',
                'created_at' => my_date_now(),
                'expire_on' => date('Y-m-d', strtotime('+'.$coupon->days.' day'))
            );
            $pay_data = $this->security->xss_clean($pay_data);
            //echo "<pre>"; print_r($pay_data); exit();
            $payments = $this->admin_model->get_previous_payments(user()->id);
            foreach ($payments as $pay) {
                $pays_data=array(
                    'status' => 'expired'
                );
                $this->common_model->edit_option($pays_data, $pay->id, 'payment');
            }

            $this->common_model->insert($pay_data, 'payment');


            echo json_encode(array('st' => 1, 'discount' => $coupon->discount, 'total_price' => $plan->lifetime_price, 'msg' => '<i class="fas fa-check-circle"></i> '.trans('coupon-applied-successfully')));

            
        }exit();
        
    }



}
	

