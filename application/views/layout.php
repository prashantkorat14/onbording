<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $pageTitle ?></title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/front/'); ?>css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/front/'); ?>css/owl.carousel.min.css" rel="stylesheet">
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

    </head>
    <body class="home">
        <?php $this->load->view('elements/header') ?>

        <?php $this->load->view($template) ?>

        <?php $this->load->view('elements/footer') ?>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url('assets/front/'); ?>js/bootstrap.min.js"></script>
        <script>
            $(window).scroll(function () {
                if ($(this).scrollTop() > 1) {
                    $('header').addClass("sticky");
                    $('body').addClass("sticky-b");
                } else {
                    $('header').removeClass("sticky");
                    $('body').removeClass("sticky-b");
                }
            });
        </script>


    </body>
</html>