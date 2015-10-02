<div class="container-fluid">
    <div class="row-fluid">
        <?php echo $admin_sidebar; ?>
        <div class="span9" id="content">
            <div class="row-fluid">
                <?php echo $this->session->flashdata('info'); ?>
                <div class="row-fluid section">
                    <!-- block -->
                    <div class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">
                                <?php echo 'All Pages'; ?>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <?php if (!empty($pages)) { ?>
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Slug</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 1;
                                        foreach ($pages as $item) {
                                            echo '<tr>
                                                <td>' . $count . '</td>
                                                <td><a target="_blank" href="' . site_url($item->slug) . '">' . $item->title . '</a></td>
                                                <td>' . date('d-M-y', strtotime($item->date)) . '</td><td>' . $item->slug . '</td>
                                                <td><a class="btn" href="' . site_url('admin/edit_page/' . $item->id) . '"><i class="fa fa-pencil-square-o"></i></a></td>
                                                <td><a class="btn btn-primary" onclick="javascript:deletePopup(\'' . $item->id . '\', \'' . site_url('admin/pagedelete') . '\');"><i class="fa fa-trash-o"></i></a></td>';
                                            echo'</tr>';
                                            $count++;
                                        }
                                        ?>
                                    </tbody>  
                                </table>
                            <?php } else { ?>
                                <div class="alert alert-info">
                                    No item founds.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /container --></div>


<!-- delete modal -->
<div id="del_model" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Delete Page</h3>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to delete?</p>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" class="btn" data-dismiss="modal">Close</a>
        <a href="javascript:void(0)" id="del" class="btn btn-primary">Delete</a>
    </div>
</div>