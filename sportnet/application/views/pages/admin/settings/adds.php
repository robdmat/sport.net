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
                                <?php echo 'Ads Management'; ?>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                                <ul id="myTab" class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#header" id="header-tab" role="tab" data-toggle="tab" aria-controls="header" aria-expanded="true">Header</a></li>
                                    <li role="presentation" class=""><a href="#sidebar_tab" id="sidebar_tab-tab" role="tab" data-toggle="tab" aria-controls="sidebar_tab" aria-expanded="false">Sidebar</a></li>
                                    <li role="presentation" class=""><a href="#pageinside" role="tab" id="pageinside-tab" data-toggle="tab" aria-controls="pageinside" aria-expanded="false">Content Top</a></li>
                                    <li role="presentation" class=""><a href="#pageinside_two" role="tab" id="pageinside_two-tab" data-toggle="tab" aria-controls="pageinside_two" aria-expanded="false">Content Bottom</a></li>
                                </ul>
                                <div id="myTabContent" class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade active in" id="header" aria-labelledby="header-tab">
                                        <form class="page" method="post" action="<?php echo site_url('settings/ad'); ?>">
                                            <input type="hidden" value="<?php echo headerTypeAddId(); ?>" name="id" />
                                            <input type="hidden" value="header" name="add_type" />
                                            <div class="control-group">
                                                <textarea class="title input-xxlarge" cols="70" rows="10" id="ads_header" placeholder="Add your header code here" name='content'><?php echo headerAdContent(); ?></textarea>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="submit" class="btn btn-success btn-large" value="Add"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="sidebar_tab" aria-labelledby="sidebar-tab">
                                        <form class="page" method="post" action="<?php echo site_url('settings/ad'); ?>">
                                            <input type="hidden" value="<?php echo sidebarTypeAddId(); ?>" name="id" />
                                            <input type="hidden" value="sidebar" name="add_type" />
                                            <div class="control-group">
                                                <textarea class="title input-xxlarge" cols="70" rows="10" id="ads_sidebar" placeholder="Add your sidebar code here" name='content'><?php echo sidebarAdContent(); ?></textarea>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="submit" class="btn btn-success btn-large" value="Add"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="pageinside" aria-labelledby="pageinside-tab">
                                        <form class="page" method="post" action="<?php echo site_url('settings/ad'); ?>">
                                            <input type="hidden" value="<?php echo pageinsideTypeAdId(); ?>" name="id" />
                                            <input type="hidden" value="content" name="add_type" />
                                            <div class="control-group">
                                                <textarea class="title input-xxlarge" cols="70" rows="10" id="ads_header" placeholder="Content ad" name='content'><?php echo pageinsideAdContent(); ?></textarea>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="submit" class="btn btn-success btn-large" value="Add"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade" id="pageinside_two" aria-labelledby="pageinside_two-tab">
                                        <form class="page" method="post" action="<?php echo site_url('settings/ad'); ?>">
                                            <input type="hidden" value="<?php echo pageinsideTwoTypeAdId(); ?>" name="id" />
                                            <input type="hidden" value="content_two" name="add_type" />
                                            <div class="control-group">
                                                <textarea class="title input-xxlarge" cols="70" rows="10" id="ads_header" placeholder="Content ad two" name='content'><?php echo pageinsideTwoAdContent(); ?></textarea>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">
                                                    <input type="submit" class="btn btn-success btn-large" value="Add"/>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>