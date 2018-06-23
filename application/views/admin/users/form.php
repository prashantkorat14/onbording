<div class="row">
    <div class="col-md-12">
        <form action="<?php echo site_url('admin/users/ajaxSave/' . @$user_id); ?>" method="post" class="form-horizontal func-handle-form">
            <?php echo validation_errors(); ?>
            <?php
            $field = 'u_email';
            $labelName = 'Email';
            ?>
            <div class="form-group">
                <input type="email" required name="<?php echo $field; ?>" value="<?php echo @${$field}; ?>" class="form-control" placeholder="<?php echo $labelName ?>" />
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>


            <?php
            $field = 'u_first_name';
            $labelName = 'First Name';
            ?>
            <div class="form-group">
                <input type="text" required name="<?php echo $field; ?>" value="<?php echo @${$field}; ?>"  class="form-control" placeholder="<?php echo $labelName ?>" />
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_last_name';
            $labelName = 'Last Name';
            ?>
            <div class="form-group">
                <input type="text" required name="<?php echo $field; ?>" value="<?php echo @${$field}; ?>" class="form-control" placeholder="<?php echo $labelName ?>" />
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_company_name';
            $labelName = 'Company name';
            ?>
            <div class="form-group">
                <input type="text" required name="<?php echo $field; ?>" value="<?php echo @${$field}; ?>" class="form-control" placeholder="<?php echo $labelName ?>" />
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_phone_no';
            $labelName = 'Phone No';
            ?>
            <div class="form-group">
                <input type="text" name="<?php echo $field; ?>" value="<?php echo @${$field}; ?>" class="form-control" placeholder="<?php echo $labelName ?>" />
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_company_size';
            $labelName = 'Company Size';
            ?>
            <div class="form-group">
                <?php
                $companySizes = array('' => $labelName);
                $companySizes ['1-49'] = '1-49';
                $companySizes ['50-99'] = '50-99';
                $companySizes ['100-499'] = '100-499';
                $companySizes ['500-999'] = '500-999';
                $companySizes ['1000+'] = '1000 above';
                echo form_dropdown($field, $companySizes, @$$field, 'class="form-control" required');
                ?>
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_app_use_for';
            $labelName = 'I am interested in your application for';
            ?>
            <div class="form-group">
                <label><?php echo $labelName; ?></label>
                <label><input type="radio" required name="<?php echo $field; ?>" <?php echo (@$$field == 1) ? 'checked' : ''; ?> value="1" /> Website</label>&nbsp;&nbsp;
                <label><input type="radio" required name="<?php echo $field; ?>" <?php echo (@$$field == 2) ? 'checked' : ''; ?> value="2" /> Mobile</label>&nbsp;&nbsp;
                <label><input type="radio" required name="<?php echo $field; ?>" <?php echo (@$$field == 3) ? 'checked' : ''; ?> value="3" /> Both</label>

                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <?php
            $field = 'u_status';
            $labelName = 'Status';
            ?>
            <div class="form-group">
                <?php
                echo form_dropdown($field, $this->mdl_users->statusArr(), @$$field, 'class="form-control" required');
                ?>
                <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
            </div>

            <div class="">
                <input type="hidden" name="user_id" value="<?php echo @$user_id; ?>" />
                <button type="button" onclick="javascript:loadList();" class="com-btn">Back</button>
                <button type="submit" class="com-btn">Save</button>
            </div>
        </form>
    </div>
</div>
