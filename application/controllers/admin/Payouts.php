<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payouts extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }


    public function settings()
    {   
        if (!is_admin()) {
            redirect(base_url());
        }
        $data = array();
        $data['page_title'] = 'Payout Settings';      
        $data['page'] = 'Payouts';
        $data['main_content'] = $this->load->view('admin/payouts/settings',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function update_settings() 
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        
        check_status();

        $commission_rate = $this->input->post('commission_rate');
        if ($commission_rate < 1 || $commission_rate > 99) {
            $this->session->set_flashdata('error', trans('commission-rate').' '.trans('must-be-between-1-99')); 
            redirect(base_url('admin/payouts/settings'));
        }

        if(!empty($this->input->post('enable_wallet'))){$enable_wallet = $this->input->post('enable_wallet', true);}
            else{$enable_wallet = 0;}

        if(!empty($this->input->post('paypal_payout'))){$paypal_payout = $this->input->post('paypal_payout', true);}
            else{$paypal_payout = 0;}

        if(!empty($this->input->post('iban_payout'))){$iban_payout = $this->input->post('iban_payout', true);}
            else{$iban_payout = 0;}

        if(!empty($this->input->post('swift_payout'))){$swift_payout = $this->input->post('swift_payout', true);}
            else{$swift_payout = 0;}

        $data = array(
            'enable_wallet' => $enable_wallet,
            'paypal_payout' => $paypal_payout,
            'iban_payout' => $iban_payout,
            'swift_payout' => $swift_payout,
            'min_payout_amount' => $this->input->post('min_payout_amount', true),
            'commission_rate' => $this->input->post('commission_rate', true)
        );
        $this->admin_model->edit_option($data, 1,'settings');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/payouts/settings'));
    }

    public function requests()
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        
        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/payouts/requests');
        $total_row = $this->admin_model->get_payouts($status=0, 0, 1, 0, 0);
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

        $data['page_title'] = 'Payout Requests';         
        $data['page'] = 'Payouts';  
        $data['status'] = 0; 
        $data['payouts'] = $this->admin_model->get_payouts($status=0, 0, 0, $config['per_page'], $page * $config['per_page']);
        $data['main_content'] = $this->load->view('admin/payouts/requests',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function completed()
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        
        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/payouts/completed');
        $total_row = $this->admin_model->get_payouts($status=1, 0, 1, 0, 0);
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

        $data['page_title'] = 'Payout Completed';         
        $data['page'] = 'Payouts'; 
        $data['status'] = 1; 
        $data['payouts'] = $this->admin_model->get_payouts($status=1, 0, 0, $config['per_page'], $page * $config['per_page']);
        $data['main_content'] = $this->load->view('admin/payouts/requests',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function complete($id) 
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        
        check_status();

        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option_md5($data, $id,'payouts');

        $payout = $this->admin_model->get_by_md5_id($id, 'payouts'); 
        if (!empty($payout)) {
            reduce_user_balance($payout->user_id, $payout->amount);
        }

        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/payouts/requests'));
    }

    public function delete($id)
    {
        if (!is_admin()) {
            redirect(base_url());
        }
        
        $this->admin_model->delete($id,'payouts'); 
        echo json_encode(array('st' => 1));
    }

    public function add()
    {   
        if (!is_admin()) {
            redirect(base_url());
        }
        
        check_status();

        if($_POST){   

            $payput_method = $this->input->post('payout_method'); 
            $user_id = $this->input->post('user_id'); 

            $user_account = $this->admin_model->get_by_id($user_id, 'users');
            $user = $this->admin_model->select_by_user_id($user_id, 'users_payout_accounts');

            if ($payput_method == 'paypal') {
                if (empty($user->payout_paypal_email)) {
                    $this->session->set_flashdata('error', trans('empty-paypal-email')); 
                    redirect(base_url('admin/payouts/add'));
                    exit();
                }
            }elseif ($payput_method == 'iban') {
                if (empty($user->iban_bank_name) && empty($user->iban_number)) {
                    $this->session->set_flashdata('error', trans('empty-iban-info')); 
                    redirect(base_url('admin/payouts/add'));
                    exit();
                }
            }elseif ($payput_method == 'swift') {
                if (empty($user->swift_bank_account_holder_name) && empty($user->swift_bank_name) && empty($user->swift_iban) && empty($user->swift_code)) {
                    $this->session->set_flashdata('error', trans('empty-swift-email')); 
                    redirect(base_url('admin/payouts/add'));
                    exit();
                }
            }
            

            $amount = $this->input->post('amount') * 100;
            $check_balance = check_user_balance($user_id, $amount);

            if ($check_balance == false) {
                $this->session->set_flashdata('error', trans('invalid-withdrawal-amount')); 
                redirect(base_url('admin/payouts/add'));
                exit();
            }

            $user_balance = round($user_account->balance/100);

            if ($user_balance < settings()->min_payout_amount) {
                $this->session->set_flashdata('error', trans('invalid-withdrawal-amount')); 
                redirect(base_url('admin/payouts/add'));
                exit();
            }

            $data=array(
                'user_id' => $user_id,
                'payout_method' => $payput_method,
                'amount' => $amount,
                'transaction_id' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),
                'status' => 0,
                'created_at' => my_date_now()
            );
            if ($check_balance == true) {
                $this->admin_model->insert($data, 'payouts');
                $this->session->set_flashdata('msg', trans('inserted-successfully'));
            }
            redirect(base_url('admin/payouts/requests'));
            
        }

        $data = array();
        $data['page_title'] = 'Add Payout';      
        $data['page'] = 'Payouts';
        $data['users'] = $this->admin_model->get_payout_users();
        $data['main_content'] = $this->load->view('admin/payouts/add_payout',$data,TRUE);
        $this->load->view('admin/index',$data);
    }





    //**** user payout code start

    public function user()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/payouts/user');
        $total_row = $this->admin_model->get_payouts($status=2, user()->id, 1, 0, 0);
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

        $data['page_title'] = 'Payouts';      
        $data['page'] = 'Payouts'; 
        $data['payouts'] = $this->admin_model->get_payouts($status=2, user()->id, 0, $config['per_page'], $page * $config['per_page']);
        $data['main_content'] = $this->load->view('admin/payouts/user_payouts',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function setup_account()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        $data = array();
        $data['page_title'] = 'Set Payout Account';      
        $data['page'] = 'Payouts';
        $data['countries'] = $this->admin_model->select_asc('country');
        $data['user'] = $this->admin_model->select_by_user_id(user()->id, 'users_payout_accounts');
        $data['main_content'] = $this->load->view('admin/payouts/setup_payout_account',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function send_request()
    {
        if (!is_user()) {
            redirect(base_url());
        }

        check_status();

        if($_POST){   

            $payput_method = $this->input->post('payout_method'); 

            $user = $this->admin_model->select_by_user_id(user()->id, 'users_payout_accounts');
            if ($payput_method == 'paypal') {
                if (empty($user->payout_paypal_email)) {
                    $this->session->set_flashdata('error', trans('empty-paypal-email')); 
                    redirect(base_url('admin/payouts/user?error=Invalid'));
                    exit();
                }
            }elseif ($payput_method == 'iban') {
                if (empty($user->iban_bank_name) && empty($user->iban_number)) {
                    $this->session->set_flashdata('error', trans('empty-iban-info')); 
                    redirect(base_url('admin/payouts/user?error=Invalid'));
                    exit();
                }
            }elseif ($payput_method == 'swift') {
                if (empty($user->swift_bank_account_holder_name) && empty($user->swift_bank_name) && empty($user->swift_iban) && empty($user->swift_code)) {
                    $this->session->set_flashdata('error', trans('empty-swift-email')); 
                    redirect(base_url('admin/payouts/user?error=Invalid'));
                    exit();
                }
            }
            

            $amount = $this->input->post('amount') * 100;
            $check_balance = check_user_balance(user()->id, $amount);

            if ($check_balance == false) {
                $this->session->set_flashdata('error', trans('invalid-withdrawal-amount')); 
                redirect(base_url('admin/payouts/user?error=Invalid'));
                exit();
            }

            $min_payout_amount = settings()->min_payout_amount * 100;
            if ($amount < $min_payout_amount) {
                $this->session->set_flashdata('error', trans('invalid-withdrawal-amount')); 
                redirect(base_url('admin/payouts/user?error=Invalid'));
                exit();
            }

            $data=array(
                'user_id' => user()->id,
                'payout_method' => $payput_method,
                'amount' => $amount,
                'transaction_id' => substr(hash('sha256', mt_rand() . microtime()), 0, 20),
                'status' => 0,
                'created_at' => my_date_now()
            );
            if ($check_balance == true) {
                $this->admin_model->insert($data, 'payouts');
                $this->session->set_flashdata('msg', trans('payout-request-sent-successfully'));
            }
            redirect(base_url('admin/payouts/user'));
            
        }
    }

    public function update_account($type)
    {   
        if (!is_user()) {
            redirect(base_url());
        }

        
        if($_POST){   

            check_status();
            $id = $this->input->post('id', true);

            if ($type == 1) {
                $data=array(
                    'user_id' => user()->id,
                    'payout_paypal_email' => $this->input->post('payout_paypal_email')
                );
            }

            if ($type == 2) {
                $data=array(
                    'user_id' => user()->id,
                    'iban_full_name' => $this->input->post('iban_full_name'),
                    'iban_country_id' => $this->input->post('iban_country_id'),
                    'iban_bank_name' => $this->input->post('iban_bank_name'),
                    'iban_number' => $this->input->post('iban_number')
                );
            }

            if ($type == 3) {
                $data=array(
                    'user_id' => user()->id,
                    'swift_full_name' => $this->input->post('swift_full_name'),
                    'swift_state' => $this->input->post('swift_state'),
                    'swift_city' => $this->input->post('swift_city'),
                    'swift_postcode' => $this->input->post('swift_postcode'),
                    'swift_address' => $this->input->post('swift_address'),
                    'swift_bank_account_holder_name' => $this->input->post('swift_bank_account_holder_name'),
                    'swift_bank_name' => $this->input->post('swift_bank_name'),
                    'swift_bank_branch_country_id' => $this->input->post('swift_bank_branch_country_id'),
                    'swift_bank_branch_city' => $this->input->post('swift_bank_branch_city'),
                    'swift_iban' => $this->input->post('swift_iban'),
                    'swift_code' => $this->input->post('swift_code')
                );
            }
            
            //if id available info will be edited
            if ($id != 0) {
                $this->admin_model->edit_option($data, $id, 'users_payout_accounts');
                $this->session->set_flashdata('msg', trans('updated-successfully')); 
            } else {
                $this->admin_model->insert($data, 'users_payout_accounts');
                $this->session->set_flashdata('msg', trans('updated-successfully')); 
            }
            redirect(base_url('admin/payouts/setup_account'));
        }
    }

}