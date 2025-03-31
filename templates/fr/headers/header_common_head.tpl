<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Language" content="fr" />
	<meta name="description" content="Venez rejoindre la communaut&eacute; {titre_page}. Le site des passionn&eacute;s des sports de montagne, de sa faune et sa flore... Contribuer en ajoutant vos randos, station de ski pr&eacute;f&eacute;r&eacute;, topo et venez discuter avec d'autres passionn&eacute;s sur notre forum. Venez partager avec toutes vos photos dans notre album interactif. Venez conseiller nos membres et nos visiteurs. Associations, clubs informez nos membres et visiteurs de vos activit&eacute;s et sortie. {titre_page} le site pour tous les montagnards." />
	<meta name="keywords" lang="fr" content="montagne, meteo montagne, photo montagne, forum montagne, randonn&eacute;e, randonn&eacute;es, alpes, neige, ski, station de ski, alpinisme, savoie, nature, hiver, trekking, escalade, communaut&eacute;, randonneur, randonn&eacute;e alpes, randonnee cycliste, randonnee en france, ski de rando, ski de randonn&eacute;e, rando a ski, topos, alpes, montagnards, topos, album, photos, paysage, skis, randonn&eacute;es, pieds, topos, site, internet, meteo, meteofrance, meteoconsult" />
	<title>{titre_page}</title>
	
	<link rel="stylesheet" href="{DOMAINE}templates/css/{design}/commun.css" type="text/css" media="screen" />
	<!-- <link rel="stylesheet" href="{DOMAINE}templates/css/{design}/tarteaucitron.css" type="text/css" media="screen" /> -->
	
	<link rel="icon" type="image/png" href="{DOMAINE}templates/images/{design}/favicon.png" />
	
	<!-- Balises facebook -->
	<!-- #################################################################################################### -->
	<!-- <link rel="canonical" href="{titre_page}" /> -->


	<!-- Images facebook (liens, hauteur, largeur)-->
	<meta property="og:image" content="{og_facebook_image}" />
	<meta property="og:image:width" content="{og_facebook_width}" />
	<meta property="og:image:height" content="{og_facebook_height}" />
	<meta property="og:locale" content="fr_FR" />
	<meta property="og:description" content="{og_facebook_description}" />
	<meta property="og:url" content="{og_facebook_url}" />
	<meta property="og:title" content="{og_facebook_title}" />
	
	<!-- og en cours de développement -->
		<!-- <meta property="og:type" content="article" />
		<meta property="article:published_time" content="2019-12-02T07:00:05+00:00" />
		<meta property="article:modified_time" content="2021-01-12T23:35:30+00:00" /> -->
	<!-- fin de fichier en cours de développement -->
	<!-- #################################################################################################### -->
	
	<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="{DOMAINE}templates/images/{design}/favicon.ico" /><![endif]-->

	
	<link rel="alternate" type="application/rss+xml" title="Flux RSS" href="rss-news.xml" />
	
	

<!-- Inclusion de la librairie tarteaucitron pour la gestion des cookies -->
<script type="text/javascript" src="{DOMAINE}/templates/gdpr/tarteaucitron.js"></script>
<script type="text/javascript">
tarteaucitron.init({
    "privacyUrl": "", /* Privacy policy url */
    "bodyPosition": "bottom", /* or top to bring it as first element for accessibility */

    "hashtag": "#tarteaucitron", /* Open the panel with this hashtag */
    "cookieName": "tarteaucitron", /* Cookie name */

    "orientation": "middle", /* Banner position (top - bottom - middle - popup) */

    "groupServices": false, /* Group services by category */

    "showAlertSmall": false, /* Show the small banner on bottom right */
    "cookieslist": false, /* Show the cookie list */
    
    "showIcon": false, /* Show cookie icon to manage cookies */
    // "iconSrc": "", /* Optionnal: URL or base64 encoded image */
    "iconPosition": "BottomRight", /* Position of the icon between BottomRight, BottomLeft, TopRight and TopLeft */

    "adblocker": true, /* Show a Warning if an adblocker is detected */

    "DenyAllCta" : true, /* Show the deny all button */
    "AcceptAllCta" : true, /* Show the accept all button when highPrivacy on */
    "highPrivacy": true, /* HIGHLY RECOMMANDED Disable auto consent */

    "handleBrowserDNTRequest": false, /* If Do Not Track == 1, disallow all */

    "removeCredit": true, /* Remove credit link */
    "moreInfoLink": true, /* Show more info link */
    "useExternalCss": false, /* If false, the tarteaucitron.css file will be loaded */
    "useExternalJs": false, /* If false, the tarteaucitron.services.js file will be loaded */
	//"cookieDomain": ".revedemontagne.fr", /* Shared cookie for subdomain website */

    //"cookieDomain": ".my-multisite-domaine.fr", /* Shared cookie for subdomain website */

    "readmoreLink": "", /* Change the default readmore link pointing to tarteaucitron.io */
    
    "mandatory": true, /* Show a message about mandatory cookies */
    "mandatoryCta": true /* Show the disabled accept button when mandatory on */
});
</script>


<!-- ###################################################################### -->
<!-- #Inclusion des diverses librairies (Jquery, prototype, sriptaculous) # -->
<!-- ###################################################################### -->
<script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.3.0/prototype.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>jQuery.noConflict();</script>

<!-- ########################################## -->
<!-- #Script JQUERY pour la gestion des photos# -->
<!-- ########################################## -->
<script src="{DOMAINE}/templates/js/Jquery/jquery.colorbox.js"></script>
<script language="JavaScript" type="text/javascript">
	jQuery(document).ready(function($){
	//Affectation du nom de la galerie et des caracteristiques colorbox, garder le nom du rel dans les liens
	$("a[rel='test']").colorbox({rel:'test', transition:"fade", innerWidth:800, innerHeight:600});
	
	//Example of preserving a JavaScript event for inline calls.
	$("#click").click(function(){ 
	$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
	return false;
	});
	});	
</script>

<!-- ########################################### -->
<!-- Script pour la gestion des menus sur mobile -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/Jquery/doubletaptogo.js"></script>
<script>
	jQuery(document).ready(function($){
		$( '#nav li:has(ul)' ).doubleTapToGo();
	});
</script>
		
<!-- ########################################### -->
<!-- Script pour la gestion du popup pour les MP -->
<!-- ########################################### -->
<script src="{DOMAINE}/templates/js/Jquery/popbox.js" defer></script>
<script>
// <![CDATA[
wReady=function(f,w){var r=document.readyState;w||r!="loading"?r!="complete"?window.addEventListener("load",function(){f(3)}):f(3):document.addEventListener("DOMContentLoaded",function(){f(2)&&wReady(f)})}
doInit=function(f,w){(w>1||(w&&document.readyState=="loading")||f(1))&&wReady(f,w>1)}
// ]]>
</script>

<!-- ########################################### -->
<!-- Gestion des diverses clès de fonctionnement -->
<!-- ########################################### -->
<script>
	var mapKeys = {"ign":"26i4kmg8961ialiuqtxk1q5e"};
</script>