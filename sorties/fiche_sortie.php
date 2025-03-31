<?php
if(!isset($load_tpl)){
$load_tpl = true;
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
}
if(!empty($_GET['pid']))
{
	
	$data = get_file(TPL_ROOT."sorties/fiche_sortie.tpl");
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);
		$reponse =  $db->requete("SELECT * FROM sortie
									LEFT JOIN topos ON topos.id_topo = sortie.id_topo
									WHERE sortie.id_sortie = '".$midi."'");
		$num = $db->num();
		$type_topo = $db->fetch($reponse);
		
		if($type_topo['id_activite'] == 1){
		$reponse =  $db->requete("SELECT topos.id_topo AS id_topo, nom_topo, nom_massif, massif.id_massif, nom_point, nom_topo, dates, meteos, recit_parser, id_point, altitude 
									FROM sortie
									LEFT JOIN topos ON topos.id_topo = sortie.id_topo
									LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
									LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
									LEFT JOIN departs ON departs.id_depart = topos.id_depart
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
									LEFT JOIN map_gpx ON map_gpx.id_mapgpx = sortie.id_mapgpx
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE sortie.id_sortie = '".$midi."'");
		$lien = 't';
		}else{
		$reponse =  $db->requete("SELECT topos.id_topo AS id_topo, nom_topo, nom_massif, massif.id_massif, nom_point, nom_topo, dates, meteos, recit_parser, id_point, altitude 
									FROM sortie
									LEFT JOIN topos ON topos.id_topo = sortie.id_topo
									LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
									LEFT JOIN departs ON departs.id_depart = topos.id_depart
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
									LEFT JOIN map_gpx ON map_gpx.id_mapgpx = sortie.id_mapgpx
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE sortie.id_sortie = '".$midi."'");	
		$lien = 'tr';
		}
		
		$num = $db->num();
		$donnees = $db->fetch($reponse);
		
	if($num > 0){
	
		$data = parse_var($data,array(
			'ids'=>$midi,
			'id_topo'=>$donnees['id_topo'],
			'nom_topo_url'=>title2url($donnees['nom_topo']),
			'massif'=>$donnees['nom_massif'],
			'id_massif'=>$donnees['id_massif'],
			'nom_massif_url'=>title2url($donnees['nom_massif']),
			'nom_sommet'=>$donnees['nom_point'],
			'nom_topo'=>$donnees['nom_topo'],
			'date_sortie'=>$donnees['dates'],
			'meteo'=>$donnees['meteos'],
			'recit'=>$donnees['recit_parser'],
			'url_nom_sommet'=>'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-2.html',
			'design'=>$_SESSION['design'],
			'titre_page'=>$donnees['nom_point'].', '.$donnees['nom_topo'].' ('.$donnees['altitude'].' m)- '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'',
			'id_t'=>$donnees['id_topo']
			));
		
		//On liste les photos éventuelles de la sortie
		$sql = ("SELECT * FROM images 
			LEFT JOIN album_sorties ON album_sorties.id_photo = images.id_image
			WHERE id_sortie = '".$midi."'");	
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$data = parse_boucle('PHOTO',$data,FALSE,array(
			'PHOTO.photos' => '<a href="'.$config['domaine'].'images/autres/1/'.$row['nom'].'" rel="test"><img src="'.$config['domaine'].'images/autres/1/mini/'.$row['nom'].'" alt="Image utilisateur" /></a>'
			));
		}
		$data = parse_boucle('PHOTO',$data,TRUE);
		
		$data = parse_var($data,array('t'=>$lien,/*'repondre'=>$reponse,*/ 'design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));
	}else
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