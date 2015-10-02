<div class="slider_bg">
    <div class="container">
        <div class="flexslider">
            <ul class="slides">
                <li><p>Innovative <span class="slide">Furniture</span> for Stunning Web Procets</p></li>
                <li><p>Innovative  for  Web Procets <span class="slide">Furniture</span></p></li>
                <li><p>This is the Lorem <span class="slide">Ipsum</span> Innovative Innovative</p></li>
                <li><p>Lorem Ipsum <span class="slide">The Dollor</span> sit Innovative Innovative</p></li>
            </ul>
        </div>
    </div>
</div><!-- slider_bg closed-->

<?php
//                                $count =1 ;
//foreach ($cat_data as $detail) {
//    echo '<pre>';
//    print_r($detail);
//    echo '</pre>';
//}
?>

<div class="container">
    <div class="row-fluid">
        <div class="span12 border-left">
            <div class="row-fluid">
                <div class="span3 left_sidebar">
                    <div class="accordion" id="leftMenu">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                                    All Categories
                                </a>
                            </div>

                        </div>
                        <?php
                        $home_url = 'http://webdekeyif.com/index.php/category/getcategroybyid';
                        $cats = categoriesquery::create()->filterByparentid(0)->find();
                        $count = 1;
                        foreach ($cats as $childs) {
                            echo '<div class="accordion-group">
                                <div class="accordion-heading">
                                    <a id="' . $childs->getid() . '"class="accordion-toggle event" href="' . $home_url . '/' . $childs->getid() . '">
                                    ' . $childs->getcategoryname() . '
                                    </a>
                                </div> ';
                            $parents_cat = categoriesquery::create()->filterByparentid($childs->getid())->find();
                            if (count($parents_cat) > 0) {
                                echo ' <div id="collapse' . $count . '" class="accordion-body collapse" style="height: 0px; ">
                                <div class="accordion-inner">
                                    <ul>';
                                foreach ($parents_cat as $parents) {
                                    echo '<li class="event" id="' . $parents->getid() . '"><a href="' . $home_url . '/' . $parents->getid() . '">' . $parents->getcategoryname() . '</a></li>';
                                }
                                echo '     </ul> </div>
                            </div>';
                                $count++;
                            }
                            echo "</div>";
                        }
                        ?>

                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span9-5 item_content">
                        <div class="row-fluid item_nav">
                            <h2 class="title"><?php echo $this->lang->line('all_files'); ?></h2> 
                            <ul class="nav nav-pills right">
                                <div class="alert alert-error" id="cat_fail">
                                    Unable to use perform the task
                                    <a data-dismiss="alert" class="close"><i class="icon-remove-sign"></i></a>
                                </div>
                                <li class="active">
                                    <a href="#"><?php echo $this->lang->line('all_files'); ?></a>
                                </li>
                                <li><a href="#"><?php echo $this->lang->line('top_authors'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('top_new_authors'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('view_all_cat'); ?></a></li>
                            </ul>
                        </div>
                        <div class="row-fluid" id="category_view">
                        </div>
                        <div class="span12">
                            <div class="span2"></div>
                            <div class="span8">
                                <div class="progress progress-striped active" id="load">
                                    <div class="bar" style="width: 100%;"></div>
                                </div>
                            </div>
                            <div class="span2"></div>
                        </div>

                        <div class="row-fluid" id="home_view_posts">
                            <ul class="thumbnails">
                                <?php
//                                ($cat_data as $detail)
                                $count = 1;
                                foreach ($cat_data as $detail) {
                                    $user = useritemsquery::create()->filterByitemid($detail['item_id'])->findOne()->getuserid();
                                    $user = userprofilequery::create()->filterByuserid($user)->findOne();
                                    $thumb = $detail['field_value'];
                                    $obj = json_decode($thumb);
                                    ?>
                                    <li class="span3 <?php echo ($count == 1) ? 'first' : '' ?>">
                                        <div class="thumbnail">
                                            <img data-src="holder.js/a" src="http://webdekeyif.com/uploads/<?php echo $obj->thumbnail; ?>" alt="<?php echo $detail['item_name']; ?>"
                                                 class="thumbimg" author="<?php echo ' ' . $user->getfirstname() . ' ' . $user->getlastname(); ?>" category="<?php echo categoriesquery::create()->filterByid($detail['category_id'])->findOne()->getcategoryname(); ?>"
                                                 data-fullsize="http://webdekeyif.com/uploads/<?php echo $obj->thumbnail; ?>" />
                                            <div class="desc">
                                                <h2><a href="<?php echo 'http://webdekeyif.com/index.php/item/productView/' . $detail['item_id']; ?>"><?php echo substr($detail['item_name'], 0, 40); ?></a></h2>
                                                <span>category :</span><a href="#"><?php echo categoriesquery::create()->filterByid($detail['category_id'])->findOne()->getcategoryname(); ?></a>
                                                <p>by<span class="author"><?php echo ' ' . $user->getfirstname() . ' ' . $user->getlastname(); ?></span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    if ($count > 3) {
                                        $count = 0;
                                    }
                                    $count++;
                                }
                                ?>
                            </ul>
                            <div class="zoomify" id="hover_div">
                                <div class="big-img"><a href="" target="_blank"><img src=""></a></div>
                                <strong class="title"></strong>
                                <div class="info">
                                    <div class="author-category">
                                        <span class="by_author">by</span>
                                        <span class="author"></span>
                                        <span class="category"></span>
                                    </div>
                                </div>
                            </div>   


                            <!-- pagination-->
                            <div class="pagination pagination-centered">
                                <ul>
                                    <li class="disabled"><a href="#">«</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li><a href="#">»</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- row closed -->
</div><!-- Container -->