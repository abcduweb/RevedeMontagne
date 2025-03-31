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
	$nb_skisrando = 0;
	$nb_rando = 0;
	
	$data = get_file(TPL_ROOT."IGN/fiche_carte.tpl");
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);

	$reponse =  $db->requete("SELECT * FROM cartes WHERE id_carte = '".$midi."'");
	$donnees = $db->fetch($reponse);		
	$charac_a_enlever = array(":", "/");
	$charac_a_mettre = array("%253A", "%252F");
	$IGN = str_replace($charac_a_enlever, $charac_a_enlever, $donnees['adresse_achat']);
	//echo '<a href="'.$donnees['adresse_achat'].'">Test lien</a>';

	$data = parse_var($data,array('num_carte'=>$donnees['num_carte'], 'nom_carte'=>$donnees['nom_carte'], 'image_IGN'=>$donnees['image_carte'], 'serie_carte'=>$donnees['serie_carte'], 'editeur_carte'=>$donnees['editeur_carte'], 'echelle_carte'=>$donnees['echelle'], 'url_acheter'=>$IGN));
	
	if(!is_cache(ROOT.'caches/.htcache_carte_'.$midi.'')){//on test le cache si il est a recharg&eacute; ou non
		//Topos skis de randonn&eacute;e
		$result = $db->requete("SELECT * FROM topos
			LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
			LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
			LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
			LEFT JOIN departs ON departs.id_depart = topos.id_depart
			LEFT JOIN activites ON activites.id_activite = topos.id_activite
			WHERE topos.statut > '0' 
			AND topos.id_activite = '1'
			AND point_gps.idcarte LIKE '%\"".$midi."\"%' 
			ORDER BY topos.id_topo DESC LIMIT 0,6");
			$i = 1;
			$nb_skisrando = $db->num($result);
			while($row = $db->fetch($result))
			{
				$cache['toposki'.$i] = array('toposki'.$i => $row['nom_point'].', '.$row['nom_topo'], 'idts'.$i => $row['id_topo'],'urlts'.$i=>title2url($row['nom_topo']));
				$i++;
			}
			
		//Topos randonn&eacute;e
		$result = $db->requete("SELECT * FROM topos
			LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
			LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
			LEFT JOIN departs ON departs.id_depart = topos.id_depart
			LEFT JOIN activites ON activites.id_activite = topos.id_activite
			WHERE topos.statut > '0' 
			AND topos.id_activite = '2' 
			AND point_gps.idcarte LIKE '%\"".$midi."\"%' 
			ORDER BY topos.id_topo DESC LIMIT 0,6");
			$i = 1;		
			$nb_rando = $db->num($result);
			while($row = $db->fetch($result))
			{
				$cache['toporando'.$i] = array('toporando'.$i => $row['nom_point'].', '.$row['nom_topo'],'idtr'.$i => $row['id_topo'],'urltr'.$i=>title2url($row['nom_topo']));
				$i++;
			}
	write_cache(ROOT.'caches/.htcache_carte_'.$midi.'',array('cache'=>$cache));
	}else{
		require_once(ROOT.'caches/.htcache_carte_'.$midi.'');
	}
		foreach($cache as $var){
			$data = parse_var($data,$var);
		}
	$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'Cartes IGN - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	
}else
{
	$message = 'La carte n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
