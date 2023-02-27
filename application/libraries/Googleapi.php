<?php
/**
 * @package Google API :  Google Client API
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 * Description of Contact Controller
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Googleapi 
{
    /**
     * Googleapi constructor.
     */
    public function __construct() {        
        // load google client api 
        require_once FCPATH.'vendor/autoload.php';
        $this->client = new Google_Client();
        $this->client->setApplicationName('Calendar Api');
        $this->ci =& get_instance();
        $this->ci->config->load('calendar');
        $this->client->setClientId($this->ci->config->item('client_id'));
        $this->client->setClientSecret($this->ci->config->item('client_secret'));
        $this->client->setRedirectUri($this->ci->config->base_url().'gc/auth/oauth');
        $this->client->addScope(Google_Service_Calendar::CALENDAR);
        $this->client->addScope('profile');
    }

    public function loginUrl() {
        return $this->client->createAuthUrl();
    }

    public function getAuthenticate() {
        return $this->client->authenticate();
    }

    public function getAccessToken() {
        return $this->client->getAccessToken();
    }

    public function setAccessToken() {
        return $this->client->setAccessToken();
    }

    public function revokeToken() {
        return $this->client->revokeToken();
    }

    public function client() {
        return $this->client;
    }

    public function getUser() {
        $google_ouath = new Google_Service_Oauth2($this->client);
        return (object)$google_ouath->userinfo->get();
    }

    public function isAccessTokenExpired() {
        return $this->client->isAccessTokenExpired();
    }
}