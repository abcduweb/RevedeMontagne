<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if($_SESSION['group'] == 1){
	if(isset($_POST['cat_article']) AND !empty($_POST['cat_article']) AND isset($_POST['label']) AND !empty($_POST['label'])){
		$var = explode('|',$_POST['cat_article']);
		$bd = intval($var[0]);
		$level = intval($var[1]) + 1;
		$label = htmlentities($_POST['label'],ENT_QUOTES);
		$sql = "UPDATE articles SET BG = BG + 2 WHERE BG >= $bd";
		$result = $db->requete($sql);
		$sql = "UPDATE articles SET BD = BD + 2 WHERE BD >= $bd";
		$result = $db->requete($sql);
		$bg = $bd;
		$bd = $bd + 1;
		$sql = "INSERT INTO articles VALUES($bg,$bd,'$label',$level,'0')";
		$result = $db->requete($sql);
		
		$message = "Nouvelle catégorie ajoutée";
		$redirection = ROOT."admin.html";
		$data = display_notice($message,"ok",$redirection);
	}
	else{
		$message = "Vous n'avez pas entré de label";
		$redirection = "javascript:history.back(-1);";		
		$data = display_notice($message,"important",$redirection);
	}
}
else{
	$message = "Vous ne pouvez pas ajouter de catégorie";
	$redirection = ROOT."admin.html";
	$data = display_notice($message,"important",$redirection);
}
$db->deconnection();
echo $data;
?>