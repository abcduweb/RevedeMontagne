<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################


$sql = "SELECT * FROM sommets";
$result = $db->requete($sql);

$sommets = array();
while ($row = $db->fetch($result))
{		
	$sommets[$row['id_point']] = $row['altitude_som'];
}

//$cle1 = 94;
foreach($sommets as $key => $var)
{
	$i =$key.' '.$var.'<br />';
	//$cle1++;
	$sql = "UPDATE point_gps SET altitude = ".$var." WHERE id_point = ".$key."";
	$result = $db->requete($sql);
}

print_r($sommets);
?>