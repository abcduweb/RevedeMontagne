<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!isset($_SESSION['ses_id'])){
	$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
	$redirection = ROOT.'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else{
	if($_SESSION['group'] == 1){
		if(isset($_GET['ip'])){
			if(isset($_POST['valider']) AND $_POST['valider'] == 1){
				$banOk = add_ban($_GET['ip']);
				if($banOk == 'ok'){
					$redirection = ROOT."liste-banis.html";
					$message = "Ip banie";
					$data = display_notice($message,'ok',$redirection);
				}
				else{
					$message = $banOk;
					$redirection = ROOT."liste-banis.html";
					$data = display_notice($message,'important',$redirection);
				}
			}
			else{
				$url = "ban.php?ip=".htmlentities($_GET['ip'],ENT_QUOTES);
				$message = "Etes vous s&ucirc;r de vouloir banir cette ip : ".htmlentities($_GET['ip'],ENT_QUOTES)."?";
				$data = display_confirm($message,$url);
			}
		}
		else{
			$message = "Aucune ip n'est s&eacute;lectionn&eacute;";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Vous n'avez pas le droit d'effectuer cette action";
		$redirection = ROOT."index.php";
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>