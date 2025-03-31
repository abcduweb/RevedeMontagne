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
//Calcul des pages//
$nb_message_page = $_SESSION['nombre_news'];
$retour = $db->requete("SELECT num_carte, nom_carte, editeur_carte, serie_carte,echelle FROM cartes");
$nb_enregistrement = $db->num($retour);
$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);
if($nombre_de_page < $page)	$page = $nombre_de_page;
$limite = ($page - 1) * $nb_message_page;
$liste_page = get_list_page($page,$nombre_de_page);
$pages = '';
foreach($liste_page as $page_n){
	if($page == $page_n)
		$pages .= $page_n.' ';
	else
		$pages .= '<a href="liste-des-cartes-ign-p'.$page_n.'.html">'.$page_n.'</a> ';
}
$liste_page = $pages;
//Fin//

if($nb_enregistrement > 0){
	$data = get_file(TPL_ROOT.'IGN/liste_carte.tpl');
	include(INC_ROOT.'header.php');
	$sql = "SELECT id_carte, num_carte, nom_carte, editeur_carte, serie_carte,echelle FROM cartes ORDER BY num_carte DESC LIMIT $limite,$nb_message_page";
	$result = $db->requete($sql);

	while ($row = $db->fetch($result))
	{
	$data = parse_boucle('IGN',$data,FALSE,array('IGN.pid'=>$row['id_carte'], 'IGN.numcarte'=>$row['num_carte'], 'IGN.nomcarte'=>$row['nom_carte'], 'IGN.url'=>title2url($row['nom_carte']), 'IGN.serie'=>$row['serie_carte'], 'IGN.echelle'=>$row['echelle']));
	}
	$data = parse_boucle('IGN',$data,TRUE);
	$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Cartes IGN - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
}
else{
	$data = get_file(TPL_ROOT.'IGN/liste_cartes_empty.tpl');
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Cartes IGN - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
}
echo $data;

$db->deconnection();
?>