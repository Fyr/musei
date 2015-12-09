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
		$('.themodal-overlay').hide().stop().fadeIn(delay.popup);
	});

	//close modal
	$('.modal .close').click( function(e){
		e.preventDefault();
		$('.themodal-overlay').fadeOut(delay.popup, function() {
			$.modal().close();
		});
	});

	$('.mCustomScroller').mCustomScrollbar({
		theme:"rounded-dark"
	});
	$('.mCustomScroller-mini').mCustomScrollbar({
		theme:"minimal"
	});
	
	
	//js for images in article
	
	// $('.wrapper1 img').wrap('<div class="border"></div>');
	
	//$(window).load( function() {   });
	
	$('.article img').each(function(){
		var _class = '';
		if ($(this).css('float') == 'left') {
			_class = 'leftFloat';
		} else if ($(this).css('float') == 'right') {
			_class = 'rightFloat';
		}
		else {
			$(this).closest('p').addClass('center');
		}

		$(this).wrap('<div class="border ' + _class + '"></div>');
	});
});
