<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/xml; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$xml = '';

//on génère l'entête du sitemap
$xml .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?> \n
		<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\" xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";

//On créer la requête du sitemap pour les topos de randonnée
$sql = ("SELECT * FROM point_gps
		LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
		LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
		WHERE point_gps.type_point > 0
		AND point_gps.type_point < 8
		AND point_gps.statut>0
	ORDER BY date_point desc");	
$result = $db->requete($sql);

//On boucle pour avoir le listing des sorties de randonnées
while ($row = $db->fetch($result))
{
	if ($row['date_point'] == "0000-00-00 00:00:00")
	{
		$date_xml = "2022-08-24";
	}
	else
	{
		//$date_xml = date_create_from_format('Y\-m\-d H:i:s', $row['date_topo']);
		$date_xml = strtotime($row['date_point']);
		$date_xml = date("Y-m-d",$date_xml);
	}
	
	//$date_xml = $row['date_point'];
	
	$xml .= "<url>";
	$xml .= "<loc>".$config['domaine']."detail-".title2url($row['nom_point'])."-".$row['id_point']."-1.html</loc>";
	//$xml .= "<loc>".$config['domaine']."topo-".title2url($row['nom_point'])."-".title2url($row['nom_topo'])."-t".$row['id_topo'].".html</loc>";
	$xml .= "<lastmod>".$date_xml."</lastmod>";	
	$xml .= "</url>";
}

$xml .= "</urlset>";

//On affiche le flux
echo $xml;