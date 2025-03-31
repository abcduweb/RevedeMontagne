<?php
/*
 * Créer le 27 oct. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: changement de mot de passe
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(isset($_SESSION['ses_id'])){
	if(!empty($_POST['mdp1'])){
		if(!empty($_POST['mdp2'])){
			if(!empty($_POST['mdp3'])){
				if($_POST['mdp2'] == $_POST['mdp3']){
					$mdp = md5($_POST['mdp2']);
					$mdp1 = md5($_POST['mdp1']);
					$sql1 = "SELECT pass FROM membres WHERE id_m = '$_SESSION[mid]'";
					$db->requete($sql1);
					$row = $db->fetch();
					if($row['pass'] == $mdp1){
						$sql = "UPDATE membres SET pass = '$mdp' WHERE id_m = '$_SESSION[mid]'";
						$db->requete($sql);
						$message = "Mot de passe modifier";
						$type = "ok";
						$redirection = ROOT."mes_options.html";
					}else{
						$message = "Ancien mot de passe invalide.";
						$type = "important";
						$redirection = "javascript:history.back(-1);";
					}
				}else{
					$message = "Nouveau mot de passe et vérification différent.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}else{
				$message = "Vérification vide.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
		}else{
			$message = "Nouveau mot de passe vide";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		}
	}else{
		$message = "Ancien mot de passe vide.";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
	}
}else{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>