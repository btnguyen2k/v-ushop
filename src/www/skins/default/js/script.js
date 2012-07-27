function redirect(url) {
	document.location.href = url;
}

function confirmPassword(value, constraints) {
	var isValid = false;
	if (constraints && constraints.other) {
		var otherInput = dijit.byId(constraints.other);
		if (otherInput) {
			var otherValue = otherInput.value;
			isValid = (value == otherValue);
		}
	}
	return isValid;
}


/*fix-content*/
/*	jQuery(document).ready(function(){
		var sideAd = jQuery("#fix-top");
		var sideAdTopOrg = sideAd.offset().top;
		var doc = jQuery(document);
		
		jQuery(window).scroll(function() {
			diff = doc.scrollTop() - sideAdTopOrg;
			if(diff < 0)
				sideAd.offset({top: sideAdTopOrg});
			else
				sideAd.offset({top: doc.scrollTop() + 10});
		});
	});*/
$(document).ready(function(){	

	if (!$.browser.opera) {

		// select element styling
		$('select.select').each(function(){
			var title = $(this).attr('title');
			if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
			$(this)
				.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
				.after('<span class="select">' + title + '</span>')
				.change(function(){
					val = $('option:selected',this).text();
					$(this).next().text(val);
					})
		});

	};
	
});