<?php
class Admin_model extends CI_Model {
    
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

    // edit function
    function edit_user_md5($action, $id, $table){
        $this->db->where('md5(user_id)', $id);
        $this->db->update($table,$action);
        return;
    } 

    // edit function
    function edit_option_sess($action, $id, $table){
        $this->db->where('business_id', $id);
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

    // delete function
    function delete_uid($id,$table){
        if (settings()->type == 'live') {
            $this->db->delete($table, array('uid' => $id));
        }
        return;
    }

    // delete days
    function delete_assaign_days($user_id, $table){
        $this->db->delete($table, array('user_id' => $user_id, 'staff_id' => 0));
        return;
    }

    // delete time
    function delete_assaign_time($user_id, $table){
        $this->db->delete($table, array('user_id' => $user_id));
        return;
    }

    // delete staff days
    function delete_assaign_staff_days($staff_id, $table){
        $this->db->delete($table, array('staff_id' => $staff_id));
        return;
    }

    // delete staff time
    function delete_assaign_staff_time($staff_id, $table){
        $this->db->delete($table, array('staff_id' => $staff_id));
        return;
    }

    // delete tags
    function delete_assign_features($id, $table){
        $this->db->delete($table, array('package_id' => $id));
        return;
    }

    // delete tags
    function delete_staff_location($id, $table){
        $this->db->delete($table, array('staff_id' => $id));
        return;
    }


    // delete
    function delete_by_user($user_id, $table){
        $this->db->delete($table, array('user_id' => $user_id));
        return;
    }

    // get function
    function get_count($table)
    {
        $this->db->select();
        $this->db->from($table);
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }

    // get function
    function get_booking_val($business_id)
    {
        $this->db->select();
        $this->db->from('booking_val');
        $this->db->where('business_id', $business_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get function
    function get_wallet_user($user_id)
    {
        $this->db->select();
        $this->db->from('wallets');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get function
    function get_count_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('business_id', $this->business->uid);
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }

    // get function
    function get_count_by_user_id($table, $user_id)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
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


    // select by function
    function get_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
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
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // select by function
    function check_data_by_user($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
        $this->db->where('business_id', $this->business->uid);
        $query = $this->db->get();
        $query = $query->num_rows();  
        if($table == 'customers' && $query == 0) {
            $this->db->select();
            $this->db->from('appointments');
            $this->db->where('user_id', $this->session->userdata('id'));
            $this->db->where('business_id', $this->business->uid);
            $query = $this->db->get();
            $query = $query->num_rows();
        }
        return $query;
    }

    // select by function
    function get_staff_location($id)
    {
        $this->db->select();
        $this->db->from('staff_locations');
        $this->db->where('staff_id', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // select by function
    function get_staff_locations($id)
    {
        $this->db->select();
        $this->db->from('staff_locations');
        $this->db->where('staff_id', $id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get_clocations
    function get_staffs_asign_locations($location_id, $sub){
        $this->db->select('staff_id');
        $this->db->from('staff_locations');
        $this->db->where('business_id', $this->business->uid);
        $this->db->where('location_id', $location_id);
        //$this->db->or_where('sub_location_id', $sub);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // get_clocations
    function get_staff_sub_locations($id){
        $this->db->select();
        $this->db->from('locations');
        $this->db->where('business_id', $this->business->uid);
        $this->db->where('parent_id', $id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // get_clocations
    function get_front_staffs_asign_locations($business_id, $location_id, $sub){
        $this->db->select('staff_id');
        $this->db->from('staff_locations');
        $this->db->where('business_id', $business_id);
        $this->db->where('location_id', $location_id);
        if (!empty($sub)) {
            $this->db->where('sub_location_id', $sub);
        }
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // select function
    function get_pages($uid)
    {
        $this->db->select();
        $this->db->from('pages');
        if ($uid == 0) {
            $this->db->where('business_id', 0);
        }else{
            $this->db->where('business_id', $uid);
        }
        $this->db->order_by('id','ASC');
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

    // select by status
    function select_order_by_name($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('status', 1);
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get();
        $query = $query->result();  
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


    //payouts code start

    function select_by_user_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 


    // select by user id
    function get_user_earnings($user_id)
    {
        $this->db->select('p.*');
        $this->db->select_sum('p.total_amount', 'net_income');
        $this->db->from('payment_user as p');
        $this->db->where('p.type', 'wallet');
        $this->db->where('p.user_id', $user_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    } 

    function get_payout_users()
    {
        $this->db->select('p.*, u.name as user_name, u.balance');
        $this->db->from('payment_user as p');
        $this->db->join('users as u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.type', 'wallet');
        $this->db->group_by('p.user_id');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 


    // get payouts
    function get_payouts($status, $user_id, $total, $limit, $offset){

        $this->db->select('p.*, u.name as user_name, u.thumb, u.balance');
        $this->db->from('payouts as p');
        $this->db->join('users as u', 'u.id = p.user_id', 'LEFT');
        if ($user_id != 0) {
            $this->db->where('p.user_id', $user_id);
        }
        if ($status != 2) {
            $this->db->where('p.status', $status);
        }
        if (isset($_GET['transaction_id'])) {
            $this->db->like('p.transaction_id', $_GET['transaction_id']);
        }
        $this->db->order_by('p.id', 'DESC');
        
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

    //payouts code end


    // get appointments
    function get_appointments($user_id, $total, $limit, $offset)
    {

        $this->db->select('a.*, s.name as service_name, s.duration_type, s.zoom_link, s.price, s.duration, f.name as staff_name, f.thumb as staff_thumb, c.name as customer_name, c.email as customer_email, c.thumb as customer_thumb, c.phone as customer_phone, c.role as customer_role');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.business_id', $this->business->uid);
        $this->db->order_by('id', 'DESC');
        if (isset($_GET['date']) && $_GET['date'] != '') {
            $this->db->where('a.date', $_GET['date']);
        }

        if (isset($_GET['range']) && $_GET['range'] != 0) {
            $this->db->where('a.date >= ', date('Y-m-d'));
            $this->db->where('a.date <= ', $_GET['range']);
        }

        if (isset($_GET['service']) && $_GET['service'] != '') {
            $this->db->where('a.service_id', $_GET['service']);
        }

        if (isset($_GET['staff']) && $_GET['staff'] != '') {
            $this->db->where('a.staff_id', $_GET['staff']);
        }

        if (isset($_GET['customer']) && $_GET['customer'] != '') {
            $this->db->where('a.customer_id', $_GET['customer']);
        }

        if (isset($_GET['status']) && $_GET['status'] != '') {
            $this->db->where('a.status', $_GET['status']);
        }

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $this->db->like('s.name', $_GET['search']);
            $this->db->or_like('f.name', $_GET['search']);
            $this->db->or_like('c.name', $_GET['search']);
        }


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


    // get appointments
    function get_appointment_by_id($id)
    {
        $this->db->select('a.*, s.name as service_name, s.price, s.duration, f.name as staff_name, f.thumb as staff_thumb, c.name as customer_name, c.email as customer_email, c.thumb as customer_thumb, c.phone as customer_phone');
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
    function get_user_appointments($user_id, $limit)
    {
        $this->db->select('a.*, s.name as service_name, s.price, s.duration, f.name as staff_name, f.thumb as staff_thumb, c.name as customer_name, c.email as customer_email, c.thumb as customer_thumb, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.business_id', $this->business->uid);
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    // get appointments
    function get_customer_appointments($customer_id, $limit)
    {
        $this->db->select('a.*, s.name as service_name, s.price, s.duration, f.name as staff_name, f.thumb as staff_thumb, c.name as customer_name, c.email as customer_email, c.thumb as customer_thumb, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.customer_id', $customer_id);
        $this->db->where('a.business_id', $this->business->uid);
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    // get appointments
    function get_calendar_appointments($user_id, $limit)
    {
        $this->db->select('a.*, s.name as service_name, s.price, s.duration, f.name as staff_name, f.thumb as staff_thumb, c.name as customer_name, c.email as customer_email, c.thumb as customer_thumb, c.phone as customer_phone');
        $this->db->from('appointments a');
        $this->db->join('services s', 's.id = a.service_id', 'LEFT');
        $this->db->join('staffs f', 'f.id = a.staff_id', 'LEFT');
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.status !=', 2);
        $this->db->where('a.business_id', $this->business->uid);
        $this->db->limit($limit);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    // get business
    function get_business($uid)
    {
        $this->db->select('b.*, n.name as country_name, n.currency_name, n.currency_symbol, n.currency_code');
        $this->db->from('business b');
        if ($uid != 0) {
            $this->db->where('b.uid', $uid);
        }
        $this->db->where('b.user_id', $this->session->userdata('id'));
        $this->db->join('country n', 'n.id = b.country', 'LEFT');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get business
    function get_business_uid($uid)
    {
        $this->db->select('b.*, n.name as country_name, n.currency_name, n.currency_symbol, n.currency_code');
        $this->db->from('business b');
        if ($uid != 0) {
            $this->db->where('b.uid', $uid);
        }
        $this->db->join('country n', 'n.id = b.country', 'LEFT');
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get customers
    function get_booking_customers($customers)
    {
        $this->db->select('a.*, c.name as name, c.email, c.phone, c.thumb');
        $this->db->from('appointments a');
        $this->db->where('a.user_id', $this->session->userdata('id'));
        $this->db->where_not_in('a.customer_id', $customers);
        $this->db->join('customers c', 'c.id = a.customer_id', 'LEFT');
        $this->db->group_by('a.customer_id');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // get customers
    function get_customers()
    {
        $this->db->select('a.*, a.id as customer_id');
        $this->db->from('customers a');
        $this->db->where('a.user_id', $this->session->userdata('id'));
        $this->db->order_by('a.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get assaign days
    function get_user_days($id)
    {
        $this->db->select();
        $this->db->from('working_days');
        $this->db->where('user_id', $this->session->userdata('id'));
        if ($id != 0) {
            $this->db->where('staff_id', $id);
        }
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    // get company
    function get_company($user_id)
    {
        $this->db->select();
        $this->db->from('business');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get assaign days
    function get_staff_days($staff_id)
    {
        $this->db->select();
        $this->db->from('working_days');
        $this->db->where('staff_id', $staff_id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // get assaign days
    function get_my_days($business_id)
    {
        $this->db->select();
        $this->db->from('working_days');
        $this->db->where('staff_id', 0);
        $this->db->where('business_id', $business_id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }


    // get assaign days
    function get_timeslot_by_day($day_id, $business_id, $staff_id)
    {
        $this->db->select();
        $this->db->from('working_days');
        $this->db->where('day', $day_id);
        $this->db->where('business_id', $business_id);
        if ($staff_id != 0) {
            $this->db->where('staff_id', $staff_id);
        }
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }



    // get assaign days
    function get_time_by_days($day_id, $business_id)
    {
        $this->db->select();
        $this->db->from('working_time');
        $this->db->where('day_id', $day_id);
        $this->db->where('business_id', $business_id);
        $this->db->group_by('time');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get assaign days
    function get_time_by_id($id)
    {
        $this->db->select();
        $this->db->from('working_time');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    // get time
    function check_time($time, $date, $service_id, $staff_id, $location_id)
    {
        if($service_id == 0){
            $service_id = $this->session->userdata('service_id');
        }

        if($staff_id == 0){
            $staff_id = $this->session->userdata('staff_id');
        }

        if($location_id == 0){
            $location_id = $this->session->userdata('location_id');
        }

        $this->db->select();
        $this->db->from('appointments');
        $this->db->where('date', $date);
        $this->db->where('time', $time);
        $this->db->where('status !=', 2);

        $this->db->where('service_id', $service_id);
        // added this staff line
        if (!empty($staff_id) && $staff_id != 0) {
            $this->db->where('staff_id', $staff_id);
        }
        
        $this->db->where('location_id', $location_id);
        
        
        $query = $this->db->get();
        $query = $query->row();
        if (isset($query)) {
            return true;
        } else {
            return false;
        }
    }


    // get time
    function check_location_time($time, $date, $location_id)
    {
        if($location_id == 0){
            $location_id = $this->session->userdata('location_id');
        }
        
        $this->db->select();
        $this->db->from('appointments');
        $this->db->where('date', $date);
        $this->db->where('time', $time);
        $this->db->where('status !=', 2);
        $this->db->where('location_id', $location_id);
        $query = $this->db->get();
        $query = $query->row();
        if (isset($query)) {
            return true;
        } else {
            return false;
        }
    }

    // get time
    function check_staff_time($time, $date, $staff_id)
    {
        if($staff_id == 0){
            $staff_id = $this->session->userdata('staff_id');
        }

        $this->db->select();
        $this->db->from('appointments');
        $this->db->where('date', $date);
        //$this->db->where('time', $time);
        $this->db->where('status !=', 2);
        $this->db->where('staff_id', $staff_id);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    // get assaign days
    function check_break($business_id, $day)
    {
        $this->db->select();
        $this->db->from('working_time');
        $this->db->where('day_id', $day);
        $this->db->where('business_id', $business_id);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    // get assaign days
    function check_break_old($start, $end, $day)
    {
        $this->db->select();
        $this->db->from('working_time');
        $this->db->where('day_id', $day);
        $this->db->where('start <=', $start);
        $this->db->where('end >=', $end);
        $query = $this->db->get();
        $query = $query->row();
        if (isset($query)) {
            return 0;
        } else {
            return 1;
        }
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



    //get report
    function get_admin_income_by_year()
    {
        $this->db->select('r.*');
        $this->db->select_sum('r.amount', 'total');
        $this->db->from('payment r');
        $this->db->where("r.status !=", 'pending');
        $this->db->group_by("DATE_FORMAT(r.created_at,'%Y')");
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    //get report
    function get_admin_income_by_date($date)
    {
        $this->db->select('r.*');
        $this->db->select_sum('r.amount', 'total');
        $this->db->from('payment r');
        $this->db->where("DATE_FORMAT(r.created_at,'%Y-%m')", $date);
        $this->db->where("r.status != ", 'pending');
        $query = $this->db->get();
        $query = $query->result();
        if (empty($query)) {
            return 0;
        } else {
            return $query[0]->total;
        }
    }


    //get payment report
    function get_user_income_by_year()
    {
        $this->db->select('r.*');
        $this->db->select_sum('r.amount', 'total');
        $this->db->from('payment_user r');
        $this->db->where('r.user_id', $this->session->userdata('id'));
        $this->db->group_by("DATE_FORMAT(r.created_at,'%Y')");
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    //get payment report
    function get_user_income_by_date($date)
    {
        $this->db->select('r.*');
        $this->db->select_sum('r.amount', 'total');
        $this->db->from('payment_user r');
        $this->db->where('r.user_id', $this->session->userdata('id'));
        $this->db->where("DATE_FORMAT(r.created_at,'%Y-%m')", $date);
        $query = $this->db->get();
        $query = $query->result();
        if (empty($query)) {
            return '0';
        } else {
            return $query[0]->total;
        }
    }

    //get report
    function get_users_packages()
    {
        $this->db->select('count(p.id) as total, k.name');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->where("p.status !=", 'pending');
        $this->db->group_by("p.package_id");
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }


    // get customer payment
    function get_customer_payment_details($puid)
    {
        $this->db->select('p.*, a.service_id');
        $this->db->from('payment_user p');
        $this->db->join('appointments a', 'a.id = p.appointment_id', 'LEFT');
        $this->db->where('p.puid', $puid);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get user payment
    function get_user_payment_details($puid)
    {
        $this->db->select('p.*, k.name as package_name, k.price, k.monthly_price, k.slug, u.name as user_name, u.phone, u.address, u.email');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->join('users u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.puid', $puid);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }

    // get payment
    function get_users_payment_lists($user_id)
    {
        $this->db->select('p.*, k.name as package_name, k.slug, u.name as user_name, u.phone, u.address, u.email');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->join('users u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.user_id', $user_id);
        //$this->db->where('p.status', 'verified');
        $this->db->order_by('p.id', 'DESC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get payment list
    function get_payment_lists($limit)
    {
        $this->db->select('p.*, k.name as package_name, k.slug, u.name as user_name, u.phone, u.address, u.email, u.thumb');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->join('users u', 'u.id = p.user_id', 'LEFT');
        $this->db->where('p.amount != ', '0.00');
        $this->db->where('p.status != ', 'expired');
        $this->db->order_by('p.id', 'DESC');
        //$this->db->group_by('p.user_id');
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    // get payment list
    function get_customer_payment_lists($limit)
    {
        $this->db->select('p.*, a.service_id');
        $this->db->from('payment_user p');
        $this->db->join('appointments a', 'a.id = p.appointment_id', 'LEFT');
        $this->db->where('p.user_id', $this->session->userdata('id'));
        $this->db->where('p.amount != ', '0.00');
        $this->db->order_by('p.id', 'DESC');
        if ($limit != 0) {
            $this->db->limit($limit);
        }
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }



    function count_users_by_status($type)
    {
        $this->db->select('count(p.id) as total');
        $this->db->from('payment p');
        $this->db->where('p.status', $type);
        $this->db->group_by("p.user_id");
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    function count_customer_info($customer_id, $type)
    {
        $this->db->select('p.*');
        $this->db->from('appointments p');
        if ($type == 2) {
            $this->db->group_by("p.service_id");
        }
        $this->db->where('p.customer_id', $customer_id);
        $this->db->where('p.business_id', $this->business->uid);
        $query = $this->db->get();
        $query = $query->num_rows();
        return $query;
    }


    function get_count_appointment_by_status($status)
    {
        $this->db->select('count(p.id) as total');
        $this->db->from('appointments p');
        if ($status != 'all') {
            $this->db->where('p.status', $status);
        }
        $this->db->where('p.user_id', $this->session->userdata('id'));
        $query = $this->db->get();
        $query = $query->row();
        if (!empty($query)) {
            return $query->total;
        } else {
            return 0;
        }
    }

    //get packages
    function get_previous_payments($user_id)
    {
        $this->db->select();
        $this->db->from('payment p');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $query = $query->result();
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


    // get_settings
    function get_settings()
    {
        $this->db->select('s.*, c.currency_code, c.currency_symbol, c.code');
        $this->db->from('settings s');
        $this->db->join('country c', 'c.id = s.country', 'LEFT');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get_settings
    function get_currency_symbol($currency_code)
    {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('currency_code', $currency_code);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    function get_font_by_slug($slug)
    {
        $this->db->select();
        $this->db->from('google_fonts');
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
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }



    // get_categories
    function get_categories(){
        $this->db->select();
        $this->db->from('category');
        $this->db->where('parent_id', 0);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
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

    // get_clocations
    function get_locations($type){
        $this->db->select();
        $this->db->from('locations');
        $this->db->where('business_id', $this->business->uid);
        if ($type == 0) {
            $this->db->where('parent_id', 0);
        }else{
            $this->db->where('parent_id !=', 0);
        }
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    } 

   
    // get blog posts
    function get_blog_posts($total, $limit, $offset){
        $this->db->select('b.*');
        $this->db->select('c.slug as category_slug, c.name as category, u.role');
        $this->db->from('blog_posts b');
        $this->db->where('u.role', 'admin');
        $this->db->where('b.user_id', $this->session->userdata('id'));
        $this->db->join('blog_category c', 'c.id = b.category_id', 'LEFT');
        $this->db->join('users u', 'u.id = b.user_id', 'LEFT');
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

    //get posts categories
    function get_name_by_id($id,$table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->row_array();  
        return $query;
    }

    //get category posts
    function get_category_posts($total, $limit, $offset, $id)
    {

        $this->db->select('p.*');
        $this->db->select('c.name as category, c.slug as category_slug');
        $this->db->from('blog_posts p');
        $this->db->join('blog_category as c', 'c.id = p.category_id', 'LEFT');
        $this->db->where('p.status', 1);
        $this->db->where('p.category_id', $id);
        
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
        //$this->active_langs();
        $this->db->select('u.*, p.status as payment_status,p.package_id, k.name as package');
        $this->db->from('users u');
        $this->db->join('payment p', 'p.user_id = u.id', 'LEFT');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->where('u.status', 1);
        $this->db->where('u.role', 'user');
        $this->db->group_by('u.id');
        $this->db->order_by('u.id','DESC');
        $this->db->limit(6);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    // count user
    function get_user_total(){
        $this->db->select();
        $this->db->from('users');
        $this->db->where('role', 'user');
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }


    // get all posts
    function active_langs(){
        gets_active_langs();
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

    //get tagfs
    function get_tags($post_id)
    {
        $this->db->select();
        $this->db->from('tags');
        $this->db->where('post_id', $post_id);
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    // delete tags
    function delete_tags($post_id, $table){
        $this->db->delete($table, array('post_id' => $post_id));
        return;
    }


    function get_top_selling_services()
    {
        $this->db->select('s.id, s.name');
        $this->db->from('services s');
        $this->db->where('s.business_id', $this->business->uid);
        $query = $this->db->get();
        $query = $query->result();  
        foreach ($query as $key => $value) {
            $this->db->select('a.*');
            $this->db->from('appointments a');
            $this->db->where('a.service_id',$value->id);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]->total = $query2;
        }
        return $query;
    }


    function get_top_customers()
    {
        $this->db->select('s.id, s.customer_id, c.name as customer_name');
        $this->db->from('appointments s');
        $this->db->where('s.business_id', $this->business->uid);
        $this->db->join('customers as c', 'c.id = s.customer_id', 'LEFT');
        $this->db->group_by('s.customer_id');
        $query = $this->db->get();
        $query = $query->result();  
        foreach ($query as $key => $value) {
            $this->db->select('a.*');
            $this->db->from('appointments a');
            $this->db->where('a.customer_id',$value->customer_id);
            $this->db->where('a.business_id',$this->business->uid);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]->total = $query2;
        }
        return $query;
    }


    function get_top_staffs()
    {
        $this->db->select('s.id, s.staff_id, c.name as staff_name');
        $this->db->from('appointments s');
        $this->db->where('s.business_id', $this->business->uid);
        $this->db->join('staffs as c', 'c.id = s.staff_id', 'LEFT');
        $this->db->group_by('s.staff_id');
        $query = $this->db->get();
        $query = $query->result();  
        foreach ($query as $key => $value) {
            $this->db->select('a.*');
            $this->db->from('appointments a');
            $this->db->where('a.staff_id',$value->staff_id);
            $this->db->where('a.business_id',$this->business->uid);
            $query2 = $this->db->get();
            $query2 = $query2->num_rows();
            $query[$key]->total = $query2;
        }
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



    // select function
    function get_all_ratings($service_id)
    {
        $this->db->select('r.*, p.name as customer_name, p.thumb as customer_thumb');
        $this->db->from('ratings r');
        $this->db->join('customers p', 'p.id = r.customer_id', 'LEFT');
        $this->db->where('r.service_id', $service_id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }


    function get_ratings_info($service_id)
    {
        $this->db->select('p.*');
        $this->db->select('(SELECT count(ratings.service_id)
                            FROM ratings 
                            WHERE (service_id = '.$service_id.')
                            )
                            AS total_user',TRUE);

        $this->db->select('(SELECT sum(ratings.rating)
                            FROM ratings
                            WHERE (service_id = '.$service_id.')
                            )
                            AS total_point',TRUE);

        $this->db->from('ratings p');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    function get_total_rating_user($service_id)
    {
        $this->db->select('p.*');
        $this->db->select('count(p.service_id) as total_service');
        $this->db->from('ratings p');
        $this->db->where('p.service_id', $service_id);
        $query = $this->db->get();
        $query = $query->row();
        return $query->total_service;
    }

    function get_total_ratings_by_user($service_id)
    {
        $this->db->select('p.*');
        $this->db->select_sum('p.rating', 'total_rating');
        $this->db->from('ratings p');
        $this->db->where('p.service_id', $service_id);
        $query = $this->db->get();
        $query = $query->row();
        return $query->total_rating;
    }


    function get_single_ratings($service_id)
    {
        $this->db->select('p.*');

        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.')
                            )
                            AS total_user',TRUE);


        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.'
                                AND
                                rating = 5)
                            )
                            AS five',TRUE);

        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.'
                                AND
                                rating = 4)
                            )
                            AS four',TRUE);

        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.'
                                AND
                                rating = 3)
                            )
                            AS three',TRUE);

        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.'
                                AND
                                rating = 2)
                            )
                            AS two',TRUE);

        $this->db->select('(SELECT count(ratings.id)
                            FROM ratings 
                                WHERE (service_id = '.$service_id.'
                                AND
                                rating = 1)
                            )
                            AS one',TRUE);

        $this->db->from('ratings p');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    function get_admin_package_features()
    {
        $this->db->select('p.*');
        $this->db->from('package p');
        $this->db->order_by('p.id', 'ASC');
        $query = $this->db->get();
        $query = $query->result();  
        foreach ($query as $key => $value) {
            $this->db->select('a.*, f.name as feature_name');
            $this->db->from('feature_assaign a');
            $this->db->join('features f', 'f.id = a.feature_id', 'LEFT');
            $this->db->where('package_id',$value->id);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $query[$key]->features = $query2;
        }
        return $query;
    }


    function get_package_features()
    {
        $this->db->select('*');
        $this->db->from('package');
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $query = $query->result();  
        foreach ($query as $key => $value) {
            $this->db->select('a.*, f.name as feature_name');
            $this->db->from('feature_assaign a');
            $this->db->join('features f', 'f.id = a.feature_id', 'LEFT');
            $this->db->where('package_id',$value->id);
            $query2 = $this->db->get();
            $query2 = $query2->result();
            $query[$key]->features = $query2;
        }
        return $query;
    }
    
    function get_features()
    {
        if(get_user_info() == FALSE){$act = 0;}else{$act = 1;};
        $this->db->select('*');
        $this->db->from('features');
        if ($act == 0) {
            $this->db->where('slug !=', 'get-online-payments');
        }
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $query = $query->result(); 
        return $query;
    }


    function get_assign_package_features($package_id)
    {
        $this->db->select('*');
        $this->db->from('feature_assaign');
        $this->db->where('package_id', $package_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        $query = $query->result(); 
        return $query;
    }

    function check_assign_feature($feature_id, $package_id)
    {
        $this->db->select('*');
        $this->db->from('feature_assaign');
        $this->db->where('feature_id', $feature_id);
        $this->db->where('package_id', $package_id);
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    function get_total_user_by_package($package_id)
    {
        $this->db->select('*');
        $this->db->from('payment');
        $this->db->where('package_id', $package_id);
        $this->db->where('status !=', 'pending');
        $this->db->group_by('user_id');
        $query = $this->db->get();
        $query = $query->num_rows(); 
        return $query;
    }


    // get_payment
    function get_my_payment()
    {
        $this->db->select();
        $this->db->from('payment');
        $this->db->where('user_id', $this->session->userdata('id'));
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    // get_payment
    function get_total_value($table, $date)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
        //$this->db->where("DATE_FORMAT(created_at,'%Y-%m-%d') >=", $date);
        //$this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }

    // get appointment rating
    function check_appointment_rating($appointment_id)
    {
        $this->db->select('*');
        $this->db->from('ratings');
        $this->db->where('appointment_id', $appointment_id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    // get_payment
    function check_appointment_payment($appointment_id)
    {
        $this->db->select('*');
        $this->db->from('payment_user');
        $this->db->where('appointment_id', $appointment_id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    }


    // get_payment
    function get_user_payment($user_id)
    {
        $this->db->select('p.*, k.name as package');
        $this->db->from('payment p');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->where('p.user_id', $user_id);
        $this->db->order_by('p.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    public function active_features($package_id){
        $this->db->select('f.*, s.name, s.slug');
        $this->db->from('feature_assaign f');
        $this->db->join('features s', 's.id = f.feature_id', 'LEFT');
        $this->db->where('f.package_id', $package_id);
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // edit function
    function update_payment($action, $user_id, $table){
        $this->db->where('user_id', $user_id);
        $this->db->update($table,$action);
        return;
    }



    // get_payment
    function get_payment($payment_id)
    {
        $this->db->select();
        $this->db->from('payment');
        $this->db->where('puid', $payment_id);
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


    // get plan coupons
    function get_plan_coupons($total, $limit, $offset){

        $this->db->select('c.*, p.name as plan_name');
        $this->db->from('plan_coupons as c');
        $this->db->join('package p', 'p.id = c.plan', 'LEFT');
        $this->db->group_by('c.uid');
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


    // get_payment
    function count_by_uid($uid)
    {
        $this->db->select();
        $this->db->from('plan_coupons');
        $this->db->where('uid', $uid);
        $query = $this->db->get();
        $query = $query->num_rows();  
        return $query;
    }


    // select by function
    function get_by_user_id($table)
    {
        $this->db->select();
        $this->db->from($table);
        $this->db->where('user_id', $this->session->userdata('id'));
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->row();  
        return $query;
    }


    // get plan coupons
    function get_plan_coupons_by_uid($uid, $total, $limit, $offset){

        $this->db->select('c.*, p.name');
        $this->db->from('plan_coupons as c');
        $this->db->join('package p', 'p.id = c.plan', 'LEFT');
        $this->db->where('c.uid', $uid);
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


    // get code
    function get_coupon_by_code($code){
        $this->db->select();
        $this->db->from('plan_coupons');
        $this->db->where('code', $code);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    } 


    // get code
    function get_coupon_code($code, $plan, $plan_type){
        $this->db->select();
        $this->db->from('plan_coupons');
        $this->db->where('code', $code);
        $this->db->where('plan', $plan);
        $this->db->where('plan_type', $plan_type);
        $this->db->where('status', 1);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    } 

    // check code
    function check_coupon_code_apply($id, $user_id){
        $this->db->select();
        $this->db->from('plan_coupons_apply');
        $this->db->where('coupon_id', $id);
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        $query = $query->row();
        return $query;
    } 


    // get all users
    function get_all_users($total, $limit, $offset, $type){
        $this->db->select('u.*, p.status as payment_status,p.package_id, k.name as package, b.name as currency_name, b.slug as company_slug');
        $this->db->from('users u');
        $this->db->join('payment p', 'p.user_id = u.id', 'LEFT');
        $this->db->join('package k', 'k.id = p.package_id', 'LEFT');
        $this->db->join('business b', 'b.user_id = u.id', 'LEFT');
        
        if (isset($_GET['sort']) && $_GET['sort'] != 'all') {
            $this->db->where('p.status', $_GET['sort']);
        }

        if (isset($_GET['package']) && $_GET['package'] != 'all') {
            $this->db->where('p.package_id', $_GET['package']);
        }

        if (isset($_GET['search']) && $_GET['search'] != '') {
            $this->db->like('u.name', $_GET['search']);
        }

        $this->db->where('u.role', 'user');
        $this->db->order_by('u.id','DESC');
        $this->db->group_by('u.id');
        $this->db->query('SET SQL_BIG_SELECTS=1');

        if ($total == 1) {
            $query = $this->db->get();
            $query = $query->num_rows();
            return $query;
        } else {

            $query = $this->db->get('', $limit, $offset);
            $query = $query->result();

            foreach ($query as $key => $value) {
                $this->db->select();
                $this->db->from('payment');
                $this->db->where('user_id', $value->id);
                $this->db->order_by('id','DESC');
                $this->db->limit(1);
                $query2 = $this->db->get();
                $query2 = $query2->row();
                $query[$key]->payment = $query2;
            }
            return $query;
        }
    }


    // image upload function with resize option
    function upload_image($max_size){
            
            // set upload path
            $config['upload_path']  = "./uploads/";
            $config['allowed_types']= 'gif|jpg|png|jpeg';
            $config['max_size']     = '92000';
            $config['max_width']    = '92000';
            $config['max_height']   = '92000';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;

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
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
 
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
                $limit_big   = 2000 ;
                $limit_medium    = 1000 ;
                $limit_thumb    = 200 ;

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



    // language start

    // get language
    function get_language()
    {
        $this->db->select();
        $this->db->from('language');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // get language
    function get_language_values()
    {
        $this->db->select();
        $this->db->from('lang_values');
        $this->db->order_by('id','ASC');
        $query = $this->db->get();
        $query = $query->result();  
        return $query;
    }

    // get language value pagination
    function get_lang_values($total, $limit, $offset)
    {
        $this->db->select('*');
        $this->db->from('lang_values');
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


    // get language value pagination
    function get_lang_values_by_type($type)
    {
        $this->db->select('*');
        $this->db->from('lang_values');
        $this->db->where('type', $type);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        $query = $query->result();
        return $query;
    }

    //check unique language keyword
    public function check_keyword($keyword)
    {
        $this->db->select('*');
        $this->db->from('lang_values');
        $this->db->where('keyword', $keyword); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return 1;
        }else{
            return 0;
        }
    }

    //check unique language name
    public function check_language($name)
    {
        $this->db->select('*');
        $this->db->from('language');
        $this->db->where('name', $name); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query->num_rows() == 1) {                 
            return 1;
        }else{
            return 0;
        }
    }

    

}