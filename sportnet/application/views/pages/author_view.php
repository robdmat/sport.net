<div class="row-fluid item_nav">
    <h2 class="title"><?php echo $heading ?></h2> 
    <ul class="nav nav-pills right">
        <div class="alert alert-error" id="cat_fail">
            Unable to use perform the task
            <a data-dismiss="alert" class="close"><i class="icon-remove-sign"></i></a>
        </div>
        <li>
            <a href="<?php echo base_url(); ?>"><?php echo $this->lang->line('all_files'); ?></a>
        </li>
        <li class="<?php echo (isset($page) && $page == 'top_authors') ? 'active' : ''; ?>"><a href="<?php echo site_url('home/topauthor'); ?>"><?php echo $this->lang->line('top_authors'); ?></a></li>
        <li class="<?php echo (isset($page) && $page == 'new_authors') ? 'active' : ''; ?>" ><a href="<?php echo site_url('home/recentauthor'); ?>"><?php echo $this->lang->line('top_new_authors'); ?></a></li>
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
    <?php if (!empty($authors)) { ?>
        <ul class="thumbnails">
            <?php
            $count = 1;
            foreach ($authors as $author) {
                //Get the item price
                $img = $author->getuseravatar();
                $img = (isset($img) && $img != '') ? $img : 'user.png';
                $name = $author->getfirstname() . " " . $author->getlastname();
                ?>
                <li class="span3 <?php echo ($count == 1) ? 'first' : '' ?>">
                    <div class="thumbnail">
                        <img  src="<?php echo base_url(); ?>uploads/avatar/<?php echo $img; ?>" alt="<?php echo $name; ?>" class="thumbimg img-polaroid"/>
                        <div class="desc">
                            <h2><a href=""><?php echo $name; ?></a></h2>
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
        <div class="tip" id="hover_div">
            <div class="big-img"><a href="" target="_blank"><img src=""></a></div>
            <strong class="title"></strong>
            <div class="info">
                <div class="author-category mrtp_5">
                    <span class="by_author">by</span>
                    <span class="author"></span>
                    <div class="wd_100 mrtp_5">
                        <div class="wd_70 over_flow_hidden">
                            <span class="category"></span>
                        </div>
                        <div class="wd_30"><div class="price">
                                <span class="cost"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>  
    <?php } else { ?>
        <div class="span12 buffer">
            <div class="alert alert-block alert-info left_buffer right_buffer">
                <h2><?php echo $this->lang->line('no_result'); ?></h2>
            </div>
        </div>
    <?php } ?>

    <!-- pagination-->
    <!--    <div class="pagination pagination-centered">
            <ul>
                <li class="disabled"><a href="#">«</a></li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">»</a></li>
            </ul>
        </div>-->
</div>