<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['mid'] == 0){
	$data = get_file(TPL_ROOT.'mail_validation.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('titre_page'=>'Demande e-mail de validation - '.SITE_TITLE,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
}
else{
	$message = "Vous êtes connecté. Vous ne pouvez demander d'e-mail de validation.";
	$redirection = "javascript:history.back(-1);";
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
