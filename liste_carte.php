<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$data = get_file(TPL_ROOT.'liste_cartes.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=> 'Liste des cartes - '.SITE_TITLE,
			'nb_requetes'=>$db->requetes,'ROOT'=>ROOT));
	echo $data;
