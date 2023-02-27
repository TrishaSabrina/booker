<?php

/* * ***
 * Version: 1.0.0
 *
 * Description of Google Calendar Controller
 *
 * @author Codericks Team
 *
 * @email  info@Codericks.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Googlecalendar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //load library  
        $this->load->library('googleapi');
        $this->calendarapi = new Google_Service_Calendar($this->googleapi->client());

    }

    public function index() { 
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('auth/google_login');
        } else {
            $this->logout();
           redirect('auth/google_login');
        }
    }


    public function sync() { 
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('auth/google_login');
        } else {

            // $calendar = $this->calendarapi->calendars->get('primary');
            // echo $calendar->getTimeZone(); exit();

            $app_id = $this->session->userdata('appointment_id');
            $slug = $this->session->userdata('company_slug');

            $appointment = $this->common_model->get_appointment_md5(md5($app_id));
            $time = explode('-', $appointment->time);
            $start_time = trim($time[0]);
            $end_time = trim($time[1]);

            $start = $appointment->date.'T'.$start_time.':00';
            $end = $appointment->date.'T'.$end_time.':00';

            $calendarId = 'primary';
            $event = array(
                'summary'     => $appointment->service_name,
                'start'       => $start,
                'end'       => $end,
                'description' => $appointment->service_name.' service booked',
            );
            //echo "<pre>"; print_r($event); exit();
            $data = $this->actionEvent($calendarId, $event);
            
            $this->googleapi->revokeToken();
            $this->session->unset_userdata('is_authenticate_user');
            $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
            $this->output->set_header("Pragma: no-cache");

            if ($this->session->userdata('role') == 'customer') {
                $cdata = array(
                    'sync_calendar' => 1
                );
                $this->admin_model->update($cdata, $app_id, 'appointments');
                $this->session->set_flashdata('msg', 'Sync Successfully'); 

                redirect(base_url('company/confirm_booking/'.$slug.'/'.md5($app_id)));
            }
               

            if ($this->session->userdata('role') == 'staff') {
                $cdata = array(
                    'sync_calendar_staff' => 1
                );
                $this->admin_model->update($cdata, $app_id, 'appointments');
                $this->session->set_flashdata('msg', 'Sync Successfully'); 

                redirect(base_url('staff/appointments'));
            }

            if ($this->session->userdata('role') == 'user') {
                $cdata = array(
                    'sync_calendar_user' => 1
                );
                $this->admin_model->update($cdata, $app_id, 'appointments');
                $this->session->set_flashdata('msg', 'Sync Successfully'); 

                redirect(base_url('admin/appointment'));
            }
            
            
        }
    }


    // actionEvent
    public function actionEvent($calendarId, $data) {
        //Date Format: 2016-06-18T17:00:00+03:00
        $calendar = $this->calendarapi->calendars->get('primary');
        $timeZone = $calendar->getTimeZone();

        $event = new Google_Service_Calendar_Event(
            array(
                'summary'     => $data['summary'],
                'description' => $data['description'],
                'start'       => array(
                    'dateTime' => $data['start'],
                    'timeZone' => $timeZone,
                ),
                'end'         => array(
                    'dateTime' => $data['end'],
                    'timeZone' => $timeZone,
                ),
                'attendees'   => array(
                    array('email' => settings()->admin_email),
                ),
            )
        );
        return $this->calendarapi->events->insert($calendarId, $event);
    }


    // login method
    public function login() {  
        if ($this->session->userdata('is_authenticate_user') == TRUE) {
            redirect('gc/auth/index');
        } else {      
            $data = array();
            $data['metaDescription'] = 'Google Plus Login';
            $data['metaKeywords'] = 'Google Plus Login';
            $data['title'] = "Google Plus Login - Codericks";
            $data['breadcrumbs'] = array('Google Plus Login' => '#');
            $data['loginUrl'] = $this->loginUrl();
            $data['main_content'] = $this->load->view('google_login', $data, TRUE);
            $this->load->view('index', $data);
        }
    }


    // oauth method
    public function oauth() {
        $code = $this->input->get('code', true);
        $this->oauthLogin($code);
        redirect(base_url('googlecalendar/sync'), 'refresh');
    }

    // check login session
    public function isLogin() {
        $token = $this->session->userdata('google_calendar_access_token');
        if ($token) {
            $this->googleapi->client->setAccessToken($token);
        }
        if ($this->googleapi->isAccessTokenExpired()) {
            return false;
        }
        return $token;
    }

    public function loginUrl() {
        return $this->googleapi->loginUrl();
    }
    // oauthLogin
    public function oauthLogin($code) {
        $login = $this->googleapi->client->authenticate($code);
        if ($login) {
            $token = $this->googleapi->client->getAccessToken();
            $this->session->set_userdata('google_calendar_access_token', $token);
            $this->session->set_userdata('is_authenticate_user', TRUE);
            return true;
        }
    }

    // get User Info
    public function getUserInfo() {
        return $this->googleapi->getUser();
    }



    // index method
    public function getCalendar() { 
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('gc/auth/login');
        } else {     
            $data = array();
            $curentDate = date('Y-m-d', time());
            if ($this->input->post('page') !== null) {
                $malestr = str_replace("?", "", $this->input->post('page'));
                $navigation = explode('/', $malestr);
                $getYear = $navigation[1];
                $getMonth = $navigation[2];
                $start = date($getYear.'-'.$getMonth.'-01').' 00:00:00';
                $end = date($getYear.'-'.$getMonth.'-t').' 23:59:59';
            } else {
                $getYear = date('Y');
                $getMonth = date('m');
                $start = date('Y-m-01').' 00:00:00';
                $end = date('Y-m-t').' 23:59:59';
            }
            if ($this->input->post('year') !== null) {
                $getYear = $this->input->post('year');
                $start = date($getYear.'-m-01').' 00:00:00';
                echo $end = date($getYear.'-m-t').' 23:59:59';
            }
            if ($this->input->post('month') !== null) {
                $getMonth = $this->input->post('month');    
                $start = date($getYear.'-'.$getMonth.'-01').' 00:00:00';
                $end = date($getYear.'-'.$getMonth.'-t').' 23:59:59';
            }

            $already_selected_value = $getYear;
            $earliest_year = 1950;
            $startYear = '';
            $googleEventArr = array();
            $calendarData = array();

            $eventData = $this->getEvents('primary', $start, $end, 40);    
            
            foreach ($eventData as $element) {
                $googleEventArr[ltrim(date('d', strtotime($element['start_date'])), 0)] = '<a data-google_event="' . ltrim(date('Y-m-d', strtotime($element['start_date'])), 0) . '" href="#" data-caltoggle="tooltip" data-placement="bottom" title="Google Events" class="small google-event" data-toggle="modal" data-target="#google-cal-data"><i class="fa fa-fw fa-circle text-primary"></i></a>';            
            }


            foreach (array_keys($googleEventArr) as $key) {
                $calendarData[$key] =  '<div class="calendar-dot-area small" style="position: relative;z-index: 2;">' . (isset($googleEventArr[$key]) ? $googleEventArr[$key] : '')  . '</div>';
            }
           
            $class = 'href="#" data-currentdate="' . $curentDate . '" class="add-gc-event" data-toggle="modal" data-target="#gc-create-event" data-year="' . $getYear . '" data-month="' . $getMonth . '" data-days="{day}"';

            $startYear .= '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="year" id="setYearVal" class="form-control">';
        foreach (range
                (date
                        ('Y') + 50, $earliest_year) as $x) {
            $startYear .= '<option value="' . $x . '"' . ($x == $already_selected_value ? ' selected="selected"' : '') . '>' . $x . '</option>';
        }
        $startYear .= '</select></div></div>';
        $startMonth = '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="mont h" id="setMonthVal" class="form-control"><option value="0">Select Month</option>
            <option value="01" ' . ('01' == $getMonth ? ' selected="selected"' : '') . '>January</option>
            <option value="02" ' . ('02' == $getMonth ? ' selected="selected"' : '') . '>February</option>
            <option value="03" ' . ('03' == $getMonth ? ' selected="selected"' : '') . '>March</option>
            <option value="04" ' . ('04' == $getMonth ? ' selected="selected"' : '') . '>April</option>
            <option value="05" ' . ('05' == $getMonth ? ' selected="selected"' : '') . '>May</option>
            <option value="06" ' . ('06' == $getMonth ? ' selected="selected"' : '') . '>June</option>
            <option value="07" ' . ('07' == $getMonth ? ' selected="selected"' : '') . '>July</option>
            <option value="08" ' . ('08' == $getMonth ? ' selected="selected"' : '') . '>August</option>
            <option value="09" ' . ('09' == $getMonth ? ' selected="selected"' : '') . '>September</option>
            <option value="10" ' . ('10' == $getMonth ? ' selected="selected"' : '') . '>October</option>
            <option value="11" ' . ('11' == $getMonth ? ' selected="selected"' : '') . '>November</option>
            <option value="12" ' . ('12' == $getMonth ? ' selected="selected"' : '') . '>December</option>
    </select></div></div>';

        //{heading_title_cell}<th colspan="{colspan}">'.$startMonth.'&nbsp;'.$startYear.'{heading}</th>{/heading_title_cell}      
        $prefs['template'] = '
        

        {table_open}<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

        {heading_row_start}<tr style="border:none;">{/heading_row_start}

        {heading_previous_cell}<th style="border:none;" class="padB"><a class="calnav" data-calvalue="{previous_url}" href="javascript:void(0);"><i class="fa fa-chevron-left fa-fw"></i></a></th>{/heading_previous_cell}
        {heading_title_cell}<th style="border:none;" colspan="{colspan}"><div class="row">' . $startMonth . '' . $startYear . '</div></th>{/heading_title_cell}
        {heading_next_cell}<th style="border:none;" class="padB"><a class="calnav" data-calvalue="{next_url}" href="javascript:void(0);"><i class="fa fa-chevron-right fa-fw"></i></a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<th>{week_day}</th>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<a ' . $class . '>{day}</a>{content}{/cal_cell_content}
        {cal_cell_content_today}<a ' . $class . '>{day}</a>{content}<div class="highlight"></div>{/cal_cell_content_today}

        {cal_cell_no_content}<a ' . $class . '>{day}</a>{/cal_cell_no_content}
        {cal_cell_no_content_today}<a ' . $class . '>{day}</a><div class="highlight"></div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';
        $prefs['start_day'] = 'monday';
        $prefs['day_type'] = 'short';
        $prefs['show_next_prev'] = TRUE;
        $prefs['next_prev_url'] = '?';

        $this->load->library('calendar', $prefs);
        $data['calendar'] = $this->calendar->generate($getYear, $getMonth, $calendarData, $this->uri->segment(3), $this->uri->segment(4));
        echo $data['calendar'];
        }
    }



    // get Events
    public function getEvents($calendarId = 'primary', $timeMin = false, $timeMax = false, $maxResults = 10) {
        if ( ! $timeMin) {
            $timeMin = date("c", strtotime(date('Y-m-d ').' 00:00:00'));

        } else {
            $timeMin = date("c", strtotime($timeMin));
        }

        if ( ! $timeMax) {
            $timeMax = date("c", strtotime(date('Y-m-d ').' 23:59:59'));
        } else {  
            $timeMax = date("c", strtotime($timeMax));

        }
        $optParams = array(
            'maxResults'   => $maxResults,
            'orderBy'      => 'startTime',
            'singleEvents' => true,
            'timeMin'      => $timeMin,
            'timeMax'      => $timeMax,
            'timeZone'     => 'Asia/Kolkata',
        );

        $results = $this->calendarapi->events->listEvents($calendarId, $optParams);
       
        $data = array();
        $creator = new Google_Service_Calendar_EventCreator();
        foreach ($results->getItems() as $item) {

            if(!empty($item->getStart()->date) && !empty($item->getEnd()->date)) {
                $startDate = date('d-m-Y H:i', strtotime($item->getStart()->date));
                $endDate = date('d-m-Y H:i', strtotime($item->getEnd()->date));
            } else {
                $startDate = date('d-m-Y H:i', strtotime($item->getEnd()->dateTime));
                $endDate = date('d-m-Y H:i', strtotime($item->getEnd()->dateTime));
            }
            
            $created = date('d-m-Y H:i', strtotime($item->getCreated()));
            $updated = date('d-m-Y H:i', strtotime($item->getUpdated()));
            
            array_push(
                $data,
                array(
                    'id'          => $item->getId(),
                    'summary'     => trim($item->getSummary()),
                    'description' => trim($item->getDescription()),
                    'creator'     => $item->getCreator()->getEmail(),
                    'organizer'     => $item->getOrganizer()->getEmail(),
                    'creatorDisplayName'     => $item->getCreator()->getDisplayName(),
                    'organizerDisplayName'     => $item->getOrganizer()->getDisplayName(),
                    'created'         => $created,
                    'updated'       => $updated,
                    'start_date'       => $startDate,
                    'end_date'         => $endDate,
                    'status'          => $item->getStatus(),
                )
            );
        }
        return $data;
    }

    // add google calendar event
    public function addEvent() {
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } else {
            $json = array();
            $calendarId = 'primary';
            $post = $this->input->post();
            if(empty(trim($post['summary']))){
                $json['error']['summary'] = 'Please enter summary';
            }
            // start date time validation
            if(empty(trim($post['startDate'])) && empty($post['startTime'])){
                $json['error']['startdate'] = 'Please enter start date time';
            }
            if(empty(trim($post['endDate'])) && empty($post['endTime'])){
                $json['error']['enddate'] = 'Please enter end date time';
            }
            if(empty(trim($post['description']))){
                $json['error']['description'] = 'Please enter description';
            }

            if(empty($json['error'])){
                $event = array(
                    'summary'     => $post['summary'],
                    'start'       => $post['startDate'].'T'.$post['startTime'].':00+03:00',
                    'end'         => $post['endDate'].'T'.$post['endTime'].':00+03:00',
                    'description' => $post['description'],

                );
                $data = $this->actionEvent($calendarId, $event);
                if ($data->status == 'confirmed') {
                    $json['message'] = 1;
                } else {
                    $json['message'] = 0;
                }
            }
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        }
        
    }


    // get event list
    public function viewEvent() {        
        $json = array();
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } else { 
            $google_event_date = $this->input->post('google_event_date');
            $start = date($google_event_date).' 00:00:00';
            $end = date($google_event_date).' 23:59:59';
            $eventData = $this->getEvents('primary', $start, $end, null);   
            /*echo "<pre>";
            print_r($eventData);die; */         
            $json['eventData'] = $eventData;
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('google-calendar/popup/render', $json);
        }

    }
    // render Event Form
    public function renderEventForm() {        
        $json = array();
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } else { 
            $datetime = $this->input->post('datetime');                   
            $json['datetime'] = $datetime;
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('google-calendar/popup/renderadd', $json);
        }

    }

    //logout method
    public function logout() {
        $this->googleapi->revokeToken();
        $this->session->unset_userdata('is_authenticate_user');
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('gc/auth/login');
    }   

}

