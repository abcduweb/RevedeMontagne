<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

$f = (int)$_GET['f'];
$titre = htmlentities($_POST['titre'],ENT_QUOTES);
$sous_titre = htmlentities($_POST['titre2'],ENT_QUOTES);
$sql = "SELECT * FROM auth_list LEFT JOIN forum ON forum.id_f = auth_list.id_forum LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.id_forum = '$f'";
$result = $db->requete($sql);
$row = $db->fetch($result);
$pseudo = $row['pseudo'];
$last_post = $row['last_post'];
$id_big = $row['id_big'];
if($row['ajouter'] == 1)
{
	if(strlen(trim($titre)) < 3 OR strlen(trim($_POST['texte'])) < 3){
      	$message = "Vous n'avez pas entré de titre ou/et de message ou ceci sont peut être trop court.";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
    }
    else{
	    if($_SESSION['group'] == 6){
			if(strlen(trim($_POST['pseudo'])) < 3){
				$message = "Vous n'avez pas entré de pseudo.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
			else
				$pseudo = htmlentities($_POST['pseudo'],ENT_QUOTES);
		}
		$date = time();
		if($date > ($last_post + 30)){
			$sql = "INSERT INTO topics VALUES('','0','$f','$titre','$sous_titre','$_SESSION[mid]','$date','0','0','1','0','0','0')";
			$result = $db->requete($sql);
			$id_t = $db->last_id();
			$text_parser = $db->escape(zcode(stripslashes($_POST['texte'])));
			$text = htmlentities($_POST['texte'],ENT_QUOTES);
			if(isset($_POST['sign']))
					$attach_sign = 1;
				else
					$attach_sign = 0;
			$sql = "INSERT INTO messages VALUES('','$id_t','$_SESSION[mid]','$pseudo','$text','$text_parser','$date','','$attach_sign')";
			$result = $db->requete($sql);
			$id_m = $db->last_id();
	
			$sql = "INSERT INTO messages_lus VALUES('$_SESSION[mid]','$id_t','$f','$id_m','1')";
			$result = $db->requete($sql);

			$sql = "UPDATE topics SET id_last_message = '$id_m' WHERE id_t = '$id_t'";

			$result = $db->requete($sql);

			$sql = "UPDATE forum SET id_last_topics = '$id_t', nb_topic = nb_topic + 1 WHERE id_f = '$f'";
			$result = $db->requete($sql);

			$sql = "UPDATE membres SET nb_post_m = nb_post_m + 1,last_post = '$date' WHERE id_m = '$_SESSION[mid]'";
			$result = $db->requete($sql);
			$message = "Votre sujet a bien été ajouté";
			$type = "ok";
			$redirection = ROOT."forum-$f-$id_t-".title2url($titre).".html";
			if(isset($_SESSION['tmp_Img'])){
				$sql = "UPDATE images SET tmp = '0',s_dir = '$id_t' WHERE dir = '3' AND s_dir = '0' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
				$db->requete($sql);
				if(isset($_SESSION['SsubDir']['tmp'])){
          $key = array_keys($_SESSION['SsubDir']['tmp']);
          unset($_SESSION['dir'.$key[0]]);
          unset($_SESSION['SsubDir']);
        }
        unset($_SESSION['tmp_Img']);
			}
		}
		else
		{
			$wait = $last_post + 30 - $date;
			$message = "Vous ne pouvez pas re-poster si vite. Vous devez attendre encore ".$wait." seconde(s)";
			$type = "important";
			$redirection = ROOT."forum-$f-".title2url($row['nom']).".html";
		}
    }
}
else
{
	$message = "Vous ne pouvez pas ajouter de sujet dans ce forum.";
	$type = "important";
	$redirection = ROOT."forum-$f-".title2url($row['nom']).".html";
}
$data = display_notice($message,$type,$redirection);
echo $data;
?>
