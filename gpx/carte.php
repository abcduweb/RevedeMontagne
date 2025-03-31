<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

	$data = get_file(TPL_ROOT.'gpx/carte.tpl');
	include(INC_ROOT.'header.php');

	$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'cartegpx - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	echo $data;
$db->deconnection();
?>