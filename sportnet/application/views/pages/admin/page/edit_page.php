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
                            <div class="muted pull-left" style="width: 100%">
                                <?php echo 'Update Page :' . $page->title; ?>
                            </div>  
                        </div>
                        <div class="block-content collapse in">
                            <form class="page" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                                <div class="control-group">
                                    <input type="text" class="title input-xxlarge <?php echo form_error('title') ? 'is_error' : ''; ?>" name='title' placeholder="<?php echo $this->lang->line('page_title'); ?>" value="<?php echo $page->title; ?>" onkeydown="javascript:removeError(this);" id="title_value" onkeyup="javascript:insertSlug(this.value);"/>  
                                    <?php echo form_error('title', '<div class="error">', '</div>'); ?>
                                </div>
                                <div class="control-group">
                                    <div class="permalink">
                                        <div class="pull-left"><strong> Permalink  : </strong><?php echo site_url(); ?></div>
                                        <div id="slugText"><?php echo $page->slug; ?></div>
                                        <input name="slug" class="hidden" value="<?php echo $page->slug; ?>" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <textarea id="ckeditor_full" name='content'><?php echo $page->content; ?></textarea>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <input type="submit" class="btn btn-success btn-large" value="<?php echo 'Update'; ?>"/>
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