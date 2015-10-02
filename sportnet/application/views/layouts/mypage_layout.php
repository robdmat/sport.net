<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
    <head>
        <?php echo $head; ?>
    </head>
    <body class="<?php echo $body_class; ?>">

        <header>
            <?php echo $header; ?>
        </header>
        <div id="content">
            <?php echo isset($banner) ? $banner : ''; ?>
            <?php echo isset($pluses) ? $pluses : ''; ?>
            <?php echo isset($statistics) ? $statistics : ''; ?>
            <?php echo $content; ?>
            <?php echo isset($feedback) ? $feedback : ''; ?>
            <?php echo $footer; ?>
        </div>
    </body>
</html>
