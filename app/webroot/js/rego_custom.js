$(document).ready(function(){

	$('.mainMenu li a').click(function(){
		$('.mainMenu li ul').stop().slideUp();
		if ( $(this).next().is('ul') ) {
			$(this).next('ul').stop().slideToggle();
		}
	});

	$(document).on('click touchstart', function(e) {
		if (!$.contains($('.mainMenu').get(0), e.target)  ) {
			$('.mainMenu li ul').stop().slideUp();

		}
	});

	$('.logoMain img').click ( function(e){
		e.preventDefault();
		$('#mapModal').modal({
			closeOnOverlayClick: false,
			onOpen: function(el, options){

				var modal = $(el).find('.modal');
				if ( modal.outerHeight(true) + 55 < $(window).height() ) {
					modal.css('margin-top', -(modal.outerHeight(true))/2);
				}
				else {
					modal.css({ 'margin-top': '55px', 'top': 0});
				}

			}
		}).open();
		$('.themodal-overlay').hide().stop().fadeIn(400);
	});

	//close modal
	$('.modal .close').click( function(e){
		e.preventDefault();
		$('.themodal-overlay').fadeOut(400, function() {
			$.modal().close();
		});
	});

	$('.mCustomScroller').mCustomScrollbar({
		theme:"rounded-dark"
	});
	$('.mCustomScroller-mini').mCustomScrollbar({
		theme:"minimal"
	});
});
