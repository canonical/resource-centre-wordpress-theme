jQuery(document).ready(function($){

// for single articles	
if ($('.article-list').hasClass('infinitescroll')) {

	$('.prev-post').each(function() {
	    var text = $(this).text();
	    $(this).text(text.replace('Older Entries', 'Load more')); 
	    $(this).addClass("load-more");
	});

	$(function() {
	  var $resultcontainer = $('.article-list');
		  $resultcontainer.infinitescroll({
		    navSelector  	: '.navigation',    // selector for the paged navigation 
		    nextSelector 	: '.navigation .nav-previous a',  // selector for the NEXT link (to page 2)
		    itemSelector 	: '.article',     // selector for all items you'll retrieve
		    animate     	: true,
		    loader				: '',
		    behavior 	 		: 'twitter',
		    loading: {
					msgText				: 'Loading more posts...',
					finishedMsg		: '<p class="loaded">All posts are loaded</p>'
				}
			});
		});
	}
});