<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez �tre enregistr� pour pouvoir acc�der � cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else{
	$data = get_file(TPL_ROOT."mes_options.tpl");
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array("design"=>$_SESSION['design'],"titre_page"=>"Mes options - ".SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>