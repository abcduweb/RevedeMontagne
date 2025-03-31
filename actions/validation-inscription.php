<?php
/*
 * Créer le 25 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: la validation de l'inscription d'un membre.
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_GET['q'])){
	$message = "Aucun code d'activation.";
	$redirection = ROOT."index.php";
	$data = display_notice($message,'important',$redirection);
}else{
	$q = htmlentities($_GET['q'],ENT_QUOTES);
	$sql = "SELECT * FROM membres WHERE code_activation = '$q'";
	$result = $db->requete($sql);
	if($db->num($result) > 0){
		$donnees = $db->fetch($result);
		$sql = "UPDATE membres SET code_activation = '', status_m = '1' WHERE code_activation = '$q'";
		$db->requete($sql);
		$row = $db->fetch($result);
		$data = get_file(TPL_ROOT.'system_ei.tpl');
		$message = "Votre compte est maintenant actif. Vous pouvez aller vous connecter.";
		$redirection = ROOT . "connexion.html";
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: Revedemontagne <noreply@revedemontagne.fr>' . "\r\n";
		$dataMail = get_file(TPL_ROOT.'mail/bienvenue.tpl');
		$dataMail = parse_var($dataMail,array('pseudo'=>$donnees['pseudo'],'mail'=>$donnees['email']));
		mail($donnees['email'],"Bienvenue ".$donnees['pseudo'],$dataMail,$headers);
		
		$data = display_notice($message,'ok',$redirection);
	}else{
		$message = "Code d'activation invalide.";
		$redirection = ROOT."index.php";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>
