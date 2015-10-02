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
<div class="container">
    <div class="row-fluid">
        <div class="span12">
            <div class="span2"></div>
            <div class="span8">
                <div class="row-fluid" id="home_view_posts">
                    <?php
                    if (!empty($items)) {
                        ?>
                        <ul class="thumbnails">
                            <?php
                            $count = 1;
                            foreach ($items as $item) {
                                $term_id = $item['item_id'];
                                $category_id = get_category_id_by_item_id($term_id);

                                //Get the item price
                                $col = Propel::getConnection();
                                $price_values_query = "SELECT `items_fields`.`field_value` FROM `items` LEFT JOIN(`categories_field`, `items_fields`) ON `items`.`id` = `items_fields`.`item_id` AND `items_fields`.`field_id` = `categories_field`.`id` WHERE  `categories_field`.`field_type` = 'item_price' AND `items`.`category_id` = $category_id";
                                $q = $col->prepare($price_values_query);
                                $q->execute();
                                $price_values = $q->fetchAll(PDO::FETCH_ASSOC);
                                $price = isset($price_values[0]['field_value']) ? $price_values[0]['field_value'] : 0;




                                $c = Propel::getConnection();
//                            $query = "SELECT `items_fields`.`field_value` FROM `items` LEFT JOIN(`categories_field`, `items_fields`) ON `items`.`id` = `items_fields`.`item_id` AND `items_fields`.`field_id` = `categories_field`.`id` WHERE  `categories_field`.`field_type` = 'item_price' AND `items`.`category_id` = $category_id";
                                $query = $next_query = "SELECT * FROM `items` LEFT JOIN(`categories_field`, `items_fields`) ON `items`.`id` = `items_fields`.`item_id` AND `items_fields`.`field_id` = `categories_field`.`id` WHERE  `categories_field`.`field_type` = 'file_upload' AND `items`.`status` = 1 AND `items`.`id` = $term_id AND `items_fields`.`item_id` = $term_id ";
                                $st = $c->prepare($query);
                                $st->execute();
                                $array_val = $st->fetchAll(PDO::FETCH_ASSOC);

//                                $price = $array_val[0]['field_value'];
                                //Fetch all the detail of the item that is to be displayed on the page
                                $user_id = useritemsquery::create()->filterByitemid($item['item_id'])->findOne()->getuserid();
                                $user = userprofilequery::create()->filterByuserid($user_id)->findOne();
                                $thumb = $array_val[0]['field_value'];
                                $slug = $array_val[0]['slug'];
                                $cat = categoriesquery::create()->filterByid($category_id)->findOne()->getcategoryname();
                                $obj = json_decode($thumb);

                                $getUserName = getUserNameById($user_id);

                                $thumbnail_url = isset($obj->thumbnail) ? $obj->thumbnail : 'no-thumbnail.png'
                                ?>
                                <li class="span3 <?php echo ($count == 1) ? 'first' : '' ?>">
                                    <div class="thumbnail">
                                        <a target="_blank" href="<?php echo site_url("item/$slug") ?>">

                                            <?php $image_url = site_url() . 'timthumb/timthumb.php?src=' ?>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <!--<img src="/scripts/timthumb.php?src=/images/whatever.jpg&h=150&w=150&zc=1" alt="">--> 
                                            <img  src="<?php echo $image_url . base_url(); ?>uploads/<?php echo $thumbnail_url . '&h=50&w=50&zc=1'; ?>" alt="<?php echo substr($array_val[0]['item_name'], 0, 40); ?>"
                                                  class="thumbimg img-polaroid tip_trigger" author="<?php echo ' ' . $user->getfirstname() . ' ' . $user->getlastname(); ?>" category="<?php echo categoriesquery::create()->filterByid($category_id)->findOne()->getcategoryname(); ?>"
                                                  data-fullsize="<?php echo base_url(); ?>uploads/<?php echo $thumbnail_url; ?>" price="<?php echo $price; ?>" />
                                        </a>
                                        <div class="desc">
                                            <h2><a target="_blank" href="<?php echo site_url("item/$slug") ?>"><?php echo substr($array_val[0]['item_name'], 0, 40); ?></a></h2>
                                            <span>category :&nbsp;</span><a href="<?php
                                            echo site_url("category");
                                            echo '/' . slugify($cat)
                                            ?>"><?php echo $cat; ?></a>
                                            <p>by<span class="author"><a href="<?php echo site_url() . 'user/' . $getUserName; ?>"><?php echo ' ' . $user->getfirstname() . ' ' . $user->getlastname(); ?></a></span><span class="right"><span class="icon-thumbs-up"></span><?php echo getLikers($item['item_id']); ?>  <span class="icon-eye-open"></span><?php echo getViews($item['item_id']); ?></span></p>
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

                        <div class="span12 page">
                            <div class="span6 offset2">
                                <div class="pagination_style">
                                    <?php echo isset($links) ? $links : ''; ?>
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
                </div>
            </div>
            <div class="span2">
            </div>
        </div>
    </div>
</div>