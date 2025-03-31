<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!empty($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;

$sql = "SELECT * FROM map_gpx
						  LEFT JOIN membres ON membres.id_m = map_gpx.id_m
						  LEFT JOIN activites ON activites.id_activite = map_gpx.id_activite
						  LEFT JOIN topos ON topos.id_topo = map_gpx.id_topo
						  LEFT JOIN massif ON massif.id_massif = topos.id_massif
						  WHERE statut_mapgpx = '0'";

	$order_id = 'ASC';
	$order_date = 'ASC';
	$order_nom = 'ASC';
	$order_dpt = 'ASC';
	$order_activite = 'ASC';
	$order_longueur = 'ASC';
	$order_duree = 'ASC';
	$order_alt_max = 'ASC';
	$order_alt_mini = 'ASC';
	$order_dennivele = 'ASC';
	$order_pseudo = 'ASC';

	
if(!empty($_GET['search'])){
	$search = htmlentities($_GET['search'],ENT_QUOTES);
	/*if(!empty($_GET['type']) AND $_GET['type'] == 2){
		$sql .= ' AND membres.pseudo LIKE('.$search.'%)';
	}*/
}else if(!empty($_GET['type'])){
	switch($_GET['type']){
					case 'id':
				$sql .= ' ORDER BY id_mapgpx';
				$current_type = 'id';
			break;
			case 'date':
				$sql .= ' ORDER BY date_mapgpx';
				$current_type = 'date';
			break;
			case 'nom':
				$sql .= ' ORDER BY nom_mapgpx';
				$current_type = 'nom';
			break;
			case 'dpt':
				$sql .= ' ORDER BY nom_massif';
				$current_type = 'dpt';
			break;
			case 'activite':
				$sql .= ' ORDER BY nom_activite';
				$current_type = 'activite';
			break;
			case 'longueur':
				$sql .= ' ORDER BY longueur';
				$current_type = 'longueur';
			break;
			case 'duree':
				$sql .= ' ORDER BY duree_totale';
				$current_type = 'duree';
			break;
			case 'alt_max':
				$sql .= ' ORDER BY altitude_maxi';
				$current_type = 'alt_max';
			break;
			case 'alt_mini':
				$sql .= ' ORDER BY altitude_mini';
				$current_type = 'alt_mini';
			break;
			case 'dennivele':
				$sql .= ' ORDER BY den_positif_cumu';
				$current_type = 'dennivele';
			break;
			case 'pseudo':
				$sql .= ' ORDER BY pseudo';
				$current_type = 'pseudo';
			break;
	}
	if(!empty($_GET['order']) AND $_GET['order'] == 'DESC'){
		$sql .= ' DESC';
		$current_order = 'DESC';
		switch($_GET['type']){
			case 'id':
				$order_id = 'ASC';
			case 'date':
				$order_date = 'ASC';
			break;
			case 'nom':
				$order_nom = 'ASC';
			break;
			case 'dpt':
				$order_dpt = 'ASC';
			break;
			case 'activite':
				$order_activite = 'ASC';
			break;
			case 'longueur':
				$order_longueur = 'ASC';
			break;
			case 'duree':
				$order_duree = 'ASC';
			break;
			case 'alt_max':
				$order_alt_max = 'ASC';
			break;
			case 'alt_mini':
				$order_alt_mini = 'ASC';
			break;
			case 'dennivele':
				$order_dennivele = 'ASC';
			break;
			case 'pseudo':
				$order_pseudo = 'ASC';
			break;
		}
	}else{
		$sql .= ' ASC';
		$current_order = 'ASC';
		switch($_GET['type']){
			case 'id':
					$order_id = 'DESC';
				case 'date':
					$order_date = 'DESC';
				break;
				case 'nom':
					$order_nom = 'DESC';
				break;
				case 'dpt':
					$order_dpt = 'DESC';
				break;
				case 'activite':
					$order_activite = 'DESC';
				break;
				case 'longueur':
					$order_longueur = 'DESC';
				break;
				case 'duree':
					$order_duree = 'DESC';
				break;
				case 'alt_max':
					$order_alt_max = 'DESC';
				break;
				case 'alt_mini':
					$order_alt_mini = 'DESC';
				break;
				case 'dennivele':
					$order_dennivele = 'DESC';
				break;
				case 'pseudo':
					$order_pseudo = 'DESC';
				break;
		}
	}
}else{
	$sql .= ' ORDER BY id_mapgpx ASC';
	$order_id = 'DESC';
	$current_order = 'ASC';
	$current_type = 'id';
}

$db->requete($sql);
$nb_pages = $db->num();
$nb_page = ceil($nb_pages / 30);
if($page > $nb_page) $page = $nb_page;
$limite = ($page - 1) * 30;
if($nb_pages > 0){
	$db->requete($sql. " LIMIT $limite,30");
	$data = get_file(TPL_ROOT.'mapgpx/liste_trace.tpl');


			if(!isset($_SESSION['ses_id']))
			{
				$ajout = '';
			}
			else
			{
				$ajout = '';
			}
		
			
			
	while($row = $db->fetch_assoc())
		{
				if ($row['id_m'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
					$modif = '<a href="'.DOMAINE.'actions/actions_mapgpx.php?action=2&nid='.$row['id_mapgpx'].'"><img src="'.DOMAINE.'/templates/images/1/cross.png" alt="Supprimer" /></a>';
				else
					$modif = ' - ';
					

				$data = parse_boucle('TRACE',$data,FALSE,array(
				'TRACE.id' => $row['id_mapgpx'],
				'TRACE.date' => strftime( "%d/%m/%Y" , strtotime($row['date_mapgpx'] )),
				'TRACE.url_nom'=>title2url($row['nom_mapgpx']),
				'TRACE.cle'=>$row['cle_mapgpx'],
				'TRACE.Nom_trace'=>$row['nom_mapgpx'],
				'TRACE.departement'=>$row['nom_massif'],
				'TRACE.activite'=>$row['nom_activite'],
				'TRACE.longueur'=>round($row['longueur'], 2),
				'TRACE.duree'=>$row['duree_totale'],
				'TRACE.altmax'=>round($row['altitude_maxi'], 2),
				'TRACE.altmin'=>round($row['altitude_mini'], 2),
				'TRACE.deni'=>$row['den_positif_cumu'],
				'TRACE.mid'=>$row['id_m'],
				'TRACE.pseudo'=>$row['pseudo'],
				'TRACE.actions'=>$modif,
				));
		}
	$data = parse_boucle('TRACE',$data,TRUE);
	$data = parse_var($data,array('ajout'=>$ajout));
	include(INC_ROOT.'header.php');
	if(!empty($search))
		$search = '&amp;search='.$search;
	else
		$search = '';
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
			$liste_page .= '<a href="liste-des-traces-gpx.html?type='.$current_type.'&amp;order='.$current_order.'{search}&amp;page='.$var.'">&#8201;'.$var.'&#8201;</a> ';
		}
	}
			$data = parse_var($data,array(
			'page'=>'&amp;page='.$page,
			'liste_page'=>$liste_page,
			'order_id'=>$order_id,
			'order_date'=>$order_date,
			'order_nom'=>$order_nom,
			'order_dpt'=>$order_dpt,
			'order_activite'=>$order_activite,
			'order_longueur'=>$order_longueur,
			'order_duree'=>$order_duree,
			'order_alt_max'=>$order_alt_max,
			'order_alt_mini'=>$order_alt_mini,
			'order_dennivele'=>$order_dennivele,
			'order_pseudo'=>$order_pseudo,
			'search'=>$search
			));
	$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des traces - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));

}
else
{
	$data = get_file(TPL_ROOT.'mapgpx/liste_trace_empty.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
}
	

		echo $data;
?>