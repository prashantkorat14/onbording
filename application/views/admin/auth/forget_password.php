<form action="" method="post">
    <div class="logo"><img src="<?php echo base_url() ?>assets/front/images/on-boardingly.png" alt=""></div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-circle-o"></i></span>
            <input type="email" name="u_email" class="form-control" placeholder="Email" aria-describedby="basic-addon1">
        </div>
        <?php echo form_error('u_email', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="">
        <button type="submit" class="com-btn">Send Email</button>
    </div>


</form>

<div class="text-right">
    <a href="<?php echo site_url('login'); ?>">Back to login</a>
</div>