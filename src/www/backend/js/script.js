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
