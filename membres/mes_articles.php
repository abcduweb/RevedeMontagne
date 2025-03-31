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
	$redirection = 'index.php';
	echo display_notice($message,'important',$redirection);
}
else{
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
	$page = 1;
	
	//Calcul des pages//
		$nb_message_page = $_SESSION['nombre_news'];
	$sql = ("SELECT * FROM articles_intro_conclu WHERE id_membre = '$_SESSION[mid]'");	
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
			case '<a href="dernieres-videos-p....html">&#8201;...&#8201;</a> ':
				$liste_page .= $var;
			break;
			default:
			$liste_page .= '<a href="mes-articles-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}

	if($nb_enregistrement > 0){
		$data = get_file(TPL_ROOT.'mes_articles.tpl');
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM articles_intro_conclu WHERE id_membre ='$_SESSION[mid]' ORDER BY article_status LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		$status = array(1 => 'publi&eacute;', 2 => 'En cours de validation', 3 => 'En cours d\'&eacute;dition');
		$ligne = 1;
		while ($row = $db->fetch($result))
		{
			$reponse = $status[$row['article_status']];
			$data = parse_boucle('ARTICLES',$data,FALSE,array('ligne' => $ligne, 'id' => $row['id_article'],'titre_article' => $row['titre'],'statut' => $reponse,'titre_url'=>title2url($row['titre'])));
			if ($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('ARTICLES',$data,TRUE);
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste de vos articles - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'mes_articles_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste de vos articles - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;
}
$db->deconnection();
?>