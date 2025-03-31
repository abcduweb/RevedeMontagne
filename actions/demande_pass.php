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
		$sql = "SELECT id_m, pseudo FROM membres WHERE email = '$mail'";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			$donnees = $db->fetch($result);
			$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789&~#'{([-_@)]=+}";
			$new_mdp = "";
			for($i=0;$i<8;$i++){
				$new_mdp .= $string[mt_rand(0,strlen($string))];
			}
			$id_m = $donnees['id_m'];
			$db->requete("UPDATE membres SET pass = '".md5($new_mdp)."' WHERE id_m = '$id_m'");
			
			
			
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$headers .= 'From: Revedemontagne <noreply@revedemontagne.fr>' . "\r\n";
			$dataMail = get_file(TPL_ROOT.'mail/pass.tpl');
			$dataMail = parse_var($dataMail,array('pseudo'=>$donnees['pseudo'],'pass'=>$new_mdp));
			mail($mail,"Perte de mot de passe ".$donnees['pseudo'],$dataMail,$headers);

		}
	}
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	$message = "Si l'adresse email donn&eacute;e est enregistr&eacute;e dans notre base de donn&eacute;es votre mot de passe lui sera envoy&eacute;";
	$type = "ok";
	$redirection = ROOT."index.php";
}else{
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	$message = "Vous êtes d&eacute;jà connect&eacute;.";
	$type = "important";
	$redirection = ROOT."index.php";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>