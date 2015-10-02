/* My Custom Scripts */
/**
 * Remove the error class on key down
 * @param {type} arg
 * @returns {undefined}
 */
function removeError(arg) {
    $(arg).removeClass('is_error');
    $(arg).next('.error:eq(0)').remove().fadeOut(5000);
}

/**
 * Displays the delete popup and as the confirmation form the user 
 * whether to delete or not
 * **/
function deletePopup(id, url) {
    $('#del_model').modal('show');
    $('#del_model .modal-footer #del').click(function () {
        $('#del_model').modal('hide');
        $.ajax({
            url: url,
            type: 'post',
            async: true,
            data: {'id': id},
            success: function (result) {
                window.location = window.location.href;
                window.location.reload(true);
            }
        });
    });
}

function deletePopupContact(id, url) {
    $('#del_model').modal('show');
    $('#del_model .modal-footer #del').click(function () {
        $('#del_model').modal('hide');
        $.ajax({
            url: url,
            type: 'post',
            async: true,
            data: {'contact_id': id},
            success: function (result) {
                window.location = window.location.href;
                window.location.reload(true);
            }
        });
    });
}

/**
 * Displays the delete popup and as the confirmation form the user 
 * whether to delete or not
 * **/
function deleteFooterItemPopup(id, url) {
    $('#del_model').modal('show');
    $('#del_model .modal-footer #del').click(function () {
        $('#del_model').modal('hide');
        $.ajax({
            url: url,
            type: 'post',
            async: true,
            data: {'footer_item_id': id},
            success: function (result) {
                window.location = window.location.href;
                window.location.reload();
            }
        });
    });
}


/**
 * 
 * @param {type} menu_id
 * @param {type} footer_label
 * @param {type} footer_link
 * @param {type} footer_name
 * @param {type} footer_title
 * @returns {undefined}
 */

function editFooterItemPopup(menu_id, footer_label, footer_link, footer_name, footer_title) {
    $("#footer_title_update").val(footer_title);
    $("#footer_menu_id").val(menu_id);
    $("#footer_label_update").val(footer_label);
    $("#footer_link_update").val(footer_link);
    $("#footer_name_update").val(footer_name);
    $("#edit_menus_button").trigger('click');
}

/**
 * Edit the footer name 
 * @param {type} footer_area
 * @param {type} footer_name
 * @returns {undefined}
 */

function editFooterName(footer_area, footer_name) {
    $("#footer_name_update_name").val(footer_name);
    $("#footer_area_footer_name_update").val(footer_area);
    $("#edit_footer_name_button").trigger('click');
}

/**
 * Function to validate the category fields
 * @returns {undefined}
 */
function validateField() {
    if ($('#field_name').val() == '') {
        $('.controls .error').hide();
        $('#field_name').parent().append('<div class="error">Please insert the field name!</div>');
    } else if ($('#field_type').val() == 'none') {
        $('.field_type .error').hide();
        $('#field_type').parent().append('<div class="error">Please select appropriate field type!</div>');
    } else {
        var count = Math.floor(Math.random() * 2000);
        var id = $('#field_type').val() + "_" + count;
        $('#fields table tbody').append('<tr id="' + id + '"><td>' + $('#field_name').val() + '</td><td>' + $('#field_type').val() + '</td><td><a class="btn" onclick="javascript:deleteCategoryField(\'#' + id + '\');"><i class="icon-trash"></i></a></td></tr>');
        $('#fields').append('<input id="' + id + '" type="hidden" name="fields[' + $('#field_type').val() + ']" value="' + $('#field_name').val() + '"/>')
        //Set the default data
        $('#field_name').val('');
        $('#field_type').val('');
        $('#myModal').modal('hide');
    }

}

/**
 * 
 * @param {type} id
 * @returns {undefined}
 */
function deleteCategoryField(id) {
    $(id).remove();
    $('input[type="hidden"]' + id).remove();
}

/**
 * 
 * @param {type} id
 * @returns {undefined}
 */
function removeDiv(id) {
    $('#' + id).remove();
}

