<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <?php echo chrome_frame(); ?>
        <?php echo $meta; ?>
        <?php
        echo add_css(array('admin_css/bootstrap.min',
            'admin_css/bootstrap-responsive.min',
            'admin_css/styles',
            'admin_css/awesome/css/font-awesome.min',));
        ?>
        <?php echo view_port(); ?>
        <?php echo apple_mobile('black-translucent'); ?>  
        <?php echo favicons(); ?>
        <?php echo $css; ?>
        <?php echo shiv(); ?>
        <?php echo add_js(array('jquery-1.10.2.min', 'scripts', 'jquery.easing.1.3')); ?>
        <?php echo $js; ?>
        <?php
        //get all the session data 
        $udata = $this->session->all_userdata();
        ?>
        <title><?php echo (!empty($title)) ? $title . '' : 'Sportnet'; ?></title>

    </head>
    <body class="<?php echo $body_class; ?>">
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">   
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <a class="brand" target="_blank" href="<?php echo base_url(); ?>"><?php echo'Admin Dashboard'; ?></a>
                    <?php if (isset($udata['is_logged_in']) && $udata['is_logged_in']) { ?>
                        <div class="nav-collapse collapse">
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                    <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i><?php echo $udata['first_name'] . " " . $udata['last_name']; ?> <i class="caret"></i>

                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a tabindex="-1" href="#">Profile</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a tabindex="-1" href="<?php echo site_url('user/logout'); ?>">Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid"> 
                <div id="content" class="span12">
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
        <hr/>
        <footer>
            <p>&copy; <?php echo 'Sportnet ' . date('Y'); ?></p>
        </footer>
        <?php echo add_js(array('admin_js/bootstrap.min.js', 'admin_js/scripts.js')); ?>
    </body>
</html>