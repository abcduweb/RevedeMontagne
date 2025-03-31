function load_photos(){
	tooltip._tooltipElement.innerHTML = '<img src="'+tooltip._backupTips+'" alt="'+tooltip._backupTips+'" />';
	
	text = escapeURI(tooltip._backupTips);
	var var_transmettre = "id="+text;
	XHR.send(var_transmettre);	
}