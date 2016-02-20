jQuery(document).ready(function() {
	jQuery('#tour_favorite').click(function() {
		if (jQuery(this).attr('rel') == 'no') {
			jQuery('#tour_favorite').removeClass('favorite_inactive')
			.addClass('favorite_active').attr('rel', 'yes');
		} else {
			jQuery('#tour_favorite').removeClass('favorite_active')
			.addClass('favorite_inactive').attr('rel', 'no');
		};
	});
});
