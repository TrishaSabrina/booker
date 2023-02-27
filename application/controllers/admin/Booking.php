<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Booking extends Home_Controller
{
    public function __construct()
    {
        parent::__construct();
        
    }

    public function index()
    {
        // get email from url
        $email = $_GET['email'];
        $email = $this->security->xss_clean($email);

        if (!$email){
            redirect('http://aoxio.test/booker/');
        }

        // get user from db
        $user = $this->db->where('email', $email)->get('users')->first_row();

        if ($user){
            // login
            
            $data =
                array('id' => $user->id, 'name' => $user->name, 'role' => $user->role, 'thumb' => $user->thumb, 'email' => $user->email, 'logged_in' => true);
                $this->session->set_userdata($data);
                
            // check if setupfirst is filled
            if($user->is_logged_in == 1){
                // redirect to dashboard
                redirect(base_url('/admin/dashboard/user'));
            }
            // redirect to setupfirst
            redirect(base_url('/admin/setupfirst'));
        }

        redirect('http://aoxio.test/booker/');
    }
}