function redirect(url) {
	document.location.href = url;
}

function jumpTo(id){
	document.location.hash='#'+id;
}

function submitForm(formId){
	document.getElementById(formId).submit();
}

function login(url){
	document.location.hash='#login';
	var username=document.getElementById("username");
	if(username!=null){
		username.focus();
	}else{
		redirect(url);
	}
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

function changeShop(select){
	 redirect(select.options[select.selectedIndex].value);
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

function getFileUploadName(fileId,inputId) {
	var fileUpload = document.getElementById(fileId);
	var inputId = document.getElementById(inputId);	
		var name = fileUpload.value.substring(fileUpload.value
				.lastIndexOf("\\"), fileUpload.value.length);
		inputId.value= name;
}

function changeColorOver(id) {
	// dojo.query(".over").removeClass("over");
	$("#"+id).addClass("hover");
}
function changeColorOut(id) {
	// dojo.query(".over").removeClass("over");
	$("#"+id).removeClass("hover");
}

function loadItemForCategory(select,url){
	var selected=select.options[select.selectedIndex].value;
	if(selected!=0){
		redirect(url+'?c='+selected);
	}else{
		redirect(url);
	}
}
