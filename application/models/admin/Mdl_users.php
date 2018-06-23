<?php

class Mdl_users extends CI_Model {

    function getData() {
        return $this->db
                        ->where('u_status > 0')
                        ->order_by('user_id', 'DESC')
                        ->get('auth.users');
    }

    // status option
    function statusArr() {
        $optArr = array('' => 'Select Option');
        $optArr[1] = 'active';
        $optArr[2] = 'pending';
        $optArr[3] = 'inactive';

        return $optArr;
    }

}
