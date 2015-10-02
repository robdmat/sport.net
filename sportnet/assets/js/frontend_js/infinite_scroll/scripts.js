$(document.body).on('click', '#slot_list li', function () {
    var tile_id = $(this).attr('slot_id');
    $(tile_id).addClass("open");
    if ($("#slot_list li .content").is(":hidden")) {
        $("#slot_list li").find("#content_slot_id_" + tile_id).slideDown("fast");
    } else {
        $("#slot_list li .content").hide();
    }
});
$(document.body).on('mouseleave', '#slot_list li', function () {
    $(this).find(".btn").css("display", "block");
    var tile_id = $(this).attr('slot_id');
    $("#slot_list li").find("#content_slot_id_" + tile_id).slideUp("fast");
    $(this).find(".btn").css("display", "none");
});


$("#slot_list li .tiles").on('mouseenter', '.asd', function () {
    $(this).find(".btn").css("display", "block");
});
$("#slot_list li .tiles").on('mouseleave', '.asd', function () {
    $(this).find(".btn").css("display", "none");
});