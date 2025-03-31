<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez �tre enregistr� pour pouvoir acc�der � cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	if(!empty($_GET['m'])){
		$auth = $db->fetch_assoc($db->requete("SELECT supprimer_com FROM autorisation_globale WHERE autorisation_globale.id_group = $_SESSION[group]"));
		if($auth['supprimer_com'] == 1){
			$id_com = intval($_GET['m']);
			$db->requete('SELECT pm_comphotos.id_com, pm_photos.id_album, pm_photos.titre FROM pm_comphotos LEFT JOIN pm_photos ON pm_photos.id_album = pm_comphotos.id_photo WHERE id_com = \''.$id_com.'\'');
			$row = $db->fetch_assoc();
			if($row['id_com'] != null){
				if(!empty($_POST['valider']) AND $_POST['valider'] == 1){
					$db->requete('DELETE FROM pm_comphotos WHERE id_com = \''.$id_com.'\'');
					$db->requete('UPDATE pm_photos SET nbcom = nbcom - 1 WHERE id_album = \''.$row['id_album'].'\'');
					$redirection = ROOT.'photo-'.title2url($row['titre']).'-commentaires-'.$row['id_album'].'.html';
					echo display_notice('Le commentaire a bien �t� supprim�.','ok',$redirection);
				}else{
					$message = "Etes vous s�r de vouloir supprimer ce commentaire?";
					$url = "supprimer_com_photo.php?m=$id_com";
					echo display_confirm($message,$url);
				}
			}else{
				$message = 'Vous ne pouvez pas �diter ce message.';
				$redirection = 'javascript:history.back(-1);';
				echo display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = 'Vous n\'�tes pas autoris� � ajouter de commentaires. Ceci peut �tre que temporaire.';
			$redirection = ROOT.'index.html';
			echo display_notice($message,'important',$redirection);
		}
	}else{
		$message = 'Aucun commentaire de s�lectionner.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>