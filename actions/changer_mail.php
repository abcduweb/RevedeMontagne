<?php
/*
 * Créer le 27 oct. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: changement d'e-mail
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
else
{
	$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
	$info = $db->fetch($db->requete($sql));
	if(isset($_POST['pass'])){
		if(isset($_POST['mail']) AND isset($_POST['mail']) AND $_POST['mail'] == $info['email'] AND preg_match('`^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$`',$_POST['mail']) AND preg_match('`^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$`',$_POST['mail2'])){
			if(md5(htmlentities($_POST['pass'],ENT_QUOTES)) == $info['pass']){
				$sql = "UPDATE membres SET email = '".htmlentities($_POST['mail2'],ENT_QUOTES)."' WHERE id_m = '$_SESSION[mid]'";
				$db->requete($sql);
				$message = 'Votre email a bien été changée.';
				$type = 'ok';
				$redirection = ROOT.'mes_options.html';
			}
			else{
				$message = 'Le mot de pass est incorrecte.';
				$type = 'important';
				$redirection = 'javascript:history.back(-1);';
			}
		}
		else{
			$message = 'Adresse e-mail invalide.';
			$type = 'important';
			$redirection = 'javascript:history.back(-1);';
		}
	}
	else{
		$message = 'Vous n\'avez entré aucun mot de passe.';
		$type = 'important';
		$redirection = 'javascript:history.back(-1);';
	}
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>
