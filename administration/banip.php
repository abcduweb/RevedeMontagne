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
	$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);;
	
}
else{
	if($_SESSION['group'] == 1){
		$listban = get_ban();
		if(!$listban){
			$data = get_file(TPL_ROOT.'admin/liste_ban_empty.tpl');
		}
		else{
			$data = get_file(TPL_ROOT.'admin/liste_ban.tpl');
			foreach($listban as $var){
				$data = parse_boucle("IP",$data,false,array('ip'=>$var));
			}
			$data = parse_boucle("IP",$data,true);
		}
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('titre_page'=>'Liste des IPs bannies - '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
		echo $data;
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);;
	}
}
$db->deconnection();
?>