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
	$sql = ("SELECT * FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN massif ON massif.id_massif = topos.id_massif 
				LEFT JOIN sommets ON sommets.id_som = topos.id_sommet
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.id_activite = '2' AND topos.id_m = '".$_SESSION['mid']."' and topos.visible < 3");	
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
			$liste_page .= '<a href="mes-topos-randonnees-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	
	
	
	
	
	
	if($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_sommet = 'Pour ajouter un topo il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_sommet = '<a href="participer.html"><img src="{DOMAINE}/templates/images/{design}/forum/ajout.png" alt="Ajouter un sujet" /></a>';
		}
		
		
		$data = get_file(TPL_ROOT.'topos/mes_topos_rando.tpl');
		$data = parse_var($data,array('ajout_som'=>$ajout_sommet));
		include(INC_ROOT.'header.php');
		$sql = "SELECT visible, topos.id_m, topos.id_topo, nom_topo, topos.id_activite, nom_point, nom_topo, nom_activite,  nom_massif, denniveles   FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.id_activite = '2' AND topos.id_m = '".$_SESSION['mid']."'
				AND topos.visible < 3";
				
		//on met en variable les différents champs de classement
		$order_id = 'ASC';
		$order_nom = 'ASC';
		$order_activite = 'ASC';
		$order_massif = 'ASC';
		$order_denniveles = 'ASC';	
		
		if(!empty($_GET['search'])){
			$search = htmlentities($_GET['search'],ENT_QUOTES);
			/*if(!empty($_GET['type']) AND $_GET['type'] == 2){
				$sql .= ' AND membres.pseudo LIKE('.$search.'%)';
			}*/
		}else if(!empty($_GET['type'])){
			switch($_GET['type']){
				case 'nomnomtopo':
					$sql .= ' ORDER BY topos.nom_topo';
					$current_type = 'nom';
				break;
				case 'activite':
					$sql .= ' ORDER BY activites.nom_activite';
					$current_type = 'activitee';
				break;
				case 'massif':
					$sql .= ' ORDER BY massif.nom_massif';
					$current_type = 'massif';
				break;
				case 'denniveles':
					$sql .= ' ORDER BY topos.denniveles';
					$current_type = 'denniveles';
				break;
				default:
					$sql .= ' ORDER BY topos.id_topo';
					$current_type = 'id';
				break;
			}
			if(!empty($_GET['order']) AND $_GET['order'] == 'DESC'){
				$sql .= ' DESC';
				$current_order = 'DESC';
				switch($_GET['type']){
					case 'nomtopo':
						$order_nom = 'ASC';
					break;
					case 'activite':
						$order_activitee = 'ASC';
					break;
					case 'massif':
						$order_massif = 'ASC';
					break;
					case 'denniveles':
						$order_denniveles = 'ASC';
					break;
					default:
						$order_id = 'ASC';
					break;

				}
			}else{
				$sql .= ' ASC';
				$current_order = 'ASC';
				switch($_GET['type']){
					case 'nomtopo':
						$order_nom = 'DESC';
					break;
					case 'activite':
						$order_activitee = 'DESC';
					break;
					case 'massif':
						$order_massif = 'DESC';
					break;
					case 'denniveles':
						$order_denniveles = 'DESC';
					break;
					default:
						$order_id = 'DESC';
					break;
					

				}
			}
		}else{
			$sql .= ' ORDER BY topos.id_topo ASC';
			$order_id = 'DESC';
			$current_order = 'ASC';
			$current_type = 'id';
		}
				
		//$result = $db->requete($sql);
		$nb_page = ceil($nb_enregistrement / $nb_message_page);
		if($page > $nb_page) $page = $nb_page;
		$limite = ($page - 1) * $nb_message_page;

		$result = $db->requete($sql. " LIMIT $limite,$nb_message_page");
		
		
		//ORDER BY nom_topo DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		
		$ligne = 1;
		while ($row = $db->fetch($result))
		{
			
			if ($row['id_m'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
			{
				$modif = '<a href="edition-fiche-topo-rando-'.$row['id_topo'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>';
				$supprimer = '<a href="'.$config['domaine'].'topos/envoi_topo_rando.php?idt='.$row['id_topo'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a>';
			}
			else
			{
				$modif = '';
				$supprimer = '';
			}
			
			if ($row['visible'] == 1)
				$valider = '<img src="'.$config['domaine'].'templates/images/1/tick.png" alt="topo mis en ligne" />';
			else
				$valider = '<a href="'.$config['domaine'].'topos/envoi_topo_rando.php?idt='.$row['id_topo'].'&val=1"><img src="'.$config['domaine'].'/templates/images/1/form/faire_valider.png" alt="Demander une validation"></a>';
				

			$data = parse_boucle('topo',$data,FALSE,array(
			'topo.url_nom_topo'=>'topo-'.title2url($row['nom_topo']),
			'topo.idact'=>$row['id_activite'],
			'topo.id_topo'=>$row['id_topo'],
			'topo.nom_sommet'=>$row['nom_point'],
			'topo.nom_topo'=>$row['nom_topo'],
			'topo.activite'=>$row['nom_activite'],
			'topo.mass'=>$row['nom_massif'],
			'topo.denniveles'=>$row['denniveles'],
			'topo.modif'=>$modif,
			'topo.ligne'=>$ligne,
			'topo.editer'=>$modif,
			'topo.valider'=>$valider,
			'topo.supprimer'=>$supprimer
			));
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('topo',$data,TRUE);
		
		
		if(!empty($search))
			$search = '&amp;search='.$search;
		else
			$search = '';
		$liste_page = '';
		foreach(get_list_page($page,$nb_page) as $var){
			switch($var){
				case $page:
					$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ' ;
				break;
				case '<a href="mes-topos-randonnees.html">&#8201;...&#8201;</a> ':
					$liste_page .= $var;
				break;
				default:
					$liste_page .= '<a href="mes-topos-randonnees.html?type='.$current_type.'&amp;order='.$current_order.$search.'&amp;page='.$var.'">&#8201;'.$var.'&#8201;</a>';
			}
		}
	
		$data = parse_var($data,array('page'=>'&amp;page='.$page, 'search'=>$search, 'order_id'=>$order_id, 'order_nom'=>$order_nom, 'order_activite'=>$order_activite,	'order_massif'=>$order_massif, 'order_denniveles'=>$order_denniveles));
		
		
		
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'topos/mes_topos_rando_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;
}
$db->deconnection();

?>