/**
 * Check the slug
 * @param {type} url
 * @param {type} txt
 * @returns {undefined}
 */
function checkSlug(url, txt) {
//check the slug
    $.ajax({
        url: url,
        type: 'post',
        async: true,
        data: {'slug': txt},
        success: function (result) {
            if (result.result == "false") {
                $('#slugText').html('');
                $('#slugText').append(txt + '-1');
                $('input[name="slug"]').val('');
                $('input[name="slug"]').val(txt + '-1');
            }
        }
    });
}


function insertSlug(url) {
    var txt = jQuery("#title_value").val();
    if (txt == '') {
        $('.permalink').addClass('hidden');
    } else {
        txt = txt.toLowerCase().replace(/[^\w ]+/g, '').replace(/ +/g, '-');
        var last = txt.substr(txt.length - 1);
        if (last == '-') {
            txt = txt.substring(0, txt.length - 1);
        }
        $('.permalink').removeClass('hidden');
        $('#slugText').html('');
        $('#slugText').append(txt);
        $('input[name="slug"]').val('');
        $('input[name="slug"]').val(txt);
        //Call check slug function 
        checkSlug(url, txt);
    }
}

/**
 * Add the page link into the menu
 * @returns {undefined}
 */
function addMenuItem() {
    $(':checkbox:checked').each(function (i) {
        var number = 1 + Math.floor(Math.random() * 1000);
        $('#nestable > .dd-list').append('<li id="page-' + number + '" class="dd-item" data-exist_id="0" page-id="' + $(this).val() + '" data-label="' + $(this).attr('page-title') + '" data-link="' + $(this).attr('page-link') + '"><div class="dd-handle">' + $(this).attr('page-title') + '</div><a class="close" onclick="javacript:closeMenu(\'page-' + number + '\');">×</a></li>');
    });
    $('#nestable').nestable();
}

/**
 * Close the menu 
 * @param {type} id
 * @returns {undefined}
 */
function closeMenu(id) {
    var ids = $('input[name="delete-pages"]').val();
    if (ids != '') {
        ids += ',';
    }
    ids += $('li#' + id).attr('data-exist_id');
    $('input[name="delete-pages"]').val(ids);
    $('li#' + id).remove();
}

function removePackage(id) {
    var ids = $('input[name="del-package"]').val();
    if (ids != '') {
        ids += ',';
    }
    ids += $('#' + id).attr('data-id');
    $('input[name="del-package"]').val(ids);
    $('#' + id).remove();
}

/**
 * function to add the custom link in the menu page
 * @returns {undefined}
 */
function addCustomLink() {
    if ($('#link-title').val() == '') {
        $('#link-title').parent().parent().addClass('error');
        return false;
    }
    if ($('#link-url').val() == '') {
        $('#link-url').parent().parent().addClass('error');
        return  false;
    }
    url_validate = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if (!url_validate.test($('#link-url').val())) {
        $('#link-url').parent().parent().addClass('error');
        return  false;
    }
    var title = $('#link-title').val();
    var url = $('#link-url').val();
    //Adding the custom link on the menu container
    var number = 1 + Math.floor(Math.random() * 1000);
    $('#nestable > .dd-list').append('<li id="page-' + number + '" class="dd-item"  data-exist_id="0" data-label="' + title + '" data-link="' + url + '"><div class="dd-handle">' + title + '</div><a class="close" onclick="javacript:closeMenu(\'page-' + number + '\');">×</a></li>');
    $('#nestable').nestable();
    $('#link-url').val('');
    $('#link-title').val('');
}

function removeError(id) {
    $('#' + id).parent().parent().removeClass('error');
}

/**
 * Function to send the ajax query to save the menu
 * @returns {undefined}
 */
