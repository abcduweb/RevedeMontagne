<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(in_array($_SESSION['group'],$team_group_id)){
	if(!empty($_GET['idM'])){
		$idMessage = intval($_GET['idM']);
		$sql = "SELECT * FROM livreor WHERE id = '$idMessage'";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			if(isset($_POST['valider']) AND $_POST['valider'] == 1){
				$sql = "DELETE FROM livreor WHERE id = '$idMessage'";
				$db->requete($sql);
				$data = get_file(TPL_ROOT."system_ei.tpl");
				$redirection = ROOT."livre-d-or.html";
				$message = "Message supprimer";
				$data = display_notice($message,'ok',$redirection);
			}else{
				$url = "supprimer_livreor.php?idM=".$idMessage;
				$message = "Etes vous sûr de vouloir supprimer ce message?";
				$data = display_confirm($message,$url);
			}
		}else{
			$redirection = "javascript:history.back(-1);";
			$message = "Message innexistant.";
			$data = display_notice($message,'important',$redirection);
		}
	}else{
		$redirection = "javascript:history.back(-1);";
		$message = "Aucun message de sélectionner.";
		$data = display_notice($message,'important',$redirection);
	}
}else{
	$redirection = "javascript:history.back(-1);";
	$message = "Message innexistant.";
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>