<?php
/*
 * Créer le 24 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: le formulaire d'iscription
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['group'] == 6){
	$data = get_file(TPL_ROOT.'inscription.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('design'=>$_SESSION['design'],'ROOT'=>'','nb_requetes'=>$db->nb_requetes(),'titre_page'=>'Inscription - '.SITE_TITLE));
}
else{
	$message = "Vous êtes déjà inscrit.";
	if(isset($_SERVER['HTTP_REFERER']))
		$redirection = "javascript:history.back(-1);";
	else
		$redirection = "index.php";
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>