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
	echo display_notice($message,'important',$redirection);
	
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	if(in_array($_SESSION['group'],$team_group_id)){
		$data = get_file(TPL_ROOT.'admin/index.tpl');
		if($auth['modifier_news'] == 1){
			$section_news = '<ul>
			<li><a href="liste-news-1.html">Liste des news valid&eacute;es</a></li>
			<li><a href="liste-news-2.html">Liste des news en attente de validation</a></li>
			<li><a href="liste-news-3.html">Liste des news en r&eacute;daction</a></li>
			</ul>';
		}
		else{
			$section_news = "Aucune action possible";
		}
		if($_SESSION['group'] == 1){
			$section_news .= '<ul>
			<li><a href="liste-newsletter-1.html">Newsletter en cours de R&eacute;daction</a></li>
			<li><a href="liste-newsletter-2.html">Newsletter en cours d\'envoi</a></li>
			<li><a href="rediger-une-newsletter.html">Ajouter un Newsletter</a>
			</ul>';
		}
		if($_SESSION['group'] == 1){
			$section_group = '<ul>
			<li><a href="admin-membres.html">Gestion membres</a></li>
			<li><a href="editer-groupes.html">Editer les groupes</a></li>
			<li><a href="ajouter-groupe.html">Ajouter un groupes</a></li>
			<li><a href="liste-banis.html">Liste ip bannies</a></li>
			</ul>';
		}
		else
			$section_group = '<ul>
			<li><a href="admin-membres.html">Gestion membres</li>
			</ul>';
			
		if($auth['administrateur_points'] == 1){
			$section_pts = '<ul>
			<li><a href="certifier-des-points.html">Valider des points de charat&egrave;res</a></li>
			</ul>';
		}
		else
			$section_pts = 'Aucune action possible';
		
		if($auth['administrateur_topo'] == 1){
			$section_topo = '<ul>
			<li><a href="'.$config['domaine'].'administration/valider_topo.php?idact=1">Valider des topos de skis de randonn&eacute;e</a></li>
			<li><a href="'.$config['domaine'].'administration/valider_topo.php?idact=2">Valider des topos de randonn&eacute;e p&eacute;destre</a></li>
			</ul>';
		}
		else
			$section_topo = 'Aucune action possible';
		
		$section_membres = '';
		if($auth['administrateur_article'] == 1){
			$section_article = '<ul>
			<li><a href="liste-articles-1.html">Liste des articles valid&eacute;</a></li>
			<li><a href="liste-articles-2.html">Liste des articles en attente de validation</a></li>
			<li><a href="liste-articles-3.html">Liste des articles en r&eacute;daction</a></li>
			</ul>';
			if($_SESSION['group'] == 1){
			$section_article .='<form action="actions/add_cat_article.php" method="post">
				<fieldset>
					<legend>Ajouter une cat&eacute;gorie</legend>
					<label for="cat_article">Ajouter dans : </label>
					<select name="cat_article" id="cat_article">';
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
					$added_scat = array();
					$i++;
					if($row['label'] != null){
						$cat[$row[1]]['s_cat'][] = array('label'=>$row['label'],'BD'=>$row['BD'],'level'=>$row['level']);
						$added_scat[] = $row['BD'];
					}
				}
				else{
					if($cat[$past[$i-1]]['level'] + 1 == $row['level'] AND !in_array($row['BD'],$added_scat)){
						$cat[$past[$i-1]]['s_cat'][] = array('label'=>$row['label'],'BD'=>$row['BD'],'level'=>$row['level']);
						$added_scat[] = $row['BD'];
					}
				}
			}
			$section_article .= develop($cat,$cat[$past[0]],0);
			$section_article .='		</select><br /><br /><br />
					<label for="label">Nom : </label>
					<input type="text" name="label" id="label" /><br />
					<div class="send">
						<input type="submit" value="ajouter" />
					</div>
				</fieldset>
			</form>';
			}
		}
		else
			$section_article = "Aucune action possible";
		if($auth['ajouter_album'] == 1){
			$section_album = '
			<form action="actions/ajout_album.php" method="post">
				<fieldset>
					<legend>Ajouter Album</legend>
					<label for="name">Album : </label>
					<input type="text" name="name" id="name" />
					<input type="submit" value="ajouter" />
				</fieldset>
			</form>
			<ul>
			<li><a href="liste-album.html">Liste des albums</a></li>
			<li><a href="liste-photos.html">Liste des photos</a></li>
			</ul>';
		}
		else
			$section_album = "Aucune action possible";
		$result = $db->requete("SELECT * FROM big LEFT JOIN forum ON forum.id_big = big.id_b LEFT JOIN auth_list ON (auth_list.id_forum = forum.id_f AND auth_list.afficher = '1') WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.add_forum = 1 ORDER BY id_b");
		$i = 0;
		while($row = $db->fetch($result)){
			if($i == 0)
			{
				$theme['id'][$i] = $row['id_b'];
				$theme['titre'][$i] = $row['nom_b'];
				$i++;
			}
			if($i > 0 AND $theme['id'][$i-1] != $row['id_b'])
			{
				$theme['id'][$i] = $row['id_b'];
				$theme['titre'][$i] = $row['nom_b'];
				$i++;
			}
		}
		$section_forum = '<ul>';
		if($_SESSION['group'] == 1){
			$section_forum .= '<li><a href="ajouter-categorie-forum.html">Ajouter une cat&eacute;gorie</a></li></ul>';
		}
		if($i != 0){
			$section_forum .= '<form action="actions/add_forum.php" method="post">
			<fieldset>
			<legend>Ajouter un forum</legend>
			<label for="cat">Cat&eacute;gorie : </label>
			<select name="cat" id="cat">';
			foreach($theme['titre'] as $key => $var){
				$section_forum .= '<option value="'.$theme['id'][$key].'">'.$var.'</option>';
			}
			$section_forum .= '</select><br />
			<label for="nom_forum">Nom : </label>
			<input type="text" name="nom_forum" id="nom_forum" />
			<div class="send">
				<input type="submit" value="ajouter" />
			</div>
			</fieldset>
			</form>';
		}
		if($section_forum == '<ul>')
			$section_forum = "Aucune action possible";
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>'Administration - '.SITE_TITLE,'section_pts'=>$section_pts, 'section_topo'=>$section_topo, 'section_news'=>$section_news,'section_forum'=>$section_forum,'section_article'=>$section_article,'section_album'=>$section_album,'section_group'=>$section_group,'section_membres'=>$section_membres,'nb_requetes'=>$db->requetes,'ROOT'=>''));
		echo $data;
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
		$redirection = 'connexion.html';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>