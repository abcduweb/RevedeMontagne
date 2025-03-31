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
		$id_news = intval($_GET['nid']);
	else
		$id_news = 0;
/*
	1 ajouter news;
	2 modifier news;
	3 demande de validation;
	4 validation;
	5 d&eacute;validation;
	6 supprimer;
*/
  $valider = 0;
	if($action > 1)
	{
		$sql = "SELECT * FROM nm_news WHERE id_news = '$id_news'";
		$result = $db->fetch($db->requete($sql));
	}
	switch($action)
	{
		case 1:
			if($row['ajouter_news'] == 1){
				$texte = $_POST['texte'];
				$texte_parser = $db->escape(zcode($texte));
				$texte = htmlentities($texte,ENT_QUOTES);
				$titre = htmlentities($_POST['titre'],ENT_QUOTES);
				if(strlen(trim($titre)) > 4){
					$sql = "INSERT INTO nm_news VALUES('','$_SESSION[mid]','$_SESSION[membre]',UNIX_TIMESTAMP(),'$titre','$texte','$texte_parser',0,3,0)";
					$db->requete($sql);
					$idNews = $db->last_id();
					$message = "Votre news a &eacute;t&eacute; ajout&eacute;e. Cependant il faut la faire valider lorsque vous aurez fini de la r&eacute;diger.";
					$type = "ok";
					$redirection = ROOT."mes-news.html";
					if(isset($_SESSION['tmp_Img'])){
						$sql = "UPDATE images SET tmp = '0',s_dir = '$idNews' WHERE dir = '1' AND s_dir = '0' AND tmp = '1'";
						echo $sql;
						$db->requete($sql);
						
						$sql2 = "SELECT * FROM images WHERE s_dir = '$idNews' AND dir = '1' AND id_owner = ".$_SESSION['mid'];
						$result2 = $db->requete($sql2);
							while($Row2 = $db->fetch($result2)){
								echo $sql2;
								if(!is_dir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/'.$idNews.'/')){
									mkdir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/'.$idNews.'/');
									mkdir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/'.$idNews.'/mini');
								}
								rename(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/0/'.$Row2['nom'],ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/'.$idNews.'/'.$Row2['nom']);
								rename(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/0/mini/'.$Row2['nom'],ROOT.'images/autres/membre_'.$_SESSION['mid'].'/1/'.$idNews.'/mini/'.$Row2['nom']);
							}
						$texte_a_garder = preg_replace("images/autres/membre_".$_SESSION['mid']."/1/0/", "images/autres/membre_".$_SESSION['mid']."/1/".$idNews."/", $texte); 
						$texte_parser_a_garder = preg_replace("images/autres/membre_".$_SESSION['mid']."/1/0/", "images/autres/membre_".$_SESSION['mid']."/1/".$idNews."/", $texte_parser); 
						$sql = "UPDATE nm_news SET texte = '$texte_a_garder', texte_parser = '$texte_parser_a_garder' WHERE id_news = ".$idNews;
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
					$message = "Vous n'avez pas entr&eacute; de titre à la news.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
		break;
		case 2:
			if(($result['id_auteur'] == $_SESSION['mid'] AND $row['ajouter_news'] == 1) OR $row['modifier_news'] == 1)
			{
				$texte = $_POST['texte'];
				$texte_parser = $db->escape(zcode($_POST['texte']));
				$texte = htmlentities($texte,ENT_QUOTES);
				$titre = htmlentities($_POST['titre'],ENT_QUOTES);
				if($row['modifier_news'] == 1){
					if($result['status_news'] == 3){
						$status = 3;
						$statusCom = 0;
					}
					else{
						$status = 1;
						$statusCom = $result['status_com'];
					}
				}
				else
					$status = 3;
				if(strlen(trim($titre)) > 4){
					$sql = "UPDATE nm_news SET titre = '$titre', texte = '$texte',texte_parser = '$texte_parser',status_news = '$status',status_com = '$statusCom' WHERE id_news = '$id_news'";
					$db->requete($sql);
					$message = "Les modifications ont bien &eacute;t&eacute; prises en compte.";
					$type = "ok";
					if($result['id_auteur'] == $_SESSION['mid'])
						$redirection = ROOT."mes-news.html";
					else
						$redirection = ROOT."admin.html";
					if(isset($_SESSION['tmp_Img'])){
						$sql = "UPDATE images SET tmp = '0' WHERE dir = '1' AND s_dir = '".$_SESSION['tmp_Img']['subDir'][0]."' AND tmp = '1'";
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
					$message = "Vous n'avez pas entr&eacute; de titre à la news.";
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
			if($row['valider_news'] == 1)
			{
				if(isset($_POST['valider']) AND $_POST['valider'] == 1){
	  				$sql = "UPDATE nm_news SET status_news = '1',status_com = '1',date_news = UNIX_TIMESTAMP() WHERE id_news = '$id_news'";
	  				$db->requete($sql);
	  				$message = "News valid&eacute;e";
	  				$type = "ok";
	  				if($result['id_auteur'] == $_SESSION['mid'])
	  				  $redirection = ROOT."mes-news.html";
	  				else
	  				  $redirection = ROOT."admin.html";
				}
				else{
					$message = "Etes vous s&ucirc;r de vouloir valider cette news?";
					$url = 'action_news.php?nid='.$id_news.'&amp;action='.$action;
					$valider = 1;
				}
			}
			elseif($result['id_auteur'] == $_SESSION['mid'])
			{
				if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) > 10){
	  				$sql = "UPDATE nm_news SET status_news = '2' WHERE id_news = '$id_news'";
	  				$db->requete($sql);
	  				$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.valider_news = 1";
	  				$newser = $db->requete($sql);
	  				$num = $db->num($newser);
	  				if($num > 5){
						$limite = mt_rand(0,$num - 5);
					}
					else
						$limite = 0;
					$text_parser = $db->escape(zcode(stripslashes($_POST['texte'])));
					$text = htmlentities($_POST['texte'],ENT_QUOTES);
					$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
					$db->requete($sql);
					$idM = $db->last_id();
          
					$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.valider_news = 1 LIMIT $limite,6";
					$newser = $db->requete($sql);
					$sql = "INSERT INTO liste_discutions VALUES('','<strong>[NEWS]</strong> Demande de validation','',$idM,$_SESSION[mid],0,0,0)";
					$db->requete($sql);
					$idDiscu = $db->last_id();
					$nb_participant = 0;
					while($to = $db->fetch($newser)){
						if($to['id_m'] != null){
							$sql = "INSERT INTO discutions_lues VALUES('$to[id_m]','$idDiscu',0,1)";
							$db->requete($sql);
							if(file_exists(ROOT.'caches/.htcache_mpm_'.$to['id_m'])){
								include(ROOT.'caches/.htcache_mpm_'.$to['id_m']);
								$img_mp = 'messages';
								$nb_mp++;
								write_cache(ROOT.'caches/.htcache_mpm_'.$to['id_m'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
							}
							$nb_participant++;
						}
					}
					$db->requete("INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$idDiscu','$idM',1)");
					$nb_participant++;
					$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
					$db->requete("UPDATE liste_discutions SET nb_participant = '$nb_participant' WHERE id_discution = '$idDiscu'");
					$message = "Votre demande de validation a &eacute;t&eacute; envoyer";
					$type = "ok";
					$redirection = ROOT."mes-news.html";
					$valider = 0;
				}
				else{
					if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) <= 10)
						$message = "Texte trop court";
					else
						$message = "Entrer un texte de motivation";
					$titre = "Demande de validation de news";
					$url = "action_news.php?nid=$id_news&amp;action=3";
					$valider = 3;
				}
			}
			else
			{
				$message = "Vous ne pouvez pas demander de validation pour cette news";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
		case 4:
			if($row['valider_news'] == 1)
			{
			  if(isset($_POST['valider']) AND $_POST['valider'] == 1){
				  $sql = "UPDATE nm_news SET status_news = '1', date_news = UNIX_TIMESTAMP(),status_com = '1' WHERE id_news = '$id_news'";
				  $db->requete($sql);
				  $message = "News valid&eacute;e";
				  $type = "ok";
				  $redirection = ROOT."admin.html";
				  $valider = 0;
				}
				else{
          $message = "Etes vous s&ucirc;r de vouloir valider cette news?";
          $url = 'action_news.php?nid='.$id_news.'&amp;action='.$action;
          $valider = 1;
        }
			}
			else
			{
				$message = "Vous n'avais pas les droits pour valider une news";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
		case 5:
			if($row['valider_news'] == 1)
			{
			  if(isset($_POST['valider']) AND $_POST['valider'] == 1){
  				$sql = "UPDATE nm_news SET status_news = '3',status_com = '0' WHERE id_news = '$id_news'";
  				$db->requete($sql);
  				$message = "News d&eacute;valid&eacute;e";
  				$type = "ok";
  				$redirection = ROOT."admin.html";
  				$valider = 0;
  			}
  			else{
          $message = "Etes vous s&ucirc;r de vouloir d&eacute;valider cette news?";
          $url = 'action_news.php?nid='.$id_news.'&amp;action='.$action;
          $valider = 1;
        }
			}
			else
			{
				$message = "Vous n'avais pas les droits pour d&eacute;valider une news";
				$type = "important";
				$redirection = ROOT."index.php";
			}
		break;
		case 6:
			if($row['supprimer_news'] == 1 OR $result['id_auteur'] == $_SESSION['mid'])
			{
			  if($result['id_auteur'] == $_SESSION['mid']){
			    if(isset($_POST['valider']) AND $_POST['valider'] == 1){
  				  $sql = "DELETE FROM nm_news WHERE id_news = '$id_news'";
  				  $db->requete($sql);
  				  $message = "News supprimer";
  				  $type = "ok";
  	    		$redirection = ROOT."mes-news.html";
  	    		$valider = 0;
  	    		$sql = "SELECT * FROM images WHERE s_dir = '$id_news' AND dir = '1' AND id_owner = '$result[id_auteur]'";
  	    		$resultNews = $db->requete($sql);
  	    		while($newsRow = $db->fetch($resultNews)){
              unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/'.$newsRow['nom']);
              unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/mini/'.$newsRow['nom']);
            }
            $db->requete("DELETE FROM images WHERE dir = '1' AND s_dir = '$id_news' AND id_owner = '$result[id_auteur]'");
				  }
				  else{
             $message = "Etes vous s&ucirc;r de vouloir supprimer cette news?";
             $url = 'action_news.php?nid='.$id_news.'&amp;action='.$action;
             $valider = 1;
          }
				}
				else{
				  if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) > 10){
				    $sql = "DELETE FROM nm_news WHERE id_news = '$id_news'";
  				  $db->requete($sql);
  				  $text_parser = $db->escape(zcode(stripslashes($_POST['texte'])));
            $text = htmlentities($_POST['texte'],ENT_QUOTES);
            $sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
            $db->requete($sql);
            $idM = $db->last_id();
            $sql = "INSERT INTO liste_discutions VALUES('','<strong>[NEWS]</strong> Suppression de news','',$idM,'$_SESSION[mid]',0,0)";
            $db->requete($sql);
            $idDiscu = $db->last_id();
            $db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
            $db->requete("INSERT INTO discutions_lues VALUES('$result[id_auteur]','$idDiscu','0','1')");
            if(file_exists(ROOT.'caches/.htcache_mpm_'.$result['id_auteur'])){
  						include(ROOT.'caches/.htcache_mpm_'.$result['id_auteur']);
  						$img_mp = 'messages';
  						$nb_mp++;
  						write_cache(ROOT.'caches/.htcache_mpm_'.$result['id_auteur'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
  					}
  					$sql = "SELECT * FROM images WHERE s_dir = '$id_news' AND dir = '1' AND id_owner = '$result[id_auteur]'";
  	    		$resultNews = $db->requete($sql);
  	    		while($newsRow = $db->fetch($resultNews)){
              unlink(ROOT.'images/autres/'.ceil($newRow['id_image']/1000).'/'.$newsRow['nom']);
              unlink(ROOT.'images/autres/'.ceil($newRow['id_image']/1000).'/mini/'.$newsRow['nom']);
            }
            $db->requete("DELETE FROM images WHERE dir = '1' AND s_dir = '$id_news' AND id_owner = '$result[id_auteur]");
  				  $message = "News supprimer";
  				  $type = "ok";
  	    		$valider = 0;
            $redirection = ROOT."admin.html";
          }
          else{
            if(isset($_POST['texte']) AND strlen(trim($_POST['texte'])) <= 10)
              $message = "Texte trop court";
            else
              $message = "Pourquoi supprimez vous cette news?";
            $titre = "Suppression de news";
            $url = "action_news.php?nid=$id_news&amp;action=6";
            $valider = 3;
          }
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
