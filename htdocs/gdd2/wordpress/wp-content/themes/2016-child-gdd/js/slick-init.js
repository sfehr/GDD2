jQuery(function($) {
	
	var images = [];
	var current_image_index;
	
	
	//OBJECT COSTRUCTOR
	function Image( src, srcset, sizes ) {
		this.src = src;
		this.srcset = srcset;
//		this.index = index;
		this.sizes = sizes;
		this.imageTag = function( prefix = '', suffix = '' ) {
			return prefix + '<img src="'+ this.src +'" srcset="'+ this.srcset +'" sizes="(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px">' + suffix ;
		};
	}
	
	// INITIALIZER
	$('.gallery .gallery-icon img').on('click', function() {
		
		//find all images in the gallery
		var gallery_images = $('.gallery').find('.gallery-icon img');
		
		//get src of clicked image
		var current_img_src = $(this).attr('src');
		
		//dynamically create the image objects
		gallery_images.each(function( index ) {
			
			images[index] = new Image( $( this ).attr('src'), $( this ).attr('srcset'), $( this ).attr('sizes') );

			// get the index of the clicked image
			if( current_img_src == $( this ).attr('src')){
				
				current_image_index = index;
				
			}
		});
		
		// create HTML 
		// div container
		$('body').append('<div class="lightbox-container"></div>');
		
		//images
		images.map(function( img ) {
			$('body .lightbox-container').append( img.imageTag('<div class="lightbox-slide invisible">', '</div>') );
		});
	
		//add nav buttons
		$('body .lightbox-container').append('<button class="btn-left"></button><button class="btn-right"></button><button class="btn-close"></button>');
			
		//call index handler
		index_handler(current_image_index);
	});	
	
	
	
	//INDEX HANDLER
	var index_handler = function(index, direction = null){
		
		var lightbox_slides = $('body').find('.lightbox-slide');
		
		if(direction !== null){
			
			if( (lightbox_slides.length > (index + direction) ) && ( (index + direction) >= 0) ) {
				
				//sets current slide invisible again
				lightbox_slides.eq(index).toggleClass( 'invisible' );
				
				//calculate new index
				index += direction;
				
				//sets new indexed slide visible
				lightbox_slides.eq(index).toggleClass( 'invisible' );

				//updates index (global variable)
				current_image_index = index;
			}
			
		}else{
			// toggles class of the clicked image (witout direction), just 1 time
			lightbox_slides.eq(index).toggleClass( 'invisible' );
		}
		
		// resets direction variable
		direction = null;
	};
	
	
	//CLOSING FUNCTION
	var close_all = function(){
		$('.lightbox-container').empty();
		$('.lightbox-container').remove();
	};
	
	
	//BUTTON EVENT LISTENER
	$('body').on('click', 'button', function() {
		//prev
		if( $(this).attr('class') == 'btn-left'){
			index_handler(current_image_index, -1);
		}
		//next
		if( $(this).attr('class') == 'btn-right'){
			index_handler(current_image_index, +1);
		}
		//close
		if( $(this).attr('class') == 'btn-close'){
			close_all();
		}
	});
	
	
	//SLIDE BG EVENT LISTENER
/*	
	$('body').on('click', function(e) {
		if ( $(e.target).has('.lightbox-slide img').length ) {
			close_all();
		}
	});
*/	
	
	//KEY EVENT LISTENER
	$('body').on('keydown', '', function(e) {	
		if (e.keyCode === 37) {
			// Left Key
			$('.btn-left').addClass('pulsuate-left');
			index_handler(current_image_index, -1);
		}
		if (e.keyCode === 39) {
			// Right Key
			$('.btn-right').addClass('pulsuate-right');
			index_handler(current_image_index, 1);
		}
		if (e.keyCode === 27) {
			// ESC Key
			$('.btn-close').addClass('pulsuate-esc');
		}		
	});
	
	//Remove pulsuate class
	$('body').on('keyup', '', function(e) {
		if (e.keyCode === 37) {
			// Left Key
			$('.btn-left').removeClass('pulsuate-left');
		}		
		if (e.keyCode === 39) {
			// Right Key
			$('.btn-right').removeClass('pulsuate-right');
		}
		if (e.keyCode === 27) {
			// ESC Key
			$('.btn-close').removeClass('pulsuate-esc');
			close_all();
		}		
	});
	
	
	///////////////////////////
	// Swipe functionality
	//////////////////////////	

	// create a simple instance
	var mc = new Hammer(container[0]);

	// listen to events...
	mc.on("swipeleft swiperight", function(ev) {
		if (ev.type == "swipeleft"){		
			plusSlides(1);
		}
		if (ev.type == "swiperight"){		
			plusSlides(-1);
		}
	});	
	
	
});	//END SKRITP


	// gray bg click 
	// break points
// swiping
