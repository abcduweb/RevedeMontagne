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
	if((isset($_GET['partid']) AND !empty($_GET['partid'])) AND (isset($_GET['artid']) AND !empty($_GET['artid']))){
		$id_article = intval($_GET['artid']);
		$id_part = intval($_GET['partid']);
		$sql = "SELECT * FROM articles_part LEFT JOIN articles_intro_conclu ON (articles_intro_conclu.id_article = articles_part.id_article_attach) WHERE id_article_attach = '$id_article' AND num = '$id_part'";
		$result = $db->requete($sql);
		$row = $db->fetch($result);
		if($row['id_membre'] == $_SESSION['mid'] OR $auth['modifier_topo'] == 1){
			if($db->num($result) > 0){
				if(isset($_GET['action']) AND $_GET['action'] == "up"){
					$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' AND num = $id_part - 1";
					$result = $db->requete($sql);
					if($db->num($result) > 0){
						$db->requete("UPDATE articles_part SET num = 0 WHERE id_article_attach = '$id_article' AND num = $id_part - 1");
						$db->requete("UPDATE articles_part SET num = num - 1 WHERE id_article_attach = '$id_article' AND num = $id_part");
						$db->requete("UPDATE articles_part SET num = $id_part WHERE id_article_attach = '$id_article' AND num = 0");
						$message = "Partie montée.";
						$type = "ok";
						$redirection = ROOT."editer-article-$id_article.html";
					}
					else{
						$message = "Cette partie ne peut être montée.";
						$type = "important";
						$redirection = ROOT."editer-article-$id_article.html";
					}
				}
				elseif(isset($_GET['action']) AND $_GET['action'] == "dwn"){
					$sql = "SELECT * FROM articles_part WHERE id_article_attach = '$id_article' AND num = $id_part + 1";
					$result = $db->requete($sql);
					if($db->num($result) > 0){
						$db->requete("UPDATE articles_part SET num = 0 WHERE id_article_attach = '$id_article' AND num = $id_part + 1");
						$db->requete("UPDATE articles_part SET num = num + 1 WHERE id_article_attach = '$id_article' AND num = $id_part");
						$db->requete("UPDATE articles_part SET num = $id_part WHERE id_article_attach = '$id_article' AND num = 0");
						$message = "Partie descendu.";
						$type = "ok";
						$redirection = ROOT."editer-article-$id_article.html";
					}
					else{
						$message = "Cette partie ne peut être descendue.";
						$type = "important";
						$redirection = ROOT."editer-article-$id_article.html";
					}
				}
				else{
					$message = "Action invalide";
					$type = "erreur";
					$redirection = ROOT."index.php";
				}
			}
			else{
				$message = "Cet article n'existe pas.";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		}
		else{
			$message = "Vous n'avez pas le droit d'éditer cet article.";
			$type = "erreur";
			$redirection = ROOT."index.php";
		}
	}
	else{
		$message = "Aucun article et/ou aucune partie de sélectionner.";
		$type = "important";
		$redirection = ROOT."index.php";
	}
}
else{
	$message = "Vous devez être enregistrer pour modifier un article.";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
$data = display_notice($message,$type,$redirection);
echo $data;
?>