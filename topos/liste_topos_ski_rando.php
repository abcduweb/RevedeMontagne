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
	$sql = ("SELECT membres.id_m, membres.pseudo, nom_point, nom_topo, topos.id_topo, nom_point, nom_topo, nom_activite, nom_massif, denniveles, topos.id_m AS id_m 
				FROM topos
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				LEFT JOIN membres ON membres.id_m = topos.id_m
				WHERE topos.statut > 0 
				AND visible = 1
				AND activites.id_activite = 1");	
	$db->requete($sql);
	//$nb_pages = $db->num();
	$nb_enregistrement = $db->num();

	if($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_sommet = 'Pour ajouter un topo il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_sommet = '<a href="participer.html?ida=2"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
		}
		
		
		$data = get_file(TPL_ROOT.'l_topo_skis.tpl');
		include(INC_ROOT.'header.php');
		
				
		
		$data = parse_var($data,array('ajout_som'=>$ajout_sommet));
		$sql = "SELECT visible, membres.id_m, membres.pseudo, nom_point, nom_topo, topos.id_topo, nom_point, nom_topo, nom_activite, nom_massif, denniveles, topos.id_m AS id_m 
				FROM topos
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				LEFT JOIN membres ON membres.id_m = topos.id_m
				WHERE topos.statut > 0
				AND activites.id_activite = 1
				AND visible = 1
				";
				
		//on met en variable les différents champs de classement
		$order_id = 'ASC';
		$order_nom = 'ASC';
		$order_activitee = 'ASC';
		$order_massif = 'ASC';
		$order_denniveles = 'ASC';
		$order_auteur = 'ASC';		
				
				
		
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
				case 'activitee':
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
				case 'auteur':
					$sql .= ' ORDER BY membres.pseudo';
					$current_type = 'auteur';
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
					case 'activitee':
						$order_activitee = 'ASC';
					break;
					case 'massif':
						$order_massif = 'ASC';
					break;
					case 'denniveles':
						$order_denniveles = 'ASC';
					break;
					case 'auteur':
						$order_auteur = 'ASC';
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
					case 'activitee':
						$order_activitee = 'DESC';
					break;
					case 'massif':
						$order_massif = 'DESC';
					break;
					case 'denniveles':
						$order_denniveles = 'DESC';
					break;
					case 'auteur':
						$order_auteur = 'DESC';
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

		$ligne = 1;
		while ($row = $db->fetch($result))
		{
		
			if(!isset($_SESSION['ses_id']))
			{
				$hcol_action = '';
				$nb_colonne = 6;
				$colaction='';	
			}
			elseif($row['id_m'] == $_SESSION['mid'] AND $auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
			{
				$nb_colonne = 7;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"><a href="'.$config['domaine'].'edition-fiche-topo-rando-'.$row['id_topo'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
								<a href="'.$config['domaine'].'topos/envoi_topo_rando.php?idt='.$row['id_topo'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
			}
			else
			{
				$nb_colonne = 7;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"> - </td>';	
			}
			$data = parse_boucle('topo',$data,FALSE,array(
			'topo.url_nom_topo'=>'topo-'.title2url($row['nom_point']).'-'.title2url($row['nom_topo']),
			'topo.id_topo'=>$row['id_topo'],
			'topo.nom_sommet'=>$row['nom_point'],
			'topo.nom_topo'=>$row['nom_topo'],
			'topo.activite'=>$row['nom_activite'],
			'topo.mass'=>$row['nom_massif'],
			'topo.denniveles'=>$row['denniveles'],
			'topo.auteur'=>$row['pseudo'],
			'topo.id_m'=>$row['id_m'],
			'topo.col_action'=>$colaction,
			'topo.ligne'=>$ligne
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
				case '<a href="liste-des-topos-skis-rando.html">&#8201;...&#8201;</a> ':
					$liste_page .= $var;
				break;
				default:
					$liste_page .= '<a href="liste-des-topos-skis-rando.html?type='.$current_type.'&amp;order='.$current_order.'{search}&amp;page='.$var.'">&#8201;'.$var.'&#8201;</a>';
			}
		}


		
		$data = parse_var($data,array('page'=>'&amp;page='.$page, 'search'=>$search, 'order_id'=>$order_id, 'order_nomtopo'=>$order_nom, 'order_activitee'=>$order_activitee,	'order_massif'=>$order_massif, 'order_denniveles'=>$order_denniveles, 'order_auteur'=>$order_auteur));
		
		$data = parse_var($data,array('hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'l_topo_skis_vide.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'Liste des topos de randonnées pédestre - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	//echo print_r($_SESSION);
	echo $data;

$db->deconnection();
?>