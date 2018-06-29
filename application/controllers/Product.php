<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function index() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Product';
        $pageData['template'] = 'front/product';

        $this->load->view('front/layout', $pageData);
    }

}
