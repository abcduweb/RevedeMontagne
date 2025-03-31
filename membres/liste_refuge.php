<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
	
}
else{
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;
	
	$nb_message_page = $_SESSION['nombre_news'];
	$sql = ("SELECT * FROM point_gps
			LEFT JOIN c_refuge ON c_refuge.id_point = point_gps.id_point
			LEFT JOIN massif ON massif.id_massif = c_refuge.id_massif 
			LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
			WHERE point_gps.type_point = 1
			AND id_m = '$_SESSION[group]'");	
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
			$liste_page .= '<a href="mes-fiche-refuge-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	
	if($nb_enregistrement > 0){
		$data = get_file(TPL_ROOT.'mes_fiches_refuge.tpl');
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM point_gps
				LEFT JOIN c_refuge ON c_refuge.id_point = point_gps.id_point
				LEFT JOIN massif ON massif.id_massif = c_refuge.id_massif 
				LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
				WHERE point_gps.type_point = 1
				AND id_m = '$_SESSION[group]'";
		$result = $db->requete($sql);
		//$status = array(1 => 'publier', 2 => 'En cours de validation', 3 => 'En cours d\'édition');
		while ($row = $db->fetch($result))
		{
			$date = $row['date_point'];
			$data = parse_boucle('listerefuge',$data,FALSE,array(
				'id_point' => $row['id_news'],
				'nom_refuge' => $row['titre'],
				'nom_refuge_url'=>title2url($row['titre']),
				'date' => $row['date_point'],
				));
		}
		$data = parse_boucle('listerefuge',$data,TRUE);
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste de vos fiches refuges - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'mes_fiches_refuge_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste de vos news - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;
}
$db->deconnection();
?>