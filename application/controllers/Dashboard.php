<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function login() {
        $pageData = array();
        $pageData['template'] = 'panel/dashboard/page';

        $this->load->view('auth/layout', $pageData);
    }

}
