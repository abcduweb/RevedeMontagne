<?php
/*################################################################################################################################
Réalisation SAS ABCduWeb
Date de création : 04/04/2024
Date de mise à jour : 03/07/2024
Contact : contact@abcduweb.fr
################################################################################################################################*/

/*if(!empty($_SERVER['REQUEST_URI'])){
	$referer = parse_url($_SERVER['REQUEST_URI']);
	if($_SERVER['HTTP_HOST']=='lemontagnardesalpes.fr' OR $_SERVER['HTTP_HOST']=='www.lemontagnardesalpes.fr'){
		header("HTTP/1.1 301");
		header('location:http://www.revedemontagne.com'.$referer['path']);
	}
}*/

/*if ($_SERVER['REMOTE_ADDR'] != '92.137.47.186' AND $config['developpement'] == true){
header("HTTP/1.0 302 Temporary redirect");
header('Location: https://revedemontagne.fr');
}*/

require_once(ROOT.'fonctions/ip.fonction.php');
require_once(INC_ROOT.'config.php');
require_once(INC_ROOT.'db.class.php');
$db = new sql2019($sql_serveur,$sql_login,$sql_pass,$sql_bdd,1,'Erreur sur la base de donnée');
require_once(ROOT.'fonctions/session.fonction.php');
require_once(ROOT.'templates.php');
require_once(ROOT.'fonctions/cache.fonction.php');
require_once(ROOT.'fonctions/commun.fonction.php');

if(is_ban(get_ip()))
{
	define('TPL_ROOT',ROOT.'templates/fr/');
	$data = get_file(TPL_ROOT.'banmsg.tpl');
	$data = parse_var($data,array('IP'=>get_ip(), 'DESIGN'=>$_SESSION['design'], 'DOMAINE'=>$config['domaine']));
	echo $data;
	exit;
}

auto_log();
include(INC_ROOT.'enligne.php');

define('DESIGN',$_SESSION['design']);
define('DOMAINE',$config['domaine']);
define('LANG',$config['lang']);
define('SITE_TITLE',$config['site_title']);
?>