<div class="control_panel">
    <div class="container clear_fix">
        <div class="controls fl_left">
            <ul class="clear_fix">
                <li>
                    <a class="grid_view" href="javascript: void(0);"></a>
                </li>
                <li>
                    <a class="filter filter_1" href="javascript: void(0);">
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
    </div>
</div>


<div class="items container clear_fix">
    <?php
    pri($feeds_list);
    die();
    ?>
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
                    $favicon = site_url() . $avatar;
                else:
                    $favicon = site_url('assets/img/avatar.jpg');
                endif;
                if ($count == 4):
                    ?>
                    <li>
                        <div class="item sponsor">
                            <div class="img">
                                <a href="#">
                                    <img src="<?php echo site_url('/assets/img/img_4.jpg'); ?>" alt="SPONSOR ADS">
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
                <li>
                    <div class="item">
                        <div class="img getImage">
                            <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>">
                                <?php echo $feed_image; ?>
                            </a>
                        </div>
                        <div class="name">
                            <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>"><?php echo isset($feed->feed_title) ? $feed->feed_title : 'title' ?></a>
                        </div>
                        <div class="bottom table clear_fix wd100_wd">
                            <div class="author clear_fix wd80_wd">
                                <div class="author_img fl_left">
                                    <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>">
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
    <?php endif; ?>
    <div class="paginationIndexWrapper" id="paginationIndexWrapper">
        <input type="hidden" id="nextPage" value="1" />
    </div>

</div>
<script type="text/javascript">var switchTo5x = true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d661bce1-3df6-41f2-a167-27cb74203fc1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<script type="text/javascript">
    jQuery("#nextPage").val(2);
    jQuery('body').on('click', '#loadMore', function () {
        jQuery(this).text('Loading...');
        var page = jQuery("#nextPage").val();
        jQuery.ajax({
            url: '<?php echo site_url('home/next'); ?>',
            type: 'POST',
            dataType: 'html',
            data: {'page': page},
            success: function (response) {
                if (response) {
                    jQuery("#appendjs").html(' ');
                    var next = 1;
                    var add = parseInt(page) + parseInt(next);
                    var jsonData = response;
                    jQuery("#loadMore").text('Load More');
                    $theCntr = $("ul#feed_content");
                    $theCntr.append(jsonData).masonry('reload');
                    jQuery("#nextPage").val(add);
                    jQuery("#appendjs").html('<script src="<?php echo site_url('assets/js/addjs.js') ?>"><\/script>');
                } else {
                    jQuery("#loadMore").text('No More Feeds');
                }
            }
        });
    });

</script>
<div id="appendjs"><script src="<?php echo site_url('assets/js/addjs.js') ?>"></script></div>
