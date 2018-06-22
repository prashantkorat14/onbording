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
        <?php $this->load->view('elements/header')?>

        <?php $this->load->view($template)?>

        <?php $this->load->view('elements/footer')?>

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

<script>
  (function(apiKey){
    (function(p,e,n,d,o){var v,w,x,y,z;o=p[d]=p[d]||{};o._q=[];
      v=['initialize','identify','updateOptions','pageLoad'];for(w=0,x=v.length;w<x;++w)(function(m){
      o[m]=o[m]||function(){o._q[m===v[0]?'unshift':'push']([m].concat([].slice.call(arguments,0)));};})(v[w]);
      y=e.createElement(n);y.async=!0;y.src='https://cdn.pendo.io/agent/static/'+apiKey+'/pendo.js';
      z=e.getElementsByTagName(n)[0];z.parentNode.insertBefore(y,z);})(window,document,'script','pendo');

    // Call this whenever information about your visitors becomes available
    // Please use Strings, Numbers, or Bools for value types.
    pendo.initialize({
      visitor: {
        id:              'VISITOR-UNIQUE-ID'   // Required if user is logged in
        // email:        // Optional
        // role:         // Optional

        // You can add any additional visitor level key-values here,
        // as long as it's not one of the above reserved names.
      },

      account: {
        id:           'ACCOUNT-UNIQUE-ID' // Highly recommended
        // name:         // Optional
        // planLevel:    // Optional
        // planPrice:    // Optional
        // creationDate: // Optional

        // You can add any additional account level key-values here,
        // as long as it's not one of the above reserved names.
      }
    });
  })('f21220bb-2485-49f0-7982-98eaffeecdb9');
</script>


    </body>

</html>