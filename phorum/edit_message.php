<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
define('Z_ROOT','./');

$id_m = (int)$_GET['m'];
$sql = "SELECT * FROM messages LEFT JOIN topics ON topics.id_t = messages.id_topics WHERE id_ms = '$id_m'";
$result = $db->requete($sql);
$row = $db->fetch($result);
if($row['deplacer'] == 0){
	$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.id_forum = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = forum.id_f) WHERE topics.id_t = '$row[id_topics]'";
}
else{
	$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.deplacer = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = topics.deplacer) WHERE topics.id_t = '$row[id_topics]'";
}
$result = $db->requete($sql);
$row2 = $db->fetch($result);
$modif_all = $row2['modifier_tout'];
if($_SESSION['group'] != 6)
{
	if(($row['id_utilisateur'] == $_SESSION['mid'] AND $row2['status'] == 1 AND $row2['ajouter'] == 1) OR ($row2['interdire_topics'] == 1 AND $modif_all == 1))
	{
		$txt = $row['text'];
		$_GET['limite'] = 1;
		$_GET['f'] = $row2['id_f'];
		$_GET['t'] = $row['id_topics'];
		$data = get_file(TPL_ROOT.'forum/edit_message.tpl');
		include(INC_ROOT.'header.php');
		$load_tpl = false;
		if($row['attachSign'] == 1)
			$attach_sign = 'checked="checked"';
		else
			$attach_sign = '';
		$data = parse_var($data,array('attache_sign'=>$attach_sign,'id_forum'=>$_GET['f'],'id_sujet'=>$_GET['t'],'id_message'=>$row['id_ms'],'texte'=>$txt,'titre_page'=>'edition d\'un message'.SITE_TITLE));
		include(Z_ROOT.'sources/message.php');
		$data = parse_var($data,array('nb_requetes'=>$db->nb_requetes()));
		echo $data;
		exit;
	}
	else{
		if($row['deplacer'] == 0){
			$id_f = $row['id_forum'];
		}
		else{
			$id_f = $row['deplacer'];
		}
		$id_t = $row['id_topics'];
		if($_SESSION['order'] == "ASC"){
			$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_t AND id_ms <= $id_m"));
			$page = ceil($num / $_SESSION['nombre_message']);
		}
		else{
			$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_t AND id_ms >= $id_m"));
			$page = ceil($num / $_SESSION['nombre_message']);
		}
		$redirection = "forum-".$id_f."-".$id_t."-p".$page."-".title2url($row2['titre']).".html";
		$message = "Vous ne pouvez pas modifier ce message.";
		echo display_notice($message,'important',$redirection);;
	}
}
else
{
	if($row['deplacer'] == 0){
			$id_f = $row['id_forum'];
	}
	else{
		$id_f = $row['deplacer'];
	}
	$id_t = $row['id_topics'];
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	require_once(ROOT.'fonctions/commun.fonction.php');
	if($_SESSION['order'] == "ASC"){
		$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_t AND id_ms <= $id_m"));
		$page = ceil($num / $_SESSION['nombre_message']);
	}
	else{
		$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_t AND id_ms >= $id_m"));
		$page = ceil($num / $_SESSION['nombre_message']);
	}
	$redirection = "forum-".$id_f."-".$id_t."-p".$page."-".title2url($row2['titre']).".html#r$id_m";
	$message = "Vous ne pouvez pas modifier ce message.";
	echo display_notice($message,'important',$redirection);;
}
$db->deconnection();
?>