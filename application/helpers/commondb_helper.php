<?php

/*
  +-----------------------------------------+
  This Function will Save and Update data.
  @params : $id -> get id
  $data -> array of data
  $table -> table name
  $tableId -> table field name
  +-----------------------------------------+
 */

function saveData($id = '', $data, $table, $tableId) {
    $CI = & get_instance();
    if ($id == "") {
        $CI->db->insert($table, $data);
        $insert_id = $CI->db->insert_id();

        if (check_db_column($table, 'sort_order')) {
            $temp['sort_order'] = $insert_id;
            saveData($insert_id, $temp, $table, $tableId);
        }
        return $insert_id;
    } else {
        $CI->db->where($tableId, $id);
        $CI->db->update($table, $data);

        return $id;
    }
}

/*
  +++++++++++++++++++++++++++++++++++++++++++++++++++++
  This function will check column exist in database
  or not? if column exist then return true otherwise
  return false.

  @params : $table_name -> name of the table
  $column_name -> Column name you want to
  check in table.
  @return : TRUE OR FALSE
  +++++++++++++++++++++++++++++++++++++++++++++++++++++
 */

function check_db_column($table_name, $column_name) {
    $CI = & get_instance();

    $sql = "SELECT *
	FROM information_schema.COLUMNS
	WHERE
		TABLE_SCHEMA = '" . $CI->db->database . "'
	AND TABLE_NAME = 'l_" . $table_name . "'
	AND COLUMN_NAME = '" . $column_name . "'";

    $rows = $CI->db->query($sql)->num_rows();

    if ($rows > 0)
        return true;
    else
        return false;
}

/*
  +-----------------------------------------+
  This Function will Delete data.
  @params : $id -> get id
  $del_in -> 1 or 0 value change in db for delete purpose
  $table -> table name
  $tableId -> table field name
  +-----------------------------------------+
 */

function deleteData($id, $table, $tableId) {
    $CI = & get_instance();

    $CI->db->where($tableId, $id);
    $CI->db->delete($table);
}

/*
  +-----------------------------------------+
  This Function will Edit form data.
  @params : $id -> get id
  $table -> table name
  $tableId -> table field name
  +-----------------------------------------+
 */

function formData($id, $table, $tableId) {
    $CI = & get_instance();
    $CI->db->where($tableId, $id);
    return $CI->db->get($table)->row_array();
}

/*
  +-----------------------------------------+
  This Function will return for find minimum ordering data.
  @params : $start_id -> start row id
  $end_id -> end row id
  $table -> table name
  $tableId -> table field name
  +-----------------------------------------+
 */

function minOrderId($start_id, $end_id, $table, $tableId) {
    $CI = & get_instance();

    return $CI->db->select_min('sort_order')->where("$tableId BETWEEN $start_id AND $end_id")->get($table);
}

/*
  +-----------------------------------------+
  This Function will return for update ordering data.
  @params : $recordId -> field row id
  $order -> order id
  $table -> table name
  $tableId -> table field name
  +-----------------------------------------+
 */

function updateDisplayOrder($recordId, $order, $table, $tableId) {
    $CI = & get_instance();
    return $CI->db->where(array('del_in' => 0, $tableId => $recordId))->update($table, array('sort_order' => $order));
}

/*
  +-----------------------------------------+
  This Function will return for check field data.
  @params : $whereData -> condition field name
  $dbTable -> table name
  +-----------------------------------------+
 */

function checkField($whereData, $dbTable) {
    $CI = & get_instance();
    if ($whereData)
        $CI->db->where($whereData);
    return $CI->db->get($dbTable);
}

/*
  +-----------------------------------------+
  This Function will return for config value.
  @params : $keyWord -> config keyword
  $dbTable -> table name
  +-----------------------------------------+
 */

function getConfig($keyWord, $dbTable) {
    $C = & get_instance();
    $C->db->select('config_value');
    $C->db->where('config_keyword', $keyWord);
    $response = $C->db->get($dbTable)->row_array();
    return $response['config_value'];
}

/*
  +------------------------------------------------------------------+
  Function will be use for single field value.
  Input ->
  @params-> $field : Name of field you want to fetch.
  $table : Name of table
  $wh : Where condition field name
  $cond : condition operator value.
  +------------------------------------------------------------------+
 */

function getField($field, $table, $wh = '', $cond = '') {
    $CI = & get_instance();

    $CI->db->select($field, FALSE);
    if ($wh && $cond)
        $CI->db->where($wh, $cond);

    $res = $CI->db->get($table);

    //if we want some aggreagration then we pass field name in $wh
    $result = $res->row_array();
    unset($CI);
    //echo $result['new_order'];die;
    return @$result[$field];
}

/*
  +------------------------------------------------------------------+
  Function will be use for listing all value.
  @params-> $table : Name of table
  +------------------------------------------------------------------+
 */

