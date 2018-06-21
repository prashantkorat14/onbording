<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
    }

    // login form
    function index() {
        $this->load->helper(array('form', 'url'));

        $this->form_validation->set_rules('u_email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('u_first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('u_last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('u_company_name', 'Company name', 'trim|required');
        $this->form_validation->set_rules('u_phone_no', 'Phone No', 'trim|required');
        $this->form_validation->set_rules('u_company_size', 'Company Size', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $pageData = array();
            $pageData['template'] = 'auth/signup';

            $this->load->view('auth/layout', $pageData);
        } else {
            $saveData = array();
            $fields = array('u_email', 'u_first_name', 'u_last_name', 'u_company_name', 'u_phone_no', 'u_company_size');
            foreach ($fields as $f) {
                $saveData[$f] = $this->input->post($f);
            }

            saveData('', $saveData, 'auth.users', 'user_id');

            // send welcome email here
            $this->sendEmail();

            redirect('login');
        }
    }

    // callback function check user email exists or not
    function email_check($email) {
        $res = $this->db->where('u_email', $email)
                ->get('auth.users')
                ->row_array();

        if ($res) {
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
