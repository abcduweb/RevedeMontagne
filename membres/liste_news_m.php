<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_GET['mid']) AND !empty($_GET['mid']))
{
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;
	$mid = intval($_GET['mid']);
	
	//Calcul des pages
	$nb_message_page = 10;
	$retour = $db->requete("SELECT id_news FROM nm_news WHERE id_auteur = '$mid' AND status_news = 1");
	$nb_enregistrement = $db->num($retour);
	$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);
	if($nombre_de_page < $page)	$page = $nombre_de_page;
	$limite = ($page - 1) * $nb_message_page;
	$liste_page = get_list_page('mes-news-p',$page,$nombre_de_page);
	//Fin//
	
	if($nb_enregistrement > 0){
		$data = get_file(TPL_ROOT.'liste_news_m.tpl');
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM nm_news WHERE id_auteur ='$_SESSION[mid]' AND status_news = 1 LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$date = date('d/m/Y', $row['date_news']);
			$data = parse_boucle('listenews',$data,FALSE,array('id' => $row['id_news'],'titrenews' => $row['titre'],'date' => $date));
		}
		$data = parse_boucle('listenews',$data,TRUE);
	}
	else{
		$data = get_file(TPL_ROOT.'liste_news_empty.tpl');
	}
	 $data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste de vos news - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>