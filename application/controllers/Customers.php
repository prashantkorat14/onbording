<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Customers';
        $pageData['template'] = 'front/customers';

        $this->load->view('front/layout', $pageData);
    }

}
