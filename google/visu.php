<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT.'google/fond_carte_google.tpl');
include(INC_ROOT.'header.php');
$lat='';
$long='';
	
$data = parse_var($data,array('lat'=>$lat,'long'=>$long));
$data = parse_var($data,array('titre_page'=>'IGN - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
echo $data;

$db->deconnection();
?>