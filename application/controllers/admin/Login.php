<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
    }

    // login form
    function index() {

        $this->load->helper(array('form', 'url'));

        $this->form_validation->set_rules('u_email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('u_password', 'Pasword', 'trim|required|callback_password_check');

        if ($this->form_validation->run() == FALSE) {
            $pageData = $this->input->post();
            $pageData['pageTitle'] = 'Login';
            $pageData['template'] = 'admin/auth/login';
            $pageData['successMsg'] = $this->session->flashdata('successMsg');
            $pageData['errorMsg'] = $this->session->flashdata('errorMsg');

            $this->load->view('admin/auth/layout', $pageData);
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

    // check user creadentials
    function password_check() {
        $res = $this->db
                ->where('u_email', $this->input->post('u_email'))
                ->where('u_password', md5($this->input->post('u_password')))
                ->get('auth.users')
                ->row_array();

        if ($res) {
            // redirect to dashboard
            $session_array = array();
            $session_array['admin'] = $res;
            $this->session->set_userdata($session_array);

            redirect('admin/dashboard');
            return TRUE;
        } else {
            $this->form_validation->set_message('password_check', 'Please enter valid credentials');
            return FALSE;
        }
    }

}
