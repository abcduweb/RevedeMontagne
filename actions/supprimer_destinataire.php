<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = ROOT.'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else
{
	if(isset($_GET['idd']) AND !empty($_GET['idd'])){
		$id_disc = intval($_GET['idd']);
		if(isset($_GET['did']) AND !empty($_GET['did'])){
			$id_dest = intval($_GET['did']);
			$sql = "SELECT * FROM discutions_lues LEFT JOIN liste_discutions ON liste_discutions.id_discution = discutions_lues.id_discution_l LEFT JOIN membres ON membres.id_m = discutions_lues.id_membre WHERE discutions_lues.id_discution_l = '$id_disc' AND discutions_lues.`in` = 1";
			$result = $db->requete($sql);
			$destinataire = array();
			$in_discution = false;
			while($row = $db->fetch($result)){
				$titre = $row['titre'];
				if($row['id_membre'] != $_SESSION['mid']){
					$destinataire[] = $row['id_membre'];
					$pseudo[$row['id_membre']] = $row['pseudo'];
				}
				else{
					if($_SESSION['mid'] == $row['id_createur'])$in_discution = true;
				}
			}
			if($in_discution AND in_array($id_dest,$destinataire)){
				if(isset($_POST['valider']) AND $_POST['valider'] == 1){
				  $sql = "UPDATE discutions_lues SET `in` = 0 WHERE id_discution_l = '$id_disc' AND id_membre = '$id_dest'";
				  $db->requete($sql);
				  $message = $pseudo[$id_dest]." a bien été Supprimé de la discution.";
				  $redirection = ROOT."mp-$id_disc-".title2url($titre).".html";
				  $data = display_notice($message,'ok',$redirection);
				}
				else{
					$message = "Etes vous sûr de vouloir enlever ".$pseudo[$id_dest]." de cette discution?";
					$url = "supprimer_destinataire.php?idd=$id_disc&amp;did=$id_dest";
					$data = display_confirm($message,$url);
				}
			}
			else{
				if(!$in_discution)$message = "Vous n'avez pas le droit d'effectuer cette action.";
				if(!in_array($id_dest,$destinataire))$message = "Impossible de supprimer. Cette personne ne fait pas partie de cette discution.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = "Aucun destinataire de sélectionner.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Aucune discution de sélectionner";
		$redirection = ROOT."liste-mp.html";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
?>
