var div;
var mouseX;
var mouseY;
var backupTips;
var htmlelement;

var tooltip = {
    id:"tooltip",
    offsetx : 10,
    offsety : 10,
    _x : 0,
    _y : 0,
    _tooltipElement:null,
    _saveonmouseover:null,
	_backupTips:null,
	_htmlelement:null
}

tooltip.show = function (htmlelement, style_id, fcallback) {
	style_id = (style_id) ? style_id : 'tooltips';
    var text = htmlelement.getAttribute("title");
	this._htmlelement = htmlelement;
	this._backupTips = text;
    htmlelement.setAttribute("title","");
	
	text.replace('&gt;','>');
	text.replace('&lt;','<');
	text.replace('&amp;quot;','"');
	text.replace('&amp;','&');
	text.replace("\'","'");
	
	this._tooltipElement = document.createElement('div');
	this._tooltipElement.setAttribute("id",style_id);

    this._saveonmouseover = document.onmousemove;
    document.onmousemove = this.mouseMove;

    this._tooltipElement.innerHTML = text;

    this.moveTo(this._x + this.offsetx , this._y + this.offsety);
    document.getElementsByTagName('body')[0].insertBefore(this._tooltipElement,document.getElementsByTagName('body')[0].firstChild);
	Element.hide(style_id);
	new Effect.Appear(style_id,{duration: 0.5});
	if(htmlelement.attachEvent)
		htmlelement.attachEvent('onmouseout',tooltip.hide);
	else
		htmlelement.addEventListener('mouseout',tooltip.hide,true);
	fcallback = (fcallback) ? fcallback : false;
	eval(fcallback);
	return false;
}

tooltip.hide = function () {
    tooltip._htmlelement.setAttribute("title",tooltip._backupTips);
	document.getElementsByTagName('body')[0].removeChild(tooltip._tooltipElement);
    document.onmousemove=tooltip._saveonmouseover;
}

tooltip.mouseMove = function (e) {
    if(e == undefined)
        e = event;

    if( e.pageX != undefined){ // gecko, konqueror,
        tooltip._x = e.pageX;
        tooltip._y = e.pageY;
    }else if(event != undefined && event.x != undefined && event.clientX == undefined){ // ie4 ?
        tooltip._x = event.x;
        tooltip._y = event.y;
    }else if(e.clientX != undefined ){ // IE6,  IE7, IE5.5
        if(document.documentElement){
            tooltip._x = e.clientX + ( document.documentElement.scrollLeft || document.body.scrollLeft);
            tooltip._y = e.clientY + ( document.documentElement.scrollTop || document.body.scrollTop);
        }else{
            tooltip._x = e.clientX + document.body.scrollLeft;
            tooltip._y = e.clientY + document.body.scrollTop;
        }
    /*}else if(event != undefined && event.x != undefined){ // IE6,  IE7, IE5.5
        tooltip.x = event.x + ( document.documentElement.scrollLeft || document.body.scrollLeft);
        tooltip.y = event.y + ( document.documentElement.scrollTop || document.body.scrollTop);
    */
    }else{
        tooltip._x = 0;
        tooltip._y = 0;
    }
    tooltip.moveTo( tooltip._x +tooltip.offsetx , tooltip._y + tooltip.offsety);

}

tooltip.moveTo = function (xL,yL) {
    if(this._tooltipElement.style){
        this._tooltipElement.style.left = xL +"px";
        this._tooltipElement.style.top = yL +"px";
    }else{
        this._tooltipElement.left = xL;
        this._tooltipElement.top = yL;
    }
}

function load_form(id, value){
	var formId;
	domObj = document.getElementById(id);
	xhr = getXMLHTTP();
	switch(value){
		case 'vierge':
			formId = 1;
		break;
		case 'topo':
			formId = 2;
		break;
		case 'ski_rando':
			formId = 3;
		break;
		case 'escalade':
			formId = 4;
		break;
		case 'alpinisme':
			formId = 5;
		break;
		case 'rocher':
			formId = 4;
		break;
		case 'rando':
			formId = 6;
		break;
		case 'cascade':
			formId = 7;
		break;
		case 'refuge':
			formId = 8;
		break;
		case '':
			return false;
		break;
	}
	if(!xhr)
	{
		return false;
	}else{
		domObj.innerHTML = '';
		domObj.style.width = 100 + '%';
		domObj.style.height = 50 +'px';
		domObj.style.backgroundImage = 'url(\'templates/ajax-loader.gif\')';
		domObj.style.backgroundRepeat  = 'no-repeat';
		domObj.style.backgroundPosition = 'center';
		
		xhr.open("POST", "ajax/load_form.php", true);
		xhr.onreadystatechange = function(){
			if (xhr.readyState == 4){
				if(xhr.responseText != 'false'){
					//reponse = Xmlclean(xhr.responseXML.documentElement);
					domObj.style.display = 'none';
					sizeDiv = document.createElement('div');
					sizeDiv.style.visibility = 'hidden';
					sizeDiv.innerHTML = xhr.responseText;
					document.getElementsByTagName('body')[0].appendChild(sizeDiv);
					domObj.style.height = sizeDiv.offsetHeight+'px';
					document.getElementsByTagName('body')[0].removeChild(sizeDiv);
					new Effect.BlindDown(id,{afterFinish:function(){
								domObj.innerHTML = xhr.responseText;
								domObj.removeAttribute('style');
							}
						}
					);
				}else{
					alert('Impossible d\'ouvrir le formulaire demandé');
					domObj.removeAttribute('style');
				}
			}
		}
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded;Charset=ISO-8859-1");
		var var_transmettre = "form="+formId;
		xhr.send(var_transmettre);
	}
}
