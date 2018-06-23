<?php

class Mdl_common extends CI_Model {

    function checkAdminSession() {
        if ($this->session->userdata('admin_id') == "")
            redirect('admin');
    }

    /*
      +-----------------------------------------+
      This Function will return all data.
      +-----------------------------------------+
     */

    function queryResult($sql) {
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            $result = $res->result_array();
        } else {
            $result = "";
        }
        return $result;
    }

    /*
      +------------------------------------------------------------------+
      Function will return query result options.
      @params : $str -> pagination base url
      $num -> Total number of rows table contain.
      $start -> start segment, position
      $segment -> From which segment you want to consider pagination record count ?.
      +------------------------------------------------------------------+
     */

    function CustompagiationData($url, $num, $start, $segment, $per_page) {

//        $this->load->library('Custom_Pagination');
        $this->load->library('pagination');

        $config['base_url'] = $url;
        $config['total_rows'] = $num;
        $config['per_page'] = $per_page;
        $config['uri_segment'] = $segment;
//        $config['cur_page'] = $cur_page;
//        $this->custom_pagination->initialize($config);

        $config['full_tag_open'] = '<ul class="pagination pagination-sm pull-right">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

//        $query = $this->db->last_query() . " LIMIT " . $start . " , " . $config['per_page'];
        $query = $this->db->last_query() . " LIMIT " . $config['per_page'] . " OFFSET " . $start;
        $res = $this->db->query($query);

        $data['listArr'] = $res->result_array();
        $data['num'] = $res->num_rows();
//        $data['links'] = $this->custom_pagination->create_links();
        $data['links'] = $this->pagination->create_links();
        $data['start'] = $start;
        $data['total_rows'] = $num;
        $data['per_page'] = $start;
        return $data;
    }

    /*
      +-----------------------------------------+
      This Function will return file upload or not.
      @params : $uploadFile -> input file name
      $filetype -> file type parameter eg. img, doc..
      $folder -> upload folder path name
      $fileName -> file name
      +-----------------------------------------+
     */

    function uploadFile($uploadFile, $filetype, $folder, $watermark = false, $fileName = '') {
        $resultArr = array();

        $config['max_size'] = '1024000';
        if ($filetype == 'img')
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG';
        if ($filetype == 'All')
            $config['allowed_types'] = '*';
        if ($filetype == 'pdf')
            $config['allowed_types'] = 'pdf';
        if ($filetype == 'doc')
            $config['allowed_types'] = 'pdf|doc|docx|xls|ppt|rtf|xlsx|pptx|swf|gif|jpg|png|jpeg|txt|csv|text|TEXT|ACL|AFP|ANS|CSV|CWK|STW|RPT|PDAX|PAP|PAGES|SXW|STW|QUOX|WRI|XML|HTML|MCW|XPS|TXT|ABW|JPEG|PNG|SWF|PPT|PPTX|PDF|DOC|DOCX|XLS|XLSX|TeX';
        if ($filetype == 'csv')
            $config['allowed_types'] = 'csv';
        if ($filetype == 'swf')
            $config['allowed_types'] = 'swf';
        if ($filetype == 'video')
            $config['allowed_types'] = 'flv|mp4|mov';

        $config['upload_path'] = 'uploads/' . $folder;

        if ($this->session->userdata('user_id')) {
//            $config['max_width'] = $config['min_width'] = '900';
//            $config['max_height'] = $config['min_height'] = '506';
        }

        if (file_exists($config['upload_path']) == false) {
            if (!mkdir($config['upload_path'], 0777, true)) {
                die('Failed to create folders...');
            }
        }

        if ($fileName != "")
            $config['file_name'] = $fileName;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($uploadFile)) {
            $resultArr['success'] = false;
            $resultArr['error'] = $this->upload->display_errors();
        } else { //if file upload
            $resArr = $this->upload->data();
            $fullname = $resArr['file_name'];

            $resultArr['success'] = true;
            $path = $config['upload_path'] . "/" . $fullname;
            $resultArr['path'] = $path;

            //caption and title for image.
            $size = getimagesize($path, $info);
            if (isset($info['APP13'])) {
                $iptc = iptcparse($info['APP13']);

                $resultArr['caption'] = (@$iptc['2#120']) ? implode('|', $iptc['2#120']) : '';
                $resultArr['title'] = (@$iptc['2#005']) ? implode('|', $iptc['2#005']) : '';
            }

            if ($watermark) //if watermark image
                $this->watermark($fullname);
        }
        return $resultArr;
    }

    /*
      +------------------------------------------------------------------+
      Function will be use for single field value.
      @params-> $field : Name of field you want to fetch.
      $table : Name of table
      $wh : Where condition field name
      $cond : condition operator value.
      +------------------------------------------------------------------+
     */

    function getField($field, $table, $wh, $cond) {
        $this->db->select($field, FALSE);
        if ($wh && $cond)
            $this->db->where($wh, $cond);

        $res = $this->db->get($table);

        //if we want some aggreagration then we pass field name in $wh
        $result = $res->row_array();

        //echo 'ddsfdfd'.$result[$field];die;
        return $result[$field];
    }

    /*
      +------------------------------------------------------------------+
      Function will be use for ajax uploading image.
      @params-> $module : Name of module name for upload image
      $fileType : Name of file type
      $inputFile : Input file name
      $watermark = false : if not watermark image
      +------------------------------------------------------------------+
     */

    function ajaxUploading($module, $fileType, $inputFile, $watermark = false) {
        //print_r($_FILES);die;
        if ($_FILES[$inputFile]["name"])
            $new_file_name = alterFileName($_FILES[$inputFile]["name"]);
        else
            $new_file_name = '';

        $data['type'] = $_FILES[$inputFile]["type"];
        $folder = 'uploads/' . $module;
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
            chmod($folder, 0777);
        }
        $res = $this->mdl_common->uploadFile($inputFile, $fileType, $folder, $watermark, $new_file_name);

        if ($res['success']) {
            $data['link'] = $res["path"];
            $data['input'] = $inputFile;
            return $this->load->view('admin/elements/ajax_view_image', $data, true);
        } else {
            $res['error'] = strip_tags($res['error']);
            return $res;
        }
    }

    /*
      +------------------------------------------------------------------+
      Function will be use for delete uploaded image.
      @params-> $field : Name of input field name
      $table : Name of table in db
      $tableId : Name of field name in db
      +------------------------------------------------------------------+
     */

    function deleteUploaderImage($field, $table, $tableId) {
        //detect ajax request
        if ($this->input->is_ajax_request()):

            //if in edit mode
            if ($this->input->post('auto_id') != '')
                $image = $this->mdl_common->getField($field, $table, $tableId, $this->input->post('auto_id'));
            else //simple in form functionality
                $image = $this->input->post('path');

            //remove image static ajax upload
            if (substr_count($image, './') > 0)
                @unlink($image);
            else
                @unlink('./' . $image);

            $thumb_img = $this->load_image($image);
            @unlink('./' . $thumb_img);

            //making this field null for edit reference
            if ($this->input->post('auto_id') != '')
                $this->db->set($field, '')->where($tableId, $this->input->post('auto_id'))->update($table);

        endif;
    }

    // LOAD THUMB IMAGE
    function load_image($path = '', $type = 'thumb') {
        if ($path != '') {
            $pathArr = explode('/', $path);
            $file_name = array_pop($pathArr);
            return implode('/', $pathArr) . '/' . $type . '/' . $file_name;
        }
    }

    /*
      +------------------------------------------------------------------+
      Function will be use for generate export excel file.
      @params-> $fileName : download file name
      $columns : column field name in file
      $listArr : list data of array
      +------------------------------------------------------------------+
     */

    function exportExcel($fileName, $columns, $listArr) {
        $this->load->helper('download');
        $handle1 = fopen($fileName, 'w');

        $fileTextArray = array_values($columns);
        $fileText = implode("\t", $fileTextArray) . "\n";
        fwrite($handle1, $fileText);

        foreach ($listArr as $list) {
            $fileText = implode("\t", $list) . "\n";
            fwrite($handle1, $fileText);
        }

        fclose($handle1);

        $this->force_download($fileName);
        unlink($fileName);
    }

    /*
      +------------------------------------------------------------------+
      Function will be use for excel download.
      @params-> $file : download file name
      +------------------------------------------------------------------+
     */

    function force_download($file) {
        if ((isset($file)) && (file_exists($file))) {
            $fileName = str_replace("./", "", $file);

            header("Content-length: " . filesize($file));
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');

            readfile($file);
        } else
            echo "No file selected";
    }

    // get news category
    function getNewsCategory() {
        $res = $this->db->where('ac_status', 1)
                ->get('article_category')
                ->result_array();

        return $res;
    }

    // get magazine category
    function getMagazineNames() {
        $res = $this->db->where('m_status', 1)
                ->get('magazine')
                ->result_array();

        return $res;
    }

    // return privilegde arr
    function getDefaultAccess() {
        $returnArr = array();
        $returnArr[] = 'create';
        $returnArr[] = 'update';
        $returnArr[] = 'delete';

        return $returnArr;
    }

    //Activity Log
    function activityLog($module, $action, $redId, $title, $al_extra_param = array()) {
        $datetime = date('Y-m-d H:i:s');
        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'al_module' => $module,
            'al_action' => $action,
            'al_record_id' => $redId,
            'al_title' => $title,
            'al_datetime' => $datetime,
            'al_extra_param' => json_encode($al_extra_param),
        );

        $this->db->insert('kc_activity_log', $data);
    }

    //Author dropdown  for modules
    function authorDropDrown($returnArr = array(), $user_type_id) {
        if ($user_type_id)
            $this->db->where_not_in('user_type_id', $user_type_id);

        if ($this->session->userdata('toggle_delete_opt') == 1) {
            $this->db->where_not_in('u_status', 0);
        }

        $data = $this->db->get('kc_users');
        $result = $data->result_array();
        foreach ($result as $value) {
            $status = ($value['u_status'] == 0) ? 'inactive' : 'active';
            $returnArr[$status][$value['user_id']] = $value['u_name'];
        }
        return $returnArr;
    }

    //Only in magazine list of authors
    function authorDropDrowninMagazine($returnArr = array()) {
        $this->db->where_not_in('a_status', 0);
        $data = $this->db->get('kc_authors');
        $result = $data->result_array();
        foreach ($result as $value) {
            $returnArr[$value['author_id']] = $value['a_eng_name'] . '(' . $value['a_guj_name'] . ')';
        }
        return $returnArr;
    }

    function userList($returnArr = array()) {
        $this->db->where_not_in('u_status', 0);
        $data = $this->db->get('kc_users');
        $result = $data->result_array();
        foreach ($result as $value) {
            $returnArr[$value['user_id']] = $value['u_name'] . ' (' . $value['count'] . ' )';
        }
        return $returnArr;
    }

    function articleCategoryList($returnArr = array()) {
        $this->db->where_not_in('ac_status', 0);


        $data = $this->db->get('kc_article_category');
        $result = $data->result_array();

        foreach ($result as $value) {
            $returnArr[$value['article_category_id']] = $value['ac_name'];
        }
        return $returnArr;
    }

    function articleName($id) {
        $this->db->where_not_in('ac_status', 0);
        if ($id) {
            $this->db->where('article_category_id', $id);
            $data = $this->db->get('kc_article_category');
            $result = $data->row_array();
            return $result['ac_name'];
        } else {
            return '';
        }
    }

    function googleShortUrl($longUrl) {
        $this->load->library('google_url_api');

        $short_url = $this->google_url_api->shorten($longUrl);
        return $short_url->id;
    }

    function getEditingBy($module, $id) {
        if ($module == 'news') {
            $module_id = 'news_id';
        }
        return $this->db->where($module_id, $id)->get($module)->row_array();
    }

    // behald user list out here
    function accessBehalfList() {
        if ($this->session->userdata('main_user_id')) {
            return '<li><a href="' . site_url('admin/login/behalfLogin/' . $this->session->userdata('main_user_id')) . '">Back to my desk</a></li>';
        } else {
            $res = $this->db->where('to_user_id', $this->session->userdata('user_id'))
                    ->join('users', 'users.user_id=user_behalf_access.of_user_id', 'LEFT')
                    ->get('user_behalf_access')
                    ->result_array();

            $returnArr = array();
            foreach ($res as $r) {
                $returnArr[] = '<li><a href="' . site_url('admin/login/behalfLogin/' . $r['of_user_id']) . '">' . $r['u_name'] . '</a></li>';
            }
//        return $returnArr;

            return '<li>
                        <a href="javascript:;"><i class="fa fa-sign-in pull-right" aria-hidden="true"></i> Login As :</a>
                        <ul>' . implode(' ', $returnArr) . '</ul>
                </li>';
        }
    }

    //Multiple image file upload
    function uploadMutipleFile($file, $filetype, $folder) {
        $fileName = '';
        $files = $_FILES;
        $count = count($_FILES[$file]['name']);
        $config['upload_path'] = './uploads/' . $folder . '/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2000000';
        $config['remove_spaces'] = true;
        $config['overwrite'] = false;
        $config['max_width'] = '';
        $config['max_height'] = '';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        for ($i = 0; $i < $count; $i++) {
            $resultArr = array();
            $_FILES[$file]['name'] = time() . $files[$file]['name'][$i];
            $_FILES[$file]['type'] = $files[$file]['type'][$i];
            $_FILES[$file]['tmp_name'] = $files[$file]['tmp_name'][$i];
            $_FILES[$file]['error'] = $files[$file]['error'][$i];
            $_FILES[$file]['size'] = $files[$file]['size'][$i];

            if (!$this->upload->do_upload()) {
                $resultArr['success'] = false;
                $resultArr['error'] = $this->upload->display_errors();
            } else {
                $resArr = $this->upload->data();
                $fullname = $resArr['file_name'];
//                $fullname = $_FILES[$file]['name'];
                $resultArr['success'] = true;
                $path = 'uploads/' . $folder . '/' . $fullname;
                $resultArr['path'] = $path;

                //caption and title for image.
                $size = getimagesize($path, $info);
                $resultArr['size'] = $info;
                if (isset($info['APP13'])) {
                    $iptc = iptcparse($info['APP13']);

                    $resultArr['caption'] = (@$iptc['2#120']) ? implode('|', $iptc['2#120']) : '';
                    $resultArr['title'] = (@$iptc['2#005']) ? implode('|', $iptc['2#005']) : '';
                }
            }

//            if ($watermark) //if watermark image
//                $this->watermark($fullname);
            $images[] = $resultArr;
        }

        return $images;
    }

    function langArr() {
        $this->db->where('l_status', 1);
        $res = $this->db->get('languages')->result_array();

        $lang = array();
        foreach ($res as $key => $value) {
            $lang[$value['language_id']] = $value['l_name'];
        }
        return $lang;
    }

    function getLatestStrory($magazine_id) {
        $sql = "SELECT magazine_page_id, magazine_id, mp_title, mp_desc, mp_img_url,
                       mp_created_by, mp_created_on, mp_updated_on, mp_eng_title, mp_eng_slug_url,
                       mp_status, mp_seo_keyword, mp_seo_desc, mp_datetime, mp_seo_author,
                       mp_notes, mp_short_url, mp_short_desc, mp_fb_like_count, mp_fb_post_id,
                       mp_push_notification
                  FROM kc_magazine_pages
                  WHERE magazine_id = $magazine_id AND mp_datetime < NOW() ORDER BY mp_datetime DESC LIMIT 1;
                ";

        return $this->db->query($sql);
    }

    //count display on dashboard
    function getContactUsCount() {
        $res = $this->db->select('count(*) AS count')
                ->where("(c_created_on BETWEEN '" . date('Y-m-d', strtotime('-1 days')) . "' AND '" . date('Y-m-d') . "')")
                ->get('kc_contactus')
                ->row_array();
        return $res['count'];
    }

    //get city list
    function getCityList() {
        $city = array();
        $this->db->where_not_in('c_status', 0);
        $res = $this->db->get('cities')->result_array();
        foreach ($res as $key => $value) {
            $city[$value['city_id']] = $value['c_name'];
        }
        return $city;
    }

    //count for top news by langauge
    function getTopNewsCount($lang_id) {
        if ($this->session->userdata('city_id')) {
            $this->db->where('city_id', $this->session->userdata('city_id'));
        }
        $res = $this->db->select('count(*) AS count')
                ->where('language_id', $lang_id)
                ->get($this->dbTable)
                ->row_array();
        return $res['count'];
    }

    function locationArr() {
        $locationJson = '{"":"Select Option","Ahmadabad":{"638":"Amraiwadi","647":"Asarwa","650":"Bapunagar","677":"Danilimda","680":"Dariapur","682":"Daskroi","690":"Dhandhuka","695":"Dholka","701":"Ellis Bridge","711":"Ghatlodia","719":"Jamalpur - Khadia","766":"Maninagar","776":"Naranpura","777":"Naroda","779":"Nikol","798":"Sabarmati","799":"Sanand","815":"Thakkarbapa Nagar","830":"Vatva","832":"Vejalpur","834":"Viramgam"},"Amreli":{"640":"Amreli","694":"Dhari","751":"Lathi","795":"Rajula","802":"Savarkundla"},"Anand":{"642":"Anand","644":"Anklav","664":"Borsad","745":"Khambhat","787":"Petlad","807":"Sojitra","820":"Umreth"},"Banas Kantha":{"679":"Danta","685":"Deesa","688":"Deodar","691":"Dhanera","737":"Kankrej","783":"Palanpur","816":"Tharad","823":"Vadgam","831":"Vav"},"Bharuch":{"646":"Ankleshwar","657":"Bharuch","720":"Jambusar","728":"Jhagadia","826":"Vagra"},"Bhavnagar":{"659":"Bhavnagar East","660":"Bhavnagar Rural","661":"Bhavnagar West","665":"Botad","703":"Gadhada","710":"Gariadhar","759":"Mahuva","784":"Palitana","812":"Talaja"},"Dohad":{"674":"Dahod","689":"Devgadbaria","702":"Fatepura","709":"Garbada","729":"Jhalod","754":"Limkheda"},"Gandhinagar":{"687":"Dehgam","707":"Gandhinagar North","708":"Gandhinagar South","734":"Kalol","768":"Mansa"},"Jamnagar":{"700":"Dwarka","721":"Jamjodhpur","722":"Jamnagar North","724":"Jamnagar Rural","723":"Jamnagar South","733":"Kalavad S.C.","744":"Khambhalia"},"Junagadh":{"731":"Junagadh","743":"Keshod","748":"Kodinar","761":"Manavadar","765":"Mangrol","808":"Somnath","813":"Talala","821":"Una","835":"Visavadar"},"Kachchh":{"634":"Abdasa","643":"Anjar","663":"Bhuj","706":"Gandhidham","763":"Mandvi","797":"Rapar"},"Kheda":{"649":"Balasinor","738":"Kapadvanj","757":"Mahudha","769":"Matar","770":"Mehmedabad","774":"Nadiad","817":"Thasra"},"Mahesana":{"656":"Becharaji","732":"Kadi","747":"Kheralu","756":"Mahesana","822":"Unjha","833":"Vijapur","836":"Visnagar"},"Narmada":{"684":"Dediyapada","775":"Nandod"},"Navsari":{"705":"Gandevi","718":"Jalalpore","778":"Navsari","828":"Vansda"},"Panch Mahals":{"713":"Godhra","715":"Halol","735":"Kalol","755":"Lunavada","773":"Morva Hadaf","801":"Santrampur","805":"Shahera"},"Patan":{"667":"Chanasma","786":"Patan","790":"Radhanpur","806":"Siddhpur"},"Porbandar":{"750":"Kutiyana","788":"Porbandar"},"Rajkot":{"697":"Dhoraji","714":"Gondal","725":"Jasdan","726":"Jetpur","772":"Morbi","791":"Rajkot East","792":"Rajkot Rural","793":"Rajkot South","794":"Rajkot West","814":"Tankara","839":"Wankaner"},"Sabar Kantha":{"654":"Bayad","662":"Bhiloda","716":"Himatnagar","717":"Idar","746":"Khedbrahma","771":"Modasa","789":"Prantij"},"Surat":{"652":"Bardoli","669":"Choryasi","736":"Kamrej","740":"Karanj","742":"Katargam","752":"Limbayat","758":"Mahuva","760":"Majura","762":"Mandvi","764":"Mangrol","780":"Nizar","781":"Olpad","809":"Surat East","810":"Surat North","811":"Surat West","818":"Udhna","829":"Varachha Road","837":"Vyara"},"Surendranagar":{"671":"Chotila","681":"Dasada","698":"Dhrangadhra","753":"Limbdi","838":"Wadhwan"},"The Dangs":{"676":"Dangs"},"Vadodara":{"636":"Akota","668":"Chhota Udaipur","672":"Dabhoi","727":"Jetpur","741":"Karjan","767":"Manjalpur","782":"Padra","796":"Raopura","800":"Sankheda","803":"Savli","804":"Sayajigunj","824":"Vadodara City","825":"Vaghodia"},"Valsad":{"693":"Dharampur","739":"Kaprada","785":"Pardi","819":"Umbergaon","827":"Valsad"}}';
        $locationArr = json_decode($locationJson, true);

        return $locationArr;
    }

}
