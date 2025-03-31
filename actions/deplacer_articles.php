<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if(isset($_GET['artid']) AND !empty($_GET['artid'])){
		$id_article = intval($_GET['artid']);
		$sql = "SELECT * FROM articles_intro_conclu LEFT JOIN articles ON articles.BD = articles_intro_conclu.id_cat WHERE id_article = '$id_article'";
		$result = $db->requete($sql);
		$row = $db->fetch($result);
		$num = $db->num($result);
		if($auth['administrateur_article'] == 1 AND $num > 0){
			if(isset($_POST['cat']) AND !empty($_POST['cat'])){
				$cat = explode('|',$_POST['cat']);
				$cat = intval($cat[0]);
				$sql = "SELECT * FROM articles WHERE BD = '$cat'";
				$result = $db->requete($sql);
				$infoCat = $db->fetch($result);
				if($db->num($result) > 0){
					$sql = "UPDATE articles SET properties = properties - 1 WHERE BG <= $row[BG] AND BD >= $row[BD]";
					$db->requete($sql);
					$sql = "UPDATE articles SET properties = properties + 1 WHERE BG <= $infoCat[BG] AND BD >= $infoCat[BD]";
					$db->requete($sql);
					$sql = "UPDATE articles_intro_conclu SET id_cat = '$cat' WHERE id_article = '$id_article'";
					$db->requete($sql);
					$message = 'L\'article a bien &eacute;t&eacute; d&eacute;plac&eacute;.';
					$type = 'ok';
					$redirection = ROOT.'liste-articles-1.html';
				}
				else{
					$message = 'La cat&eacute;gorie demand&eacute;e n\'existe pas.';
					$type = 'important';
					$redirection = ROOT.'liste-articles-1.html';
				}
			}
			else{
				$message = 'Aucune cat&eacute;gorie n\'a &eacute;t&eacute; s&eacute;lectionn&eacute;e.';
				$type = 'important';
				$redirection = ROOT.'liste-articles-1.html';
			}
		}
		else{
			$message = "Vous n'avez pas le droit de d&eacute;placer cet article.";
			$type = "erreur";
			$redirection = ROOT."index.php";
		}
	}
	else{
		$message = "Aucun article de s&eacute;lectionner.";
		$type = "important";
		$redirection = ROOT."liste-articles-1.html";
	}
}
else{
	$message = "Vous devez être enregistrer pour demander la validation d'un article.";
	$type = "important";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>