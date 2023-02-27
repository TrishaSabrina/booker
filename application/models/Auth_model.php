<?php
class Auth_model extends CI_Model {

    public function edit_option_md5($action, $id, $table)
    {
        $this->db->where('md5(id)',$id);
        $this->db->update($table,$action);
        return;
    }


    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('logged_in') == TRUE && !empty($this->get_user($this->session->userdata('id')))) {
            return true;
        } else {
            return false;
        }
    }

    //is logged in
    public function is_logged_staff()
    {
        //check if user logged in
        if ($this->session->userdata('logged_in') == TRUE && !empty($this->get_staff($this->session->userdata('id')))) {
            return true;
        } else {
            return false;
        }
    }

    //is logged in
    public function is_logged_customer()
    {
        //check if user logged in
        if ($this->session->userdata('logged_in') == TRUE && !empty($this->get_customer($this->session->userdata('id')))) {
            return true;
        } else {
            return false;
        }
    }


    //function get user
    public function get_logged_user()
    {   
        if ($this->session->userdata('role') == 'staff') {
            if ($this->is_logged_staff()) {
                $this->db->where('id', $this->session->userdata('id'));
                $query = $this->db->get('staffs');
                return $query->row();
            }
        }elseif ($this->session->userdata('role') == 'patient') {
            if ($this->is_logged_patient()) {
                $this->db->where('id', $this->session->userdata('id'));
                $query = $this->db->get('patientses');
                return $query->row();
            }
        } else {
            if ($this->is_logged_in()) {
                $this->db->where('id', $this->session->userdata('id'));
                $query = $this->db->get('users');
                return $query->row();
            }
        }
    }

    //get user by id
    public function get_user($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by id
    public function get_staff($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('staffs');
        return $query->row();
    }

    //get user by id
    public function get_customer($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('customers');
        return $query->row();
    }

    //get country
    public function get_country_value($code)
    {
        $this->db->where('code', $code);
        $query = $this->db->get('country');
        return $query->row();
    }

    //is admin
    public function is_admin()
    {
        //get_header_info();
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if ($this->session->userdata('role') == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    //is user
    public function is_user()
    {   
        //get_header_info();
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if ($this->session->userdata('role') == 'user') {
            return true;
        } else {
            return false;
        }
    }


    //is staff
    public function is_staff()
    {   
        //get_header_info();
        //check logged in
        if (!$this->is_logged_staff()) {
            return false;
        }

        //check role
        if ($this->session->userdata('role') == 'staff') {
            return true;
        } else {
            return false;
        }
    }


    //is customer
    public function is_customer()
    {   
        //get_header_info();
        //check logged in
        if (!$this->is_logged_customer()) {
            return false;
        }

        //check role
        if ($this->session->userdata('role') == 'customer') {
            return true;
        } else {
            return false;
        }
    }

    //is customer
    public function is_guest()
    {   
        //get_header_info();
        //check logged in
        if (!$this->is_logged_customer()) {
            return false;
        }

        //check role
        if ($this->session->userdata('role') == 'guest') {
            return true;
        } else {
            return false;
        }
    }


    //is pro user
    public function is_pro_user()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if (user()->role == 'user' && user()->account_type == 'pro') {
            return true;
        } else {
            return false;
        }
    }



    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('admin_logged_in');
        $this->session->unset_userdata('app_key');
    }

    // check post email
    public function check_email($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }

    public function check_username($name)
    {
        $this->db->select('*');
        $this->db->from('business');
        $this->db->where('slug', $name); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return 0;
        }
    }


    public function check_duplicate_email($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            $result = $this->check_staff_email($email);
            return $result;
        }
    }

    public function check_duplicate_phone($phone)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('phone', $phone); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }

    public function check_customer_phone($phone)
    {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('phone', $phone); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }


    public function check_staff_email($email)
    {
        $this->db->select('*');
        $this->db->from('staffs');
        $this->db->where('email', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) { 
            return $query->result();
        }else{
            $result = $this->check_customer_email($email);
            return $result;
        }
    }


    public function check_customer_email($email)
    {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('email', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }


    // check post email
    public function check_multiuser_email($type, $email)
    {
        $this->db->select('*');
        $this->db->from($type);
        $this->db->where('email', $email); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return false;
        }
    }


    // check valid user by id
    public function validate_id($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('md5(id)', $id); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query -> num_rows() == 1)
        {                 
            return $query->row();
        }
        else{
            return false;
        }
    }


    // check valid user
    function validate_user()
    {         
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $this->input->post('user_name'));
        $this->db->or_where('user_name', $this->input->post('user_name'));
        $this->db->limit(1);
        $query = $this->db->get();   
        
        if($query->num_rows() == 1)
        {                 
           return $query->row();
        }
        else{
            $result = $this->validate_staff();
            return $result;
        }
    }


    // check valid staff
    function validate_staff()
    {   
        $this->db->select('s.*');
        $this->db->from('staffs s');
        $this->db->where('s.email', $this->input->post('user_name'));
        $this->db->limit(1);
        $query = $this->db->get();   
        if($query->num_rows() > 0)
        {                 
           return $query->row();
        }
        else{
            $result = $this->validate_customer();
            return $result;
        }
    }


    // check valid customer
    function validate_customer()
    {   
        $this->db->select('c.*');
        $this->db->from('customers c');
        $this->db->where('c.phone', '+'.$this->input->post('user_name'));
        $this->db->or_where('c.email', $this->input->post('user_name'));
        $this->db->limit(1);
        $query = $this->db->get();   
        if($query->num_rows() > 0)
        {                 
           return $query->row();
        }
        else{
            return FALSE;
        }
    }



    public function send_email($to, $subject, $message)
    {
        $this->load->library('email');

        $settings = get_settings();

        if ($settings->mail_protocol == "mail") {
            $config = Array(
                'protocol' => 'mail',
                'smtp_host' => $settings->mail_host,
                'smtp_port' => $settings->mail_port,
                'smtp_user' => $settings->mail_username,
                'smtp_pass' => $settings->mail_password,
                'smtp_timeout' => 100,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
        } else {
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => $settings->mail_host,
                'smtp_port' => $settings->mail_port,
                'smtp_user' => $settings->mail_username,
                'smtp_pass' => $settings->mail_password,
                'smtp_timeout' => 100,
                'mailtype' => 'html',
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            );
        }


        //initialize
        $this->email->initialize($config);

        //send email
        $this->email->from($settings->mail_username, $settings->application_name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->set_newline("\r\n");

        return $this->email->send();
    }



}