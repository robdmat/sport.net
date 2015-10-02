<div class="container-fluid">
    <div class="row-fluid">
        <?php echo $admin_sidebar; ?>
        <div class="span9" id="content">
            <div class="row-fluid section">
                <?php echo $this->session->flashdata('info'); ?>
                <!-- block -->
                <div class="block">
                    <div class="navbar navbar-inner block-header">
                        <div class="muted pull-left">
                            <?php echo $this->lang->line('admin_cat_add'); ?>
                        </div>  
                    </div>
                    <div class="block-content collapse in">
                        <div class="row-fluid">
                            <?php echo form_open('category/add/', array('enctype' => "multipart/form-data", 'class' => 'form-horizontal')); ?>
                            <div class="control-group">
                                <label class="control-label" for="category_name"><?php echo $this->lang->line('admin_cat_name'); ?></label>
                                <div class="controls">
                                    <?php
                                    echo form_input(array(
                                        'name' => 'category_name',
                                        'id' => 'category_name',
                                        'placeholder' => $this->lang->line('admin_cat_name'),
                                        'maxlength' => '100',
                                        'size' => '50',
                                        'class' => form_error('category_name') ? 'is_error' : '',
                                        'onkeydown' => 'javascript:removeError(this);',
                                        'value' => set_value('category_name')
                                    ));
                                    ?>
                                    <?php echo form_error('category_name', '<div class="error">', '</div>'); ?>
                                    <span class="help-block"><?php echo $this->lang->line('admin_cat_eg'); ?></span>
                                    <!--/controls--></div>
                                <!-- control group---></div>
                            <div class="control-group">
                                <label class="control-label" for="category_name"><?php echo $this->lang->line('admin_cat_parent'); ?></label>
                                <div class="controls">
                                    <?php
                                    echo '<select id="category_parent" class="form-control category_parent" name="category_parent">';
                                    echo '<option value="" >None</option>';
                                    $parent_cat = getHierarchicalCategories(0, 0);
                                    if (!empty($parent_cat)) {
                                        foreach ($parent_cat as $key => $value) {
                                            echo '<option value="' . $key . '">' . $value . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                    <?php echo form_error('category_parent', '<div class="error">', '</div>'); ?>
                                    <!--/controls--></div>
                                <!-- control group---></div>
                            <div class="control-group">
                                <label class="control-label" for="category_name">Category Image</label>
                                <div class="controls">
                                    <input type="file" name="attachment" id="attachment" class="form-control" />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('save'); ?></button>
                                    <!--/controls--></div>
                                <!-- control group---></div>
                            <?php form_close(); ?>

                            <!-- /row-fluid --></div>
                        <!-- /block content --></div>
                    <!-- block closed --></div>
            </div>
        </div>
    </div>
</div>