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
			 LEFT JOIN massif ON massif.id_massif = departs.id_massif");	
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
			$liste_page .= '<a href="liste-des-departs-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
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
		
		$data = get_file(TPL_ROOT.'depart/liste_depart.tpl');
		$data = parse_var($data,array('ajout_depart'=>$ajout_depart));
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM departs
				LEFT JOIN massif ON massif.id_massif = departs.id_massif
				ORDER BY id_depart DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
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
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des d&eacute;parts - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'depart/liste_depart_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des d&eacute;parts - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;

$db->deconnection();
?>