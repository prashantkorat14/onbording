<form action="" method="post">
    <div class="logo"><img src="<?php echo base_url() ?>assets/front/images/on-boardingly.png" alt=""></div>

    <?php
    echo (@$successMsg) ? '<p class="alert alert-success">' . $successMsg . '</p>' : '';
    echo (@$errorMsg) ? '<p class="alert alert-danger">' . $errorMsg . '</p>' : '';
    ?>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user-circle-o"></i></span>
            <input type="email" name="u_email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" value="<?php echo @$u_email ?>"/>
        </div>
        <?php echo form_error('u_email', '<small class="text-danger">', '</small>'); ?>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" id="basic-addon2"><i class="fa fa-key"></i></span>
            <input type="password" name="u_password" class="form-control" placeholder="Password" aria-describedby="basic-addon2">
        </div>
        <?php echo form_error('u_password', '<small class="text-danger">', '</small>'); ?>
    </div>

    <div class="">
        <button type="submit" class="com-btn">Login</button>
    </div>
</form>