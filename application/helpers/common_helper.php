<?php

function access_denied() {
    echo "<h1>Access Denied</h1>
			<a href='" . base_url() . "home'>Go to Home</a>";
    die;
}

/*
  +-----------------------------------------------+
  Alter file name, remove special character from
  file name and append some random key to file.
  +-----------------------------------------------+
 */

function alterFileName($fileName) {
    $fileName2 = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $fileName);

    $info = pathinfo($fileName2);
    $p = $info['extension'];
    $fileName1 = basename($fileName2, '.' . $p);
    $fileName1 .= "_" . time() . "." . $p;

    return $fileName1;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  This function will call any url using php
  curl and return result as string.
  @params : pass any url Ex. http://www.google.com
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function call_url($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $out = curl_exec($ch);
    curl_close($ch);

    return $out;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  This function is displaying error message,
  keep data in session.
  @params :
  @Key : Key name of the variable
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function getFlashMessage($key) {
    $C = & get_instance();
    if ($C->session->userdata('flash_' . $key)) {
        $msg = $C->session->userdata('flash_' . $key);
        $C->session->unset_userdata('flash_' . $key);
    }
    return @$msg;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  This function is setting error,notification,
  information message,
  keep data in session.
  @params :
  @Key : Key name of the variable
  @msg : Which message you want to dispaly
  in next page without pass query string.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function setFlashMessage($key, $msg) {
    $C = & get_instance();
    $C->session->set_userdata('flash_' . $key, $msg);
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Function will return first form error which
  are validated with formValidation in codeigniter.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function get_single_form_error() {
    $CI = & get_instance();

    pr($CI->form_validation);
    if (count($CI->form_validation->_error_array) > 0) {
        foreach ($CI->form_validation->_error_array as $er) {
            return $er;
            break;
        }
    }
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Function will detect device is ipad or not.
  @params : None.
  @returrn : TRUE OR FALSE
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function is_ipad() {
    $CI = & get_instance();
    $CI->load->library('user_agent');

    if ($CI->agent->mobile('ipad'))
        return true;
    else
        return false;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Load thumb url of uploaded image. there is
  fix syntax with image name. we are uploading
  thumb image with same name but with "thumb"
  named folder. If there is no image then it will
  load default thumb image.
  @params : $url -> URL of image [url will be relative].
  $fl -> Flag stand for return thumb path only.
  @returrn : Path of thumb image
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function load_thumb($url, $fl = 0) {
    $info = pathinfo($url);
    $th = $info['dirname'] . "/thumb_" . $info['filename'] . "." . $info['extension'];
    if ($fl == 1)
        return $th;

    $thumb_path = base_url() . $th;
    if (file_exists('./' . $th))
        return $thumb_path;
    else
        return base_url() . "images/no-imges.jpg";
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Load image from url. if not file exist then
  it will load default selected image.

  @params : $url -> URL of image [url will be relative].
  $fl -> Flag stand for return image path only.
  @returrn : Path of image
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function load_image($url, $fl = 0) {
    $thumb_path = base_url() . $url;
    if (file_exists('./' . $url) && $url)
        return $thumb_path;
    else
        return base_url() . "images/no-imges.jpg";
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Just dropdown of per page listing, you can
  set how many records you want to see on page.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function per_page_drop() {
    $dropdown = array('20' => '20 Records Per Page', '40' => '40 Records Per Page', '60' => '60 Records Per Page', '100' => '100 Records Per Page');
//$dropdown = array('2'=>'2 Per Page','4'=>'4 Per Page','6'=>'6 Per Page','10'=>'10 Per Page');
    return $dropdown;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Shortcut function for print data.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function pr($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Image resizing fuction. will resize image.
  @params : $source -> relative path of source image
  $dest -> Setination path of image.
  $width -> Width of the image you want to achieve.
  $height - > height of the image you want to achieve;.
  @return : Resized image array.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function resize_image($source, $dest, $width, $height, $dynamic_output = false, $is_video = false) {
    $C = & get_instance();

    $config['image_library'] = 'gd2';
    $config['source_image'] = $source;
    $config['create_thumb'] = TRUE;
    $config['new_image'] = $dest;
    $config['maintain_ratio'] = TRUE;
    $config['width'] = $width;
    $config['height'] = $height;
    $config['thumb_marker'] = '';
    $config['quality'] = 90;

    $config['dynamic_output'] = $dynamic_output;

    if ($is_video) {
        $wm = './assets/front/images/youtube-play.png';
        $config['wm_overlay_path'] = $wm;
        $config['wm_type'] = 'overlay';
        $config['wm_opacity'] = 70;

        $config['wm_x_transp'] = '1';
        $config['wm_y_transp'] = '1';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'center';
    }

    $C->load->library('image_lib');
    $C->image_lib->initialize($config);
    $rt = $C->image_lib->resize();

    $msg = $C->image_lib->display_errors('', '');

    $returnArr = array();
    $returnArr['msg'] = $msg;
    $returnArr['rt'] = $rt;

    unset($C);
    return $returnArr;
}

/*
  ++++++++++++++++++++++++++++++++++++++++++++++
  Mail send shortcut function.
  Pass parameters according described in functions
  parameters.
  ++++++++++++++++++++++++++++++++++++++++++++++
 */

function sendMail($toEmail, $subject, $mail_body, $from_email = 'info@khabarchhe.com', $from_name = 'khabarchhe.com', $file_path = '') {
    $C = & get_instance();

    $C->load->library('email');
    if ($from_email != '')
        $fromEmail = $from_email;
    else
        $fromEmail = getField('config_value', 'config', 'config_keyword', 'admin_email');

    if ($from_name == '')
        $from_name = 'ARMS FORTUNE';

    $config['mailtype'] = 'html';
    $config['protocol'] = 'mail';
    $config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'iso-8859-1';
    $config['priority'] = '1';

    $C->email->initialize($config);
    $C->email->set_header('MIME-version', '1.0');
//$C->email->cc('another@another-example.com');
    $C->email->from($fromEmail, $from_name);
    $C->email->to($toEmail);
    $C->email->subject($subject);
    $C->email->message($mail_body);
    $C->email->reply_to($fromEmail, '');
    if ($file_path)
        $C->email->attach($file_path, '');

    $C->email->send();

    return $C->email->print_debugger();
    unset($C);
}

function sendMail1($emailId, $subject, $mail_body) {
//$fromEmail = $this->queryResult('select value from configuration where name="from_email"','value');
    $fromEmail = strip_tags(getField('config_value', 'config', 'config_keyword', 'admin_email')); //get admin email

    $C = & get_instance();
    $C->load->helper('phpmailer');
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->IsHTML(true); // send as HTML

    $mail->SMTPAuth = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port = 465;                   // set the SMTP port
    $mail->Username = "";                    // GMAIL username
    $mail->Password = "";                    // GMAIL password

    $mail->From = $fromEmail;
    $mail->FromName = "CVP";
    $mail->Subject = $subject;
    $mail->Body = $mail_body;           //HTML Body

    $emails = explode(",", $emailId);
    foreach ($emails as $email)
        $mail->AddAddress($email);

    if (!$mail->Send())
        echo "Mailer Error: " . $mail->ErrorInfo;
}

/*
  +-----------------------------------------+
  This Function will return get sort order.
  @params. $sort - sort by
  $postField - post field name
  $field - db field name
  +-----------------------------------------+
 */

function get_sort_order($sort, $postField, $field) {
    if ($postField == $field) {
        if ($sort == 'ASC')
            $sort = 'DESC';
        else
            $sort = 'ASC';
    }
    return $sort;
}

/*
  +-----------------------------------------+
  This Function will return file extension
  wise final image source.
  +-----------------------------------------+
 */

function image_src_common($filepath) {
    $ext = strtolower(substr(strrchr(basename($filepath), '.'), 1));
    $imageArr = array('jpeg', 'jpg', 'png', 'bmp', 'gif', 'JPEG');
    $docArr = array('doc', 'docx', 'ppt');
    $pdfArr = array('pdf');
    $xlsArr = array('xls', 'xlsx', 'txt', 'csv');
    $videoArr = array('mp4', 'flv', 'mov');
    switch ($ext) {
        case in_array($ext, $imageArr) :
            $img_src = $filepath;
            break;
        case in_array($ext, $docArr) :
            $img_src = 'images/admin/doc.png';
            break;
        case in_array($ext, $pdfArr) :
            $img_src = 'images/admin/pdf.png';
            break;
        case in_array($ext, $xlsArr) :
            $img_src = 'images/admin/xls.png';
            break;
        case in_array($ext, $videoArr) :
            $img_src = 'images/admin/video.png';
            break;
        default :
            $img_src = 'images/admin/unknown.png';
            break;
    }
    return $img_src;
}

function userIsLoggedIn() {
    $C = & get_instance();

    $str = ($_SERVER['QUERY_STRING'] != '') ? '?' . $_SERVER['QUERY_STRING'] : '';

    if ($C->session->userdata('user_id') == '')
        redirect('/?redirect_to=' . base64_encode(current_url() . $str));
}

/*
  +-----------------------------------------+
  This Function is return Set Full http url.
  +-----------------------------------------+
 */

function fullHttpUrl($url) {
    $u = parse_url($url);
    $protocol = (!isset($u['scheme'])) ? 'http://' : $u['scheme'] . "://";
    $d = (!isset($u['host'])) ? $u['path'] : $u['host'];
    $path = (isset($u['host']) && isset($u['path'])) ? $u['path'] : '';
    $query = (isset($u['query'])) ? '?' . $u['query'] : '';

    $domain = (substr_count($d, 'www.') == 0) ? 'www.' . $d : $d;

    $url = $protocol . $domain . $path . $query;

    $finalUrl = (substr($url, -1) != '/') ? $url . "/" : $url;
    return $finalUrl;
}

/*
  +-----------------------------------------+
  This Function is view part for Image Upload.
  +-----------------------------------------+
 */

function uploadPreview($file_src, $dbName, $columnName, $dbNameId, $dataArr = array()) {
    $C = & get_instance();
    $inputType = ($C->session->userdata('user_id')) ? 'text' : 'hidden';

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $filetype = finfo_file($finfo, $file_src);
    if ($filetype == 'application/pdf') {
        $img = '<img src="' . base_url('assets/img/pdf.png') . '" width="100" height="100">';
    } else {
        $img = '<img src="' . base_url() . $file_src . '" class="img-thumbnail" alt="" />';
    }

    return '<div class="col-md-3 col-sm-3 col-xs-6">' .
            $img .
            '</div>' .
            '<a href="javascript:;" class="btn btn-danger func-remove-file" ' .
            'data-rec-id="" ' .
            'data-table-name="' . $dbName . '" ' .
            'data-column-name="' . $columnName . '" ' .
            'data-table-id="' . $dbNameId . '" ><i class="fa fa-times"></i> Remove</a><br />'
            . '<input type="hidden" name="' . $columnName . '" value="' . $file_src . '" />';

    $htmlCont = '<img src="' . base_url() . 'admin/' . $img_src . '" class="preview" width="156" style="max-height:160px;">
    				<!--<span>' . basename($link) . '</span>-->
					<input type="hidden" id="video_path" name="video_path" value="' . $link . '" />
					<a class="remove_ajax_img" rel="ajax_uploaded_remove_video" href="javascript:void(0);" data-="' . @$id . '"></a>';

    return $htmlCont;
}

/**
 * Returns the string with URL's replaced with actual HTML link tags
 * @param string $string The string to parse for URL's
 * @param boolean $noFollow Whether or not to add the rel="nofollow"
 * attribute to the tag
 * @param boolean $newWindow Whether or not to make the link open in a new
 * window
 * @return string
 */
function getStringWithUrlLinks($s, $noFollow = true, $newWindow = true) {
    return preg_replace('/https?:\/\/[\w\-\.!~?&+\*\'"(),\/]+/', '<a href="$0"'
            . (($noFollow) ? ' rel="nofollow"' : '')
            . (($newWindow) ? ' target="_blank"' : '')
            . '>$0</a>', $s);
}

/*
  +-----------------------------------------+
  This Function will be use for decrypt the column
  +-----------------------------------------+
 */

function DecryptColumn($str, $key = 'asdzxc') {
    if (trim($str))
        return trim(mcrypt_decrypt(MCRYPT_DES, $key, hex2bin1($str), MCRYPT_MODE_ECB));
    else
        return '';
}

/*
  +-----------------------------------------+
  This Function will be use for encrypt the column
  +-----------------------------------------+
 */

function EncryptColumn($str, $key = 'asdzxc') {
    if (trim($str))
        return trim(bin2hex(mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB)));
    else
        return '';
}

/*
  +-----------------------------------------+
  This Function will be use for convert
  hexadecimal to binary string
  +-----------------------------------------+
 */

function hex2bin1($hexstr) {
    $n = strlen($hexstr);
    $sbin = "";
    $i = 0;
    while ($i < $n) {
        $a = substr($hexstr, $i, 2);
        $c = pack("H*", $a);
        if ($i == 0) {
            $sbin = $c;
        } else {
            $sbin .= $c;
        }
        $i += 2;
    }
    return $sbin;
}

function messages($id = '') {
    $dropdown = array(1 => 'Could not find activation key. Please try again.', // not found activation key
        2 => "We could not find information about this activation key. Please verify your activation email.", //for wrong activation key
        3 => "Invalid username or password combination.", //wrong user name and password
        4 => "Please activate your account first. You should have received activation link in your email.", //account without activation
        5 => "We could not find information related to this email address. Kindly check your email address registered with us.", //for wrong email address in forgot password
        11 => "Your account is activated successfully.", //After activation
        13 => "Your password information is sent to your email address. Please check your mailbox.", //In forgot password
        14 => "Your password reset successfully.", //reset password
        15 => "Your profile updated successfully.",
        16 => "Your password updated successfully.",
        20 => "Account activation link is sent to your email. Please check your mailbox.", //simple register
        21 => "You have successfully signed up with facebook. Your password details are sent to your email, please check your mailbox.", //signup through facebook
        22 => "Your account information is updated successfully.", //edit profile
        23 => "Thank you for reporting issue(s). We would try to resolve them as soon as possible.", //Contact us reporting bug
        24 => "Thank you for contacting us. We would get in touch with you soon.", //Contact us Feed back or other
        25 => "Your email not found!.", //Contact us Feed back or other
    );

//$dropdown = array();
    $dropdown['invalid_username_password'] = 'Invalid username or password combination';
    $dropdown['forget_password_email_not_found'] = 'We could not find information related to this email address. Kindly check your email address registered with us.';
    $dropdown['forget_password_sent_email'] = 'Your password information is sent to your email address. Please check your mailbox.';

    $dropdown['change_password_success'] = 'Your password updated successfully.';

    $dropdown['saved_data_success'] = 'Data has been saved successfully.';
    $dropdown['delete_data_success'] = 'Data has been removed successfully.';
    $dropdown['revert_data_success'] = 'Data has been revert successfully.';
    $dropdown['editing_by_user'] = 'This record is being edited by other user!.';

    $dropdown['no_data_found'] = 'No data Found.';

    if ($id)
        return $dropdown[$id];
    else
        return $dropdown;
}

function handle_validation_upload($fName, $folderName, $callbackValidationFunc) {
//    @unlink('./'.$_POST[$fName]);
    unset($_POST[$fName]);
    $CI = & get_instance();
    $config['upload_path'] = './uploads/' . $folderName;
    $config['allowed_types'] = 'gif|jpg|png';
    $CI->load->library('upload', $config);

    if (isset($_FILES[$fName]) && !empty($_FILES[$fName]['name'])) {
        if ($CI->upload->do_upload($fName)) {
// set a $_POST value for 'image' that we can use later
            $upload_data = $CI->upload->data();
            $_POST[$fName] = 'uploads/' . $folderName . '/' . $upload_data['file_name'];
            return true;
        } else {
// possibly do some clean up ... then throw an error
            $CI->form_validation->set_message($callbackValidationFunc, $CI->upload->display_errors());
            return false;
        }
    } else {
// throw an error because nothing was uploaded
        $CI->form_validation->set_message($callbackValidationFunc, "You must upload an image!");
        return false;
    }
}

function getOnPageAlert($alertType = 'success', $msg) {
    return ($msg) ? '<div role="alert" class="alert alert-' . $alertType . ' alert-dismissible fade in"><script type="text/javascript">setTimeout(function(){$(".alert-' . $alertType . '").slideUp("slow")}, 3000);</script>
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        ' . $msg . '</div>' : '';
}

// get sort order for column
function getSortOrder($thisFieldName, $field, $sort) {
    return get_sort_order($sort, $field, $thisFieldName);
}

// this is backgroud process for send push notification to mobile devices.
function pushNotificationSend($module_name, $rec_id) {
    $php_path = 'D:\xampp\php\php.exe';
//    $php_path = 'php';
    $pushnotification_path = FCPATH . "index.php?c=push_notifications&m=index";
    echo "$php_path $pushnotification_path ";
//    echo $pushnotification_path = FCPATH . "index.php";
    $res = shell_exec("$php_path $pushnotification_path ");
//    $res = exec("$php_path $pushnotification_path ");

    echo '<pre>res';
    print_r($res);
    echo '</pre>';
}

//get video url
function getVideoUrl($dataSrc, $returnVideoCode = false) {
    if (strpos($dataSrc, 'dailymotion') !== false) {
        $id = strtok(basename($dataSrc), '_');
        $dataSrc = '//www.dailymotion.com/embed/video/' . $id;
    } else {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $dataSrc, $matches);

        if ($matches) {
            $dataSrc = 'https://www.youtube.com/embed/' . $matches[0];
        }
    }

    return $dataSrc;
}

// show date and time
function showDateFormat($dbDate, $dateFormat = 'd-m-Y') {
    $returnVal = '';
    $dbDateTimeStamp = strtotime($dbDate);

    if (date('Y-m-d') == date('Y-m-d', $dbDateTimeStamp)) {
        $returnVal = 'Today';
    } elseif (date('Y-m-d', strtotime('-1 day')) == date('Y-m-d', $dbDateTimeStamp)) {
        $returnVal = 'Yesterday';
    } else {
        $returnVal = date($dateFormat, $dbDateTimeStamp);
    }

    return $returnVal;
}

function genDynamicImgUrl($src, $width = 0, $height = 0, $is_video = false) {
//    return base_url($src);
    $str = "common/dynamicImgs?src=$src";
    $substr = '';
    if ($width) {
        $substr .= "&width=$width";
    }
    if ($height) {
        $substr .= "&height=$height";
    }
    if ($is_video) {
        $substr .= "&is_video=1";
    }
    return base_url($str) . $substr;
}

//datetime difference for notification
function dateTimeDiff($lastDate) {
    $diff = abs(time() - strtotime($lastDate));
    $years = floor($diff / (365 * 60 * 60 * 24));
    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    $minuts = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));

    $time = array('years' => $years, 'months' => $months, 'days' => $days, 'hours' => $hours,
        'minuts' => $minuts, 'seconds' => $seconds);
    return $time;
}

//get news data of record by id
function prepareNewsData($news) {
    $video_url = '';
    $returnArr = $news;
    if ($news['n_media_type'] == 1) {
        $image_url = $news['n_media_src'];
    } else if ($news['n_media_type'] == 2) {
        $image_url = genDynamicImgUrl($news['n_media_src'], 500);
    } else if ($news['n_media_type'] == 3) {
        $image_url = genDynamicImgUrl($news['n_media_video_thumb'], 500);
        $video_url = getVideoUrl($news['n_media_src']);
    }

    $returnArr['n_media_src'] = $image_url;
    $returnArr['n_media_video'] = $video_url;

    return $returnArr;
}

function getUser($id) {
    $C = & get_instance();
    $data = $C->db->where('user_id', $id)->get('users')->row_array();
    return $data['u_name'];
}

//Multiple image upload preview
function uploadMultiplePreview($res, $dbName, $columnName, $dbNameId) {
    $C = & get_instance();
    $inputType = ($C->session->userdata('user_id')) ? 'text' : 'hidden';
    $table = '<div class="table-responsive holder-multiple-images">'
            . '<table class="table table-striped jambo_table sorted_table">'
            . '<thead>'
            . '<tr>'
            . '<th>Image</th>'
            . '</tr></thead><tbody class="sortable ui-sortable" data-action="' . site_url('admin/press_notes/ajaxUpdateOrder/') . '">';

    foreach ($res as $index => $val) {
        if (is_string($val)) {
            $new_val = array();
            $new_val['error'] = '';
            $new_val['path'] = $val;
            $val = $new_val;
            $index = time('s');
        }
        if (@$val['error']) {
            $table .= '<tr><td colspan="3">' . @$val['error'] . '</td></tr>';
        } else {
            $key = md5($val['path'] . time());
            $index = $index + 1;
            $table .= '<tr  class="sort-row"  id="row_' . $index . '">'
                    . '<td>'
                    . '<div class="col-md-8 col-sm-8 col-xs-8">' .
                    '<img src="' . base_url($val['path']) . '" class="img-thumbnail" alt="" width="100" />' .
                    '</div>' .
                    '<a href="javascript:;" class="btn btn-danger func-remove-multiple-file btn-xs" ' .
                    'data-rec-id="" ' .
                    'data-table-name="' . $dbName . '" ' .
                    'data-column-name="' . $columnName . '" ' .
                    'data-table-id="' . $dbNameId . '" ><i class="fa fa-times"></i> Remove</a>'
                    . '<input type="hidden" name="' . $columnName . '[' . $key . ']" value="' . $val['path'] . '" />'
                    . '</td></tr>';
        }
    }

    $table .= '</tbody></table></div>';
    return $table;
}

//**************************************************************************************
// check validation for requred variable

function validationArr($reqArr, $postData) {
    $errorArr = array();
    foreach ($reqArr as $r) {
        if (!isset($postData[$r])) {
            $errorArr[] = $r;
        }
    }

    if ($errorArr) {
        $msg = 'Required Param : ' . implode(', ', $errorArr);
        responseArr(0, $msg);
    }
}

function convertToShortString($str, $number_of_word) {
    $str = strip_tags($str);
    $strArr = explode(' ', $str);
    $strArr = array_chunk($strArr, $number_of_word);

    return implode(' ', $strArr[0]) . '...';
}

//return array for rest api
function responseArr($status, $msg, $data = array()) {
    $C = & get_instance();

    $returnArr = array();
    $returnArr['success'] = $status;
    $returnArr['msg'] = $msg;
    if ($data) {
        $returnArr['data'] = $data;
    }

    // return config data
    if (@$_GET['get_config'] == 1) {
        $returnArr['config'] = getRestApiConfigData(TRUE);
    }

    // reset notification count
    if (@$_GET['au_udid']) {
        // savedata
        $saveData = array('au_notification_count' => 0);

        saveData(@$_GET['au_udid'], $saveData, 'app_user_devices', 'au_udid');
    }

//    ob_clean();
    ob_start('ob_gzhandler');
    $str = json_encode($returnArr, JSON_UNESCAPED_UNICODE);

    if ($C->session->userdata('is_test_api')) {
//        header('Content-Type: text/json');
//        header('Content-Length: ' . mb_strlen($str));
        echo $str;
    } else {
//            $C->load->library('lzstrings');
//            $str = $C->lzstrings->compress($str);
//            ob_start('ob_gzhandler');
//            header("Charset: UTF-16");
//            header('Content-Type: text/plain');
//            header('Content-Length: ' . mb_strlen($str));
//            header("Content-Encoding: gzip");
//            header("Accept-Encoding: gzip, deflate");
//            header("Last-Modified: " . date("D, d M Y H:i:s", $timestamp) . " GMT");
//            ini_set('zlib.output_compression', 'On');
        echo $str;
    }
    ob_end_flush();
    exit();
}

// return date range arr
function getDatesFromRange($start, $end, $format = 'Y-m-d') {
    if ($start == $end) {
        return array($start);
    }

    return array_map(function($timestamp) use($format) {
        return date($format, $timestamp);
    }, range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
}

// check user privilege and return boolean value
function checkPriviledge($session_key, $priviledge_key) {
    $CI = & get_instance();
    $privilege = $CI->session->userdata('privilege');
    $is_admin = $CI->session->userdata('is_admin');
    $privilege = json_decode($privilege[$session_key], true);

    $boolean = (is_array($privilege) && in_array($priviledge_key, $privilege)) || $is_admin;

    return $boolean;
}

// check controller for user priviledge
function checkPriviledgeController($session_key, $priviledge_key) {
    $have_access = checkPriviledge($session_key, $priviledge_key);

    if ($have_access === false) {
        return false;
//        redirect('dashboard');
    }
    return $have_access;
}

// return full path for imgs
function getImgPath($path) {
    return base_url($path);
}

// return youtube thumb img from url
function getYoutubeImgPath($videoURL) {
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $videoURL, $matches);
    $img = '';
    if ($matches) {
        $videoId = $matches[0];
        $img = 'https://img.youtube.com/vi/' . $videoId . '/hqdefault.jpg';
    }
    return $img;
}

//get meta data to set properties
function getMetaData($metaData) {
    extract($metaData);
    if (@$image_url) {
        if (strpos($image_url, "http://") == 0) {
            $image_url = $image_url;
        } else {
            $image_url = genDynamicImgUrl($image_url, 0, 500);
        }
    }

    $application_name = (@$application_name) ? $application_name : 'jituvaghani.org';
    $description = (@$description) ? @$description : '';

    $returnHtml = array();

    $returnHtml['robot'][] = '<meta name="robots" content="index, follow" />';
//    $returnHtml['robot'][] = '<meta name="google-site-verification" content="66IatvkTuEZtFrkVAprqi-Cym4Y0wPJRdOVorHNg8Hk" />';

    $returnHtml['seo'][] = "<link itemprop='mainEntityOfPage' rel='canonical' href='" . @$url . "' />";
    $returnHtml['seo'][] = "<link itemprop='thumbnailUrl' rel='image_src' href='" . @$image_url . "' />";
    $returnHtml['seo'][] = "<meta itemprop='articleSection' content='india news' name='section' />";


    $returnHtml['seo'][] = "<meta name='keywords' content='" . @$keywords . "' />";
    $returnHtml['seo'][] = "<meta itemprop='keywords' name='keywords' content='" . @$keywords . "' />";
    $returnHtml['seo'][] = '<meta name="description"  content="' . @$description . '"/>';

//$returnHtml['seo'][] = '<meta name="apple-mobile-web-app-capable"  content="yes"/>';
    $returnHtml['seo'][] = '<meta name="application-name" content="' . @$application_name . '" />';

    $returnHtml['fb'][] = '<meta property="og:type"   content="website" /> ';
    $returnHtml['fb'][] = '<meta property="og:url" itemprop="url" content="' . @$url . '"/>';
    $returnHtml['fb'][] = '<meta property="og:title" itemprop="name" content="' . @$title . '" />';
    $returnHtml['fb'][] = '<meta property="og:description" itemprop="description" content="" />';
    $returnHtml['fb'][] = '<meta property="og:site_name" content="' . @$application_name . '"/>';


    $returnHtml['twitter'][] = '<meta name="twitter:url" content="' . @$url . '" />';

    $returnHtml['twitter'][] = '<meta name="twitter:site" content="@khabarchhe" />';
    $returnHtml['twitter'][] = '<meta name="twitter:creator" content="@khabarchhe" />';

    $returnHtml['twitter'][] = '<meta name="twitter:title" content="' . @$title . '" />';
    $returnHtml['twitter'][] = '<meta name="twitter:description" content="' . @$description . '" />';
// set image meta tag
    if (@$metaData['image_url']) {
        $returnHtml['fb'][] = '<meta property="og:image" itemprop="image" content="' . @$image_url . '" />';
        $imgData = getimagesize($image_url);
        $returnHtml['fb'][] = '<meta property="og:image:width" content="' . $imgData[0] . '" />';
        $returnHtml['fb'][] = '<meta property="og:image:height" content="' . $imgData[1] . '" />';

        $returnHtml['twitter'][] = '<meta name="twitter:image" content="' . @$image_url . '"/>';
    }


    $returnHtml['twitter'][] = '<meta name="twitter:card" content="summary_large_image" />';

    $htmlCont = '';
    foreach ($returnHtml as $data) {
        $htmlCont .= implode(' ', $data);
    }
    return $htmlCont;
}

// generate share link on social sites
function shareLink($provider, $pageUrl, $title = '') {
    $returnVal = '';

    switch ($provider) {
        case 'facebook':
            $title = ($title) ? urlencode($title) : '';
            $returnVal = 'https://www.facebook.com/sharer/sharer.php?u=' . $pageUrl . '&redirect_uri=' . $pageUrl;
            break;
        case 'facebook_like':
            $title = ($title) ? urlencode($title) : '';
            $returnVal = site_url('fb/like/' . $pageUrl); //' https://www.facebook.com/sharer/sharer.php?u=' . $pageUrl . '&redirect_uri=' . $pageUrl;
            break;
        case 'facebook_comment':
            $title = ($title) ? urlencode($title) : '';
            $returnVal = site_url('fb/getComment/' . $pageUrl); //' https://www.facebook.com/sharer/sharer.php?u=' . $pageUrl . '&redirect_uri=' . $pageUrl;
            break;
        case 'twitter':
            $title = ($title) ? urlencode($title) : '';
            $returnVal = 'https://twitter.com/intent/tweet?url=' . $pageUrl . '&original_referer=' . $pageUrl . '&tw_p=tweetbutton&ref_src=twsrc%5Etfw&text=' . $title;
            $returnVal = "https://twitter.com/intent/tweet?url=$pageUrl&text=$title&via=khabarchhe";
            break;
    }
    return $returnVal;
}

?>