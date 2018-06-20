jQuery(document).ready(function ($) {

	var $container = $('#isotope-list'); //The ID for the list with all the blog posts	
	
	$container.imagesLoaded(function(){
	
		$container.isotope({ //Isotope options, 'item' matches the class in the PHP
			itemSelector : '.item', 
	//  		layoutMode : 'masonry',
			percentPosition: true,
			masonry: {
	//			gutter: 40,
				columnWidth: '.grid-sizer',
				gutter: '.gutter-sizer'
			}		
		}).resize(); // make sure there is no overlapping (imagesLoaded function)
		
	});

	//Add the class selected to the item that is clicked, and remove from the others
	var $optionSets = $('#main'),
	$optionLinks = $optionSets.find('a');

	$optionLinks.click(function(){
	var $this = $(this);
	// don't proceed if already selected
	// (old) if ( $this.hasClass('selected') ) {
	if ( $this.hasClass('selected') ) {	
	  return false;
	}
	//additional check: to avoid confusing animation trigger, when entry-title or entry-content link is clicked	
	else if( $this.parents().hasClass('entry-title') ||
	  		 $this.parents().hasClass('entry-content') ||
	    	 $this.hasClass('post-thumbnail') ){
	// do nothing (but jump to next page)
	}
	// de-selecting current filter item and selecting clicked filter item
	else{
		var $optionSet = $this.parents('#main');
		$optionSets.find('.selected').removeClass('selected');
		$this.addClass('selected');
		
		//When an item is clicked, sort the items.
		var selector = $(this).attr('data-filter');
		$container.isotope({ filter: selector });
	}		
	

/*	
	// scrolling back to top
//	scroll.scrollTop();
	$('body,html').animate({
			scrollTop: 0 ,
		 	}, 200
		);
*/	
	var src = $this.attr('href');
	if ( src === "#" ) {
//		alert('SRC: '+ src);		
		
		// scrolling back to top
		//	scroll.scrollTop();
		$('body,html').animate({
				scrollTop: 0 ,
				}, 200
		);		
		console.log("srolled to top");
		return false;
	}    
	//return false;
	});	
});