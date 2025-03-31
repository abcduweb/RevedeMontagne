<?php
if(!isset($load_tpl)){
$load_tpl = true;
########### A METTRE SUR CHAQUE PAGE ############
session_start();		
//https://mpetazzoni.github.io/leaflet-gpx/   # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
}
if(!empty($_GET['pid']))
{
	$midi = intval($_GET['pid']);
		$reponse =  $db->requete("SELECT visible, id_m_join, invisible, topos.id_topo, nom_topo, idf, topos.id_activite, nom_point, id_point, nom_topo, topos.id_massif, nom_massif, orientation, denniveles, difficulte_topo, difficulte, topos.statut, exposition,
								   lat_depart, long_depart, departs.id_depart, lieu_depart, alt_depart, pente, nb_jours, nom_type, acces_parser, itineraire_parser, remarque_parser, altitude, topos.id_m, membres.pseudo, avatar,
								   longueur, duree_totale, duree_pause, duree_marche, sortie.id_mapgpx, cle_mapgpx, nom_mapgpx, map_gpx.id_mapgpx
									FROM topos
									LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
									LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
									LEFT JOIN departs ON departs.id_depart = topos.id_depart
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
									LEFT JOIN membres ON membres.id_m = topos.id_m
									LEFT JOIN enligne ON enligne.id_m_join = topos.id_m
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
									LEFT JOIN sortie ON sortie.id_topo = topos.id_topo
									LEFT JOIN map_gpx ON map_gpx.id_topo = topos.id_topo 
								WHERE topos.id_topo = '".$midi."'
								AND topos.id_activite = 1");
		$num = $db->num();
		$donnees = $db->fetch($reponse);

	if($num > 0 && ($donnees['visible'] == 1) || $num > 0 && ($donnees['id_m'] == $_SESSION['mid'])){
		$data = get_file(TPL_ROOT."topos/fiche_skis.tpl");
		include(INC_ROOT.'header.php');
	
		//On vérifi la validation du point GPS par l'équipe
		if($donnees['statut']==2)
		{
			$retour = $db->requete('SELECT COUNT(*) FROM messages WHERE id_topics = "'.$donnees['idf'].'"');
			$nb_coms = $db->row($retour);		
			$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe.png" alt="validé par l\'équipe" /></a>';
			$com='<li>Discussions : <a href="'.$config['domaine'].'forum-7-'.$donnees['idf'].'-'.title2url($donnees['nom_topo']).'.html">('.$nb_coms[0].') commentaire(s)</a></li>';
		}
		else
		{
			$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe_encours.png" alt="validé par l\'équipe" /></a>';
			$com='';
		}
		
		//$donnees = $db->fetch($reponse);
		//Récupération des cartes...
		$result =  $db->requete("SELECT * FROM utiliser_carte
									LEFT JOIN cartes ON cartes.id_carte = utiliser_carte.id_carte
								 WHERE id_topo = '".$midi."'");
		while ($row = $db->fetch($result))
		{
			$data = parse_boucle('CARTE',$data,FALSE,array(
			'CARTE.nom_carte'=>$row['num_carte'],
			'CARTE.nom_url_carte'=>title2url($row['nom_carte']),
			'CARTE.id_carte'=>$row['id_carte']
			));
		}
		
		$data = parse_boucle('CARTE',$data,TRUE);
		
		if($donnees['avatar'] != '')
			$avatar = '<img src="'.$donnees['avatar'].'" alt="avatar" class="emplacement_avatar" />';
		else
			$avatar = '';
		
		if(isset($donnees['id_m_join']) AND $donnees['invisible'] == 0)
			$online = 'online';
		else	
			$online = 'offline';
		

		
		
		$data = parse_var($data,array(
			'id_topo'=>$donnees['id_topo'],
			'validation'=>$validate,
			'url_nom_acces'=>title2url($donnees['lieu_depart']),
			'id_acces'=>$donnees['id_depart'],
			'nom_acces'=>$donnees['lieu_depart'],
			'alt_acces'=>$donnees['alt_depart'],
			'lat_depart'=>$donnees['lat_depart'],
			'lng_depart'=>$donnees['long_depart'],
			'coms'=>$com,
			'ids'=>$donnees['id_activite'],
			'nom_sommet'=>$donnees['nom_point'],
			'url_nom_sommet'=>'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-2.html',
			'nom_topo'=>$donnees['nom_topo'],
			'id_massif'=>$donnees['id_massif'],
			'nom_massif_url'=>title2url($donnees['nom_massif']),
			'massif'=>$donnees['nom_massif'],
			'orientation'=>$donnees['orientation'],
			'dennivele'=>$donnees['denniveles'],
			'difficulte'=>$donnees['difficulte_topo'],
			'difficulte_skis'=>$donnees['difficulte'],
			'exposition'=>$donnees['exposition'],
			'depart'=>$donnees['lieu_depart'],
			'alt_depart'=>$donnees['alt_depart'],
			'nb_jours'=>$donnees['nb_jours'],
			'type'=>$donnees['nom_type'],
			'acces'=>$donnees['acces_parser'],
			'itineraire'=>$donnees['itineraire_parser'],
			'remarques'=>$donnees['remarque_parser'],
			'id_m'=>$donnees['id_m'],
			'pseudo'=>$donnees['pseudo'],
			'avatar'=>$avatar,
			'enligne'=>$online,
			'design'=>$_SESSION['design'],
			'titre_page'=>$donnees['nom_point'].', '.$donnees['nom_topo'].' ('.$donnees['altitude'].' m)- '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'',
			));	

		$rep =  $db->requete("SELECT * FROM map_gpx WHERE id_topo = '".$midi."'");
		$nbr = $db->num();
		$gpx = $db->fetch($rep);
		
		if($nbr > 0)
		{
			if(isset($_SESSION['ses_id']))
				$telecharger = ' - <a href="'.$config['domaine'].'mapgpx/download.php?mpgpx='.$gpx['cle_mapgpx'].'">T&eacute;l&eacute;charger le fichier</a>';	
			else
				$telecharger = $gpx['cle_mapgpx'];
			
			$mapgpx = $gpx['cle_mapgpx'];
		}else{
			$mapgpx = '';
		}
		
		//On affiche la carte openstreetmap si elle existe
		if($mapgpx != '')
			$afficher_carte = '
			<div class="cadre">
				<div class="cadre_1_hg">
					<div class="cadre_1_hd">
						<h2>Trace GPX</h2>
					</div>
				</div>  
				<div class="cadre_1_cg">
					<div class="cadre_1_cd">
						<div id="demo" class="gpx" data-gpx-source="'.$config['domaine'].'mapgpx/GPX/'.$mapgpx.'.gpx" data-map-target="demo-map">
							<div class="map" id="demo-map"></div>
						</div>
						<a href="'.$config['domaine'].'traceGPX-'.title2url($donnees['nom_point']).'-'.title2url($donnees['nom_topo']).'-m'.$donnees['id_mapgpx'].'.html">Voir le d&eacute;tail de la trace</a>
					</div>
				</div>				
				<div class="cadre_1_bg">
					<div class="cadre_1_bd">
						<div class="cadre_1_b">
						&nbsp	
						</div>
					</div>
				</div>	
			</div>
			';
		else
			$afficher_carte = '';
		
		
		//On cherche les dernières sorties
		$sql = "SELECT * FROM sortie
					LEFT JOIN topos ON topos.id_topo = sortie.id_topo
					LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
					LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
					LEFT JOIN departs ON departs.id_depart = topos.id_depart
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
					LEFT JOIN membres ON membres.id_m = sortie.id_m
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
			WHERE sortie.id_topo = '".$midi."'
			ORDER BY id_point DESC LIMIT 0,10";
		
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$text_lien = '';
				
			if($row['id_activite'] == 1)
				$text_lien = '[skis de randonnée] - '.$row['nom_point'].', '.$row['nom_topo'].'';
			else
				$text_lien = ''.$row['nom_point'].', '.$row['nom_topo'].'';
		
			$data = parse_boucle('SORTIES',$data,FALSE,array(
			'SORTIES.id_sortie'=>$row['id_sortie'],
			'SORTIES.mid'=>$row['id_m'],
			'SORTIES.date'=> date("d/m/Y", strtotime($row['dates'])),
			'SORTIES.text_lien'=>$text_lien,
			'SORTIES.url_sommet'=>title2url($row['nom_point']),
			'SORTIES.url_topo'=>title2url($row['nom_topo']),
			'SORTIES.pseudo'=>$row['pseudo']
			));
		}
		
		$data = parse_boucle('SORTIES',$data,TRUE);
		
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
			if($auth['redacteur_topo'] == 1){
				$ajout_sortie = '<a href="'.$config['domaine'].'/ajouter-une-sortie-t'.$midi.'-'.$donnees['id_activite'].'.html">Ajouter une sortie</a>';
				if($nbr == 0){
					$ajout_trace = ' - <a href="'.$config['domaine'].'/ajouter-une-trace-au-topo-n'.$midi.'-a'.$donnees['id_activite'].'.html">Ajouter une trace GPX</a>';
				}else{
					$ajout_trace = '';
				}
			}else{
				$ajout_sortie = '';
				$ajout_trace = '';
			}
		
	//  	
		
		$data = parse_var($data,array('afficher_carte'=>$afficher_carte, 'cle_mapgpx'=>$mapgpx, 'ajout_sortie'=>$ajout_sortie,'ajout_trace'=>$ajout_trace, /*'repondre'=>$reponse,*/ 'design'=>$_SESSION['design'], 'idt'=>$midi,  'mapid'=>'zoom_canvas'));
	}else{
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