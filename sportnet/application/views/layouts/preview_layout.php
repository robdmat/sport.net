<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html> <!--<![endif]-->
    <head>
        <?php echo $head; ?>
    </head>
    <body style="padding-top: 0px !important" class="<?php echo $body_class; ?> preview">
        <style>
            #preview {
                float: left;
                min-height: 610px;
                width: 100%;
                overflow-x: hidden;
            }
        </style>
        <header>
            <?php echo $preview_header; ?>
        </header>
        <div id="content">
            <?php echo $content; ?>
            <?php echo $preview_footer; ?>
        </div>

    </body>
</html>