function insere(id_textarea, image_link, legende)
{
var champ = opener.document.getElementById(id_textarea);
var scroll = champ.scrollTop;

if(arguments.length > 3)
	{
	image = '<lien url="' + image_link + '"><image';
		if (legende != '')
		image += ' legende="'+legende+'"';
	image += '>' + arguments[3] + '</image></lien>';
	}
else
	{
	image = '<image';
		if (legende != '')
		image += ' legende="'+legende+'"';
	image +='>'+image_link+'</image>';
	}

	if (champ.curseur)
	{
	champ.curseur.text = image;
	}
	else if (champ.selectionStart != 'undefined' && champ.selectionEnd != 'undefined')
	{
	var debut = champ.value.substring(0, champ.selectionStart);
	var fin = champ.value.substring(champ.selectionEnd);
	champ.value = debut + image + fin;
	champ.focus();
	champ.setSelectionRange(debut.length + image.length, champ.value.length - fin.length);
	}
	else
	{
	champ.value  += image;
	champ.focus();
	}
champ.scrollTop = scroll;

var champ = opener.document.getElementById(id_textarea);
var div_prev = opener.document.getElementById('prev_'+id_textarea);
var contenu = champ.value;

	if (document.body.scrollTop)
	var scroll = opener.document.body.scrollTop;
	else
	var scroll = opener.document.window.pageYOffset;

	if (champ.selectionStart != 'undefined' && !champ.curseur)
	{
	var pos = champ.selectionStart;
	contenu = remplace(remplace(contenu.substring(0, pos),'>','&gt;'),'<','&lt;') + '<a href="#" name="prev_ancre_suivi" id="prev_ancre_suivi"></a>' + remplace(remplace(contenu.substring(pos),'>','&gt;'),'<','&lt;');
	}
	else
	contenu = remplace(remplace(contenu,'>','&gt;'),'<','&lt;');

contenu = remplace(contenu, "\n", '<br />');

contenu = contenu.replace(/&lt;code=(html|php|sql|c|c\+\+|javascript|actionscript|java)&gt;([\s\S]+?)&lt;\/code&gt;/g, '<span class="code">Code</span><div class="code2 $1">$2</div>');
contenu = contenu.replace(/&lt;gras&gt;([\s\S]+?)&lt;\/gras&gt;/g, '<strong>$1</strong>');
contenu = contenu.replace(/&lt;souligne&gt;([\s\S]+?)&lt;\/souligne&gt;/g, '<span class="souligne">$1</span>');
contenu = contenu.replace(/&lt;italique&gt;([\s\S]+?)&lt;\/italique&gt;/g, '<span class="italique">$1</span>');
contenu = contenu.replace(/&lt;barre&gt;([\s\S]+?)&lt;\/barre&gt;/g, '<strike>$1</strike>');
contenu = contenu.replace(/&lt;couleur=(orange|noir|marron|vertf|olive|marine|violet|bleugris|argent|gris|rouge|vertc|jaune|bleu|rose|turquoise|blanc)&gt;([\s\S]+?)&lt;\/couleur&gt;/g, '<span class="$1">$2</span>');
contenu = contenu.replace(/&lt;police=(arial|times|courrier|impact|geneva|optima)&gt;([\s\S]+?)&lt;\/police&gt;/g, '<span class="$1">$2</span>');
contenu = contenu.replace(/&lt;taille=(ttpetit|tpetit|petit|gros|tgros|ttgros)&gt;([\s\S]+?)&lt;\/taille&gt;/g, '<span class="$1">$2</span>');
contenu = contenu.replace(/&lt;image[ \w="]*&gt;(.+?)&lt;\/image&gt;/g, '<img src="$1" alt="Image" />');
contenu = contenu.replace(/&lt;position=(gauche|droite|centre|justifie)&gt;([\s\S]+?)&lt;\/position&gt;/g, '<div class="$1">$2</div>');
contenu = contenu.replace(/&lt;lien&gt;(.+?)&lt;\/lien&gt;/g, '<a href="$1">$1</a>');
contenu = contenu.replace(/&lt;lien=(.+?)&gt;(.+?)&lt;\/lien&gt;/g, '<a href="$1">$2</a>');
contenu = contenu.replace(/&lt;email&gt;(.+?)&lt;\/email&gt;/g, '<a href="mailto:$1">$1</a>');
contenu = contenu.replace(/&lt;email=(.+?)&gt;(.+?)&lt;\/email&gt;/g, '<a href="mailto:$1">$2</a>');
contenu = contenu.replace(/&lt;(information|attention|erreur|question)&gt;([\s\S]+?)&lt;\/\1&gt;/g, '<div class="rmq $1">$2</div>');
contenu = contenu.replace(/&lt;liste&gt;\s*(<br \/>)?\s*([\s\S]+?)\s*(<br \/>)?\s*&lt;\/liste&gt;/g, '<ul>$2</ul>');
contenu = contenu.replace(/&lt;puce&gt;([\s\S]+?)&lt;\/puce&gt;\s*(<br \/>)?\s*/g, '<li>$1</li>');
contenu = contenu.replace(/&lt;flash=(\d+)\*(\d+)&gt;(.+?)&lt;\/flash&gt;/g, '<object  type="application/x-shockwave-flash" data="$3" width="$1" height="$2"><param name="movie" value="$3" /><param name="quality" value="high" />Animation flash</object>');

var i = 0;
	while ((contenu.search(/&lt;citation (nom|rid)=\"(.*?)\"&gt;([\s\S]*?)&lt;\/citation&gt;/g) != -1 || contenu.search(/&lt;citation&gt;([\s\S]*?)&lt;\/citation&gt;/g) != -1)
	&& i < 20)
	{
	contenu = contenu.replace(/&lt;citation (nom|rid)=\"(.*?)\"&gt;([\s\S]*?)&lt;\/citation&gt;/g, '<br /><span class="citation">Citation : $2</span><div class="citation2">$3</div>');
	contenu = contenu.replace(/&lt;citation&gt;([\s\S]*?)&lt;\/citation&gt;/g, '<br /><span class="citation">Citation</span><div class="citation2">$1</div>');
	i++;
	}

contenu = remplace(contenu, ':)', '<img src="Templates/images/smilies/smile.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':D', '<img src="Templates/images/smilies/heureux.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ';)', '<img src="Templates/images/smilies/clin.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':p', '<img src="Templates/images/smilies/langue.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':lol:', '<img src="Templates/images/smilies/rire.gif" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':euh:', '<img src="Templates/images/smilies/unsure.gif" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':(', '<img src="Templates/images/smilies/triste.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':o', '<img src="Templates/images/smilies/huh.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':colere:', '<img src="Templates/images/smilies/mechant.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, 'o_O', '<img src="Templates/images/smilies/blink.gif" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, '^^', '<img src="Templates/images/smilies/hihi.png" alt="Smiley" class="smilies" />');
contenu = remplace(contenu, ':-°', '<img src="Templates/images/smilies/siffle.png" alt="Smiley" class="smilies" />');

div_prev.innerHTML = contenu;
	if (opener.document.getElementById('prev_ancre_suivi'))
	opener.document.getElementById('prev_ancre_suivi').focus();
opener.document.getElementById(id_textarea).focus();
}

var monCalque = null;

//fonction qui simplifie la vie de http://www.siteduzero.com/membres-294-15762.html
function addEvent(obj,event,fct){
if( obj.attachEvent)
		obj.attachEvent('on' + event,fct);
else
		obj.addEventListener(event,fct,true);
}

function init(){
	obj = document.getElementById('calquePhoto1');
	addEvent(obj,"mousemove",drag);
	addEvent(obj,"mouseup",drop);
	addEvent(obj,"mousedown",function (event){
		//astuce de http://www.siteduzero.com/membres-294-15762.html pour chercher la si on est bien ou il faut.
		var target = event.target || event.srcElement;
		var element = target;
		while(element){
			if( element.id && element.id == 'calquePhoto'){
				start(element,event);
				element = false;
			}
			else
				element = element.parentNode;
		}
	});
	
} 
function start(e,event){
	event.returnValue = false;
	if( event.preventDefault ) event.preventDefault();
	monCalque = document.getElementById('calquePhoto1');
	imSrc = e.src;
	imId = e.id;
	imWidth = e.width;
	imHeight = e.height;
	monCalque.X = monCalque.style.left;
	monCalque.X = monCalque.X.substring(0,monCalque.X.length-2);
	monCalque.Y = monCalque.style.top;
	monCalque.Y = monCalque.Y.substring(0,monCalque.Y.length-2);
	var x = event.clientX + (document.body.scrollLeft || document.documentElement.scrollLeft);
	var y = event.clientY + (document.body.scrollTop || document.documentElement.scrollTop);
}

function setSize(event,borderStyle,delCalque){
	if(monCalque){
		imWidth = event.clientX - monCalque.X;
		imHeight = event.clientY - monCalque.Y;
		var img = document.getElementById(imId);
		img.style.border = borderStyle;
		img.style.width = imWidth + 'px';
		img.style.height = imHeight + 'px';
		document.getElementById('nWidth').value = imWidth;
		document.getElementById('nHeight').value = imHeight;
		if(delCalque)
			monCalque = null;
		else{
			var x = event.clientX + (document.documentElement.scrollLeft + document.body.scrollLeft);
			var y = event.clientY + (document.documentElement.scrollTop + document.body.scrollTop);
		}
		return false;
	}
}

function drag(e){
	return setSize(e,"solid black 1px",false);
} 

function drop(e){
	return setSize(e,"none",true);
} 

function widthChange(object){
	var img = document.getElementById('calquePhoto');
	img.style.width = object.value +'px';
	document.getElementById('nHeight').value = img.height;
}

function heightChange(object){
	var img = document.getElementById('calquePhoto');
	img.style.height = object.value + 'px';
	document.getElementById('nWidth').value = img.width;
}