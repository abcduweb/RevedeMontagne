<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['group'] != 1){
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else{
	$data = get_file(TPL_ROOT.'admin/liste_edition_group.tpl');
	include(INC_ROOT.'header.php');
	$id_group = intval($_GET['gid']);
	$onoff = array(1=>'checked="checked"',0=>'');
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$id_group'";
	$result = $db->requete($sql);
	if($db->num($result) > 0){
		$row = $db->fetch($result);
		$nom_group = htmlentities($row['nom_group'],ENT_QUOTES);
		if(in_array($id_group,$team_group_id))
		  $dispAdmin = 'checked="checked"';
		else
		  $dispAdmin = '';
		$data = parse_var($data,array('id_group'=>$id_group,
		'modifier_news.checked'=>$onoff[$row['modifier_news']],'supprimer_news.checked'=>$onoff[$row['supprimer_news']],
		'valider_news.checked'=>$onoff[$row['valider_news']],'ajouter_album.checked'=>$onoff[$row['ajouter_album']],
		'supprimer_album.checked'=>$onoff[$row['supprimer_album']],
		'supprimer_photo.checked'=>$onoff[$row['supprimer_photo']],'modifier_com.checked'=>$onoff[$row['modifier_com']],
		'supprimer_com.checked'=>$onoff[$row['supprimer_com']],'ban.checked'=>$onoff[$row['punnir']],
		'photos.checked'=>$onoff[$row['ajouter_photo']],'news.checked'=>$onoff[$row['ajouter_news']],
		'articles.checked'=>$onoff[$row['ajouter_article']],'redacOff.checked'=>$onoff[$row['artOfficiel']],'com.checked'=>$onoff[$row['ajouter_com']],'mp.checked'=>$onoff[$row['mp']],'admin.checked'=>$dispAdmin));

		$sql = "SELECT * FROM forum LEFT JOIN big ON big.id_b = forum.id_big LEFT JOIN auth_list ON (forum.id_f = auth_list.id_forum AND auth_list.id_group = '$id_group') ORDER BY forum.id_big ASC";
		$result = $db->requete($sql);
		$curent_theme = 0;
		$j = 0;
		while($row = $db->fetch($result)){
			if($curent_theme != $row['id_b']){
				if($j != 0){
					$data = parse_boucle('FORUM',$data,TRUE);
					$data = imbrication('THEMES',$data);
				}
				$curent_theme = $row['id_b'];
				if(!isset($row['add_forum'])) $row['add_forum'] = 0;
				$j = 0;
				$data = parse_boucle('THEMES',$data,false,array('theme.titre'=>$row['nom_b'],'theme.id'=>$row['id_b'],
				'add_forum.checked'=>$onoff[$row['add_forum']]),true);
			}
			if(!isset($row['ajouter'])) $row['ajouter'] = 0;
			if(!isset($row['modifier_tout'])) $row['modifier_tout'] = 0;
			if(!isset($row['supprimer'])) $row['supprimer'] = 0;
			if(!isset($row['afficher'])) $row['afficher'] = 0;
			if(!isset($row['interdire_topics'])) $row['interdire_topics'] = 0;
			if(!isset($row['ban'])) $row['ban'] = 0;
			if(!isset($row['move'])) $row['move'] = 0;
			$data = parse_boucle('FORUM',$data,false,array('forum.titre'=>$row['nom'],'forum.id'=>$row['id_f'],
			'add.checked'=>$onoff[$row['ajouter']],'modifier.checked'=>$onoff[$row['modifier_tout']],
			'supprimer.checked'=>$onoff[$row['supprimer']],'afficher.checked'=>$onoff[$row['afficher']],
			'close.checked'=>$onoff[$row['interdire_topics']],'move.checked'=>$onoff[$row['move']]));
			$j++;
		}
		$data = parse_boucle('FORUM',$data,TRUE);
		$data = parse_boucle('THEMES',$data,TRUE);
		$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>'Edition du group {nom_group} - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'nom_group'=>$nom_group,'action'=>'Modifier','ROOT'=>''));
	}
	else{
		$message = "Le groupe sélectionné n'existe pas!";
		$redirection = "editer-groupes.html";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>
