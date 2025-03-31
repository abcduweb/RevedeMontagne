<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if (!isset ($_SESSION['ses_id'])) {
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = ROOT . 'connexion.html';
	$data = display_notice($message,'important',$redirection);
} else {
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if (!empty ($_GET['pid'])) {
		$pid = intval($_GET['pid']);
		$sql = "SELECT * FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie WHERE id_album = '$pid'";
		$result = $db->requete($sql);
		if ($db->num($result) > 0) {
			$row = $db->fetch($result);
			if (($row['mid'] == $_SESSION['mid'] AND $auth['ajouter_photo'] == 1) OR $auth['supprimer_photo'] == 1) {
				if (isset ($_POST['valider']) AND $_POST['valider'] == 1) {
					$sql = "DELETE FROM pm_photos WHERE id_album = '$pid'";
					$db->requete($sql);
					$sql = "UPDATE pm_album_photos SET nb_images = nb_images - 1 WHERE id_categorie = '$row[id_categorie]'";
					$db->requete($sql);
					unlink(ROOT.'images/album/'.ceil($pid/1000).'/'.$row['fichier']);
					unlink(ROOT.'images/album/'.ceil($pid/1000).'/mini/'.$row['fichier']);
					$message = 'La photo a bien été supprimée.';
					if($row['mid'] == $_SESSION['mid']){
						$redirection = ROOT . 'photos-'.title2url($row['regroupement']).'-'.$row['id_categorie'].'.html';
					}else{
						$redirection = ROOT.'admin.html';
					}
					$data = display_notice($message,'ok',$redirection);
				} else {
					$url = 'supprimer_photo.php?pid='.$pid;
					$message = "Etes vous sûr de vouloir supprimer cette photo?";
					$data = display_confirm($message,$url);
				}
			}else{
				$message = "Vous ne pouvez pas supprimer cette photo.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		}else{
			$message = "Cette photo n'existe pas.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	} else {
		$message = "Aucune photo de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>