<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if(isset($_POST['pid']) AND !empty($_POST['pid']) AND isset($_POST['titre']) AND strlen(trim($_POST['titre'])) > 3){
		$pid = intval($_POST['pid']);
		$sql = "SELECT * FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie WHERE id_album = '$pid'";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			$row = $db->fetch($result);
			$titre = htmlentities($_POST['titre'],ENT_QUOTES);
			$commentaire_parser = $db->escape(zcode($_POST['texte']));
			$commentaire = htmlentities($_POST['texte'],ENT_QUOTES);
			if(($row['mid'] == $_SESSION['mid'] AND $auth['ajouter_photo'] == 1) OR $auth['supprimer_photo'] == 1){
				if(isset($_FILES['fichier']['name']) and !empty($_FILES['fichier']['name'])){
					$poids_max = 307200;
					$dir = ceil($pid/1000);
					$repertoire = '../images/album/'.$dir.'/';
					$nom_fichier = $row['fichier'];
					$extention = explode('.',$nom_fichier);
					if(!isset($extention[1])){
						$size = getimagesize($_FILES['fichier']['tmp_name']);
						$extention = array('image/png'=>".png",'image/jpeg'=>".jpeg","image/jpg"=>".jpg",'image/gif'=>'.gif','image/JPG'=>'jpg','image/JPEG'=>'.jpeg');
						$nom_fichier .= $extention[$size['mime']];
					}
					$up = upload('fichier',$repertoire,$nom_fichier,$poids_max);
					if($up['type'] == 'ok'){
						miniaturisation($nom_fichier,ROOT.'images/album/'.$dir);
						$size = getimagesize($repertoire.$nom_fichier);
						$sql = "UPDATE pm_photos SET titre = '$titre',commentaire_parser = '$commentaire_parser', commentaire = '$commentaire',fichier = '$nom_fichier', taille = '".$_FILES['fichier']['size']."', largeur = '$size[1]', hauteur = '$size[0]',datemodif = UNIX_TIMESTAMP() WHERE id_album = '$pid'";
						$message = "La photo a bien été modifiée.";
						$type = 'ok';
						if($_SESSION['mid'] != $row['mid'])
							$redirection = ROOT.'admin.html';
						else
							$redirection = ROOT.'photos-'.title2url($row['nom_categorie']).'-'.$row['id_categorie'].'.html';
						$db->requete($sql);
					}
					else{
						$message = $up['message'];
						$type = $up['type'];
						$redirection = 'javascript:history.back(-1)';
					}
				}
				else{
					$sql = "UPDATE pm_photos SET titre = '$titre',commentaire_parser = '$commentaire_parser', commentaire = '$commentaire', datemodif = UNIX_TIMESTAMP() WHERE id_album = '$pid'";
					$message = "La photo a bien été modifiée.";
					$type = 'ok';
					if($_SESSION['mid'] != $row['mid'])
						$redirection = ROOT.'admin.html';
					else
						$redirection = ROOT.'photos-'.title2url($row['nom_categorie']).'-'.$row['id_categorie'].'.html';
					$db->requete($sql);
				}
			}
			else{
				if($auth['ajouter_photo'] != 1)
					$message = "Vous ne pouvez pas ajouter/modifier de photos. Ceci est peut être que temporaire.";
				else
					$message = "Vous n'étes pas autorisé à modifier cette photo.";
				$type = "important";
				$redirection = ROOT."admin.html";
			}
		}
		else{
			$message = "La photo sélectionnée n'existe pas.";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		}
	}
	else{
		if(isset($_GET['pid']) AND !empty($_GET['pid'])){
			if(isset($_POST['titre']) AND strlen(trim($_POST['titre'])) < 3){
				$message = "Vous n'avez entré aucun titre";
				$type = "important";
				$redirection = "javascript:history.back(-1)";
			}
		}
		else{
			$message = "Vous n'avez sélectionné aucune photo.";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		}
	}
}
else{
	$message = "Vous n'avez pas le droit d'accéder à cette partie.";
	$type = "important";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>