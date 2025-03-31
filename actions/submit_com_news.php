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
	if (isset ($_POST['texte']) AND !empty ($_POST['texte']) AND strlen(trim($_POST['texte'])) > 2) {
		$idnews = intval($_GET['nid']);
		$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
		$db->requete($sql);
		$auth = $db->fetch();
		$verif = $db->requete("SELECT * FROM nm_comnews WHERE idnews = '$idnews' ORDER BY id_com DESC LIMIT 0,1");
		$verifok = $db->fetch($verif);
		$id_com_user = $db->fetch($db->requete("SELECT * FROM nm_comnews WHERE idnews = '$idnews' AND mid = '$_SESSION[mid]' ORDER BY id_com DESC LIMIT 0,1"));
		$result = $db->requete("SELECT * FROM nm_news WHERE id_news = '$idnews'");
		$is_news = $db->num($result);
		$testNews = $db->fetch($result);
		if (($id_com_user['id_com'] == $verifok['id_com'] AND ($verifok['com_date'] + (3600 * 24)) > time()) OR $auth['ajouter_com'] == 0) {
			$message = 'Vous ne pouvez pas ajouter de commentaire sur cette news pour le moment.';
			$type = 'important';
			$redirection = 'javascript:history.back(-1);';
		} else {
			if ($is_news == 0) {
				$message = 'Le commentaire que vous avez posté n\'est rattaché à aucune news';
				$type = 'important';
				$redirection = 'javascript:history.back(-1);';
			} else {
				if ($testNews['status_news'] == 1 and $testNews['status_com'] == 1) {
					$text_parser = $db->escape(zcode($_POST['texte']));
					$text = htmlentities($_POST['texte'], ENT_QUOTES);
					if (isset ($_POST['sign']))
						$attach_sign = 1;
					else
						$attach_sign = 0;
					$db->requete("INSERT INTO nm_comnews VALUES('','$_SESSION[mid]','$text','$text_parser', '$idnews',UNIX_TIMESTAMP(),'','$attach_sign')");
					$id_com = $db->last_id();
					$db->requete("UPDATE nm_news SET nb_com = nb_com + 1 WHERE id_news = '$idnews'");
					$message = 'Merci d\'avoir commenté !';
					$type = 'ok';
					$redirection = ROOT.'commentaires-de-' . title2url($testNews['titre']) . '-n' . $idnews . '-r'.$id_com.'.html#r' . $id_com;
				} else {
					if($testNews['status_news'] != 1)
						$message = 'Cette news n\'est pas encore validée.';
					elseif($testNews['status_com'] != 1)
						$message = 'Les commentaires de cette news sont désactivés.';
					$type = 'important';
					$redirection = 'javascript:history.back(-1);';
				}
			}
		}
	} else {
		$message = 'Vous n\'avez entré aucun messages ou celui-ci est trop court.';
		$type = 'important';
		$redirection = 'javascript:history.back(-1);';
	}
} else {
	$message = 'Vous devez être enregistré pour pouvoir ajouter un commentaire.';
	$type = 'important';
	$redirection = 'javascript:history.back(-1);';
}

$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
