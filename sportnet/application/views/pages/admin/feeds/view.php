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
                                                        <th>Title</th>
                                                        <th>Category</th>
                                                        <th>Author</th>
                                                        <th>Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($feeds_list as $feed) {
                                                        ?>
                                                        <tr><td><?php echo $count; ?> </td>
                                                            <td> <?php echo strip_tags($feed->feed_title) ?></td>
                                                            <td> <?php echo getCatById($feed->feed_user_category); ?></td>
                                                            <td> <?php echo ($feed->feed_image_title) ?></td>
                                                            <td> <?php echo date('d-M-y', strtotime($feed->feed_date)); ?></td>
                                                            <?php
                                                            $count++;
                                                        }
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

<div id="del_model" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo $this->lang->line('admin_del_popup_title'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo $this->lang->line('admin_confirm_del'); ?></p>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript:void(0)" id="del" class="btn btn-primary"><?php echo $this->lang->line('del'); ?></a>
    </div>
</div>
