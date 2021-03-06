<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>onboarding panel</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/front/'); ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/front/'); ?>css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/front/'); ?>css/style.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script type="text/javascript">
            var BASE_URL = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body class="log">

        <div class="wrapper">
            <?php $this->load->view('admin/elements/left-panel'); ?>

            <div class="cont-wrap">
                <?php $this->load->view($template); ?>
            </div>
        </div>


        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url('assets/front/'); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/admin/'); ?>js/dev.js"></script>
    </body>
</html>
