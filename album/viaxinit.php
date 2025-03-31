<?php
include('../includes/config.php');
include('../includes/db.class.php');
$db = new mysql($sql_server,$sql_login,$sql_pass,$sql_bdd,1,'Erreur sur la base de donnée');

$index = intval($_POST['id']);
$id_album = intval($_POST['cat']);
$sql = "SELECT * FROM pm_photos WHERE id_categorie = '$id_album' ORDER BY date DESC LIMIT $index,1";
$img = $db->fetch($db->requete($sql));
$out = '<?xml version="1.0"?>';
$cat = ceil($img['id_album'] / 1000);
$size = getimagesize('images/album/'.$cat.'/'.$img['fichier']);
if($size[0] > 800 OR $size[1] > 600)
{
	if($size[0] < 800 AND $size[1] > 600){
		$facteurx = $size[1] / 600;
		$facteury = $facteurx;
	}
	elseif($size[0] > 800 AND $size[1] < 600){
		$facteurx = $size[0] / 800;
		$facteury = $facteurx;
	}
	elseif($size[0] > 800 AND $size[1] > 600)
	{
		$facteurx = $size[0] / 800;
		$facteury = $size[1] / 600;
	}
	$size[0] = $size[0] / $facteurx;
	$size[1] = $size[1] / $facteury;
}
$out .= '<reponse><dir>'.$cat.'</dir><message>'.$img['fichier'].'</message><width>'.$size[0].'</width><height>'.$size[1].'</height><cat>'.$cat.'</cat></reponse>';
header('Content-Type: text/xml');
echo $out;
?>