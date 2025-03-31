<?php
/*
 * Créer le 27 oct. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est:
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
else
{
	if(isset($_POST['intro']))
		$text = $_POST['intro'];
	else	
		$text = '';
	if(isset($_POST['conclu']))
		$bio = $_POST['conclu'];
	else
		$bio = "";
	if(isset($_POST['aim']))
		$aim = htmlentities($_POST['aim'],ENT_QUOTES);
	else
		$aim = '';
	if(isset($_POST['msn']))
		$msn = htmlentities($_POST['msn'],ENT_QUOTES);
	else
		$msn = '';
	if(isset($_POST['icq']))
		$icq = htmlentities($_POST['icq'],ENT_QUOTES);
	else
		$icq = '';
	if(isset($_POST['jabber']))
		$jabber = htmlentities($_POST['jabber'],ENT_QUOTES);
	else
		$jabber = '';
	if(isset($_POST['yahoo']))
		$yahoo = htmlentities($_POST['yahoo'],ENT_QUOTES);
	else
		$yahoo = '';
	if(!empty($_POST['date_naissance']) AND preg_match('`^[0-9]{8}$`',$_POST['date_naissance']))$naissance = mktime(0,0,0,intval(substr($_POST['date_naissance'],2,2)),intval(substr($_POST['date_naissance'],0,2)),intval(substr($_POST['date_naissance'],4,4)));
	if(isset($_POST['interets']))
		$interets = htmlentities($_POST['interets'],ENT_QUOTES);
	else
		$interets = '';
	if(isset($_POST['site']))
		$site = htmlentities($_POST['site'],ENT_QUOTES);
	else
		$site = '';
	if(isset($_POST['newsletter']))
		$newsletter = 1;
	else
		$newsletter = 0;
	$text_parser = $db->escape(zcode($text));
	$text = htmlentities($text,ENT_QUOTES);
	
	$bio_parser = $db->escape(zcode($bio));
	$bio = htmlentities($bio,ENT_QUOTES);
	if(isset($naissance))
		$sql = "UPDATE membres SET msn = '$msn',aim = '$aim',jabber = '$jabber',website = '$site',interest='$interets',naissance = '$naissance', signature = '$text', signature_parser = '$text_parser', newsletter = '$newsletter', biographie = '$bio', biographie_parser = '$bio_parser' WHERE id_m = '$_SESSION[mid]'";
	else
		$sql = "UPDATE membres SET msn = '$msn',aim = '$aim',jabber = '$jabber',website = '$site',interest='$interets', signature = '$text', signature_parser = '$text_parser', newsletter = '$newsletter', biographie = '$bio', biographie_parser = '$bio_parser' WHERE id_m = '$_SESSION[mid]'";
	$db->requete($sql);
	$message = "Profil modifié.";
	$type = "ok";
	$redirection = ROOT."mes_options.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>