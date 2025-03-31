<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
	<meta http-equiv="Content-Language" content="fr" />
	<meta name="description" content="Venez rejoindre la communaut&eacute; {titre_page}. Le site des passionn&eacute;s des sports de montagne, de sa faune et sa flore... Contribuer en ajoutant vos randos, station de ski pr&eacute;f&eacute;r&eacute;, topo et venez discuter avec d'autres passionn&eacute;s sur notre forum. Venez partager avec toutes vos photos dans notre album interactif. Venez conseiller nos membres et nos visiteurs. Associations, clubs informez nos membres et visiteurs de vos activit&eacute;s et sortie. {titre_page} le site pour tous les montagnards." />
	<meta name="keywords" lang="fr" content="montagne, meteo montagne, photo montagne, forum montagne, randonn&eacute;e, randonn&eacute;es, alpes, neige, ski, station de ski, alpinisme, savoie, nature, hiver, trekking, escalade, communaut&eacute;, randonneur, randonn&eacute;e alpes, randonnee cycliste, randonnee en france, ski de rando, ski de randonn&eacute;e, rando a ski, topos, alpes, montagnards, topos, album, photos, paysage, skis, randonn&eacute;es, pieds, topos, site, internet, meteo, meteofrance, meteoconsult" />

	<title>{titre_page}</title>
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/commun.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/news.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/tableaux.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/articles.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/formulaire.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/album.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/livreor.css" type="text/css" media="screen" />

	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/admin.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/membres.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/forum.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/visioneuse.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/form.css" type="text/css" media="screen, print" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/impression.css" type="text/css" media="print" />
	
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/lightbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/jquery.lightbox-0.5.css" type="text/css" media="screen" />
	
	
	<link rel="alternate" type="application/rss+xml" title="Flux RSS" href="rss-news.xml" />
	
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
	<script src="{DOMAINE}/templates/js/jquery.colorbox.js"></script>

	
	<script language="JavaScript" type="text/javascript">

		<!--
		function nb_aleatoire(nb) {return Math.floor(Math.random() * nb);}
		Bandeaux = new Array();
		Bandeaux[0] = '{DOMAINE}/templates/images/1/bandeau/ban_1.jpg';
		Bandeaux[1] = '{DOMAINE}/templates/images/1/bandeau/ban_2.jpg';
		Bandeaux[2] = '{DOMAINE}/templates/images/1/bandeau/ban_1.jpg';
		Bandeaux[3] = '{DOMAINE}/templates/images/1/bandeau/ban_2.jpg';
		nombre = nb_aleatoire(4);
		nombre01 = nb_aleatoire(4);
		nombre02 = nb_aleatoire(4);
		nombre03 = nb_aleatoire(4);
		nombre04 = nb_aleatoire(4);
		bandeauSrc=Bandeaux[nombre];
		bandeauSrc01=Bandeaux[nombre01]+"&amp;geometry=234x154!";
		bandeauSrc02=Bandeaux[nombre02]+"&amp;geometry=234x154!";
		bandeauSrc03=Bandeaux[nombre03]+"&amp;geometry=234x154!";
		bandeauSrc04=Bandeaux[nombre04]+"&amp;geometry=234x154!";
		//-->
		
	sfHover = function() {
			var sfEls = document.getElementById("menu").getElementsByTagName("LI");
			for (var i=0; i<sfEls.length; i++) {
					sfEls[i].onmouseover=function() {
							this.className+=" sfhover";
					}
					sfEls[i].onmouseout=function() {
							this.className=this.className.replace(new RegExp(" sfhover\\b"), "");
					}
			}
	}
	if (window.attachEvent) window.attachEvent("onload", sfHover);



	$(document).ready(function(){
		//Affectation du nom de la galerie et des caracteristiques colorbox, garder le nom du rel dans les liens
			$("a[rel='test']").colorbox({slideshow:true});
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
	});

		
</script>
</head>

<body>
