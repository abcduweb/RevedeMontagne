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
	$message = 'Vous devez �tre enregistr� pour pouvoir acc�der � cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['ajouter_article'] == 1){
		$data = get_file(TPL_ROOT.'ajout_article.tpl');
		include(INC_ROOT.'header.php');
		$value = "ajouter";
		$data = parse_var($data,array('intro'=>'','conclu'=>'','titre_page'=>'Ajouter un article - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
		echo $data;
	}
	else{
		$message = 'Vous n\'�tes pas autoris� � ajouter un article. Ceci peut �tre que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>