<!-- robot speak -->	
<meta charset="utf-8">
<title><?php echo (!empty($title)) ? $title . '' : 'Sport News'; ?></title>
<?php echo chrome_frame(); ?>
<?php echo view_port(); ?>
<?php echo apple_mobile('black-translucent'); ?>
<?php echo $meta; ?>

<!-- icons and icons and icons and icons and icons and a tile -->
<?php echo windows_tile(array('name' => 'Sport', 'image' => base_url() . '/assets/img/icons/tile.png', 'color' => '#4eb4e5')); ?>
<?php echo favicons(); ?>

<!-- crayons and paint -->	
<?php echo add_css(array('frontend_css/reset', 'frontend_css/responsive', 'frontend_css/styles')); ?>
<?php echo $css; ?>

<!-- magical wizardry -->
<?php echo jquery('1.10.2'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<?php echo shiv(); ?> 
<?php echo add_js(array('bootstrap.min', 'scripts', 'file/validation/jquery.validate.min', 'file/validation/additional-methods.min')); ?>
<?php echo $js; ?>
<!--<script id="facebook-jssdk" src="//connect.facebook.net/en_US/all.js" type="text/javascript"></script>-->