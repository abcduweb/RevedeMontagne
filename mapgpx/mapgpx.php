<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT."mapgpx/mapgpx.tpl");
include(INC_ROOT.'header.php');
$midi = htmlentities($_GET['mpgpx']);
$reponse =  $db->requete("SELECT * FROM map_gpx
						  LEFT JOIN membres ON membres.id_m = map_gpx.id_m
						  LEFT JOIN activites ON activites.id_activite = map_gpx.id_activite
						  LEFT JOIN topos ON topos.id_topo = map_gpx.id_topo
						  LEFT JOIN massif ON massif.id_massif = topos.id_massif
						  LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
						  WHERE id_mapgpx = '$midi' ");
if($db->num() > 0){
	
	$donnees = $db->fetch($reponse);
	if(isset($_SESSION['ses_id']))
		$telecharger = '<a href="mapgpx/download.php?mpgpx='.$donnees['cle_mapgpx'].'">T&eacute;l&eacute;charger le fichier</a>';	
	else
		//$telecharger = 'R&eacute;serv&eacute; aux <a href="inscription.html">membres</a> (inscription gratuite)';
		$telecharger = '<a href="mapgpx/download.php?mpgpx='.$donnees['cle_mapgpx'].'">T&eacute;l&eacute;charger le fichier</a>';	
	
	if($donnees['id_activite'] == 1)
	{
		$url_topos = $config['domaine'].'liste-des-topos-skis-rando.html';
		$type_topo = 'topos de skis de randonn&eacute;es';
		$id_massif =  $donnees['id_massif'];
		$massif =  $donnees['nom_massif'];
		$url_nom_sommet =  $config['domaine'].'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-2.html';
		$nom_sommet =  $donnees['nom_point'];
		$url_nom_topo = $config['domaine'].'topo-'.title2url($donnees['nom_topo']).'-tr'.$donnees['id_topo'].'.html';
		$nom_topo = $donnees['nom_topo'];
	}
	elseif($donnees['id_activite'] == 2)
	{
		$url_topos =  $config['domaine'].'liste-des-topos-de-randonnee.html';
		$type_topo =  'topos de randonn&eacute;es';
		$id_massif =  $donnees['id_massif'];
		$massif =  $donnees['nom_massif'];
		$url_nom_sommet =  $config['domaine'].'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-2.html';
		$nom_sommet =  $donnees['nom_point'];
		$url_nom_topo = $config['domaine'].'topo-'.title2url($donnees['nom_topo']).'-tr'.$donnees['id_topo'].'.html';
		$nom_topo = $donnees['nom_topo'];
	}	
	else
	{
		$url_topos = '';
		$type_topo = '';
		$id_massif = '';
		$massif = '';
		$url_nom_sommet = '';
		$nom_sommet = '';
		$url_nom_topo = '';
		$nom_topo = '';
	
	}
	
	$data = parse_var($data,array('url_topos'=>$url_topos, 'type_topo'=>$type_topo, 'id_massif'=>$id_massif, 'massif'=>$massif, 'url_nom_sommet'=>$url_nom_sommet, 'nom_sommet'=>$nom_sommet, 'url_nom_topo'=>$url_nom_topo, 'nom_topo'=>$nom_topo));

	$data = parse_var($data,array(
		'telecharger'=>$telecharger,
		'pseudo' => '<a href="membres-'.$donnees['id_m'].'-fiche.html">'.$donnees['pseudo'].'</a>',
		'date_mapgpx' => strftime( "%d %B %Y &agrave; %Hh%M" , strtotime( $donnees['date_mapgpx'] ) ),
		'nom_trace' => $donnees['nom_mapgpx'],
		'url_mapgpx' => $donnees['url_mapgpx'],
		'nom_membre' => $donnees['pseudo'],
		'nbpoints'=>$donnees['nb_points'],
		'longueur'=>round($donnees['longueur'], 2),
		'den_positif_cumu'=>round($donnees['den_positif_cumu'], 2),
		'den_negatif_cumu'=>round($donnees['den_negatif_cumu'], 2),
		'altitude_maxi'=>round($donnees['altitude_maxi'], 2),
		'altitude_mini'=>round($donnees['altitude_mini'], 2),
		'altitude_moyenne'=>round($donnees['altitude_moyenne'], 2),
		'date_debut'=>$donnees['date_debut'],
		'date_fin'=>$donnees['date_fin'],
		'duree_marche_totale'=>$donnees['duree_totale'],
		'duree_marche'=>$donnees['duree_marche'],
		'duree_pause'=>$donnees['duree_pause'],
		'vitesse_moyenne'=>round($donnees['vitesse_moyenne'], 2),
		'duree_montee'=>$donnees['duree_positif_cumu'],
		'duree_descente'=>$donnees['duree_negatif_cumu'],
		'vitesse_montee'=>round($donnees['vitesse_montee'], 0),
		'vitesse_descente'=>round($donnees['vitesse_descente'], 0),
		'titre_trace'=>$donnees['nom_mapgpx'],
		'activite'=>$donnees['nom_activite'],
		'departement'=>$donnees['nom_massif'],
		'desc_trace'=>$donnees['descparser_mapgpx'],
		'desc_trace_header'=>$donnees['desc_mapgpx'],
		'design'=>$_SESSION['design'],
		'titre_page'=>$donnees['nom_mapgpx'].' - '.SITE_TITLE,
		'nb_requetes'=>$db->requetes,'ROOT'=>''
		));
}else{
	$message = 'La trace n\'&eacute;xiste pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
