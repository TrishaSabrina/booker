<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends Home_Controller {

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
        $data = array();
        $data['page_title'] = 'Package';      
        $data['page'] = 'Package';   
        $data['package'] = FALSE;
        $data['packages'] = $this->admin_model->get_admin_package_features(1);
        $data['features'] = $this->admin_model->get_features();
        $data['main_content'] = $this->load->view('admin/package',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function add()
    {   
        check_status();

        if($_POST)
        {   
            $id = $this->input->post('id', true);
            $data=array(
                'name' => $this->input->post('name', true),
                'monthly_price' => $this->input->post('monthly_price', true),
                'lifetime_price' => $this->input->post('lifetime_price', true),
                'price' => $this->input->post('price', true)
            );
            $data = $this->security->xss_clean($data);
           
            $this->admin_model->edit_option($data, $id, 'package');
            $this->session->set_flashdata('msg', trans('updated-successfully')); 

            $package = $this->admin_model->get_by_id($id, 'package');
            $features = $this->input->post('features');
            $limits = $this->input->post('limits');
            $ids = $this->input->post('ids');

            // assign features
            if(!empty($features)){
                $this->admin_model->delete_assign_features($id,'feature_assaign');
                foreach ($features as $feature) {
                    $data = array(
                        'package_id' => $id,
                        'feature_id' => $feature
                    );
                    $this->admin_model->insert($data, 'feature_assaign');  
                } 
            }

            if(!empty($limits)){
                $i = 0;
                foreach ($limits as $limit) {
                    $data = array(
                        $package->slug => $limit
                    );
                    $this->admin_model->edit_option($data, $ids[$i], 'features');  
                    $i++;
                } 
            }

            redirect(base_url('admin/package'));
            
        }      
        
    }


    public function edit($id)
    {  
        $data = array();
        $data['page_title'] = 'Edit';   
        $data['package'] = $this->admin_model->select_option($id, 'package');
        $data['features'] = $this->admin_model->select('features');
        $data['assign_features'] = $this->admin_model->get_assign_package_features($id);
        $data['main_content'] = $this->load->view('admin/package',$data,TRUE);
        $this->load->view('admin/index',$data);
    }


    public function status_update($status, $id) 
    {
        check_status();
        
        $data = array(
            'status' => $status
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id, 'package');
        
        if ($status == 1) {
            $this->session->set_flashdata('msg', trans('activate-successfully')); 
        } else {
            $this->session->set_flashdata('msg', trans('deactivate-successfully')); 
        }
        
        echo json_encode(array('st' => 1));
    }

    

    public function delete($id)
    {
        $this->admin_model->delete($id,'package'); 
        echo json_encode(array('st' => 1));
    }

}
    

