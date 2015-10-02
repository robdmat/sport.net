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
    </div>
</div>


<div class="items container clear_fix">
    <ul class="clear_fix thumbnails-list items_grid" id="feed_content" style="position: relative;">
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
                $imageUrl = $feed->feed_image_url;
                if (!empty($avatar)):
                    $favicon = site_url() . 'uploads/feed/' . $avatar;
                elseif (!empty($imageUrl) || $imageUrl != ''):
                    $favicon = $imageUrl;
                else:
                    $favicon = site_url('assets/img/avatar.jpg');
                endif;
                ?>
                <li>
                    <div class="item videos clear_fix">
                        <div class="img fl_left">
                            <a href="<?php echo site_url() . 'feeds/preview/' . $feed->feed_content_hash ?>">
                                <?php
                                if (file_exists($feed_image)) {
                                    echo $feed_image;
                                } else {
                                    echo $default_image;
                                }
                                ?>
                            </a>
                        </div>
                        <div class="info">
                            <div class="name">
                                <a href="<?php echo site_url() . 'feeds/preview/' . $feed->feed_content_hash ?>"><?php echo isset($feed->feed_title) ? $feed->feed_title : 'title' ?></a>
                            </div>
                            <div class="text">
                                <?php echo strip_tags(substr($html, 0, 800)); ?>
                            </div>
                            <div class="bottom table clear_fix">
                                <div class="author clear_fix">
                                    <div class="author_img fl_left">
                                        <a href="#">
                                            <img alt="Ashley Clements" src="<?php echo site_url(); ?>/assets/img/avatar.jpg">
                                        </a>
                                    </div>
                                    <div>
                                        <div class="author_name">
                                            <a href="#"><?php echo $feed_title; ?></a>
                                        </div>
                                        <div class="date"><?php echo nicetime($date); ?></div>
                                    </div>
                                </div>
                                <div class="icon">
                                    <a href="#"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <!--                <li>
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
                                            <div class="description textStyle">
                <?php echo strip_tags(substr($html, 0, 800)); ?>
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
                                    </div>
                                </li>-->
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
<div id="shareMeDIv">
    <script type="text/javascript">var switchTo5x = true;</script>
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "d661bce1-3df6-41f2-a167-27cb74203fc1", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    <script>
        function getShareDiv(id) {
            jQuery("#slideToggleParent_" + id).slideToggle();
        }
    </script>
</div>
<script type="text/javascript">
    jQuery("#nextPage").val(2);
    jQuery('body').on('click', '#loadMore', function (e) {
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
        var shareScript = jQuery("#shareMeDIv").html();
        jQuery.ajax({
            url: '<?php echo site_url('news/next'); ?>',
            type: 'POST',
            dataType: 'html',
            data: {'page': page, ulclass: sendUlClassItemsGrid},
            success: function (response) {
                if (response) {
                    jQuery("#loadMore").css('pointer-events', 'all');
                    jQuery("#shareMeDIv").html(' ');
                    jQuery("#shareMeDIv").html(shareScript);
                    var next = 1;
                    var add = parseInt(page) + parseInt(next);
                    var jsonData = response;
                    jQuery("#loadMore").text('Load More');
                    $theCntr = $("ul#feed_content");
//                    $theCntr.append(jsonData).masonry('reload');
                    $theCntr.append(jsonData);
                    jQuery("#nextPage").val(add);
                } else {
                    jQuery("#loadMore").text('No More Feeds');
                }
            },
            error: function (errorThrown) {
                jQuery("#loadMore").css('pointer-events', 'all');
                jQuery("#loadMore").text('No More Feeds');
            }
        });
    });</script>


<!--<script>
    $('ul#main_content').infinitescroll({
        debug: false,
        nextSelector: "div.navigation .alignleft a",
        loadingImg: "<?php echo site_url('assets/img/ajax_loader.gif') ?>",
        loadingText: "!!........!!",
        donetext: "<em>!!........................!!</em>",
        navSelector: "div.navigation",
        contentSelector: "#main_content",
        dataType: 'dimp',
        appendCallback: false // USE FOR PREPENDING
    }, function (response) {
        var jsonData = response;
        jQuery("#nothing_found").html(' ');
        $theCntr = $("ul#main_content");
        $theCntr.append(jsonData).masonry('reload');
        jQuery("#appendjs").html(' ');
        jQuery("#nothing_found").html(' ');
        jQuery("#appendjs").html('<script src="<?php echo site_url('assets/js/frontend_js/infinite_scroll/scripts.js') ?>"><\/script>');
    });
</script>
<div id="appendjs"><script src="<?php echo site_url('assets/js/frontend_js/infinite_scroll/scripts.js') ?>"></script></div>-->

<!--<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '446400522196773',
            xfbml: true,
            version: 'v2.3'
        });
    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>-->
<script>
    $('#googleplus').click(function (e) {
        var data = {google_request: 'true'};
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('google') ?>",
            data: data,
            success: function (result) {
                window.location.href = result.url;
            }
        });
    });
    function getShareDiv(id) {
        jQuery("#slideToggleParent_" + id).slideToggle();
    }

</script>


<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function () {
        FB.init({
            appId: '446400522196773', // App ID
            channelURL: 'http://testingsports.thinkigaming.com', // Channel File
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            oauth: true, // enable OAuth 2.0
            xfbml: true  // parse XFBML
        });

        //
        // All your canvas and getLogin stuff here
        //
    };
    //Onclick for fb login
    $('#facebook').click(function () {
        jQuery("#appendmsg").html(' ');
        FB.getLoginStatus(function (response) {
            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token 
                // and signed request each expire
                var uid = response.authResponse.userID;
                var accessToken = response.authResponse.accessToken;
                jQuery("#appendmsg").append('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>You are already connected</div>')
                FB.logout(function (response) {
                });
            } else if (response.status === 'not_authorized') {
                FB.login(function (response) {
                    console.log(response);
                    if (response.authResponse) {
                        parent.location = "<?php echo site_url('facbook/login'); ?>"; //redirect uri after closing the facebook popup
                    }
                }, {scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos,user_education_history'}); //permissions for facebook

            } else {
                FB.login(function (response) {
                    console.log(response);
                    if (response.authResponse) {
                        parent.location = "<?php echo site_url('facbook/login'); ?>"; //redirect uri after closing the facebook popup
                    }
                }, {scope: 'email,user_birthday,user_location,user_work_history,user_hometown,user_photos,read_mailbox,user_education_history'}); //permissions for facebook

            }
        });


    });

    // Load the SDK Asynchronously
    (function (d) {
        var js, id = 'facebook-jssdk';
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        d.getElementsByTagName('head')[0].appendChild(js);
    }(document));
</script>
<!--<script id="facebook-jssdk" src="//connect.facebook.net/en_US/all.js" type="text/javascript"></script>-->