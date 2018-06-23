<form action="" method="post">
    <div class="logo"><img src="<?php echo base_url() ?>assets/front/images/on-boardingly.png" alt=""></div>

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
        <label><input type="radio" required name="<?php echo $field; ?>" value="1" /> Website</label>&nbsp;&nbsp;
        <label><input type="radio" required name="<?php echo $field; ?>" value="2" /> Mobile</label>&nbsp;&nbsp;
        <label><input type="radio" required name="<?php echo $field; ?>" value="3" /> Both</label>

        <?php echo form_error($field, '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="checkbox">
        <label>
            <input required name="agree" type="checkbox"><span class="icn"></span> Confirm that you agree with our <a href="#">Term and Condition</a>
        </label>
    </div>
    <div class="">
        <button type="submit" class="com-btn">Schedule your custom demo</button>
    </div>
</form>