function saveMenu(url) {
    var menu = $('select[name="menu"]').val();
    var txt = window.JSON.stringify($('.dd').nestable('serialize'));
    var ids = $('input[name="delete-pages"]').val();
    if (ids != '') {
        $.ajax({
            url: '/index.php/admin/deletemenu',
            type: 'post',
            async: true,
            data: {data: ids},
            success: function (result) {
            }
        });
    }
    $.ajax({
        url: url,
        type: 'post',
        async: true,
        data: {type: menu, data: txt},
        success: function (result) {
            $('#alert').removeClass('hidden');
            $('#alert').fadeIn(1000);
            $('#alert').fadeOut(1000);
            window.location.reload();
        }
    });
}

/**
 * Add the Package detail and then insert into the database
 * @returns {undefined}
 */
function addPackage() {
    $('#package_model').modal('show');
    $('#package_model .modal-footer #save').bind('click', function (e) {
        var number = 1 + Math.floor(Math.random() * 1000);
        var title = $('#package_model #package_title').val();
        var desc = $('#package_model #package_desc').val();
        var price = $('#package_model #package_price').val();
        var valid = $('#package_model #package_valid').val();
        $('#package_model #package_title').val('');
        $('#package_model #package_desc').val('');
        $('#package_model #package_price').val('');
        $('#package_model #package_valid').val('');
        var data = {title: title, desc: desc, price: price, valid: valid};
        $('#package #package_fieldset').removeClass('hidden');
        $('#package').append('<div id="package_' + number + '" class="package_item alert alert-info"><button type="button" class="close" onclick="javascript:removeDiv(\'package_' + number + '\')">&times;</button><h3>' + title + ' <sapn class="pull-right">$' + price + '</span></h3><p>' + desc + '</p><input name="package[]"  type="hidden" value=\'' + JSON.stringify(data) + '\'></div>');
        $('#package_model').modal('hide');
        $('#package_model .modal-footer #save').unbind('click');
    });
}

/**
 * Function to add the report task
 * @param {type} id
 * @returns {undefined}
 */
function reportComment(id) {
    if ($('#comment_' + id).hasClass('hidden')) {
        $('#comment_' + id).removeClass('hidden');
    } else {
        $('#comment_' + id).addClass('hidden');
    }
}

/**
 * Function to switch the language
 * @param {type} url
 * @returns {undefined}
 */
function switchLang(url) {
    $.ajax({
        url: url,
        success: function () {
            location.reload();
        }
    });
}


function likeDislike(id, obj) {
    var type = $(obj).attr('id');
    $.ajax({
        url: '/item/likeDislike',
        data: {id: id, type: type},
        type: "post",
        success: function () {
            $('#like, #dislike').removeClass('btn-primary');
            $(obj).addClass('btn-primary');
        }
    });
}


$(function () {
//Tooltips
    $(".tip_trigger").hover(function () {
//		tip = $(this).find('.tip');
        tip = $('.tip');
        tip.show(); //Show tooltip
    }, function () {
        tip.hide(); //Hide tooltip		  
    }).mousemove(function (e) {
        var dpane = $('#hover_div');
        var dpanetitle = $('#hover_div .title');
        var dpanedesc = $('#hover_div .desc');
        var dpanecategory = $('#hover_div .category');
        var dpaneauthor = $('#hover_div .author');
        var dpaneprice = $('#hover_div .price .cost');
        var newtitle = $(this).attr('alt');
        var newdate = $(this).attr('data-date');
        var newauthor = $(this).attr('author');
        var newcategory = $(this).attr('category');
        var newdesc = $(this).parent().next('.desc').attr('content');
        var newimg = $(this).attr('data-fullsize');
        var linkurl = $(this).parent().attr('href');
        var price = $(this).attr('price');
        $('.big-img a').attr('href', linkurl);
        $('.big-img a img').attr('src', newimg);
        var titlehtml = newtitle;
        dpanetitle.html(titlehtml);
        dpanedesc.html(newdesc);
        dpaneauthor.html(newauthor);
        dpanecategory.html(newcategory);
        dpaneprice.html('<sup>$</sup>' + price);
//    dpane.css({ 'left': xcoord, 'top': ycoord, 'display': 'block'});


        var mousex = e.pageX + 20; //Get X coodrinates
        var mousey = e.pageY + 20; //Get Y coordinates
        var tipWidth = tip.width(); //Find width of tooltip
        var tipHeight = tip.height(); //Find height of tooltip

        //Distance of element from the right edge of viewport
        var tipVisX = $(window).width() - (mousex + tipWidth);
        //Distance of element from the bottom of viewport
        var tipVisY = $(window).height() - (mousey + tipHeight);
        if (tipVisX < 20) { //If tooltip exceeds the X coordinate of viewport
            mousex = e.pageX - tipWidth - 20;
        }
        if (tipVisY < 20) { //If tooltip exceeds the Y coordinate of viewport
            mousey = e.pageY - tipHeight - 20;
        }
        tip.css({top: mousey, left: mousex});
    }).mouseout(function (e) {
        $('.big-img a img').attr('src', '');
    });
    $(".tip_trigger").mousemove(function (e) {
        $("#hover_div big-img img").attr('src', "");
    });
});
//Collections , favourites and follow script


