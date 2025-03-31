<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################


$data = get_file(TPL_ROOT."google/100kms.tpl");		
include(INC_ROOT.'header.php');
$lat = floatval($_GET['lat']);
$long = floatval($_GET['long']);

		
//$data = parse_var($data,array('id_massif'=>$massif['id_massif'], 'nom_massif'=>$massif['nom_massif'], 'nom_massif_url'=>title2url($massif['nom_massif'])));		
$data = parse_var($data,array('lat'=>$lat, 'long'=>$long, 'titre_page'=>'Ajouter un départ - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));

echo $data;
$db->deconnection();
?>