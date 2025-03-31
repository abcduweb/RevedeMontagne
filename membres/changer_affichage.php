<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'index.php';
	echo display_notice($message,'important',$redirection);;
}
else
{
	$data = get_file(TPL_ROOT."changer_options_site.tpl");
	include(INC_ROOT.'header.php');
	$sql = 'SELECT * FROM membres WHERE id_m = \''.$_SESSION['mid'].'\'';
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	if($row['ordre'] == 'ASC'){
		$checked_ASC = 'selected="selected" ';
		$checked_DESC = '';
	}
	else{
		$checked_ASC = '';
		$checked_DESC = 'selected="selected" ';
	}
	
	if($row['afficher_mail'] == 1)
		$checked_mail = 'checked="checked" ';
	else
		$checked_mail = '';
	if($row['attach_sign'] == 1)
		$checked_sign = 'checked="checked" ';
	else
		$checked_sign = '';
	
	$data = parse_var($data,array("design"=>$_SESSION['design'],"titre_page"=>"Options d'affichage - ".SITE_TITLE,
	'nb_message'=>$row['nombre_message_afficher'],'nb_sujet'=>$row['nb_sujet_afficher'],'nb_news'=>$row['nb_news_page'],
	'select_asc'=>$checked_ASC,'select_desc'=>$checked_DESC,'checked_email'=>$checked_mail,'checked_sign'=>$checked_sign,
	'date_style'=>$row['style_date']
	,'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>