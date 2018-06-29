<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
    }

    public function privacy() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Privacy';
        $pageData['template'] = 'front/privacy';

        $this->load->view('front/layout', $pageData);
    }

    public function terms() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Terms';
        $pageData['template'] = 'front/terms';

        $this->load->view('front/layout', $pageData);
    }

    public function security() {
        $pageData = array();
        $pageData['pageTitle'] = 'Onboardingly : Security';
        $pageData['template'] = 'front/security';

        $this->load->view('front/layout', $pageData);
    }

}
