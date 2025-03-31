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
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$data = get_file(TPL_ROOT.'design.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('DESIGN'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
	echo $data;
}
$db->deconnection();
?>
