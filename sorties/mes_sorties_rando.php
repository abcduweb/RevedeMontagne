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
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;

	$nb_message_page = $_SESSION['nombre_news'];
	$sql = ("SELECT * FROM sortie
			 LEFT JOIN topos ON topos.id_topo = sortie.id_topo
			 LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
			 LEFT JOIN activites ON activites.id_activite = topos.id_activite
			 LEFT JOIN departs ON departs.id_depart = topos.id_depart
			 LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
			 LEFT JOIN membres ON membres.id_m = sortie.id_m
			 WHERE sortie.id_m = '".$_SESSION['mid']."'
			 AND activites.id_activite = 2");	
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
			$liste_page .= '<a href="mes-sorties-de-randonnees-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	
	
	
	
	
	
	if($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_depart = 'Pour ajouter un départ il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_depart = '<a href="participer.html">ajouter un départ</a>';
		}
		
		$ajout_depart = '';
		
		$data = get_file(TPL_ROOT.'sorties/mes_sorties_rando.tpl');
		$data = parse_var($data,array('ajout_depart'=>$ajout_depart));
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM sortie
				LEFT JOIN topos ON topos.id_topo = sortie.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
				LEFT JOIN membres ON membres.id_m = sortie.id_m
				WHERE sortie.id_m = '".$_SESSION['mid']."'
				AND activites.id_activite = 2
				ORDER BY dates DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		
		$ligne = 1;
		while ($row = $db->fetch($result))
		{
			if ($row['id_m'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
				$modif = '<a href="edition-sortie-'.$row['id_sortie'].'.html"><img src="'.$config['domaine'].'templates/images/1/form/edit.png" alt="modifier"></a>';
			else
				$modif = '';
			//$modif='';
				

			$data = parse_boucle('sorties',$data,FALSE,array(
				'sorties.id_sortie'=>$row['id_sortie'],
				'sorties.modif'=>$modif,
				'sorties.id_topo'=>$row['id_topo'],
				'sorties.date'=>date("d-m-Y", strtotime($row['dates'])),
				'sorties.url_nom_sortie'=>title2url($row['nom_point']).'-'.title2url($row['nom_topo']),
				'sorties.nom_sorties'=>$row['nom_topo'],
				'sorties.sommet'=>$row['nom_point'],
				'sorties.acces'=>$row['lieu_depart'],
				'sorties.url_acces'=>title2url($row['lieu_depart']),
				'sorties.id_depart'=>$row['id_depart'],
				'sorties.massif'=>$row['nom_massif'],
				'sorties.deniveles'=>$row['denniveles'],
				'sorties.mid'=>$row['id_m'],
				'sorties.ligne'=>$ligne
			));
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('sorties',$data,TRUE);
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des sorties - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'sorties/mes_sorties_rando_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des sorties - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;
}
$db->deconnection();
?>