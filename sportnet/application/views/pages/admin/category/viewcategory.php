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
                        $cats = categoriesquery::create()->filterByparentid(0)->find();
                        $count = 1;
                        foreach ($cats as $childs) {
                            echo '<div class="accordion-group">
                                <div class="accordion-heading">
                                    <a id="' . $childs->getid() . '"class="accordion-toggle event" data-toggle="collapse" data-parent="#leftMenu" href="#collapse' . $count . '">
                                    ' . $childs->getcategoryname() . '
                                    </a>
                                </div> ';
                            $parents_cat = categoriesquery::create()->filterByparentid($childs->getid())->find();
                            if (count($parents_cat) > 0) {
                                echo ' <div id="collapse' . $count . '" class="accordion-body collapse" style="height: 0px; ">
                                <div class="accordion-inner">
                                    <ul>';
                                foreach ($parents_cat as $parents) {
                                    echo '<li class="event" id="' . $parents->getid() . '">' . $parents->getcategoryname() . '</li>';
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
                <script>
                    $(document).ready(function() {
                        $('.event').bind('click', function() {
//                            alert($(this).attr('id')); // gets the id of a clicked link that has a class of menu
                            var data = 'id=' + $(this).attr('id');
                            jQuery.ajax({
                                type: "POST",
                                url: "http://webdekeyif.com/index.php/home/getCategroyById",
                                data: data,
                                success: function(result) {
                                    if (result.result == 0) {
                                        console.log('mai nahi delete huya');
                                        $("#post_delete_failure").css("display", "block").delay(5000).fadeOut(1000);
                                        $("#loading_img").hide();
                                    } else {
                                        $("#post_delete_success").css("display", "block").delay(5000).fadeOut(1000);
                                        $("#loading_img").hide();
                                    }
                                }
                            });
                        });
                    });
                </script>


                <div class="row-fluid">
                    <div class="span9-5 item_content">
                        <div class="row-fluid item_nav">
                            <h2 class="title"><?php echo $this->lang->line('all_files'); ?></h2> 
                            <ul class="nav nav-pills right">
                                <li class="active">
                                    <a href="#"><?php echo $this->lang->line('all_files'); ?></a>
                                </li>
                                <li><a href="#"><?php echo $this->lang->line('top_authors'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('top_new_authors'); ?></a></li>
                                <li><a href="#"><?php echo $this->lang->line('view_all_cat'); ?></a></li>
                            </ul>
                        </div>
                        <div class="row-fluid">
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $(".thumbnails").Zoomdp();
                                });
                            </script>
                            <ul class="thumbnails">
                                <?php
                                $count = 1;
                                foreach ($items as $item) {
                                    $user = useritemsquery::create()->filterByitemid($item['id'])->findOne()->getuserid();
                                    $user = userprofilequery::create()->filterByuserid($user)->findOne();
                                    ?>
                                    <li class="span3 <?php echo ($count == 1) ? 'first' : '' ?>">
                                        <div class="thumbnail">
                                            <img data-src="holder.js/a" src="../../../assets/img/1.jpg" alt="">
                                            <div class="desc">
                                                <h2><a href="<?php echo 'http://webdekeyif.com/index.php/item/productView/' . $item['id']; ?>"><?php echo $item['itemname']; ?></a></h2>
                                                <span>category :</span><a href="#"><?php echo categoriesquery::create()->filterByid($item['categoryid'])->findOne()->getcategoryname(); ?></a>
                                                <p>by<span class="author"><?php echo ' ' . $user->getfirstname() . ' ' . $user->getlastname(); ?></span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    if ($count > 4) {
                                        $count = 0;
                                    }
                                    $count++;
                                }
                                ?>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" width="160" height="160" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">wordpress</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3 first">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3 first">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3 first">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                                <li class="span3">
                                    <div class="thumbnail">
                                        <img data-src="holder.js/300x200" src="../../../assets/img/1.jpg" alt="">
                                        <div class="desc">
                                            <h2>Lorem Ipsum The Dollor sit</h2>
                                            <span>category :</span><a href="#">wordpress</a>
                                            <p>by<span class="author">Ajay Kumar</span><span class="right"><span class="icon-thumbs-up"></span>250   <span class="icon-eye-open"></span>1225</span></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>

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