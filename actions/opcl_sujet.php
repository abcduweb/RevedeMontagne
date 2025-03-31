<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(empty($_GET['t'])){
	$db->deconnection();
	$message = "Aucun sujet de sélectionné.";
	$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
	$data = display_notice($message,'important',$redirection);
	exit($data);
}
else
  $id_t = intval($_GET['t']);
if(!isset($_GET['action'])){
	$db->deconnection();
	$message = "Aucune action de sélectionner.";
	$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
	$data = display_notice($message,'important',$redirection);
	exit($data);
}
else
  $action = intval($_GET['action']);
$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.id_forum = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = forum.id_f) WHERE topics.id_t = '$id_t'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);
if($row2['id_t'] != null){
	if(!empty($_POST['valider']) AND $_POST['valider'] == 1)
		$valider = true;
	else
		$valider = false;
	if($row2['interdire_topics'] == 1){
		if($action == 1){
			$sql = "UPDATE topics SET status = 1 WHERE id_t = '$id_t'";
			if($valider){
				$message = "Le sujet a bien été réouvert.";
				$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
				$data = display_notice($message,'ok',$redirection);
			}
			else{
				$message = "Etes vous sur de vouloir réouvrir le sujet?";
				$url = "opcl_sujet.php?t=$id_t&action=$action";
				$data = display_confirm($message,$url);
			}
		}
		else{
			$sql = "UPDATE topics SET status = 0 WHERE id_t = '$id_t'";
			if($valider){
				$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
				$message = "Le sujet a bien été fermé.";
				$data = display_notice($message,'ok',$redirection);
			}
			else{
				$message = "Etes vous sur de vouloir fermer le sujet?";
				$url = "opcl_sujet.php?t=$id_t&action=$action";
				$data =display_confirm($message,$url);
			}
		}
		if($valider)$db->requete($sql);
	}
	else{
		$message = "Vous n'avez pas le droit d'ouvrir/fermer ce sujet.";
		$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
		$data = display_notice($message,'important',$redirection);
	}
}
else{
	$message = "Sujet inexistant.";
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>
