<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT.'erreur.tpl');
include(INC_ROOT.'header.php');

$data = parse_var($data,array('titre_page'=>'Erreur - '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
echo $data;
$db->deconnection();
?>