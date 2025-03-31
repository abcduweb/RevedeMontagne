<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!empty($_GET['carte'])){
	$data = get_file(TPL_ROOT.'cartes.tpl');
	switch($_GET['carte']){
		case 1:
			$url_carte = 'carte-des-refuges-de-reve-de-montagne.html';
			$kml = 'carte-des-refuges-de-reve-de-montagne.kml';
			$titre_carte = 'Carte des refuges sur Reve de Montagne';
		break;
	}
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('carte'=>$titre_carte,'url_carte'=>$url_carte,'kml_carte'=>$kml,
			'design'=>$_SESSION['design'],'titre_page'=> $titre_carte.' - '.SITE_TITLE,
			'nb_requetes'=>$db->requetes,'ROOT'=>ROOT));
	echo $data;
}
