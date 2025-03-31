<?php
/*
 * Créer le 31 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: l'édition de comentaires de news
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if (!isset ($_SESSION['ses_id'])) {
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = ROOT . 'connexion.html';
	$data = display_notice($message,'important',$redirection);
} else {
	if (!empty ($_GET['m'])) {
		$id_m = intval($_GET['m']);
	} else {
		$db->deconnection();
		$message = "Aucun commentaire de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		echo display_notice($message,'important',$redirection);
		exit;
	}
	$sql = "SELECT * FROM nm_comnews LEFT JOIN nm_news ON nm_news.id_news = nm_comnews.idnews LEFT JOIN membres ON membres.id_m = nm_comnews.mid WHERE nm_comnews.id_com = '$id_m'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	$id_news = $row['id_news'];
	if ($row['status_news'] == 1 AND $row['status_com'] == 1) {
		$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
		$row2 = $db->fetch($db->requete($sql));
		if (($row['mid'] == $_SESSION['mid'] AND $row2['ajouter_com'] == 1) OR ($row2['modifier_com'] == 1)) {
			if (isset ($_POST['texte']) AND !empty ($_POST['texte']) AND strlen(trim($_POST['texte'])) > 2) {
				$text_parser = $db->escape(zcode($_POST['texte']));
				if($row['mid'] == $_SESSION['mid']){
					$edit_part = '<div class="user_edit">Edité {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row['pseudo'].'</a></div>';
				}
				else{
					$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
					$result = $db->fetch($db->requete($sql));
					$edit_part = '<div class="team_edit">Edité {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
				}
				$text_parser .= $edit_part;
				$text = htmlentities($_POST['texte'], ENT_QUOTES);
				if (isset ($_POST['sign']))
					$attach_sign = 1;
				else
					$attach_sign = 0;
				$db->requete("UPDATE nm_comnews SET date_edit = UNIX_TIMESTAMP(), com = '$text',com_parser = '$text_parser',attachSign='$attach_sign' WHERE id_com = '$id_m'");
				$message = "Le commentaire a bien été modifié.";
				$redirection = ROOT.'commentaires-de-' . title2url($row['titre']) . '-n' . $row['id_news'] . '-r'.$id_m.'.html#r' . $id_m;
				$data = display_notice($message,'ok',$redirection);
			}else{
				$message = "Votre message est trop court.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		} else {
			$message = "Vous n'avez pas le droit de modifier ce commentaire.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	} else {
		if ($row['status_news'] != 1)
			$message = "Cette news n'est pas encore validée.";
		elseif ($row['status_com'] != 1) $message = "Les commentaires de cette news sont désactivés.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>