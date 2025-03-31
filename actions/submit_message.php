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
$t = (int)$_GET['t'];
$data = get_file(TPL_ROOT.'system_ei.tpl');
$sql = "SELECT * FROM topics LEFT JOIN messages ON topics.id_last_message = messages.id_ms WHERE id_t = '$t'";
$result = $db->requete($sql);
$row = $db->fetch();
$exist = $db->num();
if($row['id_utilisateur'] == $_SESSION['mid'] AND $row['date_m'] + 86400 > time()){
	$message = "Vous ne pouvez pas \"upper\" avant 24h.";
	$type = "important";
	$redirection = ROOT."forum-$f-$t-gotoLR-".title2url($row['titre']).".html";
}
else{
	if($row['deplacer'] == 0)
		$sql = "SELECT * FROM auth_list LEFT JOIN forum ON forum.id_f = auth_list.id_forum LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' LEFT JOIN topics ON (topics.id_t = '$t' AND topics.id_forum = auth_list.id_forum) LEFT JOIN messages_lus ON (messages_lus.topics_id = topics.id_t AND messages_lus.id_membre = membres.id_m) WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.id_forum = '$f'";
	else
		$sql = "SELECT * FROM auth_list LEFT JOIN forum ON forum.id_f = auth_list.id_forum LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' LEFT JOIN topics ON (topics.id_t = '$t' AND topics.deplacer = auth_list.id_forum) LEFT JOIN messages_lus ON (messages_lus.topics_id = topics.id_t AND messages_lus.id_membre = membres.id_m) WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.id_forum = '$f'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	$id_big = $row['id_big'];
	$pseudo = $row['pseudo'];
	$last_post = $row['last_post'];
	$id_last_message = $row['id_last_message'];
	if(($row['ajouter'] == 1 AND $row['status'] == 1) OR $row['interdire_topics'] == 1)
	{
		if($exist == 0)
		{
			$message = "Vous ne pouvez pas ajouter de réponse à ce sujet.";
			$type = "important";
			$redirection = ROOT."forum-$f-".title2url($row['nom']).".html";
			$db->deconnection();
			echo display_notice($message,$type,$redirection);
			exit;
		}
		if(strlen(trim($_POST['texte'])) < 1){
	      	$message = "Le message est vide.";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
	    }
		else{
			if($_SESSION['group'] == 6)
			{
				$pseudo = htmlentities($_POST['pseudo'],ENT_QUOTES);
			}

			$date = time();
			if($date > ($last_post + 30)){
				$text = $_POST['texte'];
				$text_parser = $db->escape(zcode($text));
				$text = htmlentities($_POST['texte'],ENT_QUOTES);
				if(isset($_POST['sign']))
						$attach_sign = 1;
					else
						$attach_sign = 0;
				$sql = "INSERT INTO messages VALUES('','$t','$_SESSION[mid]','$pseudo','$text','$text_parser','$date',0,'$attach_sign')";
				$result = $db->requete($sql);
				$id_m = $db->last_id();
			
				$sql = "UPDATE topics SET id_last_message = '$id_m',nb_reponse = nb_reponse + 1 WHERE id_t = '$t'";
				$result = $db->requete($sql);
			
				$sql = "UPDATE forum SET id_last_topics = '$t', nb_reponse_t = nb_reponse_t + 1 WHERE id_f = '$f'";
				$result = $db->requete($sql);
						
				$sql = "UPDATE membres SET last_post = '$date',nb_post_m = nb_post_m + 1  WHERE id_m = '$_SESSION[mid]'";
				$result = $db->requete($sql);
				$sql = "SELECT * FROM messages_lus WHERE id_membre = '$_SESSION[mid]' AND topics_id = '$t'";
				$result = $db->requete($sql);
				$existe = $db->num($result);
				if($existe > 0)
					$sql = "UPDATE messages_lus SET post = '1' , last_message_id = '$id_m' WHERE id_membre = '$_SESSION[mid]' AND topics_id = '$t'";
				else
					$sql = "INSERT INTO messages_lus VALUES('$_SESSION[mid]','$t','$f','$id_m','1')";
				$db->requete($sql);
				$message = "Votre message a bien été ajouté";
				$type = "ok";
				$redirection = ROOT."forum-$f-$t-r$id_m-".title2url($row['titre']).".html#r$id_m";
				if(isset($_SESSION['tmp_Img'])){
					$sql = "UPDATE images SET tmp = '0' WHERE dir = '3' AND s_dir = '$t' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
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
				$wait = $last_post + 30 - $date;
				$message = "Vous ne pouvez pas re-poster si vite. Vous devez attendre encore ".$wait." seconde(s)";
				$type = "important";
				$redirection = ROOT."forum-$f-$t-r$id_last_message-".title2url($row['titre']).".html";
			}
		}
	}
	else
	{
		$message = "Vous ne pouvez pas ajouter de réponse à ce sujet";
		$type = "important";
		$redirection = ROOT."forum-$f-$t-".title2url($row['titre']).".html";
	}
}
echo display_notice($message,$type,$redirection);
$db->deconnection();
?>
