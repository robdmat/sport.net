<script>
    jQuery(function($) {
//        $('#spans-divs-regular').sortable({
////            handle: 'helper'
//        });


        $('#nestable').nestable();


        $('select[name="menu"]').change(function() {
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
                                <?php echo $this->lang->line('menu'); ?>
                            </div>  
                        </div>
                        <div class="block-content collapse in">
                            <div class="row-fluid">
                                <div class="span8">
                                    <form action="<?php echo site_url('admin/copyright'); ?>" method="post" enctype="" class="form-horizontal">
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label><?php echo 'Copyright Text'; ?></label>
                                            </div>
                                            <div class="controls">
                                                <input type="text" name="copy_right_text" id="copy_right_text" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label><?php echo 'Copyright Tagline'; ?></label>
                                            </div>
                                            <div class="controls">
                                                <input type="text" name="copy_right_tagline" id="copy_right_tagline" />
                                            </div>
                                        </div>


                                        <!--Social-->
                                        <div class="control-group">
                                            <div class="control-label">
                                                <label for="facebook">
                                                    <img width="34" height="34" alt="Facebook" src="http://webdekeyif.com/assets/img/social_icon/facebook.png" title="Facebook">
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <input type="text" id="facebook" value="http://webdekeyif.com/author/settings" name="facebook" placeholder="Facebook Profile ID">
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

                                    <!-- span8 closed --></div>
                            </div>
                            <!-- block content closed--></div>
                        <!-- block closed --></div>
                </div>
            </div>
            <!-- #content closed --></div>
    </div>
</div>

