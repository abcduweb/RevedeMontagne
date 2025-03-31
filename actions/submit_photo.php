<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

require_once(ROOT.'fonctions/divers.fonction.php');
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/zcode.fonction.php');

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
else
{
	if(isset($_POST['titre']) AND !empty($_POST['titre']) AND strlen(trim($_POST['titre'])) > 3 AND !empty($_POST['texte']) AND !empty($_POST['cat']))
	{
		$titre = htmlentities ($_POST['titre'], ENT_QUOTES);
		$message = htmlentities ($_POST['texte'], ENT_QUOTES);
		$text_parser = $db->escape(zcode($_POST['texte']));
		$_POST['cat'] = intval($_POST['cat']);
		$poids_max = 50000000;
		
		$repertoire = '../images/temp/';
		$extention = array('image/png'=>".png",'image/jpeg'=>".jpeg","image/jpg"=>".jpg",'image/gif'=>'.gif','image/JPG'=>'jpg','image/JPEG'=>'.jpeg');
		$mimetype = getimagesize($_FILES['fichier']['tmp_name']);
		$nom_fichier = str_replace('.','',uniqid(mt_rand(),true)).$extention[strtolower($mimetype['mime'])];
		$up = upload('fichier',$repertoire,$nom_fichier,$poids_max);
		$categories = $db->requete('SELECT pm_album_photos.id_categorie, pm_album_photos.nom_categorie from pm_album_photos WHERE id_categorie = '.$_POST['cat'].'');
		$num = $db->num();
		$reponse = $db->fetch_assoc($categories);
		if ($up['type'] == 'ok' AND $num > 0)//test upload valide;
		{			
			$categ = $reponse['id_categorie'];
			$size = getimagesize($repertoire.$nom_fichier);
			$db->requete("INSERT INTO pm_photos VALUES ('','$titre','$message','$text_parser','$nom_fichier','".$_FILES['fichier']['size']."','$size[1]','$size[0]','$_SESSION[mid]',UNIX_TIMESTAMP(),0,UNIX_TIMESTAMP(),'$categ')");
			$id = $db->last_id();
			$dir = ceil($id/1000);
			if(!is_dir(ROOT.'images/album/'.$dir)){
				mkdir(ROOT.'images/album/'.$dir);
				mkdir(ROOT.'images/album/'.$dir.'/mini');
			}
			rename(ROOT.'images/temp/'.$nom_fichier,ROOT.'images/album/'.$dir.'/'.$nom_fichier);
			miniaturisation($nom_fichier,ROOT.'images/album/'.$dir);
			$db->requete("UPDATE pm_album_photos SET nb_images = nb_images + 1 WHERE id_categorie = '$categ'");
			include(ROOT.'caches/.htcache_index');
			$cache['image'] = array('categorie' => $reponse['nom_categorie'],'id_categorie'=>$_POST['cat'],'image' => $nom_fichier,'titre' => $titre,'description' => $message,'titre_url'=>title2url($reponse['nom_categorie']),'album'=>$dir);
			write_cache(ROOT.'caches/.htcache_index',array('cache'=>$cache));//régénération du cache index.
		}
		if($num < 1){
			$message = 'La catégorie demandée n\'existe pas';
			$type = 'important';
			$redirection = 'javascript:history.back(-1);';
		}else{
			$message = $up['message'];
			$type = $up['type'];
			if($type == 'ok')
				$redirection = ROOT.'album-'.title2url($reponse['nom_categorie']).'-c'.$_POST['cat'].'.html';
			else
				$redirection = 'javascript:history.back(-1);';
		}
	}
	else
	{
		$message = 'Un champs au moins est vide';
		$type = 'important';
		$redirection = 'javascript:history.back(-1)';
	}
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
