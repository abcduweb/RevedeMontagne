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
  $data = display_notice($message,'important',$redirection);
}
else{
	$id_m = (int)$_GET['m'];
	$sql = "SELECT * FROM messages WHERE id_ms = '$id_m'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	if(!empty($_POST['valider']) AND $_POST['valider'] == 1)
		$valider = true;
	else
		$valider = false;
	  $sql = "SELECT * FROM topics LEFT JOIN forum ON topics.id_forum = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = forum.id_f) WHERE topics.id_t = '$row[id_topics]'";
	  $result = $db->requete($sql);
	  $row2 = $db->fetch($result);
	if($row2['id_t'] != null){
		if($row2['supprimer'] == 1){
			if($valider){
				$sql = "DELETE FROM messages WHERE id_ms ='$id_m'";
				$db->requete($sql);
				if($row2['id_last_message'] == $id_m){
					$sql = "SELECT * FROM messages WHERE id_topics = '$row2[id_t]' ORDER BY id_ms DESC";
					$last_msg = $db->fetch($db->requete($sql));
					$db->requete("UPDATE topics SET id_last_message = $last_msg[id_ms],nb_reponse = nb_reponse - 1 WHERE id_t = '$row2[id_t]'");
				}
				else{
					$db->requete("UPDATE topics SET nb_reponse = nb_reponse - 1 WHERE id_t = '$row2[id_t]'");
				}
				$message = "Le message a bien été supprimé.";
				$redirection = ROOT."forum-".$row2['id_f']."-".$row2['id_t']."-".title2url($row2['titre']).".html";
				$data = display_notice($message,'ok',$redirection);
			}
			else{
				$message = "Etes vous sûr de vouloir supprimer ce message?";
				$url = "supprimer_message.php?m=$id_m";
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
	    $message = "Ce message n'existe pas.";
	  	$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>
