<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$row = $db->fetch($db->requete($sql));
	$action = intval($_GET['action']);
	if(isset($_GET['nid']))
		$id_newsletter = intval($_GET['nid']);
	else
		$id_newsletter = 0;

  $valider = 0;
	if($action > 1)
	{
		$sql = "SELECT * FROM newsletter WHERE id_newsletter = '$id_newsletter'";
		$result = $db->fetch($db->requete($sql));
	}
	switch($action)
	{
		case 1:
			if($row['id_group'] == 1){
				$texte = $_POST['texte'];
				$texte_parser = $db->escape(zcode($_POST['texte']));
				$texte = htmlentities($texte,ENT_QUOTES, 'UTF-8');
				$titre = htmlentities($_POST['titre'],ENT_QUOTES, 'UTF-8');
				if(strlen(trim($titre)) > 4){
					$sql = "INSERT INTO newsletter VALUES('',UNIX_TIMESTAMP(),'$titre','$texte','$texte_parser',1)";
					$db->requete($sql);
					$idNews = $db->last_id();
					$message = "Votre newsletter a été ajoutée.";
					$type = "ok";
					$redirection = ROOT."liste-newsletter-1.html";
					if(isset($_SESSION['tmpImg'])){
						$sql = "UPDATE images SET tmp = '0',s_dir = '$idNews' WHERE dir = '1' AND s_dir = '0' AND tmp = '1'";
						echo $sql;
						$db->requete($sql);
						if(isset($_SESSION['SsubDir']['tmp'])){
              $key = array_keys($_SESSION['SsubDir']['tmp']);
              unset($_SESSION['dir'.$key[0]]);
              unset($_SESSION['SsubDir']);
            }
					  unset($_SESSION['tmpImg']);
					}
				}
				else{
					$message = "Vous n'avez pas entré de titre à la news.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
		break;
		case 2:
			if($row['id_group'] == 1)
			{
				$texte = $_POST['texte'];
				$texte_parser = $db->escape(zcode($_POST['texte']));
				$texte = htmlentities($texte,ENT_QUOTES, 'UTF-8');
				$titre = htmlentities($_POST['titre'],ENT_QUOTES, 'UTF-8');
				if(strlen(trim($titre)) > 4){
					$sql = "UPDATE newsletter SET titre = '$titre', texte = '$texte',texte_parser = '$texte_parser' WHERE id_newsletter = '$id_newsletter'";
					$db->requete($sql);
					$message = "Les modifications ont bien été prises en compte.";
					$type = "ok";
					$redirection = "javascript:history.back(-1);";

					if(isset($_SESSION['tmpImg'])){
						$sql = "UPDATE images SET tmp = '0' WHERE dir = '1' AND s_dir = '".$_SESSION['tmpImg']['subDir'][0]."' AND tmp = '1'";
						$db->requete($sql);
						if(isset($_SESSION['SsubDir']['tmp'])){
              $key = array_keys($_SESSION['SsubDir']['tmp']);
              unset($_SESSION['dir'.$key[0]]);
              unset($_SESSION['SsubDir']);
            }
					  unset($_SESSION['tmpImg']);
					}
				}
				else{
					$message = "Vous n'avez pas entré de titre à la newsletter.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
			else
			{
				$message = "Vous ne pouvez pas modifier cette news";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
		case 3:
			if($row['id_group'] == 1)
			{
			    if(isset($_POST['valider']) AND $_POST['valider'] == 1)
				{
					$sql = "UPDATE newsletter SET status_newsletter = 2 WHERE id_newsletter = '$id_newsletter'";
					$db->requete($sql);
					$message = "Newsletter envoyée";
					$type = "ok";
					$redirection = ROOT."liste-newsletter-2.html";
					$valider = 0;
				}
				else
				{
					$message = "Etes vous sûr de vouloir envoyer cette newsletter?";
					$url = 'action_newsletter.php?nid='.$id_newsletter.'&amp;action='.$action;
					$valider = 1;
				}
			}
			else
			{
				$message = "Vous ne pouvez pas envoyer cette newsletter";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
		case 4:
		break;
		case 5:
		break;
		case 6:
			if($row['id_group'] == 1)
			{
			    if(isset($_POST['valider']) AND $_POST['valider'] == 1)
				{
					$sql = "DELETE FROM newsletter WHERE id_newsletter = '$id_newsletter'";
					$db->requete($sql);
					$message = "Newsletter supprimée";
					$type = "ok";
					$redirection = ROOT."liste-newsletter-1.html";
					$valider = 0;
					$sql = "SELECT * FROM images WHERE s_dir = '$id_newsletter' AND dir = '1' AND id_owner = '$result[id_auteur]'";
					$resultNews = $db->requete($sql);
					while($newsRow = $db->fetch($resultNews))
					{
						unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/'.$newsRow['nom']);
						unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/mini/'.$newsRow['nom']);
					}
					$db->requete("DELETE FROM images WHERE dir = '1' AND s_dir = '$id_newsletter' AND id_owner = '$result[id_auteur]'");
				}
				else
				{
					$message = "Etes vous sûr de vouloir supprimer cette news?";
					$url = 'action_newsletter.php?nid='.$id_newsletter.'&amp;action='.$action;
					$valider = 1;
				}
			}
			else
			{
				$message = "Vous ne pouvez pas supprimer cette news";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
	}
}
else
{
	$message = "Vous devez être enregistrer pour ajouter/modifier/supprimer une news";
	$type = "important";
	$redirection = ROOT."connexion.html";
}
switch($valider){
  case 0:
    $data = display_notice($message,$type,$redirection);
  break;
  case 1:
    $data = display_confirm($message,$url);
  break;
  case 3:
    $data = get_file(TPL_ROOT.'demandes.tpl');
    $data = parse_var($data,array('ROOT'=>ROOT,'titre_page'=>'Demande de validation de news - '.SITE_TITLE,'texte'=>'','autre'=>'','url'=>$url,'message'=>$message,'titre'=>$titre,'nb_requetes'=>$db->requetes,'design'=>$_SESSION['design']));
	include(INC_ROOT.'header.php');
  break;
}
echo $data;
$db->deconnection();
?>
