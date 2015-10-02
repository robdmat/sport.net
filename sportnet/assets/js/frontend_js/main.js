$(document).ready(function() {
	jQuery(document).on('click', '.btn-opener', function(){
		jQuery(this).parent().toggleClass('list-open');
        $(window).resize();
	});
	customCheckBox();
});

(function centeredModal(){
    var $this = $('.modal-dialog');
    $('.modal').on('shown.bs.modal', function() {
        $this = $(this);
        centeredPopUp();
    });

    $(window).on('resize', centeredPopUp);

    function centeredPopUp() {
        var $modal = $this.find('.modal-dialog'),
            blockHeight = $modal.outerHeight(),
            windowHeight = $(window).outerHeight(),
            margin = (windowHeight - blockHeight)/2;

        if(windowHeight < blockHeight) {
            $modal.css('marginTop', 10);
        }

        else {
            $modal.css('marginTop', margin);
        }
    }
})();

(function toggleMenu() {
    var $this;

    $('.toggle').on('click', slideToggle);

    function slideToggle() {
        $this = $(this);
        slideUp(slideDown);
    }

    function slideUp(callback) {
        $this.parent().siblings().find('.drop_down_block').slideUp(100, callback)
    }

    function slideDown() {
        $this.parent().find('.drop_down_block').stop(true, true).slideToggle(200);
        focusIn();
    }

    function focusIn() {
        $this.parent().find('.text_field').focus();
    }

})();

(function toggleMainMenu() {
    $('#toggle_menu').on('click', slideToggle);

    function slideToggle() {
        $('#menu').stop(true, true).slideToggle(150);
    }
})();

(function validateForm() {
    $('body').on('submit', 'form', function() {
        var $this  = $(this);

        var email = new RegExp('^([0-9a-zA-Z]+[-._+&amp;])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$'),
            email_value,
            errors = [];

        $this.find('.required_email').each(function() {
            email_value = $(this).val();
            if (!email.test(email_value)) {
                $(this).parents('.row').addClass('error');
                errors.push($(this));

            } else {
                $(this).parents('.row').removeClass('error');
            }
        });

        $this.find('.required').each(function() {
            if(!$(this).val()) {
                $(this).parents('.row').addClass('error');
                errors.push($(this));
            } else {
                $(this).parents('.row').removeClass('error');
            }
        });

        $this.find('.required_radio').each(function() {
            var radio = $(this).find('input[type="radio"]:checked');
            if(!radio.length) {
                $(this).parents('.row').addClass('error');
                errors.push($(this));
            } else {
                $(this).parents('.row').removeClass('error');
            }
        });

        $this.find('.pass').each(function() {
            var pass = $(this).val();
            var confirm = $(this).parents('form').find('.confirm').val();
            if(pass !== confirm || !pass.length) {
                $('.pass').parents('.row').addClass('error');
                $('.confirm').parents('.row').addClass('error');
                errors.push($(this));
            } else {
                $('.pass').parents('.row').removeClass('error');
                $('.confirm').parents('.row').removeClass('error');
            }
        });

        if(errors.length > 0) {
            return false;
        } // through else we can call the callback
    });
})();

(function toAnchor() {
    $('body').on('click', '.anchor', goToAnchor);

    function goToAnchor() {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top
        }, {
            duration: 500
        });
        return false;
    }
})();

function customCheckBox(){
	$("body").on('click', '.checkbox.chk-all input', function (){
		if (! $(this).is(':checked')) {
			//$(this).attr('checked', true);

			jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', false);
			return;
		}
		jQuery(this).closest('.checkbox').next().find('input:checkbox').not(this).prop('checked', true);
	});
}

$(window).load(function () {
    $('.items_liszt').masonry({
        itemSelector: 'li'
    });
});
