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
                                Category                            </div>  
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
                                        if (!empty($categories)):
                                            ?>
                                                                                                                                                            <!--<table id="category_view_table" class="table table-hover table-bordered">-->
                                            <table id="example" class="table table-bordered table-hover dataTable" aria-describedby="example_info">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Category name</th>
                                                        <th>Cat Image</th>
                                                        <th>Parent Category</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $count = 1;
                                                    foreach ($categories as $cat) :
                                                        $categoryImage = $cat->cat_image_location;
                                                        if ($categoryImage != ''):
                                                            $image = '<img class="categoryClass" src="' . site_url() . $categoryImage . '"/>';
                                                        else:
                                                            $image = getCategoryDefaultImage();
                                                        endif;
                                                        ?>
                                                        <tr><td><?php echo $count; ?> </td>
                                                            <td> <?php echo $cat->category_name ?></td>
                                                            <td> <?php echo $image; ?></td>
                                                            <td> <?php echo getCatById($cat->parent_id) ?></td>
                                                            <td><a class="btn" href="<?php echo site_url() . 'category/edit/' . $cat->id; ?>"><span class="icon-pencil"><i class="fa fa-pencil"></i></span></a></td>
                                                            <td><a  href="javascript:void(0);"
                                                                    class="btn btn-primary cursor_pointer" onclick="javascript:deletePopup(<?php echo $cat->id; ?>, '<?php echo base_url() . 'category/delete'; ?>')"><span class="icon-trash"><i class="fa fa-trash-o"></i></a></div></td>
                                                        </tr>
                                                        <?php
                                                        $count++;
                                                    endforeach;
                                                    ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <div class="alert alert-info"><h3>Sorry!</h3> No Categories found.</div>
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
