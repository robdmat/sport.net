<script type="text/javascript">
    $(function () {
        $('.options li a').on('click', function (e) {
            e.preventDefault();

            if ($(this).hasClass('active')) {
                // do nothing if the clicked link is already active
                return;
            }

            $('.options li a').removeClass('active');
            $(this).addClass('active');

            var clickid = $(this).attr('id');


            $('#feed_content').fadeOut(240, function () {
                if (clickid == 'thumbnails-list') {
                    $('li .item .rightSide .description').css('display', 'block');
                    $('li.sponserList').css('display', 'none');
                    $(this).addClass('items_grid');
                    $(this).removeClass('items_list');
                } else {
                    $('li .item .rightSide .description').css('display', 'none');
                    $('li.sponserList').css('display', 'block');
                    $(this).addClass('items_list');
                    $(this).removeClass('items_grid');
                }

                $('#feed_content').fadeIn(200);
            });
        });
    });
</script>
<div class="control_panel">
    <div class="container clear_fix">
        <div class="controls fl_left">
            <ul class="clear_fix options">
                <li>
                    <a id="details-list" class="sorticon grid_view active" href="javascript: void(0);"></a>
                </li>
                <li>
                    <a class="filter sorticon filter_1" id="thumbnails-list" href="javascript: void(0);">
                        <span class="arrow down_arrow"></span>
                    </a>
                </li>
                <li>
                    <a class="filter filter_2" href="javascript: void(0);">
                        <span class="arrow down_arrow"></span>
                    </a>
                </li>
            </ul>
        </div>

        <?php
        $r = getParentCategories($category_id, 0);
        $r = array_reverse($r);
        if (!empty($r)):
            echo '<div class="breadcrumb" style="color:#F5F5F5; float:left; margin-top:10px;  text-indent: -99999px;">';
            foreach ($r as $key => $value):
                echo $value;
            endforeach;
            echo '</div>';
        endif;
        ?>

    </div>
</div>





<div class="items container clear_fix">
    <ul class="clear_fix items_list" id="feed_content" style="position: relative;">
        <?php
        $default_image = getDefaultImage();
        $count = 1;
        if (!empty($feeds_list)):
            foreach ($feeds_list as $feed):
                $html = $feed->feed_content;
                preg_match_all('/<img[^>]+>/i', $html, $result);
                $feed_image = $result;
                $date = isset($feed->feed_date) ? $feed->feed_date : date('Y-m-d');
                $feed_image = isset($feed_image[0][0]) ? $feed_image[0][0] : $default_image;
                $feed_title_title = isset($feed->feed_user_title) ? $feed->feed_user_title : '';
                $feed_title = substr($feed_title_title, 0, 40);
                $avatar = feedIconByUrl($feed->feed_admin_url);
                if (!empty($avatar)):
                    $favicon = site_url() . 'uploads/feed/' . $avatar;
                else:
                    $favicon = site_url('assets/img/avatar.jpg');
                endif;
                if ($count == 4):
                    ?>
                    <li class="sponserList">
                        <div class="item sponsor">
                            <div class="img">
                                <a href="javascript:void(0)">
                                    <?php echo sidebarAd(); ?>
                                </a>
                            </div>
                            <div class="ads text_center">
                                <a href="#">SPONSOR ADS</a>
                            </div>
                        </div>
                    </li>
                    <?php
                endif;
                ?> 
                <?php if ($count == 13):
                    ?>
                    <li class="sponserList">
                        <div class="small_height">
                            <div class="item">
                                <div class="img_class">
                                    <a href="javascript:void(0)">
                                        <?php echo pageinsideAd(); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="small_height">
                            <div class="item">
                                <div class="img_class">
                                    <a href="javascript:void(0)">
                                        <?php echo pageinsideTwo(); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                endif;
                ?>  
                <li>
                    <div class="item">
                        <div class="img getImage">
                            <a href="<?php echo site_url() . 'feeds/preview/' . $feed->feed_content_hash ?>">
                                <?php echo $feed_image; ?>
                            </a>
                        </div>
                        <div class="rightSide">
                            <div class="name">
                                <a href="<?php echo site_url() . 'feeds/preview/' . $feed->feed_content_hash ?>"><?php echo isset($feed->feed_title) ? $feed->feed_title : 'title' ?></a>
                            </div>
                            <div class="description textStyle" style="display: none">
                                <?php echo strip_tags(substr($html, 0, 800)); ?>
                            </div>
                        </div>
                        <div class="bottom table clear_fix wd100_wd">
                            <div class="author clear_fix wd80_wd">
                                <div class="author_img fl_left">
                                    <a href="<?php echo site_url() . 'feeds/preview/' . $feed->feed_content_hash ?>">
                                        <img class="avatar_class" src="<?php echo $favicon; ?>" alt="<?php isset($feed->feed_image_title) ? $feed->feed_image_title : '' ?>">
                                    </a>
                                </div> 
                                <div>
                                    <div class="author_name">
                                        <a href="#"><?php echo $feed_title; ?></a>
                                    </div>
                                    <div class="date"><?php echo nicetime($date); ?></div>
                                </div>
                            </div>
                            <div class="main_content_share_button wd20_wd" style="">
                                <div id="slideToggleParent_<?php echo $feed->id; ?>" class="main_content_share" style="display: none">
                                    <span class="st_facebook_large" displayText="Facebook"></span>
                                    <span class="st_twitter_large" displayText="Tweet"></span>
                                    <span class="st_email_large" displayText="Email"></span>
                                    <span class="st_plusone_large" displayText="Google +1"></span>
                                </div>
                                <div id="slideToggle_<?php echo $feed->id; ?>" onclick="javascript:getShareDiv(<?php echo $feed->id ?>)" class="icon slideToggle">
                                    <a href="javascript:void(0)"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
                $count++;
            endforeach;
        else:
            ?>
            <li>
                <div class="item sponsor">
                    <div class="img">
                        <a href="javascript:void(0)">
                            <img src="<?php echo site_url('/assets/img/oops_image.png'); ?>" alt="No Feeds Found">
                        </a>
                    </div>
                    <div class="ads text_center">
                        <a href="javascript:void(0)">No feeds found.!</a>
                    </div>
                </div>
            </li>
        <?php endif;
        ?>
    </ul>
    <?php if (!empty($feeds_list)): ?>
        <div class="load_more text_center">
            <a id="loadMore" href="javascript: void(0);">Load More</a>
        </div>
        <?php
    endif;
    $category = isset($category_ids) ? $category_ids : '';
    if ($category == ''):
        $segment = ($this->uri->segment(1)) ? $this->uri->segment(1) : '';
        if (!empty($segment)):
            $categoryIdThis = getCategoryIdBySlug($segment);
        endif;
    else:
        $categoryIdThis = $category_id;
    endif;
    ?>
    <div class="paginationIndexWrapper" id="paginationIndexWrapper">
        <input type="hidden" id="nextPage" value="1" />
        <input type="hidden" id="categorySlugId" value="<?php echo $category_id; ?>" />
    </div>

