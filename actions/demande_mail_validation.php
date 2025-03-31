<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_SESSION['mid']) AND $_SESSION['mid'] == 0){
	if(isset($_POST['mail'])){
		$mail = htmlentities($_POST['mail'],ENT_QUOTES);
		$sql = "SELECT id_m, pseudo, email, code_activation FROM membres WHERE email = '$mail' AND status_m = '0'";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			
			$donnees = $db->fetch($result);		
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Revedemontagne <noreply@revedemontagne.fr>' . "\r\n";
			$dataMail = get_file(TPL_ROOT.'mail/validation.tpl');
			$dataMail = parse_var($dataMail,array('pseudo'=>$donnees['pseudo'],'mail'=>$donnees['email'],'validation'=>$donnees['code_activation']));
			mail($mail,"Revedemontagne - confirmation inscription ".$pseudo,$dataMail,$headers);
		}
	}
	$message = "Si l'adresse email saisie est enregistr&eacute;e dans notre base de donn&eacute;es votre code lui sera envoy&eacute;";
	$type = "ok";
	$redirection = ROOT."index.php";
}else{
	$message = "Vous êtes déjà connecté.";
	$type = "important";
	$redirection = ROOT."index.php";
}
echo display_notice($message,$type,$redirection);;
?>