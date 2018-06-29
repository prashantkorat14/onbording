<header class="header">
    <nav class="navbar navbar-default">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo base_url('assets/front/'); ?>images/on-boardingly.png" alt="" /></a></div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo site_url('product'); ?>">Product</a></li>
                    <li><a href="<?php echo site_url('price'); ?>">Pricing</a></li>
                    <li><a href="<?php echo site_url('customers'); ?>">Customers</a></li>
                    <li><a href="<?php echo site_url('resource'); ?>">Resources</a></li>
                    <li><a href="<?php echo site_url('login'); ?>">Sign in</a></li>
                    <li class="btn-view"><a href="<?php echo site_url('signup'); ?>">Get Started</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
</header>