	$(document).ready(function() {

		var sync1 = $('#sync1');
		var sync2 = $('#sync2');

		sync1.owlCarousel({
			singleItem : true,
			slideSpeed : 1000,
			navigation: true,
			lazyLoad : true,
			pagination:false,
			navigationText: ['', ''],
			afterAction : syncPosition
			
		});

		sync2.owlCarousel({
			items : 4,
			pagination:false,
			lazyLoad : true,
			afterInit : function(el){
				el.find(".owl-item").eq(0).addClass("synced");
			}
		});

		$('.owl-theme').on('click', '.owl-prev, .owl-next', function(){
			$(this).fadeTo(0, 0.7).fadeTo(1500, 1);
		});
		

		$('#sync2').on('click', '.owl-item', function(e){
			e.preventDefault();
			var number = $(this).data('owlItem');
			sync1.trigger("owl.goTo",number);
		});
		
		
		function center(number) {
			var sync2visible = sync2.data("owlCarousel").owl.visibleItems;

			var num = number;
			var found = false;
			for(var i in sync2visible){
				if( num === sync2visible[i] ){
					var found = true;
				}
			}

			if( found===false ){
				if(num>sync2visible[sync2visible.length-1]){
					sync2.trigger("owl.goTo", num - sync2visible.length+2)
				}
				else {
					if(num - 1 === -1){
						num = 0;
					}
					sync2.trigger("owl.goTo", num);
				}
			} 
			else if( num === sync2visible[sync2visible.length-1] ) {
				sync2.trigger("owl.goTo", sync2visible[1])
			} 
			else if(num === sync2visible[0]){
				sync2.trigger("owl.goTo", num-1)
			}
		}
	
		function syncPosition(el){
			var current = this.currentItem;
			$('#sync2')
				.find(".owl-item")
				.removeClass("synced")
				.eq(current)
				.addClass("synced");

			if ( $("#sync2").data("owlCarousel") !== undefined ) {
				center(current)
			}
		}
    });