function getDbTableData($table) {
    $CI = & get_instance();
    $CI->db->where('del_in', 0);
    return $CI->db->get($table)->result_array();
}

/*
  +------------------------------------------------------------------+
  Function will be use for generate random string.
  @params-> $table : Name of table
  +------------------------------------------------------------------+
 */

function get_random_string($table, $field_code) {
    // Create a random user id
    $random_unique = random_string('alnum', 6);

    // Make sure the random user_id isn't already in use
    $CI = get_instance();
    $CI->db->where($field_code, $random_unique);
    $query = $CI->db->get_where($table);

    if ($query->num_rows() > 0) {
        // If the random user_id is already in use, get a new number
        $this->get_random_string();
    }

    return $random_unique;
}

// prepare dropdown
function prepareDropdownArr($table, $returnArr = array(), $optVal, $optLabel) {
    $CI = & get_instance();
    $res = $CI->db->get($table)->result_array();

    foreach ($res as $value) {
        $returnArr[$value[$optVal]] = $value[$optLabel];
    }
    return $returnArr;
}

/*
  +-----------------------------------------+
  This Function is view part for Image Upload.
  +-----------------------------------------+
 */

function uploadPreviewByImageId($file_src, $columnName) {
//    $file_src = getField('i_path', 'images', 'i_path', $Image_id);
    if ($file_src) {
        return '<div title="Please Click here for select other images">'
                . '<img src="' . base_url() . $file_src . '" class="img-thumbnail img-responsive" alt="" style="max-height: 150px;" />'
                . '</div>'
                . '<input type="hidden" name="' . $columnName . '" value="' . $file_src . '" />';
    } else {
        return 'Select Image';
    }
}

// check priviledge
function retunUserPriviledge($scope) {
    $CI = & get_instance();

//    $privilege = $this->session->userdata('privilege');

    $privilege = formData($CI->session->userdata('user_id'), 'user_privilege', 'user_id');
    $privilege = json_decode($privilege[$scope], true);
    $privilege = ($privilege) ? $privilege : array();
    if (!$privilege && $CI->session->userdata('is_admin') == 0) {
        if (!$CI->input->is_ajax_request()) {
            site_url('admin/login/logout');
        } else {
            echo json_encode(array('is_logged_out' => true, 'redirect_url' => site_url('admin/login/logout')));
            die;
        }
        exit();
    }

    // for super admin get priviledge arr for all access
    if ($CI->session->userdata('is_admin') == 1) {
        $privilege = $CI->mdl_common->getDefaultAccess();
    }

    return $privilege;
}

//multiple file preview by folderid

function uploadPreviewMultipleImageById($file_src, $columnName) {
//    $file_src = getField('i_path', 'images', 'i_path', $Image_id);
    $CI = & get_instance();

    if ($file_src) {

        $table = '<div class="holder-multiple-images">'
                . '<table class="table"> '
                . '<thead>'
                . '<tr>'
                . '<th>Image</th><th>Caption</th><th>Title</th>'
                . '</tr></thead><tbody>';
        foreach ($file_src as $key => $value) {
            $i_path = is_array($value) ? $value['path'] : $value;
            $res = $CI->db->where('i_path', $i_path)->get('kc_images')->row_array();

            $table .= '<tr><td style="height:100;width:100" ><div class="col-md-12 col-sm-12 col-xs-12">' .
                    '<img src="' . base_url() . $res['i_path'] . '" class="img-thumbnail" alt="" width="100" height="100"/>' .
                    '</div>' .
                    '<a href="javascript:;" class="btn btn-danger btn-sm func-remove-multiple-file" ' .
                    'data-rec-id="" ' .
                    'data-table-name="' . $columnName . '" ' .
                    'data-column-name="' . $columnName . '" ' .
                    'data-table-id="' . $columnName . '" ><i class="fa fa-times"></i> Remove</a><br /></td>'
                    . '<input type="hidden" name="' . $columnName . '[' . $key . '][path]" value="' . $res['i_path'] . '" />'
                    . '<td><input type="text" name="' . $columnName . '[' . $key . '][caption]" placeholder="caption" required value="' . $res['i_path_caption'] . '" /></td>'
                    . '<td><input type="text" name="' . $columnName . '[' . $key . '][title]" placeholder="title" required value="' . $res['i_path_title'] . '" /></td></tr>';
        }

        $table .= '</tbody></table></div>';
        return $table;
    } else {
        return 'Select Image';
    }
}

//return array of json string passed
function getArrForMulimg($str) {

    $mulImages = array();
    $data = json_decode($str);
    // $mulImages[0] = $firstVal;
    foreach ($data as $key => $value) {
        $mulImages[] = $value->path;
    }

    return $mulImages;
}

?>