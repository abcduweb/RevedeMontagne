<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', './');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT.'liste_actus.tpl');
	
if(isset($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;

	
	$nb_message_page = $_SESSION['nombre_news'];
	
	$sql = ("SELECT * FROM nm_news WHERE status_news = 1");	
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
			$liste_page .= '<a href="liste-des-actualites-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	

$result = $db->requete("SELECT * FROM nm_news WHERE status_news = 1 ORDER BY date_news DESC LIMIT $limite,$nb_message_page");
$ligne = 1;
while($row = $db->fetch($result)){
	$data = parse_boucle('NEWS',$data,FALSE,array('NEWS.date'=>get_date($row['date_news'],$_SESSION['style_date']), 
												  'NEWS.url_news'=>title2url($row['titre']),
												  'NEWS.id_news'=>$row['id_news'],
												  'NEWS.nom_news'=>$row['titre'],
												  'NEWS.pseudo'=>'<a href="membres-'.$row['id_auteur'].'-fiche.html">'.$row['pseudo_auteur'].'</a>',
												  'NEWS.nbcomm'=>$row['nb_com'],
												  'NEWS.ligne'=>$ligne));
	if($ligne == 1)
		$ligne = 2;
	else
		$ligne = 1;
}
$data = parse_boucle('NEWS',$data,TRUE);
include(INC_ROOT.'header.php');
$data = parse_var($data,array('design'=>1,'nb_requetes'=>$db->requetes,'liste_page'=>$liste_page,'titre_page'=>'Toutes les actualit&eacute;s - '.SITE_TITLE,'ROOT'=>''));

$db->deconnection();
echo $data;
?>