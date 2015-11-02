Drupal.behaviors.discernLoadMore = {
  attach: function(context, settings) {
	$('.pager-load-more a').each(function() {
	  //console.log($(this).html());
	  if ($(this).html() == 'Load more small' || $(this).html() == 'Load more vertical') {
		//console.log($(this));
		$(this).hide();  
	  }

	  $('div').filter(function() {
		return $.trim($(this).text()) === 'No'
	  }).hide();

	  $('div .spon').filter(function() {
		return $.trim($(this).text()) === ''
	  }).hide();

	});

  }
};
