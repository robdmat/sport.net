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
    <ul class="clear_fix items_list" id="main_content" style="position: relative;">
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
                $feed_title_title = isset($feed->feed_image_title) ? $feed->feed_image_title : '';
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
                        <div class="img">
                            <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>">
                                <?php echo $feed_image; ?>
                            </a>
                        </div>
                        <div class="name">
                            <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>"><?php echo isset($feed->feed_title) ? $feed->feed_title : 'title' ?></a>
                        </div>
                        <div class="bottom table clear_fix">
                            <div class="author clear_fix">
                                <div class="author_img fl_left">
                                    <a href="<?php echo isset($feed->feed_url) ? $feed->feed_url : 'javascript:void(0)' ?>">
                                        <img class="avatar_class" src="<?php echo $favicon; ?>" alt="<?php isset($feed->feed_image_title) ? $feed->feed_image_title : '' ?>">
                                    </a>
                                </div> 
                                <div>
                                    <div class="author_name">
                                        <a href="#"><?php echo $feed_title; ?></a>
                                    </div>
                                    <div class="date"><?php echo time_elapsed_string($date); ?></div>
                                </div>
                            </div>
                            <div class="main_content_share_button" style="">
                                <script type="text/javascript">var switchTo5x = true;</script>
                                <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                                <script type="text/javascript">stLight.options({publisher: "d661bce1-3df6-41f2-a167-27cb74203fc1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
                                <div id="slideToggleParent_<?php echo $feed->id; ?>" class="main_content_share" style="display: none">
                                    <span class='st_facebook_large' displayText='Facebook'></span>
                                    <span class='st_twitter_large' displayText='Tweet'></span>
                                    <span class='st_email_large' displayText='Email'></span>
                                    <span class='st_plusone_large' displayText='Google +1'></span>
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
            ?>
        </ul>
        <div class="load_more text_center">
            <a href="javascript: void(0);">Load More</a>
        </div>
        <div class="navigation">
            <div class="alignleft">  
                <a href="<?php echo site_url(); ?>home/next/2"></a>
            </div>
            <div class="alignright"></div>
        </div>
        <?php
    else:
        echo 'No results found';
        echo getOopsImage();
    endif;
    ?>
</div>
<script>
    function getShareDiv(id) {
        jQuery("#slideToggleParent_" + id).slideToggle();
    }
    < script >