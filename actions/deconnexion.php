<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!empty($_GET['id_m']) AND intval($_GET['id_m']) == $_SESSION['mid']){
	$db->requete("DELETE FROM enligne WHERE id_m_join = $_SESSION[mid]");
	$message = 'Vous &ecirc;tes d&eacute;sormais d&eacute;connect&eacute;';
	$redirection = 'index.html';
	$data = display_notice($message,'ok',$redirection);
	log_out();
}else{
	$message = "Erreur";
	$redirection = 'index.html';
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>