<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->model('admin/mdl_users');
    }

    public function index() {
        $pageData = array();
        $pageData['template'] = 'admin/users/list';

        $this->load->view('admin/layout', $pageData);
    }

    function ajaxList($start = 0) {

        $this->load->model('mdl_common');

        $dataObj = $this->mdl_users->getData();
        $url = site_url('admin/users/ajaxList');
        $total_rows = $dataObj->num_rows();
        $segment = 4;
        $per_page = 10;

        $res = $this->mdl_common->CustompagiationData($url, $total_rows, $start, $segment, $per_page);

        echo json_encode($res);
    }

    function ajaxSave($id = '') {

        $returnArr = array();
        $returnArr ['success'] = FALSE;
        $this->load->library('form_validation');

        $this->load->helper(array('form', 'url'));

        $this->form_validation->set_rules('u_email', 'Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('u_first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('u_last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('u_company_name', 'Company name', 'trim|required');
        $this->form_validation->set_rules('u_phone_no', 'Phone No', 'trim|required');
        $this->form_validation->set_rules('u_company_size', 'Company Size', 'trim|required');
        $this->form_validation->set_rules('u_status', 'Status', 'trim|required');

        if ($this->form_validation->run() == false) {
            $pageData = $this->input->post();
            if (!@$_POST && $id) {
                $pageData = formData($id, 'auth.users', 'user_id');
            }
            $returnArr ['error'] = validation_errors();
            $returnArr ['htmlCont'] = $this->load->view('admin/users/form', $pageData, TRUE);
        } else {
            // no error
            $saveData = array();
            $fields = array('u_email', 'u_first_name', 'u_last_name', 'u_company_name', 'u_phone_no', 'u_company_size', 'u_app_use_for', 'u_status');
            foreach ($fields as $f) {
                $saveData[$f] = $this->input->post($f);
            }

            saveData($id, $saveData, 'auth.users', 'user_id');
            $returnArr ['success'] = TRUE;
        }

        echo json_encode($returnArr);
    }

    function email_check($str) {
        if ($this->input->post('user_id')) {
            $this->db->where_not_in('user_id', $this->input->post('user_id'));
        }
        $res = $this->db->where('u_email', $str)->get('auth.users')->row_array();
        if ($res) {
            $this->form_validation->set_message('email_check', 'Duplicate email entry');
            return false;
        } else {
            return true;
        }
    }

    // delete record
    function ajaxDelete($id) {
        saveData($id, array('u_status' => 0), 'auth.users', 'user_id');

        $returnArr = [];
        $returnArr ['success'] = TRUE;
        echo json_encode($returnArr);
    }

}
