<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
header("Content-type: text/xml");
$idpoint = intval($_GET['idp']);
$sql = ("SELECT * FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point WHERE id_point = ".$idpoint);	
$result = $db->requete($sql);
	
$data = '<?xml version="1.0" encoding="utf-8" standalone="yes" ?><markers>';
while ($row = $db->fetch($result))
	{
		$url = 'detail-'.title2url($row['nom_point']).'-'.$row['id_point'].'-'.$row['type_point'].'.html';
		$data .="<marker id='".$row['id_point']."' lng='".$row['long_point']."' lat='".$row['lat_point']."' description='".html_entity_decode($row['nom_point'])."' iconRDM='".$row['icon_carte']."' />";
		//description='".html_entity_decode($row['nom_point'])."' />
	}
	
$sql = ("SELECT departs.id_depart, lat_depart, long_depart, lieu_depart FROM topos 
		 LEFT JOIN departs ON departs.id_depart = topos.id_depart
		 WHERE id_sommet = ".$idpoint);	
$result = $db->requete($sql);
while ($row = $db->fetch($result))
	{	
		echo $row['departs.id_depart'];
		//$data .="<marker id='".$row['departs.id_depart']."' lng='".$row['long_depart']."' lat='".$row['lat_depart']."' description='".html_entity_decode($row['lieu_depart'])."' iconRDM='".$config['domaine']."/templates/images/1/carte/voiture.png' />";
	}
$data .='</markers>';
echo $data;

$db->deconnection();
?>