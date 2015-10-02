<script>
    jQuery(function ($) {
//        $('#spans-divs-regular').sortable({
////            handle: 'helper'
//        });


        $('#nestable').nestable();


        $('select[name="menu"]').change(function () {
            window.location.href = "<?php echo site_url(); ?>/admin/menu/" + $(this).val();
        })
    });
</script>  

<div class="container-fluid">
    <div class="row-fluid">
        <?php echo $admin_sidebar; ?>
        <div class="span9" id="content">
            <div class="row-fluid">
                <div class="row-fluid section">
                    <?php echo $this->session->flashdata('info'); ?>
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">
                                <?php echo 'Footer Setting'; ?>
                            </div>  
                        </div>
                        <?php
                        if ($this->session->flashdata('footer_message')) {
                            $msg = $this->session->flashdata('footer_message');
                            echo '<div class="wd_100 text_center">' . $msg . '</div>';
                        }
                        ?>
                        <div class="block-content collapse in">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="tabs">
                                        <ul id="tabs" class="nav nav-tabs">
                                            <li class=""><a href="#copyright" data-toggle="tab">Copyright Content</a></li>
                                            <li class=""><a href="#footer_social" data-toggle="tab">Footer Social Icons</a></li>
                                        </ul>
                                        <div id="content_footer" class="tab-content">
                                            <!--TAB 1-->
                                            <div class="tab-pane fade in active  first_tab width90" id="copyright"> 

                                                <div class="span12">
                                                    <form action="<?php echo site_url('admin/footer_settings/copyright'); ?>" method="post" enctype="" class="form-horizontal">

                                                        <?php
                                                        $text = get_copyright_text();
                                                        $tagline = get_copyright_tagline();
                                                        ?>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label><?php echo 'Copyright Text'; ?></label>
                                                            </div>
                                                            <div class="controls">
                                                                <input class="input-xxlarge" type="text" required="" value="<?php echo $text; ?>" name="copy_right_text" id="copy_right_text" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label><?php echo 'Copyright Tagline'; ?></label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="text" class="input-xxlarge" required="" value="<?php echo $tagline; ?>" name="copy_right_tagline" id="copy_right_tagline" />
                                                            </div>
                                                        </div>

                                                        <div class="control-group">
                                                            <div class="control-label">
                                                            </div>
                                                            <div class="controls">
                                                                <input class="btn btn-success" type="submit" name="copyrights" id="copy_right_text" value="Save"/>
                                                            </div>
                                                        </div>
                                                        <!-- Form closed --> </form>
                                                </div>
                                            </div>

                                            <!--TAB 2-->
                                            <div class="tab-pane fade in first_tab width90" id="footer_social"> 
                                                <div class="span12">
                                                    <form action="<?php echo site_url('admin/footer_settings/social'); ?>" method="post" enctype="" class="form-horizontal">
                                                        <!--Social-->
                                                        <?php
                                                        $profile = footer_social_profiles();
                                                        ?>
                                                        <input type="hidden" name="social_id" value="<?php echo isset($profile->id) ? $profile->id : 1 ?>"/>
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="facebook">
                                                                    <img width="34" height="34" alt="Facebook" src="<?php echo site_url(); ?>assets/img/social_icon/facebook.png" title="Facebook">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="facebook" value="<?php echo isset($profile->facebook) ? $profile->facebook : '' ?>" name="facebook" placeholder="Facebook Profile ID">
                                                            </div>
                                                        </div>
                                                        <!--twitter-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="twitter">
                                                                    <img width="34" height="34" alt="Twitter" src="<?php echo site_url(); ?>assets/img/social_icon/twitter.png" title="Twitter">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="twitter" name="twitter" value="<?php echo isset($profile->twitter) ? $profile->twitter : '' ?>" placeholder="Twitter Username">
                                                            </div>
                                                        </div>
                                                        <!--Youtube-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="youtube">
                                                                    <img width="34" height="34" alt="YouTube" src="<?php echo site_url(); ?>assets/img/social_icon/youtube.png" title="YouTube">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="youtube" value="<?php echo isset($profile->youtube) ? $profile->youtube : '' ?>" name="youtube" placeholder="YouTube Username">
                                                            </div>
                                                        </div>
                                                        <!--Pintrest-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="pinterest">
                                                                    <img width="34" height="34" alt="Pinterest" src="<?php echo site_url(); ?>assets/img/social_icon/pintrest.png" title="Pinterest">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="pinterest" value="<?php echo isset($profile->pinterest) ? $profile->pinterest : '' ?>" name="pinterest" placeholder="Pinterest Username">
                                                            </div>
                                                        </div>
                                                        <!--Instagram-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="instagram">
                                                                    <img width="34" height="34" alt="Instagram" src="<?php echo site_url(); ?>assets/img/social_icon/instagram.png" title="Instagram">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="instagram" value="<?php echo isset($profile->instagram) ? $profile->instagram : ''; ?>" name="instagram" placeholder="Instagram Username">
                                                            </div>
                                                        </div>
                                                        <!--Google-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                                <label for="google">
                                                                    <img width="34" height="34" alt="Google" src="<?php echo site_url(); ?>assets/img/social_icon/google.png" title="Google">
                                                                </label>
                                                            </div>
                                                            <div class="controls">
                                                                <input type="url" required="" class="input-xlarge" id="google" value="<?php echo isset($profile->googleplug) ? $profile->googleplug : '' ?>" name="googleplug" placeholder="Google Plus Username">
                                                            </div>
                                                        </div>
                                                        <!--Button-->
                                                        <div class="control-group">
                                                            <div class="control-label">
                                                            </div>
                                                            <div class="controls">
                                                                <input type="submit" value="Save" id="copy_right_text" name="copyrights" class="btn btn-success">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- block content closed--></div>
                            <!-- block closed --></div>
                    </div>
                </div>
                <!-- #content closed --></div>
        </div>
    </div>

