<?php
/*
 * Créer le 5 sept. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: images pour les mails anti spam
 */
#######A METTRE SUR CHAQUE PAGE##########
define('ROOT', '../'); 					#
define('TPL_ROOT', ROOT . 'templates/');#
define('INC_ROOT', ROOT . 'includes/'); #
session_start(); 						#
include (INC_ROOT . 'commun.php'); 		#
############FIN #########################
if(!empty($_GET['type']) AND !empty($_GET['id'])){
	$type = intval($_GET['type']);
	$midi = intval($_GET['id']);
	$sql = "SELECT * FROM membres WHERE id_m = '$midi'";
	$db->requete($sql);
	$fetch = $db->fetch();
	if($fetch['id_m'] != null){
	switch($type){
		case 1:
			if($fetch['afficher_mail'] == 1)
				$string = $fetch['email'];
			else
				$string = "Le membre ne souhaite pas afficher son mail.";
		break;
		case 2:
			$string = $fetch['msn'];
		break;
		case 3:
			$string = $fetch['jabber'];
		break;
	}
	}else{
		$string = "Membre inexistant.";
	}
	header('Content-type: image/png');
	$x = strlen($string) * 9;
	$img = imagecreate($x,20);
	$white = imagecolorallocate($img,255,255,255);
	$black = imagecolorallocate($img,0,0,0);
	imagestring($img,5,0,2,$string,$black);
	imagepng($img);
}
?>
