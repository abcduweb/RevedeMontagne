<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################	
$data = get_file(TPL_ROOT.'topos/test.tpl');
include(INC_ROOT.'header.php');
$data = parse_var($data,array('titre_page'=>'Topos de skis de randonn&#233;es', 'nb_requetes'=>$db->requetes, 'design'=>$_SESSION['design'], 'ROOT'=>''));
echo $data;

$db->deconnection();
?>