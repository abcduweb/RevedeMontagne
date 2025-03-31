<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!empty($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;
if(!empty($_GET['cat']))
	$id_cat = intval($_GET['cat']);
else
	$id_cat = 1;
$sql = "SELECT BG,label,BD FROM articles WHERE BG = $id_cat";
$result = $db->requete($sql);
if($db->num() > 0){
	$mainCat = $db->fetch_assoc($result);
	$data = get_file(TPL_ROOT.'liste_article.tpl');
	include(INC_ROOT.'header.php');

	//Calcul des pages
	$nb_message_page = $_SESSION['nombre_message'];
	$retour = $db->requete("SELECT COUNT(*) FROM articles_intro_conclu WHERE id_cat = '$mainCat[BD]' AND article_status = 1");
	$nb_enregistrement = $db->row();
	$nombre_de_page = ceil($nb_enregistrement[0] / $nb_message_page);
	if($nombre_de_page < $page)	$page = $nombre_de_page;
	$limite = ($page - 1) * $nb_message_page;
	$liste_page = get_list_page($page,$nombre_de_page);
	$pages = '';
	foreach($liste_page as $page_l){
		if($page == $page_l)
			$pages .= '<span class="current">&#8201;'.$page_l.'&#8201;</span> ';
		else
			$pages .= '<a href="categories-des-articles-'.$mainCat['BG'].'-p'.$page_l.'">&#8201;'.$page_l.'&#8201; </a> ';
	}
	$liste_page = $pages;
	//Fin
	
	//r&eacute;cup&eacute;ration de l'arbre
	if($id_cat != 1){
		$sql = "SELECT T1.BG,T1.label,T1.BD, T2.BG AS T2BG, T2.BD as T2BD, T2.label AS T2label FROM articles T1 LEFT JOIN articles T2 ON (T2.BD = '$mainCat[BD]') WHERE T1.BG <= T2.BG AND T1.BD >= T2.BD AND T1.level < T2.level ORDER BY T1.level ASC";
		$result = $db->requete($sql);
		while($niveaux = $db->fetch_assoc($result)){
			$final['url'] = '<a href="categories-des-articles-'.$niveaux['T2BG'].'.html">'.$niveaux['T2label'].'</a>';
			$final['BD'] = $niveaux['T2BD'];
			$final['BG'] = $niveaux['T2BG'];
			$data = parse_boucle('NIVEAUX',$data,false,array('adresse'=>'<a href="categories-des-articles-'.$niveaux['BG'].'.html">'.$niveaux['label'].'</a>'));
		}
	}
	else{
		$final['url'] = '<a href="categories-des-articles-1.html">'.$mainCat['label'].'</a>';
		$final['BD'] = $mainCat['BD'];
		$final['BG'] = $mainCat['BG'];
	}
	$data = parse_boucle('NIVEAUX',$data,TRUE);
	
	if($nombre_de_page > 0){
		$ligne=1;
		$sql = "SELECT titre,id_article,pseudo,id_m,date_article FROM articles_intro_conclu LEFT JOIN membres ON articles_intro_conclu.id_membre = membres.id_m WHERE id_cat = '$mainCat[BD]' AND article_status = 1 LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		while($row = $db->fetch_assoc()){
			$data = parse_boucle('ARTICLES',$data,FALSE,array('titre'=>$row['titre'],'ligne'=>$ligne, 'titre_url'=>title2url($row['titre']),'id_article'=>$row['id_article'],'auteur'=>$row['pseudo'],'id_auteur'=>$row['id_m'],'date'=>get_date($row['date_article'],$_SESSION['style_date'])));
		
		if($ligne == 1)
			$ligne = 2;
		else
			$ligne = 1;
		}
		$table='<table class="listemess">
				<thead>
					<tr class="intitules_tabl">
						<th>Nom de l\'article</th>
						<th>Auteur</th>
						<th>Date</th>
					</tr>
				</thead>
				<tfoot>
						<tr>
							<th colspan="3">
								<div class="wp-pagenavi">
									Page(s) : {liste_pages}
								</div>
							</th>
						</tr>
					</tfoot>
				</thead>
				<tbody>';
		$data = parse_var($data,array('articles_enter'=>$table,'articles_out'=>'</tbody></table>','liste_pages'=>$liste_page));
	}
	else{
		$data = parse_var($data,array('articles_enter'=>'','articles_out'=>'','liste_pages'=>''));
	}
	$data = parse_boucle('ARTICLES',$data,TRUE);
	
	//On regarde si on est dans une branche ou une feuille. Si on est dans une branche on r&eacute;cup&eacute;rer les sous cat&eacute;gorie sinon rien.
	if($final['BD'] - $final['BG'] > 2){
		$sql = "SELECT T1.label, T1.BG, T1.properties AS nb_article FROM articles T1 LEFT JOIN articles T2 ON (T2.BD = '$mainCat[BD]') WHERE (T1.BG > T2.BG AND T1.BD < T2.BD )AND T1.level = T2.level + 1";
		$result = $db->requete($sql);
		while($row = $db->fetch_assoc($result)){
			$data = parse_boucle('CATEGORIES',$data,FALSE,array('id_cat'=>$row['BG'],'titre_cat'=>$row['label'],'nombre_article'=>$row['nb_article']));
		}
		$categorie_enter='<table id="categorie_enter" class="listemess"><thead><tr class="intitules_tabl"><th class="nom_categorie">Nom de la categorie</th><th class="nombre_articles">Quantit&eacute;</th></thead><tbody>';
		$data = parse_var($data,array('categorie_enter'=>$categorie_enter,'categorie_out'=>'</tbody></table>'));
	}
	else{
		$data = parse_var($data,array('categorie_enter'=>'','categorie_out'=>''));
	}
	$data = parse_boucle('CATEGORIES',$data,TRUE);
	$data = parse_var($data,array('final'=>$final['url'],'design'=>$_SESSION['design'],'titre_page'=>'Articles dans '.$mainCat['label'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''));
}
else{
	$data = display_notice('La cat&eacute;gorie demand&eacute; n\'existe pas.','important','javascript:history.back(-1);');
}
echo $data;
$db->deconnection();
?>