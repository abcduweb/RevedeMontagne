<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
include(ROOT.'fonctions/divers.fonction.php');

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
	$redirection = 'connexion.html';
	$data = display_notice($message,'important',$redirection);
	
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	if($auth['administrateur_article'] == 1){
		$data = get_file(TPL_ROOT.'admin/liste_topos.tpl');
		include(INC_ROOT.'header.php');
		if(isset($_GET['type']) AND $_GET['type'] < 4 AND $_GET['type'] > 0)
			$type = intval($_GET['type']);
		else
			$type = 1;
		if(isset($_GET['page']))
			$page = intval($_GET['page']);
		else
			$page = 1;
	########################################Calcul des pages#################################################################
	$nb_message_page = $_SESSION['nombre_message'];																	                                    #
	$retour = $db->requete("SELECT * FROM  articles_intro_conclu WHERE article_status = $type");    							#
	$nb_enregistrement = $db->num($retour);													 									#
	$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							 									#
	if($nombre_de_page < $page)	$page = $nombre_de_page;									 									#
	$limite = ($page - 1) * $nb_message_page;												 									#
	$liste_page = get_list_page($page,$nombre_de_page);																			#
	$pages = '';
	foreach($liste_page as $page_n){
		if($page_n == $page)
			$pages .= '<span class="current">&#8201;'.$page_n.'&#8201;</span> ';
		else
			$pages .= '<a href="liste-articles-'.$type.'-p'.$page_n.'.html">&#8201;'.$page_n.'&#8201;</a> ';
	}
	$liste_page = $pages;
	##################################################################################################################
		$status = array(1 => 'publier', 2 => 'en cours de validation', 3 => 'en cours d\'&eacute;dition');
		if($nombre_de_page != 0){
			$sql = "SELECT * FROM articles AS T1 LEFT JOIN articles AS T2 ON ( T2.BG > T1.BG AND T2.BD < T1.BD AND T1.level = T2.level - 1)ORDER BY T1.`BG` ASC ";
			$result = $db->requete($sql);
			$i = 0;
			$cat = array();
			$past = array();
			while($row = $db->fetch($result)){
				if($i==0 OR $past[$i-1] != $row[1]){
					$past[$i] = $row[1];
					$cat[$row[1]]['label'] = $row[2];
					$cat[$row[1]]['BD'] = $row[1];
					$cat[$row[1]]['level'] = $row[3];
					$cat[$row[1]]['BG'] = $row[0];
					$added_scat = array();
					$i++;
					if($row['label'] != null){
						$cat[$row[1]]['s_cat'][] = array('label'=>$row['label'],'BD'=>$row['BD'],'BG'=>$row['BG'],'level'=>$row['level']);
						$added_scat[] = $row['BD'];
					}
				}
				else{
					if($cat[$past[$i-1]]['level'] + 1 == $row['level'] AND !in_array($row['BD'],$added_scat)){
						$cat[$past[$i-1]]['s_cat'][] = array('label'=>$row['label'],'BD'=>$row['BD'],'BG'=>$row['BG'],'level'=>$row['level']);
						$added_scat[] = $row['BD'];
					}
				}
			}
			$sql = "SELECT * FROM  articles_intro_conclu LEFT JOIN membres ON (articles_intro_conclu.id_membre = membres.id_m) LEFT JOIN articles ON (articles_intro_conclu.id_cat = articles.BD) WHERE article_status = $type LIMIT $limite,$nb_message_page";
			$result = $db->requete($sql);
			$ligne = 1;
			while($row = $db->fetch($result))
			{	
				if($type == 3){
					$categorie = 'A choisir lors de la validation';
					$validation = 'A l\'auteur de faire une demande';
					$deplacer = '-';
				}
				else{
					$categorie = develop_back($cat,$cat[$past[0]],array('BD'=>$row['BD'],'BG'=>$row['BG']));;
					if($type == 2){
						$validation = '<a href="actions/valider_article.php?artid='.$row['id_article'].'&amp;action=1"><img src="'.$config['domaine'].'templates/images/1/tick.png" alt="topo mis en ligne" /></a> / <a href="actions/valider_article.php?artid='.$row['id_article'].'&amp;action=0"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Refuser"></a>';
						$deplacer = '-';
					}
					else{
						$validation = '<a href="actions/valider_article.php?artid='.$row['id_article'].'&amp;action=0"><img src="'.$config['domaine'].'templates/images/1/tick.png" alt="topo mis en ligne" /></a>';
						$deplacer = '<form action="actions/deplacer_articles.php?artid='.$row['id_article'].'" method="post">
						<select name="cat">';
						$deplacer .= develop($cat,$cat[$past[0]],0);
						$deplacer .= '</select><input type="submit" value="d&eacute;placer" />
						</form>';
					}
				}
				
				if($ligne == 1)
					$ligne = 2;
				else
					$ligne = 1;
				
				$data = parse_boucle('ARTICLES',$data,FALSE,array('id' => $row['id_article'],'titre_article' => $row['titre'],'titre_url'=>title2url($row['titre']),'cat'=>$categorie,'validation'=>$validation,'deplacer'=>$deplacer, 'ligne'=>$ligne));
			}
		}
		$data = parse_boucle('ARTICLES',$data,TRUE);
		$data = parse_var($data,array('liste_page'=>$liste_page,'titre_page'=>'Liste des topos - '.SITE_TITLE,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'type'=>$status[$type],'ROOT'=>''));
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
		$redirection = 'connexion.html';
		$data = display_notice($message,'important',$redirection);;
	}
}
$db->deconnection();
echo $data;
?>
