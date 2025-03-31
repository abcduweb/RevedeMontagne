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
$sql = ("SELECT membres.id_m, membres.pseudo, date_topo, nom_point, nom_topo, topos.id_topo, nom_point, nom_topo, nom_activite, nom_massif, denniveles, topos.id_m AS id_m 
	FROM topos
	LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
	LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
	LEFT JOIN departs ON departs.id_depart = topos.id_depart
	LEFT JOIN activites ON activites.id_activite = topos.id_activite
	LEFT JOIN membres ON membres.id_m = topos.id_m
	WHERE topos.statut > 0 
	AND visible = 1
	AND activites.id_activite = 1
	ORDER BY date_topo desc");	
$result = $db->requete($sql);

//On boucle pour avoir le listing des sorties de randonnées
while ($row = $db->fetch($result))
{
	//$date_xml = date_create_from_format('Y\-m\-d H:i:s', $row['date_topo']);
	$date_xml = strtotime($row['date_topo']);
	$date_xml = date("Y-m-d",$date_xml);
	
	$xml .= "<url>";
	$xml .= "<loc>".$config['domaine']."topo-".title2url($row['nom_point'])."-".title2url($row['nom_topo'])."-t".$row['id_topo'].".html</loc>";
	$xml .= "<lastmod>".$date_xml."</lastmod>";	
	$xml .= "</url>";
}

$xml .= "</urlset>";

//On affiche le flux
echo $xml;