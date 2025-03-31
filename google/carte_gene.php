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
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$sql = '';
$idmass = '';
$typep = '';
$requete = '';

if(!empty($_GET['idmass']))
{
	$idmass = intval($_GET['idmass']);
	$sql .= 'id_massif= '.$idmass.' ';	
}
if(!empty($_GET['typep']))
{
	//On vérifie que la variable SQL soit vide
	if($sql != '')
		$sql .= ' AND ';
		
	//cabanes < 9
	$typep = intval($_GET['typep']);
	if($typep < 9)
		$sql .= 'point_gps.type_point < 9';
	else
		$sql .= 'point_gps.type_point > 8';
}

if ($sql != '')
{
	$requete = ' WHERE '.$sql.' AND point_gps.statut > 0';
}
else
{
	$requete = ' WHERE point_gps.statut > 0'; 
}

$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$auth = $db->fetch($db->requete($sql));
$sql = ('SELECT * FROM point_gps LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point'.$requete);	
$result = $db->requete($sql);

// On initialise un tableau associatif
$tableauAgences = [];
$tableauAgences['agences'] = [];
while ($row = $db->fetch($result))
	{

	if($auth['administrateur_points'] == 1){
		if($row['id_type'] < 9)
			$modifier = "<a href=\"edition-fiche-refuge-".$row['id_point'].".html\">Editer la fiche</a>";
		else
			$modifier = "<a href =\"edition-fiche-sommet-".$row['id_point']."-m".$row['id_massif'].".html\"> Editer la fiche</a>" ;
	}else{
		$modifier = "";}

	//$modifier = "";
	$nom = "<a href=\"detail-".title2url($row['nom_point'])."-".$row['id_point']."-".$row['type_point'].".html\">".$row['nom_point']."</a>";
	//$url = "<br />".$modifier."ajout liens";
    $agen = [
            "id" => $row['id_point'],
            "nom" => $nom, //html_entity_decode($row['nom_point']),
            "lat" => $row['lat_point'],
            "lon" => $row['long_point'],
			"iconRDM" => $row['icon_carte'],
			"lien" => "<br />".$modifier,
            ];

    $tableauAgences['agences'][] = $agen;
	}

    // On encode en json et on envoie
    echo json_encode($tableauAgences);

$db->deconnection();
?>