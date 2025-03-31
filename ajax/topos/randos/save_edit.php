<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../../../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
include(ROOT.'fonctions/zcode.fonction.php');
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
header('Content-Type: text/html; charset=UTF8');

$id_m = intval($_POST['m']);
$type = htmlentities($_POST['type'], ENT_QUOTES);
$text = $_POST['texte'];
$text_parser = $db->escape(zcode($text,true));
$text = htmlentities($text,ENT_QUOTES);

$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$row = $db->fetch($db->requete($sql));

$sql = "SELECT * FROM topos LEFT JOIN membres ON membres.id_m = topos.id_m WHERE id_topo = '$id_m'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);

if (($row2['id_m'] == $_SESSION['mid'] AND $row['redacteur_topo'] == 1) OR ($row['administrateur_topo'] == 1)) 
{
	if($row['administrateur_topo'] == 1)
	{
		$status = 2;
	}
	else
	{
		$status = 1;
	}

	if($row2['id_m'] == $_SESSION['mid']){
		$edit_part = '<div class="user_edit">Edit&eacute; {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row2['pseudo'].'</a></div>';
	}
	else{
		$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
		$result = $db->fetch($db->requete($sql));
		$edit_part = '<div class="team_edit">Edit&eacute; {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
	}
	
	if($type == 'itineraire')
	{
	
		$db->requete("UPDATE topos SET statut = '$status', itineraire='$text', itineraire_parser='$text_parser' WHERE id_topo = '$id_m'");
	}
	elseif ($type == 'remarques')
	{
		$db->requete("UPDATE topos SET statut = '$status', remarque='$text', remarque_parser='$text_parser' WHERE id_topo = '$id_m'");
	}
	else
	{
		echo $type;
	}

}
else
{
	echo 0;
}






$id_m = intval($_POST['m']);
$sql = "SELECT * FROM messages LEFT JOIN topics ON topics.id_t = messages.id_topics LEFT JOIN membres ON membres.id_m = messages.id_utilisateur WHERE id_ms = '$id_m'";
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
if(isset($_SESSION['mid']) AND $_SESSION['mid'] != 0 AND $_SESSION['group'] != 6)
{
	if(($row['id_utilisateur'] == $_SESSION['mid'] AND $row2['status'] == 1 AND $row2['ajouter'] == 1) OR ($row2['interdire_topics'] == 1 AND $modif_all == 1))
	{
		$text = $_POST['texte'];
		$text_parser = $db->escape(zcode($text,true));
		$text = htmlentities(utf8_decode($text),ENT_QUOTES);
		if($row['id_utilisateur'] == $_SESSION['mid']){
			$edit_part = '<div class="user_edit">Edit&eacute; {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row['utilisateur'].'</a></div>';
		}
		else{
			$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
			$result = $db->fetch($db->requete($sql));
			$edit_part = '<div class="team_edit">Edit&eacute; {data_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
		}
		$text_parser .= $edit_part;
		$sql = "UPDATE messages SET text = '$text', text_parser = '$text_parser',date_edit = UNIX_TIMESTAMP() WHERE id_ms = '$id_m'";
		if($row['attachSign'] == 1){
			$text_parser .= '<div class="signature_message">'.$row['signature_parser'].'</div>';
		}else{
		
		}
		$db->requete($sql);
		echo stripslashes(stripslashes(str_replace('\n','',str_replace('{data_edit}',get_date(time(),$_SESSION['style_date']),$text_parser))));
	}
	else
	{
		echo 0;
	}
}
else
{
	echo 0;
}
?>
