<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (settings()->enable_frontend == 0) {
            redirect(base_url('login'));
        }
    }
    
    public function index()
    {
        $data = array();
        $data['page_title'] = 'Home';
        $data['menu'] = TRUE;
        $data['features'] = $this->common_model->select_orders('product_services');
        $data['testimonials'] = $this->common_model->select('testimonials');
        $data['posts'] = $this->common_model->get_home_blog_posts();
        $data['main_content'] = $this->load->view('home', $data, TRUE);
        $this->load->view('index', $data);
    }
   
    public function switch_lang($language = "")
    {   
        $language = ($language != "") ? $language : "english";
        $site_lang = array('site_lang' => $language);
        $this->session->set_userdata($site_lang);
        redirect($_SERVER['HTTP_REFERER']);
    }


    //features
    public function features()
    {   
        $data = array();
        $data['page_title'] = 'Features';
        $data['menu'] = TRUE;
        $data['features'] = $this->common_model->select('features');
        $data['main_content'] = $this->load->view('features', $data, TRUE);
        $this->load->view('index', $data);
    }

    //companies
    public function users()
    {   
        if (settings()->enable_users == 0){
            redirect(base_url());
        }

        $data = array();
        //initialize pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('home/users');
        $total_row = $this->common_model->get_all_business(1 , 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 9;
        $this->pagination->initialize($config);
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['page_title'] = 'Companies';
        $data['menu'] = TRUE;
        $data['companies'] = $this->common_model->get_all_business(0 , $config['per_page'], $page * $config['per_page']);
        $data['countries'] = $this->admin_model->select_asc('country');
        $data['locations'] = $this->common_model->get_all_locations();
        $data['categories'] = $this->admin_model->select_by_status('categories');
        $data['main_content'] = $this->load->view('users', $data, TRUE);
        $this->load->view('index', $data);
    }



    //pricing
    public function pricing()
    {   
        $data = array();
        $data['page_title'] = 'Pricing';
        $data['menu'] = TRUE;
        $data['packages'] = $this->admin_model->get_package_features();
        $data['features'] = $this->admin_model->get_features();
        $data['main_content'] = $this->load->view('price', $data, TRUE);
        $this->load->view('index', $data);
    }

    //faqs
    public function faqs()
    {   
        $data = array();
        $data['page_title'] = 'Faqs';
        $data['menu'] = TRUE;
        $data['faqs'] = $this->admin_model->select_asc('faqs');
        $data['main_content'] = $this->load->view('faqs', $data, TRUE);
        $this->load->view('index', $data);
    }

 
    //purchase page
    public function purchase($payment_id)
    {   
        $data = array();
        $data['menu'] = TRUE;
        $data['payment'] = $this->common_model->get_payment($payment_id);
        $data['payment_id'] = $payment_id;  
        $data['package'] = $this->common_model->get_package_by_slug($data['payment']->package);
        $this->load->view('purchase', $data);
    }

    

    //send contact message
    public function send_message()
    {     
        if ($_POST) {
            $data = array(
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'message' => $this->input->post('message', true),
                'created_at' => my_date_now()
            );
            $data = $this->security->xss_clean($data);
            
            //check reCAPTCHA status
            if (!$this->recaptcha_verify_request()) {
                $this->session->set_flashdata('error', trans('recaptcha-is-required')); 
            } else {
                $this->common_model->insert($data, 'site_contacts');
                $this->session->set_flashdata('msg', trans('send-successfully'));

                //send message
                $subject = 'Contact Message from '. $this->input->post('name');
                $msg = $this->input->post('message');
                $response = $this->email_model->send_email(settings()->admin_email, $subject, $msg);
           
            }
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

  
    public function contact()
    {   
        $data = array();
        $data['menu'] = TRUE;
        $data['page_title'] = 'Contact';
        $data['settings'] = $this->common_model->get('settings');
        $data['main_content'] = $this->load->view('contact', $data, TRUE);
        $this->load->view('index', $data);
    }

    //show pages
    public function page($slug)
    {   
        $data = array();
        $data['page_title'] = 'Pages';
        $data['menu'] = TRUE;
        $data['page'] = $this->common_model->get_single_page($slug);
        if (empty($data['page'])) {
            redirect(base_url());
        }
        $data['page_name'] = $data['page']->title;
        $data['main_content'] = $this->load->view('page', $data, TRUE);
        $this->load->view('index', $data);
    }

    //show pages
    public function terms()
    {   
        $data = array();
        $data['page_title'] = 'Terms of Service';
        $data['menu'] = TRUE;
        $data['main_content'] = $this->load->view('terms', $data, TRUE);
        $this->load->view('index', $data);
    }

    //blogs
    public function blogs()
    {   
        $data = array();
        //initialize pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('blogs');
        $total_row = $this->common_model->get_site_blog_posts(1 , 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 9;
        $this->pagination->initialize($config);
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }
        
        $data['page_title'] = 'Blogs';
        $data['menu'] = TRUE;
        $data['posts'] = $this->common_model->get_site_blog_posts(0 , $config['per_page'], $page * $config['per_page']);
        $data['categories'] = $this->common_model->get_blog_categories();
        $data['main_content'] = $this->load->view('blog_posts', $data, TRUE);
        $this->load->view('index', $data);
    }

    //category
    public function category($slug)
    {   
        $data = array();
        $slug = $this->security->xss_clean($slug);
        $category = $this->common_model->get_category_by_slug($slug);
        
        if (empty($category)) {
            redirect(base_url('blog'));
        }

        //initialize pagination
        $this->load->library('pagination');
        $config['base_url'] = base_url('category/'.$slug);
        $total_row = $this->common_model->get_category_posts(1 , 0, 0, $category->id);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 9;
        $this->pagination->initialize($config);
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }
        
        $data['page_title'] = 'Category Posts';
        $data['menu'] = TRUE;
        $data['title'] = $category->name;
        $data['posts'] = $this->common_model->get_category_posts(0, $config['per_page'], $page * $config['per_page'], $category->id);
        $data['categories'] = $this->common_model->get_blog_categories();
        $data['main_content'] = $this->load->view('blog_posts', $data, TRUE);
        $this->load->view('index', $data);
    }

    //post details
    public function post_details($slug)
    {   

        $data = array();
        $slug = $this->security->xss_clean($slug);
        $data['page_title'] = 'Post details';
        $data['menu'] = TRUE;
        $data['page'] = 'Post';
        $data['post'] = $this->common_model->get_post_details($slug);

        if (empty($data['post'])) {
            redirect(base_url());
        }
        $category_id = $data['post']->category_id;
        $post_id = $data['post']->id;
        $data['post_id'] = $post_id;

        $data['comments'] = $this->common_model->get_comments_by_post($data['post']->id);
        $data['total_comment'] = count($data['comments']);
        $data['tags'] = $this->common_model->get_post_tags($post_id);
        $data['main_content'] = $this->load->view('single_post', $data, TRUE);
        $this->load->view('index', $data);
    }


    //send comment
    public function send_comment($post_id)
    {     
        if ($_POST) {
            $data = array(
                'post_id' => $post_id,
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'message' => $this->input->post('message', true),
                'created_at' => my_date_now()
            );
            $data = $this->security->xss_clean($data);
            $this->common_model->insert($data, 'comments');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    public function demo()
    {  
        $this->load->view('demo');
    }

    // not found page
    public function error_404()
    {
        $data['page_title'] = "Error 404";
        $data['description'] = "Error 404";
        $data['keywords'] = "error,404";
        $this->load->view('error_404');
    }


}