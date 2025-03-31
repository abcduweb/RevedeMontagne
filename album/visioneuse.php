<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_GET['cat']) OR empty($_GET['cat']))
{
	$message = "Vous n'avez pas selectionner d'album";
	$redirection = "album-photos.html";
	$type = "important";
	echo display_notice($message,'important',$redirection);
}
else{
	if(isset($_GET['index']) AND !empty($_GET['index']))
		$index = intval($_GET['index']);
	else
		$index = 0;
	$_GET['cat'] = intval($_GET['cat']);
	$sql = "SELECT * FROM pm_photos WHERE  id_categorie = '$_GET[cat]'";
	$result = $db->requete($sql);
	$nb_img = $db->num($result);
	if($nb_img > 0){
		$data = get_file(TPL_ROOT.'visioneuse.tpl');
		$sql = "SELECT pm_photos.id_album, pm_photos.fichier, pm_album_photos.id_categorie,
		pm_album_photos.nom_categorie FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie WHERE pm_photos.id_categorie = '$_GET[cat]' ORDER BY date DESC LIMIT $index,1";
		$img = $db->fetch_assoc($db->requete($sql));
		if($index == $nb_img-1)
			$next = 0;
		else
			$next = $index + 1;
		if($index == 0)
			$prev  = $nb_img - 1;
		else
			$prev = $index - 1;
		$var = array('index_prev'=>$prev,'index_next'=>$next,'cat' => $img['id_categorie'],'dir'=>ceil($img['id_album'] / 1000),'img_start'=>$img['fichier'],'index'=>$index,'nb_img'=>$nb_img);
		$data = parse_var($data,$var);
		$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>$img['nom_categorie'].' - '.SITE_TITLE,'titre_url'=>title2url($img['nom_categorie']),'DOMAINE'=>DOMAINE));
	}
	else{
		$message = "Cet album ne contient aucune photos.";
		$redirection = "album-photos.html";
		$data = display_notice($message,'important',$redirection);
	}
	echo $data;
}
?>