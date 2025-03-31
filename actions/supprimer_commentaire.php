<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_GET['m'])){
  $message = "Aucun message de sélectionner.";
  $redirection = "javascript:history.back(-1);";
  display_notice($message,'important',$redirection);
}
else{
	$id_com = (int)$_GET['m'];
	$sql = "SELECT * FROM nm_comnews WHERE id_com = '$id_com'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
		if($db->num($result) == 0){
		$data = get_file(TPL_ROOT.'system_ei.tpl');
		$message = "Ce message n'existe pas.";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
		$data = parse_var($data,array('message'=>$message,'type'=>$type,'redirection'=>$redirection,'TPL_ROOT'=>ROOT.'templates/','DESIGN'=>$_SESSION['design']));
		echo $data;
		$db->deconnexion();
		exit;
	}
	if(!empty($_POST['valider']) AND $_POST['valider'] == 1)
		$valider = true;
	else
		$valider = false;
	$sql = "SELECT * FROM nm_news LEFT JOIN autorisation_globale ON (autorisation_globale.id_group = '".$_SESSION['group']."') WHERE nm_news.id_news = '$row[idnews]'";
	$result = $db->requete($sql);
	$row2 = $db->fetch($result);
	if($row2['id_news'] != null){
		if($row2['supprimer_com'] == 1){
			if($valider){
				$sql = "DELETE FROM nm_comnews WHERE id_com ='$id_com'";
				$db->requete($sql);
				$db->requete("UPDATE nm_news SET nb_com = nb_com - 1 WHERE id_news = '$row2[id_news]'");
				$message = "Le message a bien été supprimé.";
				$redirection = ROOT."commentaires-de-".title2url($row2['titre'])."-n".$row2['id_news'].".html";
				$data = display_notice($message,'ok',$redirection);
			}
			else{
				$message = "Etes vous sûr de vouloir supprimer ce message?";
				$url = "supprimer_commentaire.php?m=$id_com";
				$data = display_confirm($message,$url);
			}
		}
		else{
			$message = "Vous n'avez pas le droit de supprimer ce message.";
			$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Cette news n'existe pas.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>