function favouriteItem(item_id) {
    var status = $("#favourites_anchor").val();
    $("#item_container").addClass('pointer_events');
    if (item_id !== '') {
        var data = {item_id: item_id};
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "/item/favorites",
            data: data,
            success: function (result) {
                $("#item_container").removeClass('pointer_events');
                if (result.favorite === 'true') {
                    $("#favourite_span_id").html(' ');
                    $("#favourite_span_id").append('<span id="favorite_spam" class="btn btn-success"><i class="fa fa-heart-o"></i>&nbsp;In Favorites</span>');
                } else if (result.favorite === 'false') {
                    //                                        $("#favorite_spam").html('Add to Favorites');
                    $("#favourite_span_id").html(' ');
                    $("#favourite_span_id").append('<span id="favorite_spam" class="btn btn-info"><i class="fa fa-heart-o"></i>&nbsp;Add to Favorites</span>');
                }
            }
        });
    }
}




function followuser(user_id) {
    var follower_id = $("#follower_id").val();
    if (user_id !== '') {
        var data = {user_id: user_id, follower_id: follower_id};
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "http://webdekeyif.com/user/follow",
            data: data,
            success: function (result) {
                $("#follower_count").html(' ');
                $("#follower_count").append('<span class="counts">' + result.count + '</span>');
                if (result.following === 'following') {
                    $("#following_span_id").html(' ');
                    $("#following_span_id").append('<input type="submit" class="btn btn-success" value="Unfollow" id="follow_button" onclick="javascript:followuser(' + user_id + ')" />');
                } else if (result.following === 'not_following') {
                    $("#following_span_id").html(' ');
                    $("#following_span_id").append('<input type="submit" class="btn btn-info" value="Follow" id="follow_button" onclick="javascript:followuser(' + user_id + ')" />');
                }
            }
        });
    }
}

function follower_count(user_id) {
    var data = {user_id: user_id};
    jQuery.ajax({
        type: "POST",
        dataType: 'json',
        url: "/user/follower_count",
        data: data,
        success: function (result) {
            alert(result);
        }
    });
}

function addTocollection(item_id) {
//    $("#collection_container_button").trigger('click');
//    $("#outercontainer").css('display', 'block');
    $("#collection_container_button").trigger('click');
}
$('#collection_container').modal();
//coolection
function saveItemToCollections(item_id, collection_id) {
    if (collection_id !== '') {
        $("#col-" + collection_id).addClass('pointer_events');
        var data = {collection_id: collection_id, item_id: item_id};
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "/collection/saveItemToCollections",
            data: data,
            success: function (result) {
                $("#col-" + collection_id).removeClass('pointer_events');
                if (result.incollection === 'no') {
                    $("#icon_parameter-" + collection_id).html(' ');
                    $("#icon_parameter-" + collection_id).append('<i class="fa fa-plus icon_status"></i>&nbsp');
                } else {
                    $("#icon_parameter-" + collection_id).html(' ');
                    $("#icon_parameter-" + collection_id).append('<i class="fa fa-check icon_status"></i>&nbsp;');
                }

                if (result.collection === 'incollections') {
                    $("#collection_span_id").html(' ');
                    $("#collection_span_id").append('<span id="collection_spam" class="btn btn-success"><i class="fa fa-folder-open-o"></i>&nbsp;In Collection</span>');
                } else {
                    $("#collection_span_id").html(' ');
                    $("#collection_span_id").append('<span id="collection_spam" class="btn btn-info"><i class="fa fa-folder-open-o"></i>&nbsp;Add to Collection</span>');
                }
            }
        });
    }
}

