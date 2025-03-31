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
	$data = get_file(TPL_ROOT."chang_profil.tpl");
	include(INC_ROOT.'header.php');
	$sql = 'SELECT * FROM membres WHERE id_m = \''.$_SESSION['mid'].'\'';
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	if($row['newsletter'] == 1)
		$checked_newsletter = 'checked="checked" ';
	else
		$checked_newsletter = '';
	$data = parse_var($data,array("checked_newsletter"=>$checked_newsletter, "design"=>$_SESSION['design'],"titre_page"=>"Mon profil - ".SITE_TITLE,"icq"=>$row['icq'],'msn'=>$row['msn'],'jabber'=>$row['jabber'],'yahoo'=>$row['yahoo'],'aim'=>$row['aim'],'date_naissance'=>date('dmY',$row['naissance']),'pays'=>$row['pays'],'intro'=>$row['signature'],'site_web'=>$row['website'],'interets'=>$row['interest'],'conclu'=>$row['biographie'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>