<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/topos/');#
##########################################
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;

	$nb_message_page = $_SESSION['nombre_news'];
	$sql = ("SELECT nom_point, nom_topo, topos.id_topo, nom_point, nom_topo, nom_activite, nom_massif, denniveles, topos.id_m AS id_m 
				FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.statut > 0");	
	$db->requete($sql);
	//$nb_pages = $db->num();
	$nb_enregistrement = $db->num();
	$nb_page = ceil($nb_enregistrement / $nb_message_page);
	if($page > $nb_page) $page = $nb_page;
	$limite = ($page - 1) * $nb_message_page;
	
	$liste_page = '';
	foreach(get_list_page($page,$nb_page) as $var){
		switch($var){
			case $page:
				$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ';
			break;
			case '<a href="#">&#8201;...&#8201;</a> ':
				$liste_page .= $var;
			break;
			default:
			$liste_page .= '<a href="liste-des-topos-skis-rando-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	
	
	
	
	
	
	if($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_sommet = 'Pour ajouter un topo il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_sommet = '<a href="participer.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
		}
		
		
		$data = get_file(TPL_ROOT.'liste_topos_ski_rando');
		$data = parse_var($data,array('ajout_som'=>$ajout_sommet));
		include(INC_ROOT.'header.php');
		$sql = "SELECT membres.id_m, membres.pseudo, nom_point, nom_topo, topos.id_topo, nom_point, nom_topo, nom_activite, nom_massif, denniveles, topos.id_m AS id_m 
				FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				LEFT JOIN membres ON membres.id_m = topos.id_m
				WHERE topos.statut > 0
				ORDER BY id_topo DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		
		while ($row = $db->fetch($result))
		{
		
			if(!isset($_SESSION['ses_id']))
			{
				$hcol_action = '';
				$nb_colonne = 5;
				$colaction='';	
			}
			elseif($row['id_m'] == $_SESSION['mid'] AND $auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
			{
				$nb_colonne = 6;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"><a href="'.$config['domaine'].'edition-fiche-topo-ski-'.$row['id_topo'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
								<a href="'.$config['domaine'].'topos/envoi_topo_skis.php?idt='.$row['id_topo'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
			}
			else
			{
				$nb_colonne = 6;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"> - </td>';	
			}
			$data = parse_boucle('topo',$data,FALSE,array(
			'topo.url_nom_topo'=>'topo-'.title2url($row['nom_topo']),
			'topo.id_topo'=>$row['id_topo'],
			'topo.nom_sommet'=>$row['nom_point'],
			'topo.nom_topo'=>$row['nom_topo'],
			'topo.activite'=>$row['nom_activite'],
			'topo.mass'=>$row['nom_massif'],
			'topo.denniveles'=>$row['denniveles'],
			'topo.auteur'=>$row['pseudo'],
			'topo.id_m'=>$row['id_m'],
			'topo.col_action'=>$colaction
			));
		}
		$data = parse_boucle('topo',$data,TRUE);
		$data = parse_var($data,array('hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'liste_topos_rando_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos de skis de randonnées - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;

$db->deconnection();
?>