// lounch the configuration model
function lounchConfigurationModel(collection_name, collection_id) {
    $("#collection_form_description").val(' ');
    $("#bookmark_form_name").val(collection_name);
    $("#collection_id").val(collection_id);
    $("#configuration_model_button").trigger('click');
    var data = {collection_id: collection_id};
    jQuery.ajax({
        type: "POST",
        dataType: 'json',
        url: "/collection/getcollectiondescription",
        data: data,
        success: function (result) {
            $("#collection_form_description").val(result._desc);
        }
    });
}

$('#configuration_model').modal({keyboard: false});
$('#share_collection').modal({keyboard: false});
$('#collection_container').modal({keyboard: false});
$('#delete_collection').modal({keyboard: false});
// lounch the delete model
function lounchDeleteModel(collection_id) {
    $("#collection_id_delete").val(collection_id);
    $("#delete_collection_button").trigger('click');
}

// lounch the share moedel
function lounchShareModel(collection_name, collection_id) {
    $("#mycollectionsharename").html(collection_name);
    $("#collection_name_gen").html(collection_name);
    $("#mycollectionshareid").val(collection_id);
    $("#collection_id").val(collection_id);
    $("#share_collection_button").trigger('click');
}

//generate and revoke the share link
function generateShareLink() {
    var collection_id = $("#mycollectionshareid").val();
    var site_url = 'http://webdekeyif.com/shared/';
    $("#share_buttons").html(' ');
    if (collection_id !== '') {
        var data = {collection_id: collection_id};
        jQuery.ajax({
            type: "POST",
            dataType: 'json',
            url: "/collection/generatesharelink",
            data: data,
            success: function (result) {
                if (result.result === 'success') {
                    if (result.share_key != '') {
                        var share_key = result.share_key;
                    }
                    $("#revoke_div").css('display', 'none');
                    $("#share_link_value").val(site_url + share_key);
                    $("#shared_div").css('display', 'block');
                    $("#share_buttons").html(' ');
                    $("#share_buttons").append('<button type="submit" name="button" id="sharelinkgenerate" class="btn btn--primary" onclick="javascript:revokeShareLink();">Revoke share link</button>');
                } else {

                }
            }
        });
    }
}

// functions revokes the shares

function revokeShareLink() {
    $("#share_buttons").html(' ');
    $("#revoke_div").css('display', 'block');
    $("#shared_div").css('display', 'none');
    $("#share_buttons").append('<button onclick="javascript:generateShareLink();" class="btn btn--primary" id="sharelinkgenerate" name="button" type="submit">Generate share link</button>');
}



//    var decodedString = atob(encodedString);
//    console.log(decodedString);

// if link is generated
//$('input[type="submit"]').removeAttr('disabled');
//$("#share_buttons").html(' ');
//$("#share_buttons").append('<button type="submit" name="button" id="sharelinkgenerate" class="btn btn--primary" onclick="javascript:revokeShareLink();">Revoke share link</button>');
//

function avatardModel(catId) {
    alert(catId);
    jQuery("#activeModel").trigger('click');
    jQuery("#loader").css('display', 'block');
    var email = jQuery("#email").val();
    var password = jQuery("#password").val();
    var data = {email: email, password: password};
    jQuery.ajax({
        type: "POST",
        dataType: 'json',
        url: url,
        data: data,
        success: function (result) {
            alert(result);
            console.log(result);
            jQuery("#appendmsg").append(result.msg);
            jQuery("#loader").css('display', 'none');
            location.reload(true);
        }
    });
}