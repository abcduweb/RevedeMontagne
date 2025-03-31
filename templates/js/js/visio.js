function getXMLHTTP(){
	var xhr = null;
	if(window.XMLHttpRequest)
	{ // Firefox et autres
		xhr = new XMLHttpRequest();
	}
	else if(window.ActiveXObject)
	{ // Internet Explorer
		try
		{
			xhr = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(e)
		{
			try
			{
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(e1)
			{
				xhr = null;
			}
		}
	}
	else
	{ // XMLHttpRequest non supporté par le navigateur
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
	}

	return xhr;
}

function goClean(c){
	if(!c.data.replace(/\s/g,''))
		c.parentNode.removeChild(c);
}

function Xmlclean(d){
	var bal=d.getElementsByTagName('*');

	for(i=0;i<bal.length;i++){
		a=bal[i].previousSibling;
		if(a && a.nodeType==3)
			goClean(a);
		b=bal[i].nextSibling;
		if(b && b.nodeType==3)
			goClean(b);
	}
	return d;
} 

function get_rules(){
	if (!document.styleSheets) return;
	var regles=new Array();
	if (document.styleSheets[0].cssRules){
		regles=document.styleSheets[0].cssRules;
		return regles;
	}
	else if (document.styleSheets[0].rules){
		regles = document.styleSheets[0].rules;
		return regles;
	}
	else return
}

function resize_img(largeur,hauteur,speed,dir,file,com) {
	lastSize = new Array();
	regles = get_rules();
	
	lastSize[0] = parseInt(regles[2].style.width.replace('px',''));
	lastSize[1] = parseInt(regles[2].style.height.replace('px',''));
	if(largeur < lastSize[0]){
		i=lastSize[0];
		i = i - speed;
		if(i < largeur)i=largeur;
		regles[2].style.width = i + 'px';
		
		window.setTimeout("resize_img("+largeur+","+hauteur+","+speed+",'"+dir+"','"+file+"')", 1);
	}
	else if(largeur > lastSize[0]){
		i=lastSize[0];
		i= i + speed;
		if(i>largeur)i=largeur;
		
		regles[2].style.width = i + 'px';
		window.setTimeout("resize_img("+largeur+","+hauteur+","+speed+",'"+dir+"','"+file+"')", 1);
	}else{
		if(hauteur < lastSize[1]){
			i=lastSize[1];
			i = i - speed;
			if(i < hauteur)i=hauteur;
			regles[2].style.height = i + 'px';
			window.setTimeout("resize_img("+largeur+","+hauteur+","+speed+",'"+dir+"','"+file+"')", 1);
		}else if(hauteur > lastSize[1]){
			i=lastSize[1];
			i= i+speed;
			if(i>hauteur)i=hauteur;
			regles[2].style.height = i + 'px';
			window.setTimeout("resize_img("+largeur+","+hauteur+","+speed+",'"+dir+"','"+file+"')", 1);
		}else{
			display(dir,file);
			document.getElementById('photo').style.width = largeur + 'px';
			document.getElementById('photo').style.height = hauteur + 'px';
			return;
		}
	}
}

function display(dir,file){
	imgPreloader = new Image();
	imgPreloader.onload=function(){
		regles = get_rules();
		regles[2].style.border = 'none';
		document.getElementById('photo').src = 'images/album/'+dir+'/'+file;
		document.getElementById('photo').alt = file;
		Element.show('photo');
	}
	imgPreloader.src = 'images/album/'+dir+'/'+file;
}

function get_next(){
	if(current_img + 1 > nb_img - 1)
		return 0;
	else
		return current_img + 1;
}

function get_prev(){
	if(current_img - 1 < 0) 
		return nb_img - 1;
	else
		return current_img - 1;
}

function next_photo()
{
	current_img++;
	if(current_img > nb_img - 1) current_img = 0;
	load_img(current_img);
}

function prev_photo()
{
	current_img--;
	if(current_img < 0) current_img = nb_img - 1;
	load_img(current_img);
}

function diapo() {
	if (on_diapo == 1) {
		next_photo();
		window.setTimeout("diapo()", rotate_delay);
	}
}

function start_diapo()
{
	if(on_diapo == 1){
		on_diapo = 0;
		document.getElementById('launchstop').innerHTML = 'Lancer le diaporama';
	}
	else{
		on_diapo = 1;
		document.getElementById('launchstop').innerHTML = 'Arrêter le diaporama';
	}
	window.setTimeout("diapo()", rotate_delay);
}

function setTime(time){
	rotate_delay = time * 1000;
}