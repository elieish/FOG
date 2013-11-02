function loadpage(page, type) {
	
	
	
   if (page == ''){
		var page = prompt("Please enter the name of the new page:", "");
		loadpage(page, type);
	}

	else {
		$('#page_frame').attr('src','../editor.php?t=' + type + '&p='+page);

		var height = $('.page_list').height();
		$('#page_frame').height(height);
	}
}

function browse(type,file) {
	
	if (type == 'dir') {
		location.href='?p=file_manager&file='+file;
	}
	else {
		location.href='../content/files/' + file;
	}
}
function ajax_get_data(this_url) {
	// Get Response
	var new_html = $.ajax({
		url: this_url,
		async: false,
		dataType: "html"
	}).responseText;
	alert(new_html);
	// Return Response
	return new_html;
}