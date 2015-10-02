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
                            <div class="muted pull-left">Feeds </div>  
                        </div>
                        <div class="wng-scope" id="loader" style="display: none">
                            <div class="card">
                                <div class="plus">
                                </div>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="panel panel-primary" data-collapsed="0">
                                <div class="panel-heading">
                                    <div class="panel-title">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row-fluid">
                                        <?php
                                        if (!empty($feeds_list)):
                                            ?>
                                            <table id="example" class="table table-bordered table-hover dataTable" aria-describedby="example_info">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Url</th>
                                                        <th>Favicon</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($feeds_list as $feed):
                                                        $feedId = feedIdByUrl($feed->feed_admin_url);
                                                        $feed_favicon = feedIconByUrl($feed->feed_admin_url);
                                                        $concate = 'uploads/feed/';
                                                        if ($feed_favicon != ''):
                                                            $image = '<img class="categoryClass" src="' . site_url() . $concate . $feed_favicon . '"/>';
                                                        else:
                                                            $image = getCategoryDefaultImage();
                                                        endif;
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?> </td>
                                                            <td> <?php echo $feed->feed_admin_url; ?></td>
                                                            <td id="image_<?php echo $feedId; ?>"> <?php echo $image; ?></td>
                                                            <td> <a href="javascript:void(0)" 
                                                                    onclick="javascript:updateFavicon('<?php echo $feedId; ?>')">Edit</a></td>
                                                            <td><a href="javascript:void(0)" class="btn btn-primary cursor_pointer" onclick="javascript:deleteFeed('<?php echo $feed->feed_admin_url; ?>', '<?php echo base_url() . 'feeds/delete'; ?>')"><span class="icon-trash"><i class="fa fa-trash-o"></i></a></div></td>

                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info"><h3>Sorry!</h3> No Feeds In the database.</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- block content closed --></div>
                        <!-- block closed --></div>
                    <!-- section closed --></div>

                <!-- /row-fluid --></div>
            <!-- /container --></div>
    </div>
</div>

<a style="display: none" href="#editModel" role="button" class="btn" data-toggle="modal" id="confirmButton"></a>
<div style="display: none" role="dialog" id="editModel" tabindex="-1" class="bootbox modal fade in" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="bootbox-close-button close" type="button">×</button>
                <h4 class="modal-title">Update Favicon:</h4>
            </div>
            <div class="modal-body">
                <div data-example-id="horizontal-static-form-control" class="bs-example">
                    <form class="form-horizontal"  enctype="multipart/form-data" method="post" name="update_favicon" action="<?php echo site_url('feeds/updateFavicons'); ?>">
                        <input type="hidden" name="feed_id" id="feed_id" value="" />
                        <div class="control-group">
                            <label class="control-label" for="category_name">Category Image</label>
                            <div class="controls" id="appendImage">

                            </div>
                        </div>

                        <div class="control-group" id="">
                            <div id="adId"></div>
                            <label class="control-label" for="category_name">Category Image</label>
                            <div class="controls">
                                <input type="file" name="attachment" id="attachment" class="form-control" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit" id="updateButtonLink" data-bb-handler="success">Update!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function updateFavicon(id) {
        jQuery("appendImage").html(' ');
        jQuery("adId").html(' ');
        jQuery("#feed_id").val(id);
        var image = jQuery("#image_" + id).html();
        jQuery("#appendImage").html(image);
        jQuery("#confirmButton").trigger('click');
    }

//    delete the feed
    /**
     * Displays the delete popup and as the confirmation form the user 
     * whether to delete or not
     * **/
    function deleteFeed(id, url) {
        $('#del_model').modal('show');
        $('#del_model .modal-footer #del').click(function () {
            $('#del_model').modal('hide');
            $.ajax({
                url: url,
                type: 'post',
                async: true,
                data: {'id': id},
                success: function (result) {
                    window.location = window.location.href;
                    window.location.reload(true);
                }
            });
        });
    }
</script>


<div id="del_model" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Delete feed.</h3>
    </div>
    <div class="modal-body">
        <p>Delete all the posts from this feed?</p>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript:void(0)" id="del" class="btn btn-primary">Delete</a>
    </div>
</div>