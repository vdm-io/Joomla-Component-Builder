###BOM###

function updateDropboxLinks(){
	var getUrl = "index.php?option=com_###component###&task=ajax.updateDropboxLinks&format=json";
	if(token.length > 0 ){
		var request = 'token='+token+'&now=1';
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}

// Initial Script
jQuery(document).ready(function(){
	//  update Dropbox Local links
	updateDropboxLinks();
});
