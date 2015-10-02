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
                            Add Category Avatar
                        </div>  
                    </div>
                    <div class="block-content collapse in">
                        <div class="row-fluid">
                            <?php echo form_open('category/edit/' . $category->id, array('class' => 'form-horizontal')); ?>
                            <div class="control-group">
                                <label class="control-label" for="category_name"><?php echo $this->lang->line('admin_cat_name'); ?></label>
                                <div class="controls">
                                    <?php
                                    echo form_input(array(
                                        'name' => 'category_name',
                                        'id' => 'category_name',
                                        'value' => $category->category_name,
                                        'class' => form_error('category_name') ? 'is_error' : '',
                                        'onkeydown' => 'javascript:removeError(this);',
                                    ));
                                    echo form_hidden('category_id', $category->id);
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
                                    $parent_cat = getHierarchicalCategories(0, 0);
                                    if (!empty($parent_cat)) {
                                        foreach ($parent_cat as $key => $value) {
                                            if ($key == $category->parent_id):
                                                $selected = "selected='selected'";
                                            else:
                                                $selected = "";
                                            endif;
                                            echo '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
                                        }
                                    }
                                    echo '</select>';
                                    ?>
                                    <?php echo form_error('category_parent', '<div class="error">', '</div>'); ?>
                                    <!--/controls--></div>
                                <!-- control group---></div>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    <a  class="btn btn-danger left_buffer" href="<?php echo base_url(); ?>category/viewall"><?php echo $this->lang->line('cancel'); ?></a>
                                    <!--/controls--></div>
                                <!-- control group---></div>
                            <?php form_close(); ?>
                            <!-- /row-fluid --></div>

                        <!-- block content--></div>
                    <!-- /block --></div>
            </div>
        </div>
    </div>
</div>

<!-- field add Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Add category fields</h3>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="field_name"><?php echo $this->lang->line('admin_field_name'); ?></label>
                <div class="controls">
                    <input id="field_name" type="text" name="field_name" placeholder="<?php echo $this->lang->line('admin_field_name'); ?>" onkeydown="javascript:removeError(this);"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="field_type"><?php echo $this->lang->line('admin_field_type'); ?></label>
                <div class="controls field_type">
                    <select id="field_type" name="field_type" onfocus="javascript:removeError(this);">
                        <option value="none"><?php echo $this->lang->line('admin_field_type'); ?></option>
                        <?php
                        foreach ($this->config->item('cat_type') as $type => $value) {
                            echo '<option value="' . $type . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $this->lang->line('close'); ?></button>
        <a class="btn btn-primary" onclick="javascript:validateField();"><?php echo $this->lang->line('add_new'); ?></a>
    </div>
</div>
<!-- This is the field delete modal -->
<div id="del_model" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3><?php echo $this->lang->line('admin_del_popup_title'); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo $this->lang->line('admin_confirm_del'); ?></p>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal"><?php echo $this->lang->line('close'); ?></a>
        <a href="#" id="del" class="btn btn-primary"><?php echo $this->lang->line('del'); ?></a>
    </div>
</div>