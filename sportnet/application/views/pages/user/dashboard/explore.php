<div id="content">
    <div class="banner text_center table">
        <div class="loader">Loading...</div>
        <div>
            <a href="javascript: void(0);">
                <img src="<?php echo site_url('assets') ?>/img/banner_img.png" alt="fastplaysport.com">
            </a>
        </div>
    </div>
    <div class="control_panel control_panel_avatar">
        <div class="container clear_fix">

            <div class="author_avatar clear_fix">
                <div>
                    <div class="account_name">
                        <a href="javascript: void(0);"><?php
                            $udata = $this->session->all_userdata();
                            $email = isset($udata['email']) ? $udata['email'] : '';
                            echo $email;
                            ?></a>
                    </div>
                    <div class="author_setting">
                        <a href="javascript: void(0);">Settings</a>
                    </div>
                </div>
                <div class="author_img fl_right">
                    <a href="javascript: void(0);">
                        <img src="<?php echo site_url('assets') ?>/img/avatar.jpg" alt="Ashley Clements">
                    </a>
                </div>
            </div>

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
    <div class="container">
        <div class="filtr clear_fix">
            <form accept-charset="utf-8" method="post" action="<?php echo site_url('user/session') ?>"> 
                <div class="filtr_sel clear_fix">
                    <?php
                    $cats = getSelectedCats();
                    if (!empty($cats)):
                        foreach ($cats as $category):
                            echo '<p onclick="javascript:removeMe(' . $category . ')" id="remove_id_' . $category . '">';
                            echo '<input type="hidden" value="' . $category . '" name="category_array[]" class="name_' . $category . '" id="inputId_' . $category . '">' . getCatNameByCatId($category) . '<a href="javascript:void(0)"></a></p>';
                        endforeach;
                    endif;
                    ?>
                </div>
                <p class="submit_wrapper fl_right clear_fix">
                    <input class="submit-3 inline_block" type="submit" value="SUBMIT" name="commit">
                    <span class="sub_btn"></span>
                </p>
            </form>
        </div>
    </div>

    <div class="container">
        <ul class="avatar">
            <?php
            if (!empty($categories)):
                foreach ($categories as $category):
                    $categoryImage = $category->cat_image_location;
                    if ($categoryImage != ''):
                        $image = '<img alt="' . $category->category_name . '" class="categoryClass" src="' . site_url() . $categoryImage . '"/>';
                    else:
                        $image = getCategoryDefaultImage();
                    endif;
                    $listNameCount = strlen($category->category_name);
                    if ($listNameCount > 16):
                        $listNameClass = 'catlistnamextend';
                    else:
                        $listNameClass = 'catlistname';

                    endif;

                    echo '<li class="catlist">';
                    if ($categoryImage == ''):
                        echo '<h3 count="' . $listNameCount . '"  class="' . $listNameClass . '">' . $category->category_name . '</h3>';
                    endif;
                    echo '<a href="javascript:void(0);" onclick="avatarModel(' . $category->id . ')">';
                    echo $image;
                    echo '<strong class="add-feeds">Add to feeds</strong>';
                    echo '</a>';
                    echo '</li>';
                endforeach;
            endif;
            ?>
        </ul>
    </div>
</div>