<?php
include('includes/config.php');
include('includes/db.class.php');
$db = new mysql($sql_serveur,$sql_login,$sql_pass,$sql_bdd,1,'Erreur sur la base de donnée');

$index = intval($_POST['id']);
$id_album = intval($_POST['cat']);
$sql = "SELECT pm_photos.fichier,pm_photos.id_album, pm_photos.commentaire_parser FROM pm_photos WHERE id_categorie = '$id_album' ORDER BY date DESC LIMIT $index,1";
$img = $db->fetch_assoc($db->requete($sql));
$out = '<?xml version="1.0"?>';
$cat = ceil($img['id_album'] / 1000);
$size = getimagesize('images/album/'.$cat.'/'.$img['fichier']);
if($size[0] > 800 OR $size[1] > 600){
	if($size[0] > $size[1]){
		$x = 800;
		$y = 600;
	}
	elseif($size[0] < $size[1]){
		$x = 450;
		$y = 600;
	}
	else{
		$x = 600;
		$y = 600;
	}
	$facteurx = $x / $size[0];
	$facteury = $y / $size[1];
	if($facteurx <= $facteury)
		$facteury = $facteurx;
	else
		$facteurx = $facteury;
	$size[0] = ceil($size[0] * $facteurx);
	$size[1] = ceil($size[1] * $facteury);
}

$out .= '<reponse><dir>'.$cat.'</dir><message>'.$img['fichier'].'</message><width>'.$size[0].'</width><height>'.$size[1].'</height><cat>'.$cat.'</cat><com>'.str_replace(array('&','&amp;quot;','<','>','"'),array('&amp;','&amp;amp;quot;','&lt;','&gt;','&amp;quot;'),$img['commentaire_parser']).'</com></reponse>';
header('Content-Type: text/xml');
echo $out;
$db->deconnection();
?>
