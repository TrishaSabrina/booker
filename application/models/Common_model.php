<?php
class Common_model extends CI_Model {

    // insert function
	public function insert($data,$table){
        $this->db->insert($table,$data);        
        return $this->db->insert_id();
    }

    // edit function
    function edit_option($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    } 

    // edit function
    function edit_option_md5($action, $id, $table){
        $this->db->where('md5(id)', $id);
        $this->db->update($table,$action);
        return;
    } 

    // update function
    function update($action,$id,$table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
    }

    // delete function
    function delete($id,$table){
        if (settings()->type == 'live') {
            $this->db->delete($table, array('id' => $id));
        }
        return;
    }

  

    // get function
    function get($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    function get_all($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // select by function
    function select_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
        $this->db->order_by('user_id','DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // select function
    function select($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // asc select function
    function select_asc($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // asc select function
    function select_orders($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->order_by('orders','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // select by id
    function select_option($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    // select by id
    function get_by_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // select by id
    function get_by_uid($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('uid', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // select by id
    function get_by_md5_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('md5(id)', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // select by slug
    function get_by_slug($slug,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // select by slug
    function get_slug_by_company($slug, $table, $business_id)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('slug', $slug);
        $this->db->where('business_id', $business_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // select by slug
    function get_id_by_company($id, $table, $business_id)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $this->db->where('business_id', $business_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // select by slug
    function get_by_company($business_id, $table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('business_id', $business_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // select by slug
    function get_by_status($business_id, $table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('business_id', $business_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // select by status
    function select_by_status($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // get locations
    function get_locations($type, $business_id){
        $this->db->select();
        $this->db->from('locations');
        $this->db->where('business_id', $business_id);
        $this->db->where('status', 1);
        if ($type == 0) {
            $this->db->where('parent_id', 0);
        }else{
            $this->db->where('parent_id !=', 0);
        }
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // get locations
    function get_sub_locations($location_id){
        $this->db->select();
        $this->db->from('locations');
        $this->db->where('status', 1);
        $this->db->where('parent_id', $location_id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // get coupon
    function get_coupon($code, $service_id, $business_id)
    {
        $this->db->select();
        $this->db->from('coupons');
        $this->db->where('code', $code);
        $this->db->where('service_id', $service_id);
        $this->db->where('business_id', $business_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // get coupon apply
    function check_coupon_apply($code, $service_id, $business_id, $customer_id)
    {
        $this->db->select();
        $this->db->from('coupons_apply');
        $this->db->where('code', $code);
        $this->db->where('service_id', $service_id);
        $this->db->where('business_id', $business_id);
        $this->db->where('customer_id', $customer_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // check coupon
    function check_service_coupon($service_id, $business_id)
    {
        $this->db->select();
        $this->db->from('coupons');
        $this->db->where('service_id', $service_id);
        $this->db->where('business_id', $business_id);
        $this->db->where('status', 1);
        $this->db->where('usages_limit !=', 0);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // check coupon apply
    function check_customer_coupon($appointment_id)
    {
        $this->db->select();
        $this->db->from('coupons_apply');
        $this->db->where('appointment_id', $appointment_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // select by status
    function get_random_staffs($business_id, $service_id, $table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('business_id', $business_id);
        $this->db->where('id', $service_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'RANDOM');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 



    function get_category_services($business_id)
    {
        $this->db->select('*');
        $this->db->from('service_category');
        $this->db->where('status', 1);
        $this->db->where('business_id', $business_id);
        $this->db->order_by('orders', 'ASC');
        $query = $this->db->get();
        $query = $query->result();  

        foreach ($query as $key => $value) {
            $this->db->select('s.*');
            $this->db->from('services s');
            $this->db->where('s.category_id',$value->id);
            $this->db->where('s.business_id', $business_id);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $query[$key]->services = $query2;
        }
        return $query;
    }


    // select by status
    function get_service_staffs($service_id)
    {
        $this->db->select('s.*');
        $this->db->from('services as s');
        $this->db->where('id', $service_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // select by status
    function get_service_staffs__($service_id)
    {
        $this->db->select('*');
        $this->db->from('staffs');
        $this->db->like('service_id', json_decode($service_id));
        $this->db->where('status', 1);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // select by slug
    function get_company_services($business_id, $limit)
    {
        $this->db->select();
        $this->db->from('services');
        $this->db->where('business_id', $business_id);
        if ($limit != 0) {
            $this->db->limit($limit);
        }

        if (!empty($_GET['search'])) {
            $this->db->like('name', $_GET['search']);
        }

        if (!empty($_GET['staffs'])) {
            //print_r(json_encode($_GET['staffs']));
            $this->db->like('staffs', json_decode($_GET['staffs']));
        }


        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    function check_customer($user_name)
    {
        $this->db->select();
        $this->db->from('customers');
        $this->db->where('phone', '+'.$user_name);
        $this->db->or_where('email', $user_name);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

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
        $this->db->from('users');
        $this->db->where('user_name', $name); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->result();
        }else{
            return 0;
        }
    }


    // select function
    function get_single_page($slug)
    {
        $this->db->select();
        $this->db->from('pages');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    //get category
    public function get_category($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('category');
        return $query->row();
    }

    //get category
    public function get_category_option($id, $table)
    {
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query->row();
    }


    function get_subcategory($id)
    {
        $this->db->select();
        $this->db->from('category');
        $this->db->where('parent_id', $id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get settings
    function get_settings()
    {
        $this->db->select('s.*, l.short_name, l.name as language_name, l.slug as lang_slug, l.text_direction as dir');
        $this->db->from('settings s');
        $this->db->join('language as l', 'l.id = s.lang', 'LEFT');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    function get_slug_by_language($slug,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    // select by id
    function select_option_md5($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where(md5('id'), $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    //get user by id
    public function get_user_by_slug($slug)
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // asc select function
    function get_services($user_id)
    {
        $this->db->select();
        $this->db->from('services');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // asc select function
    function get_customers_by_userid($user_id)
    {
        $this->db->select();
        $this->db->from('customers');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // get pricing packages
    function get_pricing()
    {
        $this->db->select('*');
        $this->db->from('package');
        $query = $this->db->get();
        $query = $query->result_array();  

        foreach ($query as $key => $value) {
            $this->db->select('*');
            $this->db->from('features f');
            $this->db->where('f.package_id',$value['id']);
            $query2 = $this->db->get();
            $query2 = $query2->result_array();
            $query[$key]['features'] = $query2;
        }
        return $query;
    }


    // get site blog posts
    function get_home_blog_posts(){
        $this->db->select('b.*');
        $this->db->select('c.slug as category_slug, c.name as category, u.role');
        $this->db->from('blog_posts b');
        $this->db->where('b.status', 1);
        $this->db->where('u.role', 'admin');
        $this->db->join('blog_category c', 'c.id = b.category_id', 'LEFT');
        $this->db->join('users u', 'u.id = b.user_id', 'LEFT');
        $this->db->limit(3);
        $this->db->group_by('b.id');
        $this->db->order_by('b.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    } 


    // get all users
    function get_home_users($total, $limit, $offset)
    {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('role', 'user');

        if (!empty($_GET['search'])) {
            $this->db->like('name', $_GET['search']);
        }
        $this->db->order_by('id','DESC');
        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    }


    // get all users
    function get_total_user_by_type($type)
    {
        $this->db->select();
        $this->db->from('users');
        $this->db->where('role', 'user');
        $this->db->where('account_type', $type);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    // get features
    function gets_home_features()
    {
        gets_active_langs();
        $this->db->select();
        $this->db->from('features');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get features
    function get_count($table)
    {   
        $this->db->select();
        $this->db->from($table);
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }


    // get features
    function get_feature_limit($id)
    {   
        $this->db->select();
        $this->db->from('features');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get features
    function get_feature($slug)
    {   
        $this->db->select();
        $this->db->from('features');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get_payment
    function get_payment($puid)
    {
        $this->db->select();
        $this->db->from('payment');
        $this->db->where('puid', $puid);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get_payment
    function get_package_by_slug($slug)
    {
        $this->db->select();
        $this->db->from('package');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // select function
    function get_user_payment($user_id)
    {
        $this->db->select();
        $this->db->from('payment');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }



    // get
    function get_my_package()
    {
        if ($this->session->userdata('role') == 'user') {
            $user_id = $this->session->userdata('id');
        } else {
            $user_id = $this->session->userdata('parent');
        }
        
        $this->db->select('p.*, k.name as package_name, k.slug, k.id as package_id');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get_payment
    function get_customer_appointments()
    {

        $this->db->select('a.*, s.name as service_name, s.duration_type, s.zoom_link,s.google_meet, s.price, s.duration, f.name as staff_name, c.name as customer_name, c.email as customer_email, c.phone as customer_phone, b.name as business_name');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->join('business b', 'b.uid = a.business_id', 'LEFT');
        $this->db->where('a.customer_id', $this->session->userdata('id'));
        $this->db->where('a.status !=', 2);

        if (isset($_GET['daterange']) && $_GET['daterange'] != '') {
            $date = explode('-',trim($_GET['daterange']));
            if ($date[0] != $date[1]) {
                $this->db->where('a.date >=', date("Y-m-d", strtotime($date[0])));
                $this->db->where('a.date <=', date("Y-m-d", strtotime($date[1])));
            }
        }
        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    
    // get appointments
    function get_staff_appointments()
    {
        $this->db->select('a.*, s.name as service_name, s.duration_type, s.price, s.duration, f.name as staff_name, c.name as customer_name, c.email as customer_email, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.staff_id', $this->session->userdata('id'));

        if (isset($_GET['daterange']) && $_GET['daterange'] != '') {
            $date = explode('-',trim($_GET['daterange']));
            if ($date[0] != $date[1]) {
                $this->db->where('a.date >=', date("Y-m-d", strtotime($date[0])));
                $this->db->where('a.date <=', date("Y-m-d", strtotime($date[1])));
            }
        }

        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // get appointments
    function get_appointment($id)
    {
        $this->db->select('a.*, s.name as service_name, s.price, f.name as staff_name, c.name as customer_name, c.email as customer_email, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get appointments
    function get_appointment_md5($id)
    {
        $this->db->select('a.*, s.name as service_name, s.price, s.duration_type, f.name as staff_name, c.name as customer_name, c.email as customer_email, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('md5(a.id)', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get appointments
    function today_appointments()
    {
        $this->db->select('a.*, s.name as service_name, s.price, f.name as staff_name, c.name as customer_name, c.email as customer_email, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.date', date("Y-m-d", strtotime('+1 day')));
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get_payment
    function get_user_package($user_id)
    {

        $this->db->select('p.*, k.name as package_name, k.slug, k.id as package_id');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    public function expire_payments()
    {   
        $payments = $this->get_expire_payments();
        foreach ($payments as $payment) {
            $data = array(
                'status' => 'expire',
                'expire_on' => '1970-01-01',
                'created_at' => '1970-01-01 01:01:01'
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->update($data, $payment->id, 'payment');
        }
    }

    // get expire payments
    function get_expire_payments(){
        $this->db->select();
        $this->db->from('payment');
        $this->db->where('expire_on', date('Y-m-d'));
        $this->db->or_where('expire_on <', date('Y-m-d'));
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // get trial users
    function get_trial_users(){
        $this->db->select();
        $this->db->from('users');
        $this->db->where('trial_expire', date('Y-m-d'));
        $this->db->or_where('trial_expire <', date('Y-m-d'));
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    
    // get testimonials
    function get_testimonials($user_id){
        $this->db->select();
        $this->db->from('testimonials');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    // get categories
    function get_categories(){
        $this->db->select();
        $this->db->from('category');
        $this->db->where('parent_id', 0);
        $this->db->order_by('cat_order', 'ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // get blog posts
    function get_blog_posts($total, $limit, $offset, $user_id){
        $this->db->select('b.*');
        $this->db->select('c.slug as category_slug, c.name as category');
        $this->db->from('blog_posts b');
        $this->db->where('b.user_id', $user_id);
        $this->db->join('blog_category c', 'c.id = b.category_id', 'RIGHT');
        $this->db->limit($limit);
        
        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    } 



    function get_site_blog_posts($total, $limit, $offset){
        $this->db->select('b.*');
        $this->db->select('c.slug as category_slug, c.name as category, u.role');
        $this->db->from('blog_posts b');
        $this->db->where('u.role', 'admin');
        $this->db->where('b.status', 1);
        if(isset($_GET['search']) && $_GET['search'] != ''){
            $this->db->like('b.title', $_GET['search']);
        }
        $this->db->join('users u', 'u.id = b.user_id', 'LEFT');
        $this->db->join('blog_category c', 'c.id = b.category_id', 'LEFT');
        
        $this->db->order_by('b.id', 'DESC');
        
        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    } 


    //get posts categories
    function get_category_by_slug($slug)
    {
        $this->db->select();
        $this->db->from('blog_category');
        $this->db->where('slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    //get blog categories
    function get_blog_category($user_id)
    {
        $this->db->select();
        $this->db->from('blog_category');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    //get blog categories
    function get_post_details($slug)
    {
        $this->db->select('p.*, c.name as category_name');
        $this->db->from('blog_posts p');
        $this->db->join('blog_category c', 'p.category_id = c.id');
        $this->db->where('p.slug', $slug);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

  


    //get latest posts
    function get_related_post($category_id, $post_id, $user_id)
    {
        $this->db->select('p.*');
        $this->db->select('c.name as category');
        $this->db->select('u.name as author_name');
        $this->db->from('blog_posts p');
        $this->db->join('blog_category c', 'c.id = p.category_id', 'LEFT');
        $this->db->join('users u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.id !=', $post_id);
        $this->db->where('p.user_id', $user_id);
        $this->db->where('p.category_id', $category_id);
        $this->db->where('p.status', 1);
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    //get posts tags
    public function get_post_tags($post_id)
    {
        $this->db->where('post_id', $post_id);
        $query = $this->db->get('tags');
        return $query->result();
    }

    //get comments by img
    public function get_comments_by_post($post_id)
    {   
        $this->db->select('c.*');
        $this->db->from('comments c');
        $this->db->where('c.post_id', $post_id);
        $this->db->order_by('c.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }
   
    // delete tags
    function delete_tags($post_id, $table){
        $this->db->delete($table, array('post_id' => $post_id));
        return;
    }


    //get category posts
    function get_category_posts($total, $limit, $offset, $id, $user_id)
    {

        $this->db->select('p.*');
        $this->db->select('c.name as category, c.slug as category_slug');
        $this->db->from('blog_posts p');
        $this->db->join('blog_category as c', 'c.id = p.category_id', 'LEFT');
        $this->db->where('p.status', 1);
        $this->db->where('p.category_id', $id);
        $this->db->where('p.user_id', $user_id);
        
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit($limit);
        
        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    }


    //get category posts
    function count_posts_by_categories($id)
    {
        $this->db->select('count(p.id) as total');
        $this->db->from('blog_posts p');
        $this->db->where('p.status', 1);
        $this->db->where('p.category_id', $id);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return $query->row();
        }else{
            return 0;
        }
    }

    //get random posts
    function get_random_tags($user_id)
    {
        $this->db->select('t.*');
        $this->db->select('p.status, p.slug as post_slug, u.name as author_name');
        $this->db->from('tags t');
        $this->db->join('blog_posts as p', 'p.id = t.post_id', 'LEFT');
        $this->db->join('users as u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.status', 1);
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('rand()');
        $this->db->limit(8);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get_categories
    function get_blog_categories(){
        $this->db->select();
        $this->db->from('blog_category');
        $this->db->where('user_id', $this->session->userdata('id'));
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

    //get latest users
    function get_latest_users(){
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.status', 1);
        $this->db->order_by('u.id','DESC');
        $this->db->limit(6);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    // get all posts
    function get_latest_messages(){
        $this->db->select('c.*');
        $this->db->from('contacts c');
        $this->db->order_by('c.id','DESC');
        $this->db->limit(8);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    //get latest users
    function get_users(){
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.status', 1);
        $this->db->where('u.role', 'user');
        $this->db->order_by('u.id','DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    // get all users
    function get_all_users($total, $limit, $offset)
    {
        $this->db->select('u.*');
        $this->db->from('users as u');
        $this->db->where('role', 'user');

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $this->db->like('u.name', $_GET['search']);
        }

        $this->db->order_by('u.id','DESC');
        $this->db->group_by('u.id');

        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    }



    function get_all_business($total, $limit, $offset)
    {
        $this->db->select('b.*, n.name as country_name, n.currency_name, n.currency_symbol, n.currency_code, c.name as category_name');
        $this->db->from('business b');
       
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $this->db->like('b.name', $_GET['search']);
        }

        if (isset($_GET['category']) && $_GET['category'] != '') {
            $this->db->like('b.category', $_GET['category']);
        }

        if (isset($_GET['country']) && $_GET['country'] != '') {
            $this->db->like('b.country', $_GET['country']);
        }

        if (isset($_GET['location']) && $_GET['location'] != '') {
            $this->db->like('l.id', $_GET['location']);
        }

        $this->db->where('u.status', 1);
        $this->db->join('users u', 'u.id = b.user_id', 'LEFT');
        $this->db->join('locations l', 'l.business_id = b.uid', 'LEFT');
        $this->db->join('country n', 'n.id = b.country', 'LEFT');
        $this->db->join('categories c', 'c.id = b.category', 'LEFT');
        $this->db->order_by('b.id', 'DESC');
        $this->db->group_by('b.id');
        
        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {
            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();
            return $query;
        }
    }



    //get latest users
    function get_all_locations(){
        $this->db->select('l.*');
        $this->db->from('locations l');
        $this->db->where('l.status', 1);
        $this->db->where('l.parent_id', 0);
        $this->db->group_by('l.name');
        $this->db->order_by('l.name','ASC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }



    // get images by user
    function get_total_info(){
        $this->db->select('p.id');
        $this->db->select('(SELECT count(posts.id)
                            FROM posts 
                            WHERE (status = 1)
                            )
                            AS post',TRUE);
        
        $this->db->select('(SELECT count(users.id)
                            FROM users 
                            WHERE (status = 1)
                            )
                            AS user',TRUE);

        $this->db->from('posts p');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


     //get user info
    function get_user_info()
    {
        $this->db->select('u.*');
        $this->db->from('users u');
        $this->db->where('u.id', $this->session->userdata('id'));
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // image upload function with resize option
    function upload_image($max_size){
            
            // set upload path
            $config['upload_path']  = "./uploads/";
            $config['allowed_types']= 'gif|jpg|png|jpeg';
            $config['max_size']     = '92000';
            $config['max_width']    = '92000';
            $config['max_height']   = '92000';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload("photo")) {

                
                $data = $this->upload->data();

                // set upload path
                $source             = "./uploads/".$data['file_name'] ;
                $destination_thumb  = "./uploads/thumbnail/" ;
                $destination_medium = "./uploads/medium/" ;
                $main_img = $data['file_name'];
                // Permission Configuration
                chmod($source, 0777) ;

                /* Resizing Processing */
                // Configuration Of Image Manipulation :: Static
                $this->load->library('image_lib') ;
                $img['image_library'] = 'GD2';
                $img['create_thumb']  = TRUE;
                $img['maintain_ratio']= TRUE;

                /// Limit Width Resize
                $limit_medium   = $max_size ;
                $limit_thumb    = 150;

                // Size Image Limit was using (LIMIT TOP)
                $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;

                // Percentase Resize
                if ($limit_use > $limit_medium || $limit_use > $limit_thumb) {
                    $percent_medium = $limit_medium/$limit_use ;
                    $percent_thumb  = $limit_thumb/$limit_use ;
                }

                //// Making THUMBNAIL ///////
                $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
                $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = ' 100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_thumb ;

                $thumb_nail = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                ////// Making MEDIUM /////////////
                $img['width']   = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
                $img['height']  = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = '100%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_medium ;

                $mid = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                // set upload path
                $images = 'uploads/medium/'.$mid;
                $thumb  = 'uploads/thumbnail/'.$thumb_nail;
                unlink($source) ;

                return array(
                    'images' => $images,
                    'thumb' => $thumb
                );
            }
            else {
                echo "Failed! to upload image" ;
            }
            
    }


    //multiple image upload with resize option
    public function do_upload($photo) {                   
        $config['upload_path']  = "./uploads/";
        $config['allowed_types']= 'gif|jpg|png|jpeg';
        $config['max_size']     = '20000';
        $config['max_width']    = '20000';
        $config['max_height']   = '20000';
 
        $this->load->library('upload', $config);                
        
            if ($this->upload->do_upload($photo)) {
                $data       = $this->upload->data(); 
                /* PATH */
                $source             = "./uploads/".$data['file_name'] ;
                $destination_thumb  = "./uploads/thumbnail/" ;
                $destination_medium = "./uploads/medium/" ;
                $destination_big    = "./uploads/big/" ;

                // Permission Configuration
                chmod($source, 0777) ;

                /* Resizing Processing */
                // Configuration Of Image Manipulation :: Static
                $this->load->library('image_lib') ;
                $img['image_library'] = 'GD2';
                $img['create_thumb']  = TRUE;
                $img['maintain_ratio']= TRUE;

                /// Limit Width Resize
                $limit_big   = 1000 ;
                $limit_medium    = 400 ;
                $limit_thumb    = 100 ;

                // Size Image Limit was using (LIMIT TOP)
                $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;

                // Percentase Resize
                if ($limit_use > $limit_big || $limit_use > $limit_thumb || $limit_use > $limit_medium) {
                    $percent_big = $limit_big/$limit_use ;
                    $percent_medium  = $limit_medium/$limit_use ;
                    $percent_thumb  = $limit_thumb/$limit_use ;
                }

                //// Making THUMBNAIL ///////
                $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
                $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_thumb-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = '99%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_thumb ;

                $thumb_nail = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;                 

                //// Making MEDIUM ///////
                $img['width']  = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
                $img['height'] = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_medium-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = '99%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_medium ;

                $medium = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;               

                ////// Making BIG /////////////
                $img['width']   = $limit_use > $limit_big ?  $data['image_width'] * $percent_big : $data['image_width'] ;
                $img['height']  = $limit_use > $limit_big ?  $data['image_height'] * $percent_big : $data['image_height'] ;

                // Configuration Of Image Manipulation :: Dynamic
                $img['thumb_marker'] = '_big-'.floor($img['width']).'x'.floor($img['height']) ;
                $img['quality']      = '99%' ;
                $img['source_image'] = $source ;
                $img['new_image']    = $destination_big ;

                $album_picture = $data['raw_name']. $img['thumb_marker'].$data['file_ext'];
                // Do Resizing
                $this->image_lib->initialize($img);
                $this->image_lib->resize();
                $this->image_lib->clear() ;

                $data_image = array(
                    'thumb' => 'uploads/thumbnail/'.$thumb_nail,
                    'medium' => 'uploads/medium/'.$medium,
                    'big' => 'uploads/big/'.$album_picture
                );

                unlink($source) ;   
                return $data_image;   
    
            }
            else {
                return FALSE ;
            }
       
    }

}