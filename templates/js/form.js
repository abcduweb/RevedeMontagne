/*
Auteur : karamilo
Derniere version : 30 juin 2005
Mail : pierre@bleu-provence.com
Si vous trouvez des bugs/commentaires, merci de me le signaler !
*/

var antiflood = false;	
var last = 0;

var smilies = new Array(':magicien:',':colere:',':diable:',':ange:',':ninja:',':-:',':pirate:',':zorro:',':honte:',':soleil:',':\'\\(',':waw:',':\\)',':D',';\\)',
			':p',':lol:',':euh:',':\\(',':o',':colere2:','o_O','\\^\\^',':\\-°');
var smilies_url = new Array('magicien.png','angry.gif','diable.png','ange.png','ninja.png','pinch.png','pirate.png','zorro.png','rouge.png','soleil.png',
			'pleure.png','waw.png','smile.png','heureux.png','clin.png','langue.png','rire.gif','unsure.gif','triste.png','huh.png','mechant.png',
			'blink.gif','hihi.png','siffle.png');

	function storeCaret(id_textarea)
	{ 
	champ = document.getElementById(id_textarea);
		if (champ.createTextRange)
		champ.curseur = document.selection.createRange().duplicate();
	}
	
	function balise(balise_debut, balise_fin, id_textarea)
	{
	var champ = document.getElementById(id_textarea);
	var scroll = champ.scrollTop;
	
	if(balise_fin == '')
		balise_debut = ' ' + balise_debut + ' ';

		if (champ.curseur)
		{
		champ.curseur.text = balise_debut + champ.curseur.text + balise_fin;
		}
		else if (champ.selectionStart >= 0 && champ.selectionEnd >= 0)
		{
		var debut = champ.value.substring(0, champ.selectionStart);
		var entre = champ.value.substring(champ.selectionStart, champ.selectionEnd);
		var fin = champ.value.substring(champ.selectionEnd);
		champ.value = debut + balise_debut + entre + balise_fin + fin;
		champ.focus();
		champ.setSelectionRange(debut.length + balise_debut.length, champ.value.length - fin.length - balise_fin.length);
		}
		else
		{
		champ.value  += balise_debut + balise_fin;
		champ.focus();
		}
	champ.scrollTop = scroll;
	}
	
	function parse(id_textarea, id_prev)
	{
		if (document.getElementById('activ_'+id_textarea).checked)
		{
		clearTimeout(last);
		last = setTimeout('parse2(\''+id_textarea+'\',\''+id_prev+'\')',100);
		antiflood = true;
		}
	}

	function parse2(id_textarea, id_prev)
	{
	var champ = document.getElementById(id_textarea);
	var div_prev = document.getElementById(id_prev);
	var contenu = champ.value;
	antiflood = false;
		if (document.body.scrollTop)
		var scroll = document.body.scrollTop;
		else
		var scroll = window.pageYOffset;

	contenu = contenu.replace(/&/g,'&amp;');

		if (champ.selectionStart != 'undefined' && !champ.curseur)
		{
		var pos = champ.selectionStart;
		contenu = remplace(remplace(contenu.substring(0, pos),'>','&gt;'),'<','&lt;') + '<a href="#" name="prev_ancre_suivi" id="prev_ancre_suivi"></a>' + 
		remplace(remplace(contenu.substring(pos),'>','&gt;'),'<','&lt;');
		}
		else
		contenu = remplace(remplace(contenu,'>','&gt;'),'<','&lt;');

	var reg = '';
		for (i=0;i<smilies.length;i++)
		{
		eval('reg = /(\\s|\\r|^|&gt;)'+smilies[i]+'(\\s|\\r|$|&lt;)/g');
		contenu = contenu.replace(reg, '$1<img src="images/smilies/'+smilies_url[i]+'" alt="Smiley" class="smilies" />$2');
		}

	contenu = remplace(contenu, "\n", '<br />');
/*
	var re = /([\s\S]+)&lt;code&gt;([\s\S]*?)&lt;\/code&gt;([\s\S]+)/;
	var smil = '';
		while (tableau = re.exec(contenu))
		{
			for (i=0;i<smilies.length;i++)
			{
			smil = '';
				for (j=0;j<smilies[i].length;j++)
				smil += '&#'+smilies[i].charCodeAt(j)+';';
			tableau[2] = remplace(tableau[2], smilies[i], smil);
			}
		contenu = tableau[1]+'<br /><span class="code">Code</span><div class="code2">'+remplace(tableau[2],'&lt;', '&#60;')+'</div>'+tableau[3];
		}

	re = /([\s\S]+)&lt;code type=\"(actionscript|csharp|matlab|qbasic|ada|mpasm|smarty|apache|css|nsis|sql|asm|delphi|objc|vbnet|asp|diff|oobas|vb|bash|d|oracle8|vhdl|caddcl|html|pascal|visualfoxpro|cadlisp|java|perl|xml|c_mac|javascript|php-brief|c|lisp|php|cpp|lua|python)\"&gt;([\s\S]*?)&lt;\/code&gt;([\s\S]+)/;
		while (tableau = re.exec(contenu))
		{
			for (i=0;i<smilies.length;i++)
			{
			smil = '';
				for (j=0;j<smilies[i].length;j++)
				smil += '&#'+smilies[i].charCodeAt(j)+';';
			tableau[3] = remplace(tableau[3], smilies[i], smil);
			}
		contenu = tableau[1]+'<br /><span class="code">Code : '+tableau[2]+'</span><div class="code2">'+remplace(tableau[3],'&lt;', '&#60;')+'</div>'+tableau[4];
		}
*/	
	contenu = contenu.replace(/&lt;gras&gt;([\s\S]*?)&lt;\/gras&gt;/g, '<strong>$1</strong>');
	contenu = contenu.replace(/&lt;titre1&gt;([\s\S]*?)&lt;\/titre1&gt;/g, '<h3 class="titre1">$1</h3>');
	contenu = contenu.replace(/&lt;titre2&gt;([\s\S]*?)&lt;\/titre2&gt;/g, '<h4 class="titre2">$1</h4>');
	contenu = contenu.replace(/&lt;souligne&gt;([\s\S]*?)&lt;\/souligne&gt;/g, '<span class="souligne">$1</span>');
	contenu = contenu.replace(/&lt;italique&gt;([\s\S]*?)&lt;\/italique&gt;/g, '<span class="italique">$1</span>');
	contenu = contenu.replace(/&lt;barre&gt;([\s\S]*?)&lt;\/barre&gt;/g, '<strike>$1</strike>');
	contenu = contenu.replace(/&lt;couleur nom="(orange|noir|marron|vertf|olive|marine|violet|bleugris|argent|gris|rouge|vertc|jaune|bleu|rose|turquoise|blanc)"&gt;([\s\S]*?)&lt;\/couleur&gt;/g, '<span class="$1">$2</span>');
	contenu = contenu.replace(/&lt;police nom="(arial|times|courrier|impact|geneva|optima)"&gt;([\s\S]*?)&lt;\/police&gt;/g, '<span class="$1">$2</span>');
	contenu = contenu.replace(/&lt;taille valeur="(ttpetit|tpetit|petit|gros|tgros|ttgros)"&gt;([\s\S]*?)&lt;\/taille&gt;/g, '<span class="$1">$2</span>');
	contenu = contenu.replace(/&lt;image&gt;([^"]*?)&lt;\/image&gt;/g, '<img src="$1" alt="Image" />');
	contenu = contenu.replace(/&lt;position valeur="(gauche|droite|centre|justifie)"&gt;([\s\S]*?)&lt;\/position&gt;/g, '<div class="$1">$2</div>');
	contenu = contenu.replace(/&lt;flottant valeur="(gauche|droite)"&gt;([\s\S]*?)&lt;\/flottant&gt;/g, '<div class="flot_$1">$2</div>');
	contenu = contenu.replace(/&lt;lien&gt;([\s\S]*?)&lt;\/lien&gt;/g, '<a href="$1">$1</a>');
	contenu = contenu.replace(/&lt;lien url="([\s\S]*?)"&gt;([\s\S]*?)&lt;\/lien&gt;/g, '<a href="$1">$2</a>');
	contenu = contenu.replace(/&lt;email&gt;([\s\S]*?)&lt;\/email&gt;/g, '<a href="mailto:$1">$1</a>');
	contenu = contenu.replace(/&lt;email addr="([\s\S]*?)"&gt;([\s\S]*?)&lt;\/email&gt;/g, '<a href="mailto:$1">$2</a>');
	contenu = contenu.replace(/&lt;(information|attention|erreur|question)&gt;([\s\S]*?)&lt;\/\1&gt;/g, '<div class="rmq $1">$2</div>');
	contenu = contenu.replace(/&lt;liste&gt;\s*(<br \/>)?\s*([\s\S]*?)\s*(<br \/>)?\s*&lt;\/liste&gt;/g, '<ul>$2</ul>');
	contenu = contenu.replace(/&lt;liste type="(disque|cercle|rectangle|rien)"&gt;\s*(<br \/>)?\s*([\s\S]*?)\s*(<br \/>)?\s*&lt;\/liste&gt;/g, '<ul class="liste_$1">$3</ul>');
	contenu = contenu.replace(/&lt;liste type="([1iIaA])"&gt;\s*(<br \/>)?\s*([\s\S]*?)\s*(<br \/>)?\s*&lt;\/liste&gt;/g, '<ol class="liste_$1">$3</ol>');
	contenu = contenu.replace(/&lt;puce&gt;([\s\S]*?)&lt;\/puce&gt;\s*(<br \/>)?\s*/g, '<li>$1</li>');
	contenu = contenu.replace(/&lt;acronyme valeur="([\s\S]*?)"&gt;([\s\S]*?)&lt;\/acronyme&gt;/g, '<acronym title="$1">$2</acronym>');

	var i = 0;
		while ((contenu.search(/&lt;citation nom=\"(.*?)\"&gt;([\s\S]*?)&lt;\/citation&gt;/g) != -1 || contenu.search(/&lt;citation&gt;([\s\S]*?)&lt;\/citation&gt;/g) != -1)
		&& i < 20)
		{
		contenu = contenu.replace(/&lt;citation nom=\"(.*?)\"&gt;([\s\S]*?)&lt;\/citation&gt;/g, '<br /><span class="citation">Citation : $1</span><div class="citation_2">$2</div>');
		contenu = contenu.replace(/&lt;citation&gt;([\s\S]*?)&lt;\/citation&gt;/g, '<br /><span class="citation">Citation</span><div class="citation_2">$1</div>');
		i++;
		}
	
	div_prev.innerHTML = contenu;
		if (document.getElementById('prev_ancre_suivi'))
		document.getElementById('prev_ancre_suivi').focus();
	document.getElementById(id_textarea).focus();
	}
	
	function remplace(data, search, replace)
	{
	var temp = data;
	var longueur = search.length;
		while (temp.indexOf(search) > -1)
		{
		pos = temp.indexOf(search);
		temp = (temp.substring(0, pos) + replace + temp.substring((pos + longueur), temp.length));
		}
	return temp;
	}
	
	function add_bal(nom, val, id_liste, id_textarea, id_prev)
	{
	bal = document.getElementById(id_liste).value;
		if (bal != '')
		balise('<'+nom+' '+val+'="'+bal+'">','</'+nom+'>', id_textarea);
		else
		balise('<'+nom+'>','</'+nom+'>', id_textarea);
	parse(id_textarea, id_prev);
		if (document.getElementById(id_liste))
		document.getElementById(id_liste).options[0].selected = true;
	}
	
	function add_bal2(nom, val, id_textarea, id_prev)
	{
	var texte = '';
		if (nom == 'citation')
		texte = 'Veuillez renseigner l\'auteur de la citation';
		else if (nom == 'lien')
		texte = 'Veuillez indiquer le lien';
		else if (nom == 'email')
		texte = 'Veuillez indiquer l\'email';
	bal = prompt(texte);
		if (!bal && nom == 'citation')
		bal = 'Pas de titre';
		if (bal)
		balise('<'+nom+' '+val+'="'+bal+'">','</'+nom+'>', id_textarea);parse(id_textarea, id_prev);
	
		if (document.getElementById(nom))
		document.getElementById(nom).options[0].selected = true;
	}
	
	function add_liste(id_textarea, id_prev)
	{
	var texte = '';
		while (tmp = prompt('Saisir le contenu d\'une puce (si vous voulez arreter ici, cliquez sur annuler)'))
		texte += '<puce>'+tmp+'</puce>'+"\n";
	balise('<liste>'+"\n"+texte,'</liste>', id_textarea);parse(id_textarea, id_prev);
	}

	function ouvrir_page(page,nom,x,y)
	{
		window.open(page,nom,'toolbar=yes,personalbar=yes,titlebar=yes,location=yes,directories=yes,width='+x+',height='+y+',scrollbars=yes,resizable=yes');
	}
	
	function switch_activ(textarea,prev)
	{
	div = document.getElementById(prev);
		if (document.getElementById('activ_'+textarea).checked == true)
		{
		div.style.display = 'block';
		storeCaret(textarea);
		parse(textarea,prev);
		}
		else
		div.style.display = 'none';
	}

	function request_apercu(url,data,dir)
	{
		if(callInProgress(xmlhttp))
		setTimeout('request_apercu("' + url + '","' + data + '","' + dir + '")',100);
		
		else
		{
		data = escape(data);
		data = remplace(data, '+','%2B');
		return Xsend('POST',url,'texte=' + data +'&dir=' + escape(dir),true);
		}
	}

	function full_preview(id_textarea, id_prev_final, dir)
	{
	var button = document.getElementById('lancer_apercu_' + id_textarea);
	
	button.disabled = true;
	
	request_apercu('xml_getzcode.php',document.getElementById(id_textarea).value, dir);
	
	xmlhttp.onreadystatechange = function()
		{
		if (xmlhttp.readyState == 4)
			{
			if (xmlhttp.status == 200)
				document.getElementById(id_prev_final).innerHTML = xmlhttp.responseText;
			else
				document.getElementById(id_prev_final).innerHTML = an_error;
			}
		}
	
	button.disabled = false;
	}
	
	function ouvrir_page(page,nom,x,y)
	{
		window.open(page,nom,'toolbar=yes,personalbar=yes,titlebar=yes,location=yes,directories=yes,width='+x+',height='+y+',scrollbars=yes,resizable=yes');
	}
	
	function add_user()
	{	
		document.getElementById('dest').value += document.getElementById('recherche').value + "\r\n";
		document.getElementById('recherche').value = '';
	}