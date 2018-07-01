<div class="page-head">
    <div class="title-d">
        <h3>User List</h3>
    </div>
    <div class="head-act">
        <a href="<?php echo site_url('admin/users/ajaxSave'); ?>" class="head-btn func-load-form">Create New</a>
    </div>
</div>

<div class="card-bg">
    <div class="card-body">
        <div class="table-responsive holder-contents">

        </div>
    </div>
</div>

<script type="text/javascript">
    var listUrl = '<?php echo site_url('admin/users/ajaxList'); ?>';
    var optArr = <?php echo json_encode($this->mdl_users->statusArr()) ?>;
    $(document).ready(function () {
        loadList();

        // pagination link handler
        $(document).on('click', '.pagination a', function () {
            listUrl = $(this).attr('href');
            loadList();
            return false;
        })

        // create or edit data
        $(document).on('click', '.func-load-form', function () {
            ajaxCall('GET', $(this).attr('href'), [], 'bindForm');
            return false;
        });

        // form submit handler
        $(document).on('submit', '.func-handle-form', function () {
            ajaxCall('POST', $(this).attr('action'), $(this).serialize(), 'bindForm');
            return false;
        });
    });

    function loadList() {
        ajaxCall('GET', listUrl, [], 'bindList');
    }

    // form place in content box
    function bindForm(data) {

        if (data.success === false) {
            $('.holder-contents').html(data.htmlCont);
        } else {
            loadList();
        }

    }


    function bindList(data) {
        var listTemplate = '';
        listTemplate += '<table class="table">';
        listTemplate += '        <thead class="thead-inverse">';
        listTemplate += '            <tr>';
        listTemplate += '                <th>Name</th>';
        listTemplate += '                <th>Email</th>';
        listTemplate += '                <th>Status</th>';
        listTemplate += '                <th class="text-right">Action</th>';
        listTemplate += '            </tr>';
        listTemplate += '        </thead>';
        listTemplate += '        <tbody>';
        $(data.listArr).each(function (index, data) {
            listTemplate += '<tr>';
            listTemplate += '    <td>';
            listTemplate += '        <div class="avatar-view">';
            listTemplate += '            <div class="avatar-name">' + data.u_first_name + ' ' + data.u_last_name + '</div>';
            listTemplate += '        </div>';
            listTemplate += '    </td>';
            listTemplate += '    <td>' + data.u_email + '</td>';
            listTemplate += '    <td>' + optArr[data.u_status] + '</td>';
            listTemplate += '    <td class="act">';
            listTemplate += '        <div class="tbl-act">';
            listTemplate += '            <a href="' + BASE_URL + '/admin/users/ajaxSave/' + data.user_id + '" class="func-load-form"><i class="fa fa-pencil"></i></a>';
            listTemplate += '            <a href="' + BASE_URL + '/admin/users/ajaxDelete/' + data.user_id + '" class="func-load-form"><i class="fa fa-trash-o"></i></a>';
            listTemplate += '        </div>';
            listTemplate += '    </td>';
            listTemplate += '</tr>';
        });
        listTemplate += '</tbody>';
        listTemplate += '    </table>';
        listTemplate += '    <div class="holder-pagination-links">' + data.links + '</div>';

        $('.holder-contents').html(listTemplate);
    }
</script>
