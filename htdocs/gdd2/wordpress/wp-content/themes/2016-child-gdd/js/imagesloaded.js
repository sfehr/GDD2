jQuery(document).ready(function($) {

var $container = $('#isotope-list');

$container.imagesLoaded( function(){ 
	$container.masonry({ 
		itemSelector: '.thirties', columnWidth: 3
		}); 
}); 