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
		if($row['id_membre'] == $_SESSION['mid'] OR $auth['supprimer_topo'] == 1){
			if($num > 0){
				if($row['id_membre'] == $_SESSION['mid']){
					if(isset($_POST['valider']) AND $_POST['valider'] == 1){
						$db->requete("DELETE FROM articles_intro_conclu WHERE id_article = '$id_article'");
						$db->requete("DELETE FROM articles_part WHERE id_article_attach = '$id_article'");
						if($row['article_status'] == 1){
							$db->requete("UPDATE articles SET properties = properties - 1 WHERE BG <= $row[BG] AND BD >= $row[BD]");
						}
						$message = "Article supprimé.";
						$type = "ok";
						$redirection = ROOT."mes-articles.html";
						$validation = 0;
						$sql = "SELECT * FROM images WHERE id_owner = $row[id_membre] AND dir = '4' AND s_dir = '$id_article'";
						$result = $db->requete($sql);
						while($delete = $db->fetch($result)){
							unlink(ROOT.'images/autres/'.ceil($delete['id_image']/1000).'/'.$delete['nom']);
							unlink(ROOT.'images/autres/'.ceil($delete['id_image']/1000).'/mini/'.$delete['nom']);
						}
						$sql = "DELETE FROM images WHERE id_owner = $row[id_membre] AND dir = '4' AND s_dir = '$id_article'";
						$db->requete($sql);
					}
					else{
	            		$message = "Etes vous sûr de vouloir supprimer cet article?";
	            		$url = "supprimer_article.php?artid=$id_article";
	            		$validation = 1;
					}
				}
				else{
					if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) > 10){
						$db->requete("DELETE FROM articles_intro_conclu WHERE id_article = '$id_article'");
						$db->requete("DELETE FROM articles_part WHERE id_article_attach = '$id_article'");
						if($row['article_status'] == 1){
							$db->requete("UPDATE articles SET properties = properties - 1 WHERE BG <= $row[BG] AND BD >= $row[BD]");
						}
						$message = "Article supprimé.";
						$type = "ok";
						$redirection = ROOT.'admin.html';
						$validation = 0;
						
						$sql = "SELECT * FROM images WHERE id_owner = $row[id_membre] AND dir = '4' AND s_dir = '$id_article'";
						$result = $db->requete($sql);
						while($delete = $db->fetch($result)){
							unlink(ROOT.'images/autres/'.ceil($delete['id_image']/1000).'/'.$delete['nom']);
							unlink(ROOT.'images/autres/'.ceil($delete['id_image']/1000).'/mini/'.$delete['nom']);
						}
						$sql = "DELETE FROM images WHERE id_owner = $row[id_membre] AND dir = '4' AND s_dir = '$id_article'";
						$db->requete($sql);
						$text_parser = $db->escape(zcode($_POST['texte']));
						$text = htmlentities($_POST['texte'],ENT_QUOTES);
						$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
						$db->requete($sql);
						$idM = $db->last_id();
						$sql = "INSERT INTO liste_discutions VALUES('','<strong>[ARTICLES]</strong> Suppression d\'articles','',$idM,'$_SESSION[mid]',0,0)";
						$db->requete($sql);
						$idDiscu = $db->last_id();
						$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
						$db->requete("INSERT INTO discutions_lues VALUES('$row[id_membre]','$idDiscu','0','1')");
					}
					else{
						if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) <= 10)
							$message = "Texte trop court";
						else
							$message = "Pourquoi supprimez vous cet article?";
						$titre = "Suppression d'article";
						$url = "supprimer_article.php?artid=$id_article";
						$validation = 2;
					}
				}
			}
			else{
				$message = "Cet article n'existe pas.";
				$type = "important";
				$redirection = ROOT."index.php";
				$validation = 0;
			}
		}
		else{
			$message = "Vous n'avez pas le droit de supprimer cet article.";
			$type = "erreur";
			$redirection = ROOT."index.php";
			$validation = 0;
		}
	}
	else{
		$message = "Aucun article de sélectionner.";
		$type = "important";
		$redirection = ROOT."index.php";
		$validation = 0;
	}
}
else{
	$message = "Vous devez être enregistrer pour supprimer un article.";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
	$validation = 0;
}
switch($validation){
  case 0:
    $data = display_notice($message,'important',$redirection);
  break;
  case 1:
    $data = $data = get_file(TPL_ROOT."system_confirm.tpl");
	include(INC_ROOT.'header.php');
    $data = parse_var($data,array('url'=>$url,'message'=>$message,'design'=>$_SESSION['design'],'ROOT'=>'../'));
  break;
  case 2:
    $data = get_file(TPL_ROOT.'demandes.tpl');
	include(INC_ROOT.'header.php');
    $data = parse_var($data,array('url'=>$url,'message'=>$message,'titre'=>$titre,'design'=>$_SESSION['design'],'ROOT'=>'../'));
  break;
}
echo $data;
$db->deconnection();
?>
