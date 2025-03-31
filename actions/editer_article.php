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
	if(isset($_GET['artid']) AND !empty($_GET['artid'])){
		$id_article = intval($_GET['artid']);
		$sql = "SELECT * FROM articles_intro_conclu WHERE id_article = '$id_article'";
		$result = $db->requete($sql);
		$row = $db->fetch($result);
		$num = $db->num($result);
		if(($row['id_membre'] == $_SESSION['mid'] AND $auth['ajouter_article'] == 1) OR $auth['administrateur_article'] == 1){
			if(isset($_GET['partid']) AND !empty($_GET['partid'])){
				$id_part = intval($_GET['partid']);
				$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' AND num = '$id_part'";
				$is_existing = $db->num($db->requete($sql));
				if($is_existing == 1){
					if((isset($_POST['titre']) AND strlen(trim($_POST['titre'])) > 1) AND (isset($_POST['texte']) AND strlen(trim($_POST['texte'])) > 1)){
						$titre = htmlentities($_POST['titre'],ENT_QUOTES);
						$texte_parser = $db->escape(zcode($_POST['texte']));
						//echo $texte_parser;
						$texte = htmlentities($_POST['texte'],ENT_QUOTES);
						$sql = "UPDATE articles_part SET titre_part = '$titre',texte_part = '$texte', texte_part_parse = '$texte_parser' WHERE id_article_attach = '$id_article' AND num = '$id_part'";
						$db->requete($sql);
						$message = "L'article a bien été modifié.";
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
						$message = "Vous n'avez pas entré de titre ou de texte";
						$type = "important";
						$redirection = "javascript:history.back(-1);";
					}
				}
				else{
					$message = "L'article ne posséde pas cette partie.";
					$type = "important";
					$redirection = ROOT."index.php";
				}
			}
			else{
				if((isset($_POST['titre']) AND strlen(trim($_POST['titre'])) > 1) AND (isset($_POST['intro']) AND strlen(trim($_POST['intro'])) > 1)){
					if($num > 0){
						$titre = htmlentities($_POST['titre'],ENT_QUOTES);
						$intro_parser = $db->escape(zcode($_POST['intro']));
						$intro = htmlentities($_POST['intro'],ENT_QUOTES);
						$conclu_parser = $db->escape(zcode($_POST['conclu']));
						$conclu = htmlentities($_POST['conclu'], ENT_QUOTES);
						$sql = "UPDATE articles_intro_conclu SET titre = '$titre', intro = '$intro', intro_parse = '$intro_parser', conclu = '$conclu', conclu_parse = '$conclu_parser' WHERE id_article = '$id_article'";
						$db->requete($sql);
						$message = "L'article a bien été modifié";
						$type = "ok";
						$redirection = ROOT."editer-article-$id_article.html";
						if(isset($_SESSION['tmp_Img'])){
							$sql = "UPDATE images SET tmp = '0' WHERE dir = '4' AND s_dir = '$id_article' AND tmp = '1'";
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
						$message = "Cet article n'existe pas.";
						$type = "important";
						$redirection = "javascript:history.back(-1);";
					}
				}
				else{
					$message = "Vous n'avez pas entré de titre ou de texte.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
		}
		else{
			$message = "Vous n'avez pas le droit d'éditer cet article.";
			$type = "erreur";
			$redirection = ROOT."index.php";
		}
	}
	else{
		$message = "Aucun article de sélectionner.";
		$type = "important";
		$redirection = ROOT."index.php";
	}
}
else
{
	$message = "Vous devez être enregistrer pour modifier un article.";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
