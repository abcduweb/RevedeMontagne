<?php
/*
 * Créer le 21 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: le traitement de changement de groupe.
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if($_SESSION['group'] == 1){
	if(isset($_GET['mid']) AND !empty($_GET['mid'])){
		$Umid = intval($_GET['mid']);
		$sql = "SELECT * FROM membres WHERE id_m = '$Umid'";
		$result = $db->requete($sql);
		$infoUser = $db->fetch($result);
		if($db->num($result) > 0){
			if(!empty($_POST['idNGroup']) OR !empty($_GET['idNGroup'])){
				if(isset($_POST['idNGroup']))
					$idNGroup = intval($_POST['idNGroup']);
				else
					$idNGroup = intval($_GET['idNGroup']);
				$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$idNGroup'";
				$result = $db->requete($sql);
				$infoGroupe = $db->fetch($result);
				if($db->num($result) > 0){
					if(isset($_POST['valider']) AND $_POST['valider'] == 1){
						$sql = "UPDATE membres SET id_group = $idNGroup WHERE id_m = '$Umid'";
						$db->requete($sql);
						$message = "Le changement de groupe a bien été effectuer";
						$redirection = ROOT."admin-membres.html";
						$data = display_notice($message,'ok',$redirection);
					}else{
						$url = "changer_group.php?mid=".intval($_GET['mid']).'&amp;idNGroup='.$idNGroup;
						$message = "Etes vous sur de vouloir passer $infoUser[pseudo] en $infoGroupe[nom_group]"; 
						$data = display_confirm($message,$url);
					}
				}else{
					$message = "Ce groupe n'existe pas.";
					$redirection = "javascript:history.back(-1);";
					$data = display_notice($message,'important',$redirection);
				}
			}else{
				$message = "Aucun groupe de sélectionner.";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
			}
		}else{
			$message = "Ce membre n'existe pas.";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	}else{
		$message = "Aucun membre de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		$data = display_notice($message,'important',$redirection);
	}
}
else{
	$message = "Vous n'avez pas accé à cette partie.";
	$redirection = "javascript:history.back(-1);";
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>