<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	if(!empty($_GET['m'])){
		$auth = $db->fetch_assoc($db->requete("SELECT modifier_com,ajouter_com FROM autorisation_globale WHERE autorisation_globale.id_group = $_SESSION[group]"));
		if($auth['ajouter_com'] == 1){
			$id_com = intval($_GET['m']);
			$db->requete('SELECT pm_comphotos.id_com, pm_comphotos.mid, pm_comphotos.com,pm_comphotos.attachSign, membres.pseudo, pm_photos.id_album, pm_photos.id_categorie, pm_photos.titre, pm_album_photos.nom_categorie FROM pm_comphotos LEFT JOIN pm_photos ON pm_photos.id_album = pm_comphotos.id_photo LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie LEFT JOIN membres ON membres.id_m = pm_comphotos.mid WHERE id_com = \''.$id_com.'\'');
			$row = $db->fetch_assoc();
			if($row['id_com'] != null AND ($_SESSION['mid'] == $row['mid'] OR $auth['modifier_com'] == 1)){
				if(!empty($_POST['texte']) AND strlen(trim($_POST['texte'])) > 4){
					$text_parser = $db->escape(zcode($_POST['texte']));
					$text = htmlentities($_POST['texte'],ENT_QUOTES);
					if($_SESSION['mid'] == $row['mid']){
						$edit_part = '<div class="user_edit">Edité {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row['pseudo'].'</a></div>';
					}
					else{
						$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
						$result = $db->fetch($db->requete($sql));
						$edit_part = '<div class="team_edit">Edité {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
					}
					$text_parser .= $edit_part;
					
					if(!empty($_POST['sign']))
						$sign = 1;
					else
						$sign = 0;
					$db->requete("UPDATE pm_comphotos SET com = '$text', com_parser = '$text_parser', attachSign = '$sign', date_edit = UNIX_TIMESTAMP() WHERE id_com = '$id_com'");
					$message = 'Le commentaire a bien été édité.';
					$redirection = ROOT.'photo-'.title2url($row['titre']).'-commentaires-'.$row['id_album'].'-'.$row['id_com'].'.html#r'.$row['id_com'];
					echo display_notice($message,'ok',$redirection);
				}else{
					$message = 'Votre commentaire est vide ou trop court';
					$redirection = 'javascript:history.back(-1);';
					echo display_notice($message,'important',$redirection);
				}
			}else{
				$message = 'Vous ne pouvez pas éditer ce message.';
				$redirection = 'javascript:history.back(-1);';
				echo display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = 'Vous n\'étes pas autorisé à ajouter de commentaires. Ceci peut être que temporaire.';
			$redirection = ROOT.'index.html';
			echo display_notice($message,'important',$redirection);
		}
	}else{
		$message = 'Aucun commentaire de sélectionner.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>