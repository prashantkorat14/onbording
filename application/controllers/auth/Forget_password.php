<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Forget_password extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
    }

    // login form
    function index() {
        $this->load->helper(array('form', 'url'));

        $this->form_validation->set_rules('u_email', 'Email', 'trim|required|valid_email|callback_email_check');

        if ($this->form_validation->run() == FALSE) {
            $pageData = array();
            $pageData['template'] = 'auth/forget_password';

            $this->load->view('auth/layout', $pageData);
        }
    }

    // callback function check user email exists or not
    function email_check($email) {
        $res = $this->db->where('u_email', $email)
                ->get('auth.users')
                ->row_array();

        if ($res) {
            // send email
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', 'email is not registered with us');
            return FALSE;
        }
    }

    // send email to user
    function sendEmail() {

    }

}
