<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if(isset($_GET['m'])){
	$id_m = (int)$_GET['m'];
	$sql = "SELECT * FROM messages LEFT JOIN topics ON topics.id_t = messages.id_topics WHERE id_ms = '$id_m'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	if($row['deplacer'] == 0){
		$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.id_forum = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = forum.id_f) WHERE topics.id_t = '$row[id_topics]'";
	}
	else{
		$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.deplacer = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = topics.deplacer) WHERE topics.id_t = '$row[id_topics]'";
	}
	$result = $db->requete($sql);
	$row2 = $db->fetch($result);
	$modif_all = $row2['modifier_tout'];
	if((($_SESSION['group'] != 6 AND $_SESSION['group'] != 7) AND $row2['status'] == 1) OR $row2['interdire_topics'] == 1)
	{
		if(($row['id_utilisateur'] == $_SESSION['mid'] AND $row2['ajouter'] == 1) OR $modif_all == 1)
		{
			$text = stripslashes($_POST['texte']);
			$text_parser = $db->escape(zcode($text));
			$text = htmlentities($text,ENT_QUOTES);
			if($row['id_utilisateur'] == $_SESSION['mid']){
				$edit_part = '<div class="user_edit">Edité {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row['utilisateur'].'</a></div>';
			}
			else{
				$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
				$result = $db->fetch($db->requete($sql));
				$edit_part = '<div class="team_edit">Edité {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
			}
			$text_parser .= $edit_part;
			if(isset($_POST['sign']))
				$attach_sign = 1;
			else
				$attach_sign = 0;
			$sql = "UPDATE messages SET text = '$text', text_parser = '$text_parser',date_edit = UNIX_TIMESTAMP(),attachSign = '$attach_sign' WHERE id_ms = '$id_m'";
			$db->requete($sql);
			$message = "Le message a bien été modifié.";
			$type = "ok";
			$sql = "SELECT * FROM messages WHERE id_ms < $id_m AND id_topics = '".intval($_GET['t'])."'";
			$db->requete($sql);
			$page = ceil($db->num() / $_SESSION['nombre_message']);
			if($page == 0)$page = 1;
			$redirection = ROOT."forum-".intval($_GET['f'])."-".intval($_GET['t'])."-p".$page."-".title2url($row2['titre']).".html#r$id_m";
			if(isset($_SESSION['tmp_Img'])){
				$sql = "UPDATE images SET tmp = '0' WHERE dir = '3' AND s_dir = '".intval($_GET['t'])."' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
				$db->requete($sql);
				if(isset($_SESSION['SsubDir']['tmp'])){
	        $key = array_keys($_SESSION['SsubDir']['tmp']);
	        unset($_SESSION['dir'.$key[0]]);
	        unset($_SESSION['SsubDir']);
	      }
	      unset($_SESSION['tmp_Img']);
			}
		}
		else{
			$sql = "SELECT * FROM messages WHERE id_ms < $id_m AND id_topics = '".intval($_GET['t'])."'";
			$db->requete($sql);
			$page = ceil($db->num() / $_SESSION['nombre_message']);
			if($page == 0)$page = 1;
			$redirection = ROOT."forum-".intval($_GET['f'])."-".intval($_GET['t'])."-p$page-".title2url($row2['titre']).".html#r$id_m";
			$message = "Vous ne pouvez pas modifier ce message.";
			$type = "important";
		}
	}
	else
	{
		$sql = "SELECT * FROM messages WHERE id_ms < $id_m AND id_topics = '".intval($_GET['t'])."'";
		$db->requete($sql);
		$page = ceil($db->num() / $_SESSION['nombre_message']);
		$message = "Vous ne pouvez pas editer ce message";
		$type = "important";
		$redirection = ROOT."forum-".intval($_GET['f'])."-".intval($_GET['t'])."-p$page-".title2url($row2['titre']).".html#r$id_m";
	}
}else{
	$message = "Aucun message de sélectionner.";
	$type = "important";
	$redirection = ROOT."forum-".intval($_GET['f'])."-".intval($_GET['t'])."-".title2url($row2['titre']).".html";
}
echo display_notice($message,$type,$redirection);;
$db->deconnection();
?>
