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
	