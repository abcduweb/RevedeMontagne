<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
if (isset ($_SESSION['ses_id'])) {
	if(!empty($_GET['pid'])){
		$pid = intval($_GET['pid']);
		if (isset ($_POST['texte']) AND !empty ($_POST['texte']) AND strlen(trim($_POST['texte'])) > 2) {
			$sql = "SELECT id_album, pm_photos.id_categorie, pm_album_photos.nom_categorie, pm_comphotos.mid, pm_comphotos.com_date  FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie LEFT JOIN pm_comphotos ON pm_comphotos.id_photo = pm_photos.id_album WHERE id_album = '$pid'";
			$db->requete($sql);
			$row = $db->fetch_assoc();
			if($db->num() > 0){
				$sql = "SELECT ajouter_com FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
				$db->requete($sql);
				$right = $db->row();
				if($right[0] == 1){
					if($row['mid'] != $_SESSION['mid'] OR ($row['mid'] == $_SESSION['mid'] AND $row['com_date'] + (24 * 3600) < time())){
						$text_parser = $db->escape(zcode($_POST['texte']));
						$text = htmlentities($_POST['texte'],ENT_QUOTES);
						if(!empty($_POST['sign']))
							$sign = 1;
						else
							$sign = 0;
						$sql = "INSERT INTO pm_comphotos VALUES('','$_SESSION[mid]','$pid','$text','$text_parser',UNIX_TIMESTAMP(),'','$sign')";
						$db->requete($sql);
						$msg_id = $db->last_id();
						$db->requete("UPDATE pm_photos SET nbcom = nbcom + 1 WHERE id_album = '$pid'");
						$message = "Votre commentaire a bien été ajouté.";
						$redirection = ROOT.'photo-'.title2url($row['nom_categorie']).'-commentaires-'.$pid.'-'.$msg_id.'.html#r'.$msg_id;
						$data = display_notice($message,'ok',$redirection);
					}else{
						$message = "Vous êtes le dernier à avoir ajouter un commentaire. Vous devez donc attendre 24H avant d'ajouter un nouveau commentaire.";
						$redirection = ROOT.'photo-'.title2url($row['nom_categorie']).'-commentaires-'.$pid.'.html';
						$data = display_notice($message,'important',$redirection);
					}
				}else{
					$redirection = ROOT.'photo-'.title2url($row['nom_categorie']).'-commentaires-'.$pid.'.html';
					$data = display_notice("Vous n'avez pas le droit d'ajouter de commentaires. Ceci n'est peut être que temporaire.",'important',$redirection);
				}
			}else{
				$data = display_notice("La photo sélectionnée n'existe pas.",'important',ROOT.'album-photos.html');
			}
		}
	}else{
		$data = display_notice("Aucune photo de sélectionner.",'important',ROOT.'album-photos.html');
	}
}else{
	$data = display_notice("Vous devez être enregistrer pour ajouter des commentaires.",'important',ROOT.'connexion.html');
}
$db->deconnection();
echo $data;