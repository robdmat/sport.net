/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


jQuery(".checkit").on("click", function () {
    var checked = jQuery(this).find("[name='check_added']").is(':checked');
    if (checked) {
        jQuery(this).find("[name='check_added']").prop('checked', false);
    } else {
        jQuery(this).find("[name='check_added']").prop('checked', true);
    }
    var value = jQuery(this).find("[name='check_added']").val();
    var id = jQuery(this).attr('id');
    var name = jQuery(this).attr('name');
    jQuery(this).find('span').css('beforebackground-color', '#f00');
    var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + value + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
//    var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).val();
    var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
    if (return_value === 0 || return_value === undefined) {
        jQuery(".filtr_sel").append(input_n);
    } else {
        jQuery(".filtr_sel #remove_id_" + id).remove();
        console.log('Nahi add hua');
    }
    return false;
});

// When Main Category is selected
$("body").on('click', '.chk-all input', function () {
//    var id = jQuery(this).attr('id');
//    var name = jQuery(this).attr('class');
//    if (name === undefined) {
//        name = jQuery(this).find("[name='isCheckedAll'] span").text();
//    }
//    var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + name + '" name="category_main[]" value="' + id + '"/> All From ' + name + '<a href="javascript:void(0)"></a></p>';
//    var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
//    if (return_value === 0 || return_value === undefined) {
//        jQuery(".filtr_sel").append(input_n);
//        return;
//    } else {
//        //  jQuery(".filtr_sel #remove_id_" + id).remove();
//        console.log('add');
//    }
    var checked_input_array = new Array();
    if (!$(this).is(':checked')) {
        //$(this).attr('checked', true);
        jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', false);
        var t = jQuery(this).closest('.checkbox').next().text();
        if (t === '' || t === undefined) {
            var id = jQuery(this).attr('id');
            jQuery(".filtr_sel #remove_id_" + id).remove();
        } else {
            jQuery(this).closest('ul').find('input:checkbox').each(function (index, element) {
                var id = jQuery(this).attr('id');
                jQuery(".filtr_sel #remove_id_" + id).remove();
            });
        }
        return;
    } else {
        jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', true);
        var t = jQuery(this).closest('.checkbox').next().text();
        if (t === '' || t === undefined) {
            var input_value = jQuery(this).val();
            var id = jQuery(this).attr('id');
            var name = jQuery(this).attr('class');
            if (name === undefined) {
                name = jQuery(this).find("[name='isCheckedAll'] span").text();
            }
            var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + name + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
            var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
            if (return_value === 0 || return_value === undefined) {
                jQuery(".filtr_sel").append(input_n);
                return;
            } else {
                console.log('add');
            }


        } else {
            jQuery(this).closest('ul').find('input:checkbox').each(function (index, element) {
                var input_value = jQuery(this).val();
                var id = jQuery(this).attr('id');
                var name = jQuery(this).attr('class');
                if (name === undefined) {
                    name = jQuery(this).find("[name='isCheckedAll'] span").text();
                }
                var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + name + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
                var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
                if (return_value === 0 || return_value === undefined) {
                    jQuery(".filtr_sel").append(input_n);
                    return;
                } else {
                    console.log('add');
                }
            });
        }

    }
});

// Toggle Share Div
function getShareDiv(id) {
    jQuery("#slideToggleParent_" + id).slideToggle();
}


//
///* 
// * To change this license header, choose License Headers in Project Properties.
// * To change this template file, choose Tools | Templates
// * and open the template in the editor.
// */
//
//
//jQuery(".checkit").on("click", function () {
//    var checked = jQuery(this).find("[name='check_added']").is(':checked');
//    if (checked) {
//        jQuery(this).find("[name='check_added']").prop('checked', false);
//    } else {
//        jQuery(this).find("[name='check_added']").prop('checked', true);
//    }
//    var value = jQuery(this).find("[name='check_added']").val();
//    var id = jQuery(this).attr('id');
//    var name = jQuery(this).attr('name');
//    jQuery(this).find('span').css('beforebackground-color', '#f00');
//    var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + value + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
////    var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).val();
//    var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
//    if (return_value === 0 || return_value === undefined) {
//        jQuery(".filtr_sel").append(input_n);
//    } else {
//        jQuery(".filtr_sel #remove_id_" + id).remove();
//        console.log('Nahi add hua');
//    }
//    return false;
//});
//
//// When Main Category is selected
//$("body").on('click', '.chk-all input', function (e) {
//    var checked_input_array = new Array();
//    if (!$(this).is(':checked')) {
//        //$(this).attr('checked', true);
//        jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', false);
////        var check = jQuery(this).closest('ul li').has("ul");
//        // check if has sub category 
//        //if not then code
//        var check = jQuery(this).closest('ul').hasClass('sub');
//        alert(check);
//        if (check === false || check === undefined) {
//            var id = jQuery(this).attr('id');
//            jQuery(".filtr_sel #remove_id_" + id).remove();
//        } else {
//            // has subcategory 
//            jQuery(this).closest('ul').find('input:checkbox').each(function (index, element) {
//                var id = jQuery(this).attr('id');
//                jQuery(".filtr_sel #remove_id_" + id).remove();
//            });
//            return;
//        }
//    } else {
//        // check subcategory
//        jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', true);
//        var check = jQuery(this).closest('ul').next().find('ul li').size();
////        var check = jQuery(this).closest('ul').hasClass('sub');
////        var check = jQuery(this).closest('ul li').has("ul");
////        var check = jQuery(this).closest('ul li').has("ul");
//        alert(check);
//        if (check === false || check === undefined) {
//            var input_value = jQuery(this).val();
//            var id = jQuery(this).attr('id');
//            var name = jQuery(this).attr('class');
//            if (name === undefined) {
//                name = jQuery(this).find("[name='isCheckedAll'] span").text();
//            }
//            var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + name + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
//            var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
//            if (return_value === 0 || return_value === undefined) {
//                jQuery(".filtr_sel").append(input_n);
//                return;
//            } else {
//                console.log('add');
//            }
//        } else {
//            jQuery(this).closest('ul').find('input:checkbox').each(function (index, element) {
//                var input_value = jQuery(this).val();
//                var id = jQuery(this).attr('id');
//                var name = jQuery(this).attr('class');
//                if (name === undefined) {
//                    name = jQuery(this).find("[name='isCheckedAll'] span").text();
//                }
//                var input_n = '<p id="remove_id_' + id + '" onclick="javascript:removeMe(' + id + ')"><input id="inputId_' + id + '" type="hidden" class="name_' + name + '" name="category_array[]" value="' + id + '"/> ' + name + '<a href="javascript:void(0)"></a></p>';
//                var return_value = jQuery(".filtr_sel #remove_id_" + id).find('#inputId_' + id).length;
//                if (return_value === 0 || return_value === undefined) {
//                    jQuery(".filtr_sel").append(input_n);
//                    return;
//                } else {
//                    console.log('add');
//                }
//            });
//        }
//    }
//});
//
//// Toggle Share Div
//function getShareDiv(id) {
//    jQuery("#slideToggleParent_" + id).slideToggle();
//}
