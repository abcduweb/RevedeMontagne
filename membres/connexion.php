<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['mid'] == 0){
	if(isset($_SERVER['HTTP_REFERER'])){
	  $url = parse_url($_SERVER['HTTP_REFERER']);
	  if(($url['host'] == "revedemontagne.com" OR $url['host'] == "www.revedemontagne.com") AND !isset($_SESSION['loginRedirect']))$_SESSION['loginRedirect'] = htmlentities($_SERVER['HTTP_REFERER'],ENT_QUOTES);
	}
	$data = get_file(TPL_ROOT.'connexion.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('titre_page'=>'Connexion - '.SITE_TITLE,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
}
else{
	$message = "Vous êtes déjà connecté.";
	$redirection = "javascript:history.back(-1);";
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
