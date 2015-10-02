<div id="header">
    <div class="top_block">
        <div class="wide_container">
            <div class="table clear_fix mrbottom0">
                <div class="top_menu">
                    <ul class="clear_fix">
                        <?php getPages(); ?>
                    </ul>
                </div>
                <div class="right_block text_right">
                    <div class="social inline_block">
                        <?php
                        $linksSocial = getSocials();
                        $default = 'javascript:void(0)';
                        ?>
                        <ul class="clear_fix">
                            <li class="fb"><a target="_blank" href="<?php echo isset($linksSocial->facebook) ? $linksSocial->facebook : $default; ?>"></a></li>
                            <li class="gp"><a target="_blank" href="<?php echo isset($linksSocial->googleplug) ? $linksSocial->googleplug : $default; ?>"></a></li>
                            <li class="inst"><a target="_blank" href="<?php echo isset($linksSocial->instagram) ? $linksSocial->instagram : $default; ?>"></a></li>
                            <li class="pint"><a target="_blank" href="<?php echo isset($linksSocial->pinterest) ? $linksSocial->pinterest : $default ?>"></a></li>
                            <li class="twit"><a target="_blank" href="<?php echo isset($linksSocial->twitter) ? $linksSocial->twitter : $default ?>"></a></li>
                        </ul>
                    </div>
                    <?php
                    if (!isUserLoggedIn()):
                        ?>
                        <div class="inline_block">
                            <a class="btn start_btn login_start" href="#loginModel" data-toggle="modal">LogIn</a>
                        </div>
                    <?php else: ?>
                        <div class="inline_block">
                            <a class="btn start_btn login_start" href="<?php echo site_url('user/logout'); ?>">Logout</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $segment = ($this->uri->segment(1)) ? $this->uri->segment(1) : 1;
    if ($segment != 'dashboard'):
        ?>
        <div class="bottom_block">
            <div class="wide_container">
                <div class="table">
                    <div class="left_block logo text_center">
                        <a href="<?php echo site_url(); ?>">
                            <img src="<?php echo site_url(); ?>assets/img/logo.png" alt="Sport.Net">
                        </a>
                    </div>
                    <div class="menu_btn">
                        <a id="toggle_menu" href="javascript: void(0);">
                            <span class="text">Menu</span>
                            <span class="icon"></span>
                        </a>
                    </div>
                    <!--SEARCH-->
                    <div class="search clear_fix">
                        <div class="drop_down_block">
                            <form action="<?php echo site_url('search') ?>" method="GET">
                                <input class="text_field" name="search_item" type="text">
                                <input class="search_btn" type="submit" value="">
                            </form>
                        </div>
                        <a class="toggle_search toggle fl_right" href="javascript: void(0);"></a>
                    </div>

                    <div id="main_menu" class="main_menu clear_fix">
                        <div class="drop_down_block menu_wrapper">
                            <ul>
                                <li>
                                    <a href="<?php echo site_url('news'); ?>">
                                        <span class="icon news_icon"></span>
                                        <span>News</span>
                                    </a>
                                    <div class="drop-main-menu">
                                        <div class="red-box">
                                            <strong class="title">Categories</strong>
                                            <ul>
                                                <?php
                                                echo getCategoriesForMenus(8);
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="news-box">
                                            <strong class="title">Latest News</strong>
                                            <?php
                                            $getOnlyNewsFeeds = getOnlyNewsFeeds();
                                            if (!empty($getOnlyNewsFeeds)):
                                                foreach ($getOnlyNewsFeeds as $newsContent):
                                                    $htmlNews = $newsContent->feed_content;
                                                    $hash = $newsContent->feed_content_hash;
                                                    $contentToshow = strip_tags(substr($htmlNews, 0, 60));
                                                    if (!empty($contentToshow) || $contentToshow != ''):
                                                        ?>
                                                        <a href="<?php echo site_url('news') . '/' . $hash; ?>" class="news-item">
                                                            <div class="text-holder">
                                                                <?php echo $contentToshow; ?>
                                                            </div>
                                                        </a>
                                                        <?php
                                                    endif;
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="<?php echo site_url('pictures'); ?>">
                                        <span class="icon pictures_icon"></span>
                                        <span>Pictures</span>
                                    </a>
                                    <div class="drop-main-menu">
                                        <div class="red-box">
                                            <strong class="title">Categories</strong>
                                            <ul>
                                                <?php
                                                echo getCategoriesForMenus(8);
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="news-box">
                                            <strong class="title">Latest Pictures</strong>
                                            <?php
                                            $defaultImage = getDefaultImage();
                                            $getOnlyPictureFeeds = getOnlyPictureFeeds();
                                            if (!empty($getOnlyPictureFeeds)):
                                                foreach ($getOnlyPictureFeeds as $picture):
                                                    $html = $picture->feed_content;
                                                    preg_match_all('/<img[^>]+>/i', $html, $result);
                                                    $feed_image = $result;
                                                    $feed_image = isset($feed_image[0][0]) ? $feed_image[0][0] : $defaultImage;
                                                    ?>
                                                    <a href="#" class="news-item pictureIndex">
                                                        <div class="visual">
                                                            <?php echo $feed_image; ?>" 
                                                        </div>
                                                        <div class="text-holder textHolderRight">
                                                            <?php echo strip_tags(substr($html, 0, 300)); ?>
                                                        </div>
                                                    </a>
                                                    <?php
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon video_icon"></span>
                                        <span>Video</span>
                                    </a>
                                    <div class="red-box-right">
                                        <div class="red-box">
                                            <strong class="title">Categories</strong>
                                            <ul>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                                <li><a href="#">lorem</a></li>
                                            </ul>
                                        </div>
                                        <div class="news-box">
                                            <strong class="title">Latest Videos</strong>
                                            <a href="#" class="news-item">
                                                <div class="visual">
                                                    <img src="<?php echo site_url(); ?>assets/img/img_9.jpg" alt="">
                                                </div>
                                                <div class="text-holder">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores
                                                </div>
                                            </a>
                                            <a href="#" class="news-item">
                                                <div class="visual">
                                                    <img src="<?php echo site_url(); ?>assets/img/img_9.jpg" alt="">
                                                </div>
                                                <div class="text-holder">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores
                                                </div>
                                            </a>
                                            <a href="#" class="news-item">
                                                <div class="visual">
                                                    <img src="<?php echo site_url(); ?>assets/img/img_9.jpg" alt="">
                                                </div>
                                                <div class="text-holder">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores
                                                </div>
                                            </a>
                                            <a href="#" class="news-item">
                                                <div class="visual">
                                                    <img src="<?php echo site_url(); ?>assets/img/img_9.jpg" alt="">
                                                </div>
                                                <div class="text-holder">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus asperiores
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon tv_icon"></span>
                                        <span>Live TV</span>
                                    </a>

                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon livescore_icon"></span>
                                        <span>Livescore</span>
                                    </a>

                                </li>
                                <li>
                                    <a href="#">
                                        <span class="icon statistics_icon"></span>
                                        <span>Statistics</span>
                                    </a>

                                </li>
                            </ul>
                        </div>
                        <button class="main_menu_toggle toggle fl_right">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="menu" class="category_menu" style="display: block;">
                <div class="container">
                    <ul class="clear_fix sport-nav">
                        <?php
                        echo getHeaderMenu();
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>