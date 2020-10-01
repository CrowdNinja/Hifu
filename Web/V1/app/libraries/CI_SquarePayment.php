<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'libraries/SquarePaymentSDK/autoload.php';  
                           
class CI_SquarePayment
{
    public $access_token = "EAAAEEJRcs_eUUZ8mggDRwTaeotPP0a0EiGpOke239u1BfPXOGJ__xbIylFVFz1-";
    private $api_config;
    
    private $api_client;
    private $locations_api;
     
    public function __construct()
    {
        parent::__construct();
        
        $this->api_config = new \SquareConnect\Configuration();
        $this->api_config->setHost("https://connect.squareupsandbox.com");
        $this->api_config->setAccessToken($this->access_token);
        $this->api_client = new \SquareConnect\ApiClient($api_config);
        $this->location_api = new \SquareConnect\Api\LocationsApi($api_client);
    }

    public function get_api_obj()
    {
        $payments_api = new \SquareConnect\Api\PaymentsApi($this->api_client);
        return $payments_api;
    }
}