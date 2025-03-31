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
		if($row['id_membre'] == $_SESSION['mid'] OR $auth['administrateur_article'] == 1){
			if($db->num($result) > 0){
				if(isset($_POST['valider']) AND $_POST['valider'] == 1){
					$db->requete("DELETE FROM articles_part WHERE id_article_attach = '$id_article' AND num = '$id_part'");
					$db->requete("UPDATE articles_part SET num = num - 1 WHERE id_article_attach = '$id_article' AND num > '$id_part'");
					$data = get_file(TPL_ROOT."system_ei.tpl");
					$message = "Partie supprimée.";
					$redirection = ROOT."editer-article-$id_article.html";
					$data = display_notice($message,'ok',$redirection);
				}else{
					$url = "supprimer_partie.php?partid=$id_part&amp;artid=$id_article";
					$message = "Etes vous sûr de vouloir supprimer cette partie?";
					$data = display_confirm($message,$url);
				}
			}
			else{
				$message = "Cet article n'existe pas.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = "Vous n'avez pas le droit d'éditer cet article.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Aucun article et/ou aucune partie de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
else{
	$message = "Vous devez être enregistrer pour modifier un article.";
	$redirection = ROOT."connexion.html";
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>