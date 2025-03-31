<?php
/*
 * Créer le 28 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: la suppression de fichier uploader
 */
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
		$sql = "SELECT * FROM images LEFT JOIN images_folder ON images_folder.id_folder = images.dir WHERE id_image = '$pid'";
		$result = $db->requete($sql);
		if ($db->num($result) > 0) {
			$row = $db->fetch($result);
			if (($row['id_owner'] == $_SESSION['mid'] AND $auth['ajouter_photo'] == 1) OR $auth['supprimer_photo'] == 1) {
				if (isset ($_POST['valider']) AND $_POST['valider'] == 1) {
					$sql = "DELETE FROM images WHERE id_image = '$pid'";
					$db->requete($sql);
					unlink(ROOT.'images/autres/'.ceil($pid/1000).'/'.$row['nom']);
					unlink(ROOT.'images/autres/'.ceil($pid/1000).'/mini/'.$row['nom']);
					$data = get_file(TPL_ROOT . 'system_ei.tpl');
					$message = 'L\'image a bien été supprimée.';
					if($row['id_owner'] == $_SESSION['mid']){
						$redirection = ROOT . 'upload-'.$row['dir'];
						if($row['s_dir'] != 0)
							$redirection .= '-'.$row['s_dir'];
						if(!empty($_GET['textarea']))
							$redirection .= '-'.htmlentities($_GET['textarea']).'.html';
						else
							$redirection .= '.html';
					}else{
						$redirection = ROOT.'admin.html';
					}
					$data = display_notice($message,'ok',$redirection);
				} else {
					$url = 'supprimer_upload.php?pid='.$pid;
					$message = "Etes vous sûr de vouloir supprimer cette image?";
					$data = display_confirm($message,$url);
				}
			}else{
				$message = "Vous ne pouvez pas supprimer cette image.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		}else{
			$message = "Cette image n'existe pas.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	} else {
		$message = "Aucune image de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>