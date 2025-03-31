<?php
define('ROOT','../');
define('INC_ROOT',ROOT.'includes/');
include('../includes/commun.php');
if(!empty($_POST['id'])){
	$id_album = intval($_POST['id']);
	$row = $db->fetch_assoc($db->requete('SELECT pm_photos.fichier FROM pm_photos WHERE id_album = \''.$id_album.'\''));
	echo './images/album/'.ceil($id_album/1000).'/mini/'.$row['fichier'];
}
else{
	echo  false;
}
?>