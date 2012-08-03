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

function getFileUploadName(fileId, inputId) {
	var fileUpload = document.getElementById(fileId);
	var inputId = document.getElementById(inputId);
	var name = fileUpload.value.substring(fileUpload.value.lastIndexOf("\\"),
			fileUpload.value.length);
	inputId.value = name;
}