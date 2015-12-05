$(function(){
	var Page = (function() {

		var config = {
				$bookBlock : $( '#bb-bookblock' ),
				$navNext : $( '#bb-nav-next' ),
				$navPrev : $( '#bb-nav-prev' ),
			},
			init = function() {
				config.$bookBlock.bookblock( {
					speed : 1000,
					shadowSides : 1,
					shadowFlip : 1,
					onBeforeFlip: function( page ) { $('.bb-bookblock').addClass('zIndex') },
					onEndFlip: function( page ) {

						$('.bb-bookblock').removeClass('zIndex');

						$('.bb-item:visible .ellipsis').dotdotdot({
							wrap: 'word',
							watch: 'window',
							after: 'a.readmore'
						});

					}
				} );
				initEvents();
			},

			initEvents = function() {

				var $slides = config.$bookBlock.children();

				// add navigation events
				config.$navNext.on( 'click touchstart', function() {
					$('.mainMenu li ul').stop().hide();
					config.$bookBlock.bookblock( 'next' );
					return false;
				} );

				config.$navPrev.on( 'click touchstart', function() {

					$('.mainMenu li ul').stop().hide();
					config.$bookBlock.bookblock( 'prev' );
					return false;
				} );

				// add swipe events
				$slides.on( {
					'swipeleft' : function( event ) {
						config.$bookBlock.bookblock( 'next' );

						return false;
					},
					'swiperight' : function( event ) {
						config.$bookBlock.bookblock( 'prev' );
						return false;
					}
				} );

				// add keyboard events
				$( document ).keydown( function(e) {
					var keyCode = e.keyCode || e.which,
						arrow = {
							left : 37,
							up : 38,
							right : 39,
							down : 40
						};

					switch (keyCode) {
						case arrow.left:
							config.$bookBlock.bookblock( 'prev' );
							break;
						case arrow.right:
							config.$bookBlock.bookblock( 'next' );
							break;
					}
				} );
			};

		return { init : init };
	})();

	Page.init();

	$('.wrapper3 .ellipsis').each( function(index, element) {
		$(this).data('value', $(this).find('.text').text() );
	});

	$('.ellipsis .readmore').click( function(e){
		var self = this;
		e.preventDefault();
		$('.fullReview').modal().open({

			closeOnOverlayClick: false,
			onOpen: function(el, options){

				var modal = $(el).find('.modal');

				modal.append( '<div class="title">' +  $(self).closest('.reviewText').prev('.reviewName').text()  + '</div>' );
				modal.append( '<div class="comment">' + $(self).closest('.ellipsis').data('value') + '</div>' );

				if ( modal.outerHeight(true) + 55 < $(window).height() ) {
					modal.css('margin-top', -(modal.outerHeight(true))/2);
				}
				else {
					modal.css({ 'margin-top': '55px', 'top': 0 });

				}
			}
		});

		$('.themodal-overlay').hide().stop().fadeIn(400);
	});

	$('.bb-item:visible .ellipsis').dotdotdot({
		wrap: 'word',
		watch: 'window',
		after: 'a.readmore'
	});
});


