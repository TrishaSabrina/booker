<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customers extends Home_Controller {

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
        $data['page_title'] = 'Customers';      
        $data['page'] = 'Customers';   
        $data['customer'] = FALSE;
        $data['customers'] = $this->admin_model->get_customers();
        $cus_val = array();
        foreach($data['customers'] as $row)
        {
           $cus_val[] = $row->id;
        }
        $customer_array = implode (",", $cus_val);
        //$data['customers_app'] = $this->admin_model->get_booking_customers($customer_array);
        $data['main_content'] = $this->load->view('admin/user/customers',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {	
        if($_POST)
        {   

            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required|max_length[100]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/customers'));
            } else {
                if ($id != '') {
                    $new_password = $this->input->post('password');
                    if (empty($new_password)) {
                        $staff = $this->admin_model->get_by_id($id, 'customers');
                        $password = $staff->password;
                    } else {
                        $password = hash_password($this->input->post('password'));
                    }
                    
                    
                } else {
                    $new_password = $this->input->post('password');
                    $password = hash_password($this->input->post('password'));
                }

                $data=array(
                    'user_id' => user()->id,
                    'business_id' => $this->business->uid,
                    'name' => $this->input->post('name', true),
                    'email' => $this->input->post('email', true),
                    'phone' => $this->input->post('phone', true),
                    'status' => $this->input->post('status'),
                    'image' => 'assets/images/no-photo.png',
                    'thumb' => 'assets/images/no-photo-sm.png',
                    'password' => $password,
                    'created_at' => my_date_now(),
                );
                $data = $this->security->xss_clean($data);

                if ($id != '') {
                    $this->admin_model->edit_option($data, $id, 'customers');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {

                    $total = get_total_value('customers');
                    if (ckeck_plan_limit('customers', $total) == FALSE) {
                        $this->session->set_flashdata('error', trans('reached-maximum-limit'));
                        redirect(base_url('admin/customers'));
                        exit();
                    }
                    $this->admin_model->insert($data, 'customers');
                    $this->session->set_flashdata('msg', trans('inserted-successfully'));

                    $subject = trans('welcome-to').' . '.$this->settings->site_name.' . '.$this->business->name;
                    $msg = trans('new-user-account-login').' <br> '.trans('username').' '.$this->input->post('email').' <br> '.trans('password').': '.$new_password;

                    $edata = array();
                    $edata['subject'] = $subject;
                    $edata['message'] = $msg;

                    $message = $this->load->view('email_template/appointment', $edata, true);
                    $this->email_model->send_email($this->input->post('email'), $subject, $message);
                }

                redirect(base_url('admin/customers'));

            }
        }      
        
    }

    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['customer'] = $this->admin_model->select_option($id, 'customers');
        $data['services'] = $this->admin_model->select_by_user('services');
        $data['main_content'] = $this->load->view('admin/user/customers',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function details($id)
    {  
        $data = array();
        $data['page'] = 'Customers';   
        $data['page_title'] = 'Details';   
        $data['customer'] = $this->admin_model->get_by_md5_id($id, 'customers');
        $data['appointments'] = $this->admin_model->get_customer_appointments($data['customer']->id, 100);
        $data['main_content'] = $this->load->view('admin/user/customers_details',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'customers');
        $this->session->set_flashdata('msg', trans('activate-successfully')); 
        redirect(base_url('admin/customers'));
    }

    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'customers');
        $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        redirect(base_url('admin/customers'));
    }

    public function delete($id)
    {
        $this->admin_model->delete($id,'customers'); 
        echo json_encode(array('st' => 1));
    }

}
	

