<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

if(!empty($_GET['idp']))
{
	$idp = intval($_GET['idp']);
	
	$extention = array('image/png'=>".png",'image/jpeg'=>".jpeg","image/jpg"=>".jpg",'image/gif'=>'.gif','image/JPG'=>'.jpg','image/JPEG'=>'.jpeg');
	$mimetype = getimagesize($_FILES['upl']['tmp_name']);
	$fileName = str_replace('.','',uniqid(mt_rand(),true)).$extention[strtolower($mimetype['mime'])];

	$up = upload('upl',ROOT.'/images/autres/1/',$fileName,'7168000');
	
	$size = getimagesize(ROOT.'images/autres/1/'.$fileName);
	$titre = $_FILES['upl']['name'];
	$db->requete("INSERT INTO images VALUES ('','$_SESSION[mid]','$fileName','$titre','".$_FILES['upl']['size']."','$size[1]','$size[0]','10','$idp','0')");
	$id_photo = $db->last_id();
	$db->requete("INSERT INTO album_sorties VALUES ('$id_photo', '$idp')");
	
	miniaturisation($fileName,ROOT.'images/autres/1/');


		if($up['type'] == 'ok'){
			echo '{"status":"success"}';
			exit;
		}
		else{		
			echo '{"status":"error"}';
			exit;
		}
}
else{
	echo '{"status":"error"}';
	exit;
}
echo '{"status":"error"}';
exit;
$db->deconnection();
?>
