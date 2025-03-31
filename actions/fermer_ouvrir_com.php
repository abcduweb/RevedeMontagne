<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(empty($_GET['nid'])){
	$db->deconnection();
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	$message = "Aucune news de s&eacute;lectionn&eacute;e.";
	$redirection = "javascript:history.back(-1);";
	echo display_notice($message,'important',$redirection);
	exit;
}
else
  $nid = intval($_GET['nid']);
if(!isset($_GET['action'])){
	$db->deconnection();
	$message = "Aucune action de s&eacute;lectionn&eacute;e.";
	$redirection = "javascript:history.back(-1);";
	echo $data = get_file(TPL_ROOT.'system_ei.tpl');
	exit;
}
else
  $action = intval($_GET['action']);
$sql = "SELECT * FROM nm_news LEFT JOIN autorisation_globale ON (autorisation_globale.id_group = '".$_SESSION['group']."') WHERE nm_news.id_news = '$nid'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);
if($row2['id_news'] != null){
  if(!empty($_POST['valider']) AND $_POST['valider'] == 1)
    $valider = true;
  else
    $valider = false;

  if($row2['supprimer_news'] == 1 AND $row2['status_news'] == 1){
	$redirection = ROOT.title2url($row2['titre'])."-n$nid.html";
  	if($action == 1){
  		$sql = "UPDATE nm_news SET status_com = 1 WHERE id_news = '$nid'";
  		if($valider){
  		  $message = "Les commentairs ont bien &eacute;t&eacute; r&eacute;ouvert.";
		  $data = display_notice($message,'ok',$redirection);
		}
  		else{
  		  $message = "Etes vous sur de vouloir r&eacute;ouvrir les commentaires?";
  		  $url = "fermer_ouvrir_com.php?nid=$nid&action=$action";
		  $data = display_confirm($message,$url);
  		}
  	}
  	else{
  		$sql = "UPDATE nm_news SET status_com = 0 WHERE id_news = '$nid'";
  		if($valider){
  		  $message = "Les commentaires ont bien &eacute;t&eacute; ferm&eacute;s.";
		  $data = display_notice($message,'ok',$redirection);
		} 
  		else{
			$message = "Etes vous sur de vouloir fermer les commentaires?";
			$url = "fermer_ouvrir_com.php?nid=$nid&action=$action";
			$data = display_confirm($message,$url);
		}
  	}
  	if($valider)$db->requete($sql);
  }
  else{
  	$message = "Vous n'avez pas le droit d'ouvrir/fermer les commentaires de cette news.";
  	$redirection = ROOT."".title2url($row2['titre'])."-n$nid.html";
	$data = display_notice($message,'important',$redirection);
  }
}
else{
    $message = "News inexistant.";
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>
