<div class="container-fluid">
    <div class="row-fluid">
        <?php echo $admin_sidebar; ?>
        <div class="span9" id="content">
            <div class="row-fluid section">
                <?php echo $this->session->flashdata('info'); ?>
                <div id="messages"></div>
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">
                            Add Feed
                        </div>  
                    </div>
                    <div class="block-content collapse in">
                        <div class="row-fluid">
                            <div class="progress progress-striped active" id="ajaxLoader" style="display: none">
                                <div class="progress-bar progress-bar-success" style="width:100%">
                                </div>
                            </div>
                            <form id="addFeedsMainForm" class="form-horizontal" novalidate="novalidate" _lpchecked="1">
                                <div class="control-group">
                                    <label class="control-label">Feed Title</label>
                                    <div class="controls">
                                        <input id="feed_title" required="" type="text" name="feed_title" class="form-control input-xxlarge" placeholder="Feed Title Here">
                                        <label style="display: none" id="feed_title_error" class="error" for="feed_title">Please a feed title</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Feed Url</label>
                                    <div class="controls">
                                        <input id="feed_url" required="" type="url" name="feed_url" class="form-control input-xxlarge" placeholder="Enter valid feed url">
                                        <label style="display: none" id="feed_url_error" class="error" for="feed_url">Please enter a valid feed url</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Feed Category</label>
                                    <div class="controls">
                                        <?php
                                        echo '<select required="" id="feed_category" class="form-control category_parent input-xlarge" name="feed_category">';
                                        echo '<option value="" >None</option>';
                                        $parent_cat = getHierarchicalCategories(0, 0);
                                        if (!empty($parent_cat)) {
                                            foreach ($parent_cat as $key => $value) {
                                                echo '<option value="' . $key . '">' . $value . '</option>';
                                            }
                                        }
                                        echo '</select>';
                                        ?>
                                        <label style="display: none" id="feed_category_error" class="error" for="feed_category">Please select category</label>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Select language</label>
                                    <div class="controls">
                                        <select id="language" class="form-control input-xlarge" name="language">
                                            <option value="1">English</option>
                                            <option value="2">Spanish</option>                                                   
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="file_upload">Upload Favicon</label>
                                    <div class="controls">
                                        <div id="fileuploader">Upload</div>
                                    </div>
                                    <img id="imgprvw" alt=""/>
                                </div>
                                <div class="control-group">
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <div id="feedFavicon"></div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label">Feed Type</label>
                                    <div class="controls">
                                        <select id="feed_type" class="form-control input-xlarge" name="feed_type">
                                            <option value="video">Videos</option>
                                            <option value="picture">Pictures</option>
                                            <option value="news">News</option>
                                            <option value="other">Other</option>                                                   
                                        </select>
                                    </div>
                                </div>


                                <div style="float:right">
                                    <input type="button" class="btn btn-primary button-finish" id="addfeed" name="check" value="Add Feed">
                                </div>
                            </form>


                            <!-- /row-fluid --></div>
                        <!-- /block content --></div>
                    <!-- block closed --></div>
            </div>
        </div>
    </div>
</div>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>-->

<!--   jQuery("#addFeedsMainForm").validate({
            rules: {
                feed_title: {required: true},
                feed_url: {required: true},
                feed_category: {required: true},
                feed_type: {required: true}
            },
            messages: {
                feed_title: {
                    required: "Please a feed title"
                },
                feed_url: {
                    required: "Please enter a valid feed url"
                },
                feed_type: {
                    required: "Please select feed type"
                },
                feed_category: {
                    required: "Please select category"
                }
            },
            submitHandler: function () {
                addFeeds();
            }
        });-->
<script>
    jQuery(document).ready(function () {
        jQuery("body").on('click', "#addfeed", function () {
            jQuery("#messages").html(' ');
            var category = jQuery("#feed_category").val();
            var feed_title = jQuery("#feed_title").val();
            var url = jQuery("#feed_url").val();
            var feed_type = jQuery("#feed_type").val();
            var _icon = jQuery("#feed_favicon_icon").val();
            if (category === '' || category === 0) {
                jQuery("#feed_category_error").css('display', 'block');
            } else if (feed_title === '' || feed_title === undefined) {
                jQuery("#feed_title_error").css('display', 'block');
            } else if (url === '') {
                jQuery("#feed_url_error").css('display', 'block');

            } else {
                jQuery("#ajaxLoader").css('display', 'block');
                jQuery("#messages").html(' ');
                jQuery("#ajaxLoader").css('display', 'block');
                jQuery("#addfeed").attr('disabled', true);
                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '<?php echo site_url('feeds/add'); ?>',
                    data: {feed_title: feed_title, favicon_icon: _icon, feed_url: url, category: category, feed_type: feed_type},
                    async: false,
                    success: function (result) {
                        jQuery("#addfeed").attr('disabled', false);
                        console.log(result);
//                alert(result.msg);
                        jQuery("#messages").append(result.msg);
                        jQuery("#ajaxLoader").css('display', 'none');
                        //location.reload(true);
                    }
                });
            }

        });
    });

</script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/jquery.uploadfile.js"></script>
<script>
    jQuery(document).ready(function ()
    {
        jQuery("#fileuploader").uploadFile({
            url: "<?php echo site_url('feeds/do_upload'); ?>/myfile",
            fileName: "myfile"
        });

    });
</script>