<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
include(ROOT.'fonctions/zcode.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$row = $db->fetch($db->requete($sql));
	if(isset($_GET['alid']) AND isset($_POST['name']) AND !empty($_POST['name'])){
		$data = get_file(TPL_ROOT.'system_confirm.tpl');
		$form ='<form action="demande_validation.php?artid='.$id_article.'" method="post">';
	}
	else{
	
	}
}
else{

}
?>
