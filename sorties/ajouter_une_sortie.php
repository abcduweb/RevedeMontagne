<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{

	if(!empty($_GET['topo']))
	{
		
		$data = get_file(TPL_ROOT."sorties/ajouter_une_sortie.tpl");
			
		include(INC_ROOT.'header.php');
		$topo = intval($_GET['topo']);
		$acts = intval($_GET['acts']);
		
		$sql = "SELECT * FROM map_gpx WHERE id_m = '".$_SESSION['mid']."' ORDER BY id_mapgpx DESC";
		$result = $db->requete($sql);
		
		
		
		if (!isset($_GET['m']))
		{
		$data = parse_var($data,array('nom_depart'=>'', 'acces'=>'', 'altitude'=>''));
		
		while($row = $db->fetch_assoc($result))
			{
				$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>'', 'TYPE.id_gpx'=>$row['id_mapgpx'], 'TYPE.date_gpx'=>date("d/m/Y", strtotime($row['date_mapgpx'])),'TYPE.nom_gpx'=>$row['nom_mapgpx']));
			}
			$data = parse_boucle('TYPE',$data,TRUE);
		
		
		}
		else
		{

		}
			
		$data = parse_var($data,array('edition'=>''));		
			
		$data = parse_var($data,array('acts'=>$acts, 'idt'=>$topo, 'titre_page'=>'Ajout / Edition d\'une sortie - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));

	}else
	{
		$message = 'Veuillez choisir un topo avant d\'ajouter une sortie';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>