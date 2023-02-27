<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Home_Controller {

	public function __construct()
    {
        parent::__construct();
        //check auth
        if (!is_admin()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $this->all_users('all');
    }

    //all users list
    public function all_users($type)
    {

        $data = array();
        //initialize pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/users/all_users/'.$type);
        $total_row = $this->admin_model->get_all_users(1 , 0, 0, $type);
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

        $data['page_title'] = 'Users';
        $data['packages'] = $this->admin_model->select('package');
        $data['users'] = $this->admin_model->get_all_users(0 , $config['per_page'], $page * $config['per_page'], $type);
        $data['main_content'] = $this->load->view('admin/users', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['packages'] = $this->admin_model->select('package');
        $data['user'] = $this->admin_model->select_option($id, 'users');
        $data['payment'] = $this->admin_model->get_user_payment($id);
        $data['main_content'] = $this->load->view('admin/users',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {   
        if($_POST)
        {   

            $id = $this->input->post('id', true);

            //validate inputs
            $this->form_validation->set_rules('name', trans('name'), 'required|max_length[100]');
            $this->form_validation->set_rules('email', trans('email'), 'required|max_length[100]');

            if ($this->form_validation->run() === false) {
                $this->session->set_flashdata('error', validation_errors());
                redirect(base_url('admin/users'));
            } else {
                if ($id != '') {
                    $new_password = $this->input->post('password');
                    if (empty($new_password)) {
                        $user = $this->admin_model->get_by_id($id, 'users');
                        $password = $user->password;
                    } else {
                        $password = hash_password($this->input->post('password'));
                    }
                } else {
                    $new_password = $this->input->post('password');
                    $password = hash_password($this->input->post('password'));
                }

                $email = $this->auth_model->check_duplicate_email($mail);
                if ($email){
                    $this->session->set_flashdata('msg', trans('email-exist'));
                    redirect(base_url('admin/users'));
                }


                $udata=array(
                    'name' => $this->input->post('name', true),
                    'slug' => str_slug($this->input->post('name', true)),
                    'user_name' => str_slug($this->input->post('name', true)),
                    'email' => $this->input->post('email', true),
                    'phone' => $this->input->post('phone', true),
                    'thumb' => 'assets/images/no-photo-sm.png',
                    'password' => $password,
                    'role' => 'user',
                    'user_type' => 'registered',
                    'trial_expire' => '',
                    'status' => $this->input->post('status'),
                    'parent_id' => 0,
                    'paypal_payment' => 0,
                    'stripe_payment' => 0, 
                    'verify_code' => '0',
                    'email_verified' => 0,
                    'enable_appointment' => 1,
                    'created_at' => my_date_now()
                );


                if ($id != '') {
                    $this->admin_model->edit_option($udata, $id, 'users');
                    $this->session->set_flashdata('msg', trans('updated-successfully')); 
                } else {

                    $id = $this->admin_model->insert($udata, 'users');
                    $this->session->set_flashdata('msg', trans('inserted-successfully'));

                    $rand_uid = substr(random_string('numeric', 5).mt_rand(), 0, 12);
                    $uid = ltrim($rand_uid, '0');

                    $company_data=array(
                        'uid' => $uid,
                        'user_id' => $id,
                        'name' => 'Your Company',
                        'email' => $this->input->post('email', true),
                        'slug' => $uid,
                        'category' => 1,
                        'details' => '',
                        'country' => '0',
                        'type' => 1,
                        'enable_location' => 0,
                        'enable_category' => 0,
                        'status' => 1,
                        'enable_staff' => 0,
                        'template_style' => 1,
                        'created_at' => my_date_now()
                    );
                    $company_data = $this->security->xss_clean($company_data);
                    $this->common_model->insert($company_data, 'business');

                }

                $payment = $this->admin_model->get_user_payment($id);
                if($this->input->post('billing_type') =='monthly'):
                    $amount = round($package->monthly_price); 
                    $expire_on = date('Y-m-d', strtotime('+1 month'));
                else:
                    $amount = round($package->price); 
                    $expire_on = date('Y-m-d', strtotime('+12 month'));
                endif;

                $pdata=array(
                    'puid' => random_string('numeric',5),
                    'user_id' => $id,
                    'package_id' => $this->input->post('package', true),
                    'billing_type' => $this->input->post('billing_type', true),
                    'amount' => $amount,
                    'status' => $this->input->post('payment_status', true),
                    'created_at' => my_date_now(),
                    'expire_on' => $expire_on
                );
                if (empty($payment)) {
                    $this->admin_model->insert($pdata, 'payment');
                } else {
                    $this->admin_model->update_payment($pdata, $id, 'payment');
                }

                redirect(base_url('admin/users'));

            }
        }      
        
    }


    //active or deactive post
    public function status_action($type, $id) 
    {
        $data = array(
            'status' => $type
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'users');

        if($type ==1):
            $this->session->set_flashdata('msg', trans('activate-successfully')); 
        else:
            $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        endif;
        redirect(base_url('admin/users'));
    }

    //change user role
    public function change_account($id) 
    {
        $data = array(
            'account_type' => $this->input->post('type', false)
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'users');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/users'));
    }


    public function delete($user_id)
    {
        check_status();

        $this->admin_model->delete_by_user($user_id,'payment');
        $this->admin_model->delete_by_user($user_id,'appointments');
        $this->admin_model->delete_by_user($user_id,'business');
        $this->admin_model->delete_by_user($user_id,'services');
        $this->admin_model->delete_by_user($user_id,'staffs');
        $this->admin_model->delete($user_id,'users'); 
        echo json_encode(array('st' => 1));
        
    }


}