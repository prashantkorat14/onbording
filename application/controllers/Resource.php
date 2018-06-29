<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resource extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Resources';
        $pageData['template'] = 'front/resources';

        $this->load->view('front/layout', $pageData);
    }

}
