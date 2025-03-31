<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
	header("Content-type: text/xml");
	




	$result = $db->requete("SELECT * FROM point_gps");	
	
	$xml='';
	$xml .= '<markers>';
	while ($row = $db->fetch($result))
	{			
				$xml .= '<marker titre="'.$row['nom_point'].' ('.$row['type_point'].')" uri="'.title2url($row['nom_point']).'" lat="'.$row['lat_point'].'"
				lng="'.$row['long_point'].'" description="'.$row['nom_point'].'" icone="'.$row['icones'].'" id_point ="'.$row['id_point'].'" id_type="'.$row['type_point'].'"/>';
				
				
	}
	$xml .= '</markers>';


	echo $xml;
?>