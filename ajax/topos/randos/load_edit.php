<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../../../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
include(ROOT.'fonctions/zcode.fonction.php');
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
header('Content-Type: text/html; charset=UTF8');

$id_m = intval($_POST['id']);
$type = htmlentities($_POST['type'], ENT_QUOTES);

$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$row = $db->fetch($db->requete($sql));



$sql = "SELECT * FROM topos WHERE id_topo = '$id_m'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);

if (($row2['id_m'] == $_SESSION['mid'] AND $row['redacteur_topo'] == 1) OR ($row['administrateur_topo'] == 1)) 
{
	if ($type == 'itineraire')
	{
		echo $row2['itineraire'];

	}
	else
	{
		echo $row2['remarque'];
	}
}
else
{
	echo 'édition de la fiche impossible';
}
$db->deconnection();
?>
