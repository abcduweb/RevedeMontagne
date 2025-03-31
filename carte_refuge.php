<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$data = get_file(TPL_ROOT.'carte_refuge.tpl');
include(INC_ROOT.'header.php');
$data = parse_var($data,array('titre_page'=>'carte des refuges - '.SITE_TITLE,'ROOT'=>ROOT,'design'=>$_SESSION['design'],
					'mapid'=>'map_canvas', 'lat'=>'46.7', 'long'=>'2.5', 'zoom'=>'6', 'nb_requetes'=>$db->requetes,'ROOT'=>''));
echo $data;
$db->deconnection();
?>