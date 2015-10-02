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
                                <?php echo 'Add Page :' ?>
                            </div>  
                        </div>
                        <div class="block-content collapse in">
                            <form class="page" method="post" action="<?php site_url('admin/addpage'); ?>">
                                <div class="control-group">
                                    <input type="text" class="title input-xxlarge <?php echo form_error('title') ? 'is_error' : ''; ?>" name='title' placeholder="<?php echo $this->lang->line('page_title'); ?>" onkeydown="javascript:removeError(this);" id="title_value" onkeyup="javascript:insertSlug('<?php echo site_url('admin/checkslug'); ?>', this.value);"/>  
                                    <?php echo form_error('title', '<div class="error">', '</div>'); ?>
                                </div>
                                <div class="control-group">
                                    <div class="permalink hidden">
                                        <div class="pull-left"><strong>Permalink : </strong><?php echo site_url(); ?></div>
                                        <div id="slugText"></div><input name="slug" class="hidden"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <textarea id="ckeditor_full" name='content'></textarea>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" class="btn btn-success btn-large" value="Add"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- block closed --></div>
                </div>
            </div>
        </div>
    </div>   
</div>  
<script>
    $(function () {
        $('textarea#ckeditor_full').ckeditor({width: '99%', height: '300px', toolbar: [
                {name: 'clipboard', groups: ['clipboard', 'undo'], items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'editing', groups: ['find', 'selection', 'spellchecker'], items: ['Scayt']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']},
                {name: 'tools', items: ['Maximize']},
                {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source']},
                {name: 'others', items: ['-']},
                '/',
                {name: 'basicstyles', groups: ['basicstyles', 'cleanup'], items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']},
                {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
                {name: 'styles', items: ['Styles', 'Format']}
            ]});
    });
</script>