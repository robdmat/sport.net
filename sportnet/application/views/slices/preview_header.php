<style>
    #header .top_block .top_menu ul li a {margin: 8px 10px !important;font: 14px/14px Candara, Calibri, sans-serif !important;
                                          display: inline-block !important;
                                          color: #fff !important;
                                          text-decoration: none !important;
    }

</style>

<div id="header" style="  height: 50px;
     position: fixed;
     width: 100%;
     z-index: 10000000;">
    <div class="top_block">
        <div class="wide_container">
            <div class="table clear_fix">
                <div class="top_menu">
                    <ul class="clear_fix" style="padding: 0px!important; margin: 0px !important">
                        <?php getPages(); ?>
                    </ul>
                </div>
                <div class="right_block text_right">
                    <div class="social inline_block">
                        <?php
                        $linksSocial = getSocials();
                        $default = 'javascript:void(0)';
                        ?>
                        <ul class="clear_fix" style="padding: 0px!important; margin: 0px !important">
                            <li class="fb"><a target="_blank" href="<?php echo isset($linksSocial->facebook) ? $linksSocial->facebook : $default; ?>"></a></li>
                            <li class="gp"><a target="_blank" href="<?php echo isset($linksSocial->googleplug) ? $linksSocial->googleplug : $default; ?>"></a></li>
                            <li class="inst"><a target="_blank" href="<?php echo isset($linksSocial->instagram) ? $linksSocial->instagram : $default; ?>"></a></li>
                            <li class="pint"><a target="_blank" href="<?php echo isset($linksSocial->pinterest) ? $linksSocial->pinterest : $default ?>"></a></li>
                            <li class="twit"><a target="_blank" href="<?php echo isset($linksSocial->twitter) ? $linksSocial->twitter : $default ?>"></a></li>
                        </ul>
                    </div>
                    <?php
                    if (!isUserLoggedIn()):
                        ?>
                        <div class="inline_block">
                            <a class="btn start_btn login_start" href="#modal" data-toggle="modal">LogIn</a>
                        </div>
                    <?php else: ?>
                        <div class="inline_block">
                            <a class="btn start_btn login_start" href="<?php echo site_url('user/logout'); ?>">Logout</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--<div class="top_nav">
    <div class="container">
        <div class="row-fluid">
            <div class="span6"><a class="btn btn-danger" href="<?= $url; ?>"><?= 'Remove Frame'; ?></a></div>
            <div class="span6"><a class="removeButton" href="<?= site_url(); ?>"><?= 'Remove Frame'; ?></a></div>
        </div>
    </div>
</div>-->
