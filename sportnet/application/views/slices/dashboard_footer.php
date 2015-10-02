<div class="bottom_block">
    <div class="wide_container">
        <div class="links text_center">
            <ul>
                <?php getPages(); ?>
            </ul>
        </div>
        <div class="table">
            <div class="social">
                <div class="name">Follow Sport.net</div>
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
            <div class="text_center">
                <a class="start_btn" href="#">Start reading</a>
            </div>
            <div class="logo text_right">
                <a href="index.html"><img src="<?php echo site_url(); ?>assets/img/logo.png" alt="Sport.Net"></a>
            </div>
        </div>
    </div>
</div>
</div>
<div id="footer">
    <div class="wide_container clear_fix">
        <div class="fl_left">
            Copyright &copy; 2014 <a href="index.html">Sport.Net</a>. All rights reserved.
        </div>
        <div class="fl_right">
            <ul>
                <li>
                    <a href="#">Terms of Use</a>
                </li>
                <li>
                    <a href="#">Privacy Policy</a>
                </li>
                <li>
                    <a href="#">Site Map</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script>

    function removeMe(removeId) {
        jQuery("#remove_id_" + removeId).remove();
        return false;
    }
    function avatarModel(catId) {
//        var return_value = jQuery("#modelCheck").find('#checkList_' + catId).length;
//        alert(return_value);
//        if (return_value === 0 || return_value === undefined) {

//        alert(catId);
//        jQuery("#checkList").html(' ');
        var checked_input_array = new Array();
        var selected = jQuery(".filtr_sel").html();
        if (selected !== 0 || selected !== undefined) {
            jQuery(".filtr_sel input").each(function (index, element) {
                checked_input_array.push(jQuery(this).val());
//                console.log(jQuery(this).text());
//                var khandala = jQuery(this).find("input").val();
                console.log(checked_input_array);
            });
        }
        jQuery("#checkscript").html(' ');
        jQuery("#ajaxLoader").css('display', 'block');
        var data = {id: catId, selected: checked_input_array};
        jQuery.ajax({
            type: "POST",
            dataType: 'html',
            url: '<?php echo site_url('dashboard/categorySubList') ?>',
            data: data,
            success: function (result) {
//                alert(result);
                jQuery("#ajaxLoader").css('display', 'none');
                jQuery("#modelCheck").html(' ');
                jQuery("#modelCheck").append(result);
//                    jQuery("#isAvailable").append(result);
                jQuery("#activeModel").trigger('click');
                jQuery("#checkscript").html('<script src="<?php echo site_url('assets/js/addjs.js') ?>"><\/script>')
            }
        });
//        } else {
//
//        }
    }

//    jQuery(".checkit").on("click", function () {
//        alert("The paragraph was clicked.");
//    });
//    var selected = [];
//    jQuery('#checkList li input:checked').each(function () {
//        var ques = selected.push(jQuery(this).attr('name'));
//        alert(ques);
//    });
</script>
<div id="checkscript">
    <script src="<?php echo site_url(); ?>assets/js/addjs.js"></script>
</div>
<div class="isAvailable" id="isAvailable">

</div>
<a href="#avatar_modal" id="activeModel" data-toggle="modal" style="display: none"></a>
<div id="avatar_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clear_fix">
                <a href="javascript: void(0);" data-dismiss="modal" class="fl_right close light"></a>
            </div>
            <div class="modal-body">
                <div class="modal-box" id="modelCheck">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/modal.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/main.js"></script>
<script src="<?php echo site_url(); ?>assets/js/frontend_js/masonry.pkgd.min.js"></script>