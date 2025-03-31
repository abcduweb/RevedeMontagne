<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if($_SESSION['group'] == 1){
	if(!empty($_POST['nom_forum']) AND strlen(trim($_POST['nom_forum'])) >= 4
	AND !empty($_POST['nom']) AND strlen(trim($_POST['nom'])) >= 4){
		$sql = "INSERT INTO big VALUES ('','".htmlentities($_POST['nom'],ENT_QUOTES)."')";
		$db->requete($sql);
		$id_big = $db->last_id();
		$sql = "SELECT MAX(position) FROM forum WHERE id_big = '$id_big'";
		$db->requete($sql);
		$row = $db->row();
		$position = $row[0] + 1;
		$sql = "INSERT INTO forum VALUES ('',0,'$id_big','$position','".htmlentities($_POST['nom_forum'],ENT_QUOTES)."','".htmlentities($_POST['description'],ENT_QUOTES)."',0,0)";
		$db->requete($sql);
		$id_forum = $db->last_id();
		$sql = "SELECT * FROM autorisation_globale";
		$result = $db->requete($sql);
		$is_on = array('on'=>1,''=>0);
		while($row = $db->fetch($result)){
			$db->requete("INSERT INTO auth_list VALUES($id_big,$id_forum,$row[id_group],".$is_on[$_POST['auth'][$row['id_group']]['add']].",".$is_on[$_POST['auth'][$row['id_group']]['modifier']].",".$is_on[$_POST['auth'][$row['id_group']]['supprimer']].",".$is_on[$_POST['auth'][$row['id_group']]['afficher']].",".$is_on[$_POST['auth'][$row['id_group']]['close']].",".$is_on[$_POST['auth'][$row['id_group']]['move']].",".$is_on[$_POST['auth'][$row['id_group']]['add_forum']].")");
		}

		$message = "Nouvelle catégorie ajoutée";
		$redirection = ROOT."admin.html";
		$data = display_notice($message,"ok",$redirection);
	}
	else{
		if(empty($_POST['nom_forum']) OR strlen(trim($_POST['nom_forum'])) < 4){
			$message = "Vous n'avez pas entré de nom, ou celui-ci est trop court, pour le forum.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,"important",$redirection);
		}
		elseif(empty($_POST['nom']) OR strlen(trim($_POST['nom'])) < 4){
			$message = "Vous n'avez pas entré de nom, ou celui-ci est trop court, pour la nouvelle catégorie.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,"important",$redirection);
		}
	}
}
else{
	$message = "Vous ne pouvez pas ajouter de catégorie";
	$redirection = ROOT."index.php";
	$data = display_notice($message,"important",$redirection);
}
$db->deconnection();
echo $data;
?>