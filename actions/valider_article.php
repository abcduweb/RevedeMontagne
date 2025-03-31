<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/geo.fonction.php');
if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if(isset($_GET['artid']) AND !empty($_GET['artid'])){
		$id_article = intval($_GET['artid']);
		$sql = "SELECT * FROM articles_intro_conclu LEFT JOIN articles ON articles.BD = articles_intro_conclu.id_cat WHERE id_article = '$id_article' AND (article_status = 2 OR article_status = 1)";
		$result = $db->requete($sql);
		$num = $db->num($result);
		$row = $db->fetch($result);
		if($auth['administrateur_article'] == 1 AND $row['id_membre'] != $_SESSION['mid']){
			if($num > 0){
				if(!isset($_GET['action']))
					$action = 3;
				else{
					if($_GET['action'] == 0 OR $_GET['action'] == 1){
						if($_GET['action'] == 0)
							$action = 3;
						else
							$action = 1;
					}
					else{
						$message = "Action invalide.";
						$redirection = ROOT."index.php";
						$data = display_notice($message,'important',$redirection);
					}
				}
				if(isset($_POST['valider']) AND $_POST['valider'] == 1){
					$sql = "UPDATE articles_intro_conclu SET article_status = '$action', date_article = UNIX_TIMESTAMP() WHERE id_article = '$id_article'";
					$db->requete($sql);
					if($action == 1){
						$sql = "UPDATE articles SET properties = properties + 1 WHERE BG <= $row[BG] AND BD >= $row[BD]";
						$db->requete($sql);
							unlink(ROOT.'caches/.htcache_index');
						if($row['BG'] >= 15 AND $row['BD'] <= 24){
							$result = $db->requete("SELECT num,titre_part,texte_part_parse FROM articles_part WHERE id_article_attach =$row[id_article]");
							while($refuge = $db->fetch_assoc($result)){
								addRefuge($row['id_article'],$refuge['num'],$refuge['titre_part'], $refuge['texte_part_parse']);
							}
						}
					}else{
						if($row['article_status'] == '1'){
							$sql = "UPDATE articles SET properties = properties - 1 WHERE BG <= $row[BG] AND BD >= $row[BD]";
							$db->requete($sql);
							$db->requete("DELETE FROM refuges WHERE id_article = '$row[id_article]'");
							unlink(ROOT.'caches/.htcache_index');
						}
					}
					if($action == 1 AND $row['article_status'] == '2'){
						$sql = "INSERT INTO messages_discution VALUES('','','Votre article : $row[titre] a été validé','Votre article : $row[titre] a été validé',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
            			$db->requete($sql);
            			$idM = $db->last_id();
            			$sql = "INSERT INTO liste_discutions VALUES('','<strong>[ARTICLES]</strong> Validation d\'articles','',$idM,'$_SESSION[mid]',1,0,0)";
            			$db->requete($sql);
            			$idDiscu = $db->last_id();
            			$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
            			$db->requete("INSERT INTO discutions_lues VALUES('$row[id_membre]','$idDiscu','0','1')");
					}elseif($row['article_status'] == 1){
						$sql = "INSERT INTO messages_discution VALUES('','','Votre article : $row[titre] a été dévalidé','Votre article : $row[titre] a été dévalidé. Pour plus d\'information contactez moi.',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
            			$db->requete($sql);
            			$idM = $db->last_id();
            			$sql = "INSERT INTO liste_discutions VALUES('','<strong>[ARTICLES]</strong> Dévalidation d\'articles','',$idM,'$_SESSION[mid]',1,0,0)";
            			$db->requete($sql);
            			$idDiscu = $db->last_id();
            			$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
            			$db->requete("INSERT INTO discutions_lues VALUES('$row[id_membre]','$idDiscu','0','1')");
					}
					if($action == 1)
						$message = 'Article validé.';
					else{
						if($row['article_status'] == 2)
							$message = 'Article refusé.';
						else
							$message = 'Article dévalidé.';
					}
					$redirection = ROOT.'liste-articles-1.html';
					$data = display_notice($message,'ok',$redirection);
				}else{
					if($action == 3)$action = 0;
					$url = 'valider_article.php?artid='.$id_article.'&amp;action='.$action;
					if($action == 1)
						$message = "Etes vous sûr de vouloir valider cet article?";
					else
						$message = 'Etes vous sûr de vouloir dévalider cet article?';
					$data = display_confirm($message,$url);
				}
			}
			else{
				$message = "Cet article n'existe pas ou est déjà validé ou encore aucune demande de validation n'a été faite.";
				$redirection = ROOT."admin.html";
				$data = display_notice($message,'important',$redirection);
			}
		}
		else{
			if($row['id_membre'] == $_SESSION['mid'])
				$message = "Vous ne pouvez pas valider vos articles";
			else
				$message = "Vous n'avez pas le droit de valider cet article.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Aucun article de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
else{
	$message = "Vous devez être enregistrer pour valider un article.";
	$redirection = ROOT."connexion.html";
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>
