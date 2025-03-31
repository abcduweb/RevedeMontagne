<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!empty($_GET['pid']))
{
	
	$data = get_file(TPL_ROOT."depart/fiche_depart.tpl");
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);
		$reponse =  $db->requete("SELECT * FROM departs
								  LEFT JOIN massif ON massif.id_massif = departs.id_massif
								  LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE departs.id_depart = '".$midi."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);

	if($num > 0){
	
		//On cherche les sommets liers à ce départ
		$sql = "SELECT *
				FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
				WHERE departs.id_depart = '".$midi."'
				AND topos.visible = 1
				ORDER BY id_point DESC LIMIT 0,5";
		
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$data = parse_boucle('TOPOS',$data,FALSE,array(
			'TOPOS.id_topo'=>$row['id_topo'],
			'TOPOS.nom_topo'=>$row['nom_topo'],
			'TOPOS.nom_topo_url'=>title2url($row['nom_topo']),
			'TOPOS.orientation'=>$row['orientation'],
			'TOPOS.diff1'=>$row['difficulte_topo'],
			'TOPOS.alti'=>$row['denniveles']
			));
		}
		
		$data = parse_boucle('TOPOS',$data,TRUE);
		
		
		
		$data = parse_var($data,array(
			'url_nom_depart'=>'depart-'.title2url($donnees['lieu_depart']),
			'nom_depart'=>$donnees['lieu_depart'],
			'id_depart'=>$donnees['id_depart'],
			'acces'=>$donnees['acces_parser'],
			'altitude'=>$donnees['alt_depart'],
			'massif'=>$donnees['nom_massif'],
			'design'=>$_SESSION['design'],
			'titre_page'=>'D&eacute;part - '.$donnees['lieu_depart'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'',
			));
			
		
		$data = parse_var($data,array('design'=>$_SESSION['design']));
	}	
	else
	{
		$message = 'La fiche n\'existe pas';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
	}
}else
{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>