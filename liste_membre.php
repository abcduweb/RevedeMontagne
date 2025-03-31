<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']) and $_SESSION['group'] != 1)
{
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'index.html';
	echo display_notice($message,'important',$redirection);
	
}
else
{
	$data = get_file(TPL_ROOT.'liste_membre.tpl');
	if(!empty($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;

	$sql = "SELECT membres.id_m, membres.pseudo, membres.dateInscr, membres.last_log,autorisation_globale.nom_group FROM membres 
	LEFT JOIN  autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE status_m = '1'";

	$order_groupe = 'ASC';
	$order_pseudo = 'ASC';
	$order_connexion = 'ASC';
	$order_inscription = 'ASC';
	$order_id = 'ASC';

	if(!empty($_GET['search'])){
		$search = htmlentities($_GET['search'],ENT_QUOTES);
		/*if(!empty($_GET['type']) AND $_GET['type'] == 2){
			$sql .= ' AND membres.pseudo LIKE('.$search.'%)';
		}*/
	}else if(!empty($_GET['type'])){
		switch($_GET['type']){
			case 'groupe':
				$sql .= ' ORDER BY autorisation_globale.nom_group';
				$current_type = 'groupe';
			break;
			case 'pseudo':
				$sql .= ' ORDER BY membres.pseudo';
				$current_type = 'pseudo';
			break;
			case 'connexion':
				$sql .= ' ORDER BY membres.last_log';
				$current_type = 'connexion';
			break;
			case 'inscription':
				$sql .= ' ORDER BY membres.dateInscr';
				$current_type = 'inscription';
			break;
			default:
				$sql .= ' ORDER BY membres.id_m';
				$current_type = 'id';
			break;
		}
		if(!empty($_GET['order']) AND $_GET['order'] == 'DESC'){
			$sql .= ' DESC';
			$current_order = 'DESC';
			switch($_GET['type']){
				case 'groupe':
					$order_groupe = 'ASC';
				break;
				case 'pseudo':
					$order_pseudo = 'ASC';
				break;
				case 'connexion':
					$order_connexion = 'ASC';
				break;
				case 'inscription':
					$order_inscription = 'ASC';
				break;
				default:
					$order_id = 'ASC';
				break;
			}
		}else{
			$sql .= ' ASC';
			$current_order = 'ASC';
			switch($_GET['type']){
				case 'groupe':
					$order_groupe = 'DESC';
				break;
				case 'pseudo':
					$order_pseudo = 'DESC';
				break;
				case 'connexion':
					$order_connexion = 'DESC';
				break;
				case 'inscription':
					$order_inscription = 'DESC';
				break;
				default:
					$order_id = 'DESC';
				break;
			}
		}
	}else{
		$sql .= ' ORDER BY membres.id_m ASC';
		$order_id = 'DESC';
		$current_order = 'ASC';
		$current_type = 'id';
	}

	$db->requete($sql);
	$nb_membres = $db->num();
	$nb_page = ceil($nb_membres / 50);
	if($page > $nb_page) $page = $nb_page;
	$limite = ($page - 1) * 50;

	$db->requete($sql. " LIMIT $limite,50");
	$ligne = 1;
	while($row = $db->fetch_assoc()){
		$data = parse_boucle('MEMBRE',$data,false,array('pseudo'=>$row['pseudo'],'mid'=>$row['id_m'],'groupe'=>$row['nom_group'],
		'date_inscription'=>get_date($row['dateInscr'],$_SESSION['style_date']),'date_log'=>get_date($row['last_log'],$_SESSION['style_date']), 'ligne'=>$ligne));
		if($ligne == 1)
			$ligne = 2;
		else
			$ligne = 1;
	}
	$data = parse_boucle('MEMBRE',$data,true);
	include(INC_ROOT.'header.php');
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
			case '<a href="liste-montagnards.html">&#8201;...&#8201;</a> ':
				$liste_page .= $var;
			break;
			default:
				$liste_page .= '<a href="liste-montagnards.html?type='.$current_type.'&amp;order='.$current_order.'{search}&amp;page='.$var.'">&#8201;'.$var.'&#8201;</a>';
		}
	}
	$data = parse_var($data,array('page'=>'&amp;page='.$page,'liste_page'=>$liste_page,'order_id'=>$order_id,'order_group'=>$order_groupe,'order_connexion'=>$order_connexion,'order_inscription'=>$order_inscription,'order_pseudo'=>$order_pseudo,'search'=>$search,'titre_page'=>'Les Montagnards et autres randonneurs de '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
	echo $data;
}
?>