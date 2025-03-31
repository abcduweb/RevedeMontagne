<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if (!isset ($_SESSION['ses_id'])) {
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT . 'connexion.html';
} else {
	$pourcentage = intval($_POST['pourcentage']);
	$id_m = intval($_GET['mid']);
	$sql = "SELECT punnir FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['punnir'] == 1){
		$sql = "SELECT pourcent,id_m,id_group FROM membres where id_m='$id_m'";
		$membre = $db->fetch($db->requete($sql));
		$membre['pourcent'] = $membre['pourcent'] + $pourcentage;
		if ($membre['pourcent'] >= 100) {
			$db->requete('UPDATE membres SET id_group = 8,pourcent = \''.$membre['pourcent'].'\' WHERE id_m=' . $id_m . '');
			$time2set = time() + 24 * 7 * 3600;
			$db->requete("INSERT INTO punish VALUES('','$membre[id_m]','$membre[id_group]','$time2set')");
			$message = 'Ce membre est mis en lecture seul pour 1 semaine.';
			$redirection = ROOT . 'admin-membres.html';
			$type = 'ok';
		} else {
			$pourcentage = $pourcentage + $membre['pourcent'];
			$db->requete('UPDATE membres SET pourcent = ' . $membre['pourcent'] . ' WHERE id_m=' . $id_m . '');
			$message = 'Pourcentage ajoutée.';
			$redirection = ROOT . 'admin-membres.html';
			$type = 'ok';
		}
	}else{
		$message = 'Vous n\'avez pas le droits de punnir un membre.';
		$redirection = ROOT . 'admin-membres.html';
		$type = 'important';
	}
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>