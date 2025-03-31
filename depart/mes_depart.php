<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
	
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;

	$nb_message_page = $_SESSION['nombre_news'];
	$sql = ("SELECT * FROM departs
			 LEFT JOIN massif ON massif.id_massif = departs.id_massif
			 WHERE id_m = '".$_SESSION['mid']."'");	
	$db->requete($sql);
	//$nb_pages = $db->num();
	$nb_enregistrement = $db->num();
	
	
	/*
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
			$liste_page .= '<a href="liste-des-departs-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}*/
	
	
	
	
	
	
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
		
		$data = get_file(TPL_ROOT.'depart/mes_depart.tpl');
		$data = parse_var($data,array('ajout_depart'=>$ajout_depart));
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM departs
				LEFT JOIN massif ON massif.id_massif = departs.id_massif
				WHERE id_m = '".$_SESSION['mid']."'";
				
				
		$order_nom = 'ASC';
		$order_descriptif = 'ASC';
		$order_massif = 'ASC';
		$order_altitude = 'ASC';
		$order_id = 'ASC';

		if(!empty($_GET['search'])){
			$search = htmlentities($_GET['search'],ENT_QUOTES);
			/*if(!empty($_GET['type']) AND $_GET['type'] == 2){
				$sql .= ' AND membres.pseudo LIKE('.$search.'%)';
			}*/
		}else if(!empty($_GET['type'])){
			switch($_GET['type']){
				case 'nom':
					$sql .= ' ORDER BY lieu_depart';
					$current_type = 'nom';
				break;
				case 'descriptif':
					$sql .= ' ORDER BY acces';
					$current_type = 'descriptif';
				break;
				case 'massif':
					$sql .= ' ORDER BY nom_massif';
					$current_type = 'massif';
				break;
				case 'altitude':
					$sql .= ' ORDER BY alt_depart';
					$current_type = 'altitude';
				break;
				default:
					$sql .= ' ORDER BY id_depart';
					$current_type = 'id';
				break;
			}
			if(!empty($_GET['order']) AND $_GET['order'] == 'DESC'){
				$sql .= ' DESC';
				$current_order = 'DESC';
				switch($_GET['type']){
					case 'nom':
						$order_nom = 'ASC';
					break;
					case 'descriptif':
						$order_descriptif = 'ASC';
					break;
					case 'massif':
						$order_massif = 'ASC';
					break;
					case 'altitude':
						$order_altitude = 'ASC';
					break;
					default:
						$order_id = 'ASC';
					break;
				}
			}else{
				$sql .= ' ASC';
				$current_order = 'ASC';
				switch($_GET['type']){
					case 'nom':
						$order_nom = 'DESC';
					break;
					case 'descriptif':
						$order_descriptif = 'DESC';
					break;
					case 'massif':
						$order_massif = 'DESC';
					break;
					case 'altitude':
						$order_altitude = 'DESC';
					break;
					default:
						$order_id = 'DESC';
					break;
				}
			}
		}else{
			$sql .= ' ORDER BY id_depart';
			$order_id = 'DESC';
			$current_order = 'ASC';
			$current_type = 'id';
		}

		$nb_page = ceil($nb_enregistrement / $nb_message_page);
		if($page > $nb_page) $page = $nb_page;
		$limite = ($page - 1) * $nb_message_page;

		$result = $db->requete($sql. " LIMIT $limite,$nb_message_page");


		$ligne = 1;
		while ($row = $db->fetch($result))
		{
			if ($row['id_m'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
				$modif = '<a href="edition-depart-'.$row['id_depart'].'.html"><img src="'.$config['domaine'].'templates/images/1/form/edit.png" alt="modifier"></a>';
			else
				$modif = '';
				

			$data = parse_boucle('depart',$data,FALSE,array(
			'depart.url_nom_depart'=>'depart-'.title2url($row['lieu_depart']),
			'depart.nom_depart'=>$row['lieu_depart'],
			'depart.id_depart'=>$row['id_depart'],
			'depart.acces'=>$row['acces_parser'],
			'depart.altitude'=>$row['alt_depart'],
			'depart.massif'=>$row['nom_massif'],
			'depart.modif'=>$modif,
			'depart.ligne'=>$ligne		
			));
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('depart',$data,TRUE);
		
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
				case '<a href="mes-departs.html">&#8201;...&#8201;</a> ':
					$liste_page .= $var;
				break;
				default:
					$liste_page .= '<a href="mes-departs.html?type='.$current_type.'&amp;order='.$current_order.$search.'&amp;page='.$var.'">&#8201;'.$var.'&#8201;</a>';
			}
		}
	
		$data = parse_var($data,array('page'=>'&amp;page='.$page, 'search'=>$search, 'order_id'=>$order_id, 'order_nom'=>$order_nom, 'order_descriptif'=>$order_descriptif,	'order_massif'=>$order_massif, 'order_altitude'=>$order_altitude));		
		
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des d&eacute;parts - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'depart/mes_depart_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des d&eacute;parts - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;

$db->deconnection();
?>