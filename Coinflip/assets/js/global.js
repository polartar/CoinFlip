 
function getCookie(key){
	var patt = new RegExp(key+"=([^;]*)");
	var matches = patt.exec(document.cookie);
	if(matches){
		return matches[1];
	}
	return "";
}
