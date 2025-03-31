<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if((isset($_POST['titre']) AND strlen(trim($_POST['titre'])) > 1) AND (isset($_POST['intro']) AND strlen(trim($_POST['intro'])) > 1)){
		if(isset($_GET['artid']) AND !empty($_GET['artid'])){
			$id_article = intval($_GET['artid']);
			$sql = "SELECT * FROM articles_intro_conclu WHERE id_article = '$id_article'";
			$result = $db->requete($sql);
			$row = $db->fetch($result);
			if($db->num($result) > 0){
				if(($row['id_membre'] == $_SESSION['mid'] AND $auth['ajouter_article'] == 1) OR $auth['modifier_topo'] == 1){
					$artid = intval($_GET['artid']);
					$titre = htmlentities($_POST['titre'],ENT_QUOTES);
					$texte_parser = $db->escape(zcode($_POST['intro']));
					$texte = htmlentities($_POST['intro'],ENT_QUOTES);
					$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' ORDER BY num DESC";
					$last = $db->fetch($db->requete($sql));
					$num = $last['num'] + 1;
					$sql = "INSERT INTO articles_part VALUES('','$id_article',$num,'$titre','$texte','$texte_parser')";
					$db->requete($sql);
					$message = "La partie à bien été ajoutée.";
					$type = "ok";
					$redirection = ROOT."editer-article-$id_article.html";
					if(isset($_SESSION['tmp_Img'])){
						$sql = "UPDATE images SET tmp = '0' WHERE dir = '4' AND s_dir = '$id_article' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
						$db->requete($sql);
						if(isset($_SESSION['SsubDir']['tmp'])){
              $key = array_keys($_SESSION['SsubDir']['tmp']);
              unset($_SESSION['dir'.$key[0]]);
              unset($_SESSION['SsubDir']);
            }
            unset($_SESSION['tmp_Img']);
					}
				}
				else{
					$message = "Vous n'avez pas le droit d'éditer cet article.";
					$type = "important";
					$redirection = ROOT."index.php";
				}
			}
			else{
				$message = "Cet article n'existe pas.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
		}
		else{
			$message = "Aucun article de sélectionner.";
			$type = "important";
			$redirection = ROOT."index.php";
		}
	}
	else{
		$message = "Vous n'avez pas entré de titre et/ou de texte.";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
	}
}
else{
	$message = "Vous devez être enregistrer pour modifier un article.";
	$type = "important";
	$redirection = ROOT."connexion.html";
}
echo display_notice($message,$type,$redirection);
?>
