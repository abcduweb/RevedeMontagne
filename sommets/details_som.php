<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_GET['pid']) AND !empty($_GET['pid'])){
$id_som = intval($_GET['pid']);
	
$sql = "SELECT * FROM point_gps
		LEFT JOIN sommets ON sommets.id_point = point_gps.id_point
		LEFT JOIN massif ON massif.id_massif = sommets.id_massif 
		LEFT JOIN cartes ON cartes.id_carte = sommets.id_carte
		WHERE point_gps.id_point = '".$id_som."'";
$result = $db->requete($sql);
	
	//Si le sommet existe
	if($db->num($result) > 0)
	{
		$row = $db->fetch($result);
		$data = get_file(TPL_ROOT.'sommets/details_som.tpl');
		include(INC_ROOT.'header.php');
		
		$data = parse_var($data,array(
			'nom_som'=>$row['nom_som'],
			'design'=>$_SESSION['design'],
			'titre_page'=> $row['titre'].' - '.SITE_TITLE,
			'nb_requetes'=>$db->requetes,));
	}
	else
	{
		$data = display_notice('Ce sommet n\'existe pas','important','index.html');
	}
}
else
{
	header("location:index.html");
}
echo $data;
$db->deconnection();
?>
