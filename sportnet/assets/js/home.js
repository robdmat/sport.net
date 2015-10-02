/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(window).load(function() {
    $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider) {
            $('body').removeClass('loading');
        }
    });
});

