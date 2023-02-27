<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    //expire payments
    public function expire_payments()
    {   

        $payments = $this->common_model->get_expire_payments();
        foreach ($payments as $payment) {
            $data = array(
                'status' => 'expire'
            );
            $data = $this->security->xss_clean($data);
            if ($payment->billing_type != 'lifetime') {
                $this->common_model->update($data, $payment->id, 'payment');
            }
        }

        //check trial expire users
        $trial_users = $this->common_model->get_trial_users();
        foreach ($trial_users as $user) {
            $user_data = array(
                'status' => 1,
                'user_type' => 'registered',
                'trial_expire' => '1971-01-01'
            );
            $user_data = $this->security->xss_clean($user_data);
            $this->common_model->update($user_data, $user->id, 'users');
        }


        $appointments = $this->common_model->today_appointments();
        
        if (!empty($appointments)) {
            $company = $this->common_model->get_by_uid($appointments[0]->business_id, 'business');
            foreach ($appointments as $appointment) {
                $subject = trans('appointment-reminder').' - '.settings()->site_name;
                $content = trans('tomorrow-you-have-an-appointment').' '.$company->name.' - '.$appointment->service_name.' '.my_date_show($appointment->date).' '.$appointment->time;

                $edata = array();
                $edata['subject'] = $subject;
                $edata['message'] = $content;

                $message = $this->load->view('email_template/appointment', $edata, true);
                if (!empty($appointment->customer_email)) {
                    $this->email_model->send_email($appointment->customer_email, $subject, $message);
                }
            }
        }

        
    }

}