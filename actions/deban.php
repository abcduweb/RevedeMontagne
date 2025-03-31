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
				if(remove_ip($_GET['ip'])){
					$url = ROOT."admin.html";
					$message = "Ip d&eacute;banie";
					$redirection = ROOT.'liste-banis.html';
					$data = display_notice($message,'ok',$redirection);
				}
				else{
					$message = "Ip non bannie";
					$url = ROOT."admin.html";
					$redirection = ROOT.'liste-banis.html';
					$data = display_notice($message,'important',$redirection);
				}
			}
			else{
				$url = "deban.php?ip=".htmlentities($_GET['ip'],ENT_QUOTES);
				$message = "&Ecirc;tes vous s&ucirc;r de vouloir d&eacute;banir cette ip?";
				$data = display_confirm($message,$url);
			}
		}
		else{
			$message = "Aucune ip n'est s&eacute;lectionn&eacute;e";
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