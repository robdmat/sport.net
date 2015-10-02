<?php
$uri = $this->uri->segment(1);
if ($uri == 'favorites') {
    $favorites_active = 'active';
    $title = 'Favorites';
} else {
    $favorites_active = '';
}
if ($uri == 'collection') {
    $collections_active = 'active';
    $title = 'Collections';
} else {
    $collections_active = '';
}
?>
<div class="row-fluid item_nav">
    <div class="span12">
        <h2 class="title offset2 span8"><?php echo $title; ?></h2> 
    </div>
</div>
<div class="span12">
    <ul class="nav nav-pills offset2 span8">
        <li class="<?php echo $favorites_active; ?>"><a href="/favorites">Your Favorites</a></li>
        <li class="<?php echo $collections_active; ?>"><a href="/collection">Your Collections</a></li>
    </ul>
</div>


<?php
$user_id = get_current_user_id();
$collections = get_all_my_collections($user_id);
?>


<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span8">
                <?php
                if ($this->session->flashdata('collection_message')) {
                    $msg = $this->session->flashdata('collection_message');
                    echo '<div class="wd_100 text_center">' . $msg . '</div>';
                }
            
                foreach ($collections as $collection) {
                    $collection_id = $collection['id'];
                    $count = get_all_my_collections_count($user_id, $collection_id);
                    ?>

                    <div class="span12 collection_container">
                        <div class="span4 this_left">
                            <a href="<?php echo site_url(); ?>collection/edit/<?php echo base64_encode($collection_id); ?>">
                                <img width="260" height="140" src="//dmypbau5frl9g.cloudfront.net/assets/default-collection-216171d6e1e7d0b0f38832c89c1ad7b5.jpg" alt="<?php echo $collection['title']; ?>">
                            </a>  
                        </div>
                        <div class="span4 this_left">
                            <div class="collection_center">
                                <h3 class="collection_title">
                                    <a title="<?php echo $collection['title']; ?>" href="<?php echo site_url(); ?>collection/edit/<?php echo base64_encode($collection_id); ?>"><?php echo $collection['title']; ?></a>
                                </h3>
                            </div>
                        </div>
                        <div class="span4 this_left">
                            <div class="collection-summary__meta">
                                <strong><?php echo $count . '&nbspItems' ?> </strong>
                                <br>
                                <br>
                                <br>
                                <br>
                                <ul class="collection_buttons_action">
                                    <li>
                                        <a onclick="javascript:lounchShareModel('<?php echo $collection['title'] ?>',<?php echo $collection_id ?>);" title="Share" class="btn collection_buttons_action_li_class" href="javascript:void(0);">
                                            <span class="collection_icon_share"> <i class="fa fa-share-alt"></i></span>
                                        </a>  
                                    </li>
                                    <li>
                                        <a onclick="javascript:lounchDeleteModel(<?php echo $collection_id ?>);" title="Delete" class="btn collection_buttons_action_li_class" href="javascript:void(0);">
                                            <span class="collection_icon_delete"><i class="fa fa-trash-o"></i></span>
                                        </a>     
                                    </li>
                                    <li>
                                        <a title="Edit" onclick="javascript:lounchConfigurationModel('<?php echo $collection['title'] ?>',<?php echo $collection_id ?>);" class="btn collection_buttons_action_li_class" href="javascript:void(0);">
                                            <span class="collection_icon_configuration"><i class="fa fa-cog"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="span4">
                <div class="sidebar-s sidebar-right">
                    <div class="spacebox">
                        <a href="javascript:void(0);" class="btn collection_buttons_action_li_class" onclick="javascript:newCollection();" title="Edit">
                            <span class="collection_icon_configuration"> New Collection</span>
                        </a>
                    </div>

                    <div class="box--topbar">
                        <h2>What are Collections?</h2>
                    </div>
                    <div class="box--hard-top">
                        <div class="new-typography">
                            <p>Collections are groups of items compiled by different users on a theme.</p>
                            <p>They can be set to Private for personal use, or Public so that they appear on this page and on a user's homepage.</p>
                        </div>
                    </div>

                    <div class="box--topbar">
                        <h2>Search Collections</h2>
                    </div>
                    <div class="box--hard-top">
                        <form method="get" class="search-field" action="/old_search" accept-charset="UTF-8"><div style="margin:0;padding:0;display:inline"><input type="hidden" value="✓" name="utf8"></div>  <input type="text" value="" placeholder="Search Collections" name="term" id="term">

                            <input type="hidden" value="collections" name="type">


                            <button type="submit"><span class="glyph__alt">Search</span></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--<--configuration_model-->
<button class="btn btn-primary btn-lg" style="display: none" data-toggle="modal" data-target="#configuration_model" id="configuration_model_button"></button>
<div class="modal hide fade minus_zindex_configuration" id="configuration_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="new_collection_form" enctype="multipart/form-data" action="/collection/update_collection" accept-charset="UTF-8">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only"></span></button>
                    <h4 id="myModalLabel" class="modal-title">Update your Collection</h4>
                </div>
                <div class="modal-body">
                    <div class="collection-form">
                        <input type="hidden" name="collection_id" id="collection_id" >
                        <div class="wd_100 mrtp_5">
                            <label for="collection_form_name" class="string required"><strong>Collection name</strong> <abbr title="required">*</abbr></label>
                            <input type="text" required="" size="100" placeholder="Enter name" name="bookmark_name" id="bookmark_form_name" class="wd_70">
                        </div>

                        <div class="wd_100 mrtp_5">
                            <label for="collection_form_description" class="text optional"><strong>Add a description</strong>></label>
                            <textarea style="width: 70%; height: 150px" required="" rows="20" placeholder="HTML is enabled" name="collection_description" id="collection_form_description" cols="40" class="text optional js-collection-input"></textarea>
                        </div>

                        <div class="collection-form">
                            <div class="wd_100 mrtp_5">
                                <span class="wd_25 this_left">
                                    <input type="radio" name="visibility" value="private" class="radio_button_collection" checked="checked">
                                    <label class="radio_button_collection_label">Keep it private</label>
                                </span>
                                <span class="wd_25 this_left">
                                    <input type="radio" name="visibility" value="public" class="radio_button_collection">
                                    <label class="radio_button_collection_label">Make it public</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button type="submit" name="button"  class="btn btn--primary js-collection-form-submit">Update Collection</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--<--Delete Model-->


<!--<--configuration_model-->
<button style="display: none" data-toggle="modal" data-target="#delete_collection" id="delete_collection_button"></button>
<div class="modal hide fade minus_zindexdelete" id="delete_collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="new_collection_form" enctype="multipart/form-data" action="/collection/delete_collection" accept-charset="UTF-8">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only"></span></button>
                            <h4 id="myModalLabel" class="modal-title">Delete the Collection</h4>
                        </div>
                        <input type="hidden" name="collection_id_delete" id="collection_id_delete" >
                        <div class="modal-body">
                            Are you sure you want to delete the collection;
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                            <button type="submit" name="button" class="btn btn--primary">Delete Collection</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div>
            </form>
        </div>
    </div>
</div>


<!--<--Share Model-->


<!--<--share_model-->
<button style="display: none" data-toggle="modal" data-target="#share_collection" id="share_collection_button"></button>
<div class="modal hide fade minus_zindexshare" id="share_collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content_my">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only"></span></button>
                    <h4 id="myModalLabelShare">Share this Collection</h4>
                    <h5 id="mycollectionsharename">My Collection</h5>
                </div>
                <input type="hidden" name="mycollectionshareid" id="mycollectionshareid" >
                <div class="modal-body" id="sharecollectionbody">
                    <div class="" id="shared_div" style="display: none">
                        <div class="collection-form__share-link">
                            <label>Copy and paste this link to share</label>
                            <input id="share_link_value" class="wd_70 this_left" type="text" onclick="this.select();" readonly="readonly" value="">
                        </div>
                        <small class="wd_70 this_left">If you revoke this share link, anyone you have previously shared your collection with will no longer be able to see it.</small>
                    </div>

                    <div id="revoke_div">
                        <p>If you'd like to share your Collection <strong id="collection_name_gen">My Collection</strong> privately, with friends, colleagues or clients, you can generate a share link here. </p>
                    </div>

                </div>
                <div class="modal-footer wd_90 this_left">
                    <div class="wd_48 this_left">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>
                    <div id="share_buttons" class="wd_48 this_left">
                        <button type="submit" name="button" id="sharelinkgenerate" class="btn btn--primary" onclick="javascript:generateShareLink();">Generate share link</button>
                    </div>
                </div><!-- /.modal-content -->
            </div>
        </div>
    </div>
</div>







<!--<--New Collection-->
<button class="btn btn-primary btn-lg" style="display: none" data-toggle="modal" data-target="#new_collection" id="new_collection_button"></button>
<div class="modal hide fade" id="new_collection" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="new_collection_form" enctype="multipart/form-data" action="/collection/new_collection" accept-charset="UTF-8">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only"></span></button>
                    <h4 id="myModalLabel" class="modal-title">Update your Collection</h4>
                </div>
                <div class="modal-body">
                    <div class="collection-form">
                        <input type="hidden" name="collection_id" id="collection_id" >
                        <div class="wd_100 mrtp_5">
                            <label for="collection_form_name" class="string required"><strong>Collection name</strong> <abbr title="required">*</abbr></label>
                            <input type="text" required="" size="100" placeholder="Enter name" name="collection_name" id="bookmark_form_name" class="wd_70">
                        </div>

                        <div class="wd_100 mrtp_5">
                            <label for="collection_description" class="text optional"><strong>Add a description</strong>></label>
                            <textarea style="width: 70%; height: 150px" required="" rows="20" placeholder="Enter Discription" name="collection_description" id="collection_form_description" cols="40" class="text optional js-collection-input"></textarea>
                        </div>

                        <div class="collection-form">
                            <div class="wd_100 mrtp_5">
                                <span class="wd_25 this_left">
                                    <input type="radio" name="visibility" value="private" class="radio_button_collection" checked="checked">
                                    <label class="radio_button_collection_label">Keep it private</label>
                                </span>
                                <span class="wd_25 this_left">
                                    <input type="radio" name="visibility" value="public" class="radio_button_collection">
                                    <label class="radio_button_collection_label">Make it public</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    <button type="submit" name="button"  class="btn btn--primary js-collection-form-submit">Create Collection</button>
                </div>
            </form>
        </div>
    </div>
</div>