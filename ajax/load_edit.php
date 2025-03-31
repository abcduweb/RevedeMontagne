<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
include(ROOT.'fonctions/zcode.fonction.php');
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
header('Content-Type: text/html; charset=UTF8');

/*#######A METTRE SUR CHAQUE PAGE#######
define('ROOT','../');				 #
define('INC_ROOT',ROOT.'includes/'); #
session_start();					 #
include(INC_ROOT.'config.php');		 #
include(INC_ROOT.'db.class.php');	 #
$db = mysqli_connect($sql_serveur, $sql_login, $sql_pass, $sql_bdd);
include(ROOT.'fonctions/session.fonction.php');	 #
############FIN ######################*/
//header('Content-type: text/html; charset=ISO-8859-1');
$id_m = intval($_POST['id']);
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
if(isset($_SESSION['mid']) AND $_SESSION['mid'] != 0 AND $_SESSION['group'] != 6)
{
	if(($row['id_utilisateur'] == $_SESSION['mid'] AND $row2['status'] == 1 AND $row2['ajouter'] == 1) OR ($modif_all == 1))
	{
		echo html_entity_decode($row['text']);
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
$db->deconnection();
?>
