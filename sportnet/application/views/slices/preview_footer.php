<div class="bottom_block">
    <div class="wide_container">
        <div class="links text_center">
            <ul style="padding: 0px!important; margin: 0px !important">
                <?php getPages(); ?>
            </ul>
        </div>
        <div class="table">
            <div class="social">
                <div class="name">Follow Sport.net</div>
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
            <div class="text_center">
                <a class="start_btn" href="#">Start reading</a>
            </div>
            <div class="logo text_right">
                <a href="index.html"><img src="<?php echo site_url(); ?>assets/img/logo.png" alt="Sport.Net"></a>
            </div>
        </div>
    </div>
</div>
</div>
<div id="footer">
    <div class="wide_container clear_fix">
        <div class="fl_left">
            <!--Copyright &copy; 2014 <a href="index.html">Sport.Net</a>. All rights reserved.-->
            <?php echo get_copyright_text(); ?>
        </div>
        <div class="fl_right">
            <ul style="padding: 0px!important; margin: 0px !important">
                <li>
                    <a href="#">Terms of Use</a>
                </li>
                <li>
                    <a href="#">Privacy Policy</a>
                </li>
                <li>
                    <a href="#">Site Map</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!--<div id="loginModel" class="modal fade">-->
<div class="modal fade" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="loginModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clear_fix">
                <a href="javascript: void(0);" data-dismiss="modal" class="fl_right closeModel" id="close"></a>
            </div>
            <div class="modal-body">
                <div class="modal_title text_center">Create your personalized newsfeed now</div>
                <div class="text_center modal_content">
                    <div class="form">
                        <div class="form_name">Access your Sports feed everywhere</div>
                        <div class="inputs text_center">
                            <?php
                            $attributes = array('class' => 'login', 'id' => 'login_form');
                            echo form_error('invalid', '<div class="alert alert-error">', '</div>');
                            echo form_open('user/login/');
                            ?>
                            <?php
                            echo '<div class="row">';
                            echo form_input(array(
                                'name' => 'email',
                                'id' => 'email',
                                'placeholder' => 'Email',
                                'maxlength' => '100',
                                'size' => '50',
                                'class' => 'text_field required',
                                'onkeydown' => 'javascript:removeError(this);',
                                'value' => set_value('email')
                            ));
                            echo '</div>';
                            echo '<div class="row">';
                            echo form_error('email', '<div class="error">', '</div>');
                            echo form_password(array(
                                'name' => 'password',
                                'id' => 'password',
                                'placeholder' => 'Password',
                                'maxlength' => '100',
                                'size' => '50',
                                'class' => 'text_field required',
                                'onkeydown' => 'javascript:removeError(this);',
                                'value' => set_value('password')
                            ));
                            echo '</div>';
                            echo form_error('password', '<div class="error">', '</div>');
                            ?>

                            <div class="row">
                                <input class="cancel button" id="buttonCloseLogin" data-dismiss="modal" type="button" value="Cancel">
                                <input class="submit button" type="submit" value="Sign In">
                            </div>
                            <div class="text">
                                <a href="<?php echo site_url('user/password_reset'); ?>">Forgot your password</a>
                            </div>
                            <div class="text">
                                Don't have an account? <a href="javascript:void(0)" onclick="javascript:showRegisterModel()">SignUp</a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
//    jQuery('#modalRegister').modal();
//    jQuery('#loginModel').modal();
</script>

<!--REGISTER MODEL-->
<!--<div id="modalRegister" class="modal fade">-->
<div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="modalRegister" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clear_fix">
                <a href="javascript: void(0);" data-dismiss="modal" class="fl_right closeModel" id="close"></a>
            </div>
            <div class="modal-body">
                <div class="modal_title text_center">Create your personalized newsfeed now</div>
                <div class="text_center modal_content">
                    <div class="form">
                        <div class="form_name">Access your Sports feed everywhere</div>
                        <div class="inputs text_center">
                            <?php
                            $attributess = array('class' => 'login', 'id' => 'signup_form');
                            echo form_error('invalid', '<div class="alert alert-error">', '</div>');
                            echo form_open('user/register/');
                            ?>
                            <?php
                            echo '<div class="row">';
                            echo form_input(array(
                                'name' => 'email',
                                'id' => 'email',
                                'placeholder' => 'Email',
                                'maxlength' => '100',
                                'size' => '50',
                                'class' => 'text_field required',
                                'onkeydown' => 'javascript:removeError(this);',
                                'value' => set_value('email')
                            ));
                            echo '</div>';
                            echo '<div class="row">';
                            echo form_error('email', '<div class="error">', '</div>');
                            echo form_password(array(
                                'name' => 'password',
                                'id' => 'password',
                                'placeholder' => 'Password',
                                'maxlength' => '100',
                                'size' => '50',
                                'class' => 'text_field required',
                                'onkeydown' => 'javascript:removeError(this);',
                                'value' => set_value('password')
                            ));
                            echo '</div>';
                            echo form_error('password', '<div class="error">', '</div>');

                            echo '<div class="row">';
                            echo form_password(array(
                                'name' => 'confirm_password',
                                'id' => 'confirm_password',
                                'placeholder' => 'Confirm Password',
                                'maxlength' => '100',
                                'size' => '50',
                                'class' => 'text_field required',
                                'onkeydown' => 'javascript:removeError(this);',
                                'value' => set_value('confirm_password')
                            ));
                            echo form_error('confirm_password', '<div class="error">', '</div>');
                            echo '</div>';
                            ?>

                            <div class="row">
                                <input class="cancel button" id="buttonCloseLogin" data-dismiss="modal" type="button" value="Cancel">
                                <input class="submit button" type="submit" value="Sign In">
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--</div>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/modal.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/main.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/masonry.pkgd.min.js"></script>