</div>
<div id="shareJsId">
    <script type='text/javascript'>var switchTo5x = true;</script>
    <script type='text/javascript' src='http://w.sharethis.com/button/buttons.js'></script>
    <script type='text/javascript'>stLight.options({publisher: "d661bce1-3df6-41f2-a167-27cb74203fc1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</div>
<script type="text/javascript">
    jQuery("#nextPage").val(2);
    jQuery('body').on('click', '#loadMore', function () {

        //ul class
        var sendUlClassItemsGrid = '';
        var ulClass = jQuery("#feed_content").hasClass('items_grid');
        if (ulClass) {
            sendUlClassItemsGrid = 'true';
        } else {
            sendUlClassItemsGrid = 'false';
        }

        jQuery(this).css('pointer-events', 'none');
        jQuery(this).text('Loading...');
        var page = jQuery("#nextPage").val();
        var categorySlugId = jQuery("#categorySlugId").val();
        jQuery.ajax({
            url: '<?php echo site_url('category/loadMore'); ?>',
            type: 'POST',
            dataType: 'html',
            data: {'page': page, category_id: categorySlugId, ulclass: sendUlClassItemsGrid},
            success: function (response) {
                if (response) {
                    jQuery("#loadMore").css('pointer-events', 'all');
                    jQuery("#appendjs").html(' ');
                    var next = 1;
                    var add = parseInt(page) + parseInt(next);
                    var jsonData = response;
                    jQuery("#loadMore").text('Load More');
                    $theCntr = $("ul#feed_content");
//                    $theCntr.append(jsonData).masonry('reload');
                    $theCntr.append(jsonData);
                    jQuery("#nextPage").val(add);
                    jQuery("#appendjs").html('<script src="<?php echo site_url('assets/js/addjs.js') ?>"><\/script>');
                } else {
                    jQuery("#loadMore").text('No More Feeds');
                }
            },
            error: function (errorThrown) {
                jQuery("#loadMore").css('pointer-events', 'all');
                jQuery("#loadMore").text('No More Feeds');
            }
        });
    });

</script>
<div id="appendjs"><script src="<?php echo site_url('assets/js/addjs.js') ?>"></script></div>

