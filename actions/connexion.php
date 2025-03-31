<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
//include (INC_ROOT . '2FA/googleAuthenticator.php');
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$pseudo = htmlentities($_POST['pseudo'],ENT_QUOTES);
$pass = $_POST['password'];
$pass = md5($pass);


if (!empty($pseudo) AND !empty($pass)){
	$reponse = $db->requete("SELECT * FROM membres LEFT JOIN enligne ON enligne.id_m_join = membres.id_m WHERE pseudo='$pseudo'");
	$donnees = $db->fetch($reponse);
	$verif = $donnees['pass'];
    $id = $donnees['id_m'];
	$pseudo_sql = $donnees['pseudo'];
	$confirm = $donnees['status_m'];
	if($pass != $verif){
    	$message = 'Votre identifiant ou votre code secret est incorrect';
		$redirection = ROOT.'connexion.html';
		//$temps_redirection = $_SESSION['redirection'];
		$type = 'important';
    }
	elseif($confirm != '1'){
		$message = 'Votre compte n\'est pas encore activé';
		$redirection = ROOT.'index.php';
		//$temps_redirection = $_SESSION['redirection'];
		$type = 'important';
	}
	elseif($donnees['id_group'] == 7){
		$message = 'Vous avez &eacute;t&eacute; banni!';
		$redirection = ROOT.'index.php';
		//$temps_redirection = $_SESSION['redirection'];
		$type = 'important';
	}
	elseif($donnees['id'] != null){
		$message = 'Une session est d&eacute;j&agrave; ouverte';
		$type = 'important';
		$redirection = ROOT.'index.php';
	}
	else{
		
		purge(ROOT.'caches/','.htcache_mpm_*');
		if(isset($_SESSION['updateOnligne']))$updateOnligne = $_SESSION['updateOnligne'];
		session_regenerate_id(true);
		$_SESSION['membre'] = $pseudo_sql;
		$uniq_key = uniqid(mt_rand(), TRUE);
		$_SESSION['ses_id'] = md5($_SESSION['membre'].$id.$uniq_key);
		$_SESSION['mid'] = $id;
		if($donnees['id_group'] == 8){
			$sql = "SELECT * FROM punish WHERE time_to_set <= UNIX_TIMESTAMP() AND id_m_punish = '$_SESSION[mid]'";
			$db->requete($sql);
			if($db->num() > 0){
				$original = $db->fetch();
				$db->requete("DELETE FROM punish WHERE id_m_punish = '$_SESSION[mid]'");
				$_SESSION['id_group'] = $original['original_group'];
				if($donnees['pourcent'] == 100){
					$db->requete("UPDATE membres SET id_group = '$original[original_group]',pourcent = pourcent - 50 WHERE id_m = '$_SESSION[mid]'");
				}else{
					$db->requete("UPDATE membres SET id_group = '$original[original_group]' WHERE id_m = '$_SESSION[mid]'");
				}
			}
		}
		$_SESSION['group'] = $donnees['id_group'];
		$_SESSION['nombre_sujet'] = $donnees['nb_sujet_afficher'];
		$_SESSION['nombre_message'] = $donnees['nombre_message_afficher'];
		$_SESSION['nombre_news'] = $donnees['nb_news_page'];
		$_SESSION['order'] = $donnees['ordre'];
		$_SESSION['redirection'] = $donnees['redirection'];
		$_SESSION['style_date'] = $donnees['style_date'];
		$_SESSION['design'] = $donnees['design'];
		if(isset($updateOnligne)){
			$_SESSION['updateOnligne'] = $updateOnligne;
			$sql = "UPDATE enligne SET timer = UNIX_TIMESTAMP(), id_m_join = '$_SESSION[mid]' WHERE uniqid = '".$_SESSION['updateOnligne']['id']."'";
		}else{
			$_SESSION['updateOnligne']['id'] = uniqid(mt_rand(),true);
			$_SESSION['updateOnligne']['last'] = time();
			$sql = "INSERT INTO enligne VALUES('',$_SESSION[mid],UNIX_TIMESTAMP(),'".get_ip()."',0,'".$_SESSION['updateOnligne']['id']."')";
		}
		$db->requete($sql);
		if(isset($_POST['retenir'])){
			$timestamp_expire = time() + 365*24*3600;
			setcookie('ses_id', $_SESSION['ses_id'], $timestamp_expire,'/');
		}
		$db->requete('UPDATE membres SET last_log = UNIX_TIMESTAMP(),ip = \''.get_ip().'\', ses_key = \''.$uniq_key.'\', ses_id = \''.$_SESSION['ses_id'].'\' WHERE id_m = "'.$id.'"');
		$message = 'Connexion r&eacute;ussie';
		if(isset($_SESSION['loginRedirect'])){
			$redirection = $_SESSION['loginRedirect'];
			unset($_SESSION['loginRedirect']);
		}
		else
			$redirection = ROOT.'index.php';
		$type = 'ok';
	}
}
else{
	$message = 'Un des champs de connexion au moins est vide';
	$redirection = ROOT.'connexion.html';
	//$temps_redirection = $_SESSION['redirection'];
	$type = 'important';
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>