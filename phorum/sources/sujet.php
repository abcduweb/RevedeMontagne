<?php
require_once(ROOT.'fonctions/sujet.fonction.php');
$id_forum = intval($_GET['f']);
//echo $id_forum.'bb';
$niveaux_forum_id = intval($_GET['f']);
$sql = 'SELECT * FROM topics WHERE id_forum =\''.$id_forum.'\' AND topics.unique = 0';
$result = $db->requete($sql);
$nb_total_topic = $db->num($result);
$nombre_page = ceil($nb_total_topic/$_SESSION['nombre_sujet']);
$page = (int)$_GET['limite'];
if($page > $nombre_page) $page = $nombre_page;
$page_limite = get_limite($page);
$droits = $db->fetch_assoc($db->requete('SELECT afficher,ajouter FROM auth_list WHERE id_forum = '.$id_forum.' AND id_group = '.$_SESSION['group'].''));
if($droits['afficher'] == 1)
{
	if($page_limite <= 0)
	{
		$sql = "SELECT topics.id_t AS topic_id, topics.deplacer AS move, topics.nb_reponse AS topic_nb_answer,topics.nb_lecture AS topic_nb_read, topics.titre AS topic_title, topics.sous_titre AS topic_subtitle, big.nom_b AS cat_title, big.id_b AS cat_id,
		forum.nom AS forum_title, forum.id_f AS forum_id, membres.id_m AS creator_id, membres.pseudo AS creator_name,
		messages_lus.last_message_id AS rmessage_id, messages_lus.post AS posted, E2.id_m_join AS puser_id, E2.invisible AS puser_invisible, E1.id_m_join AS cuser_id,
		E1.invisible AS cuser_invisible, messages.date_m AS lmessage_date, messages.id_ms AS lmessage_id, messages.utilisateur AS luser, messages.id_utilisateur AS luser_id
		FROM topics LEFT JOIN messages ON messages.id_ms = topics.id_last_message LEFT JOIN membres ON membres.id_m = topics.id_auteur LEFT JOIN messages_lus ON (messages_lus.topics_id = topics.id_t AND messages_lus.id_membre = '$_SESSION[mid]') LEFT JOIN forum ON forum.id_f = '$id_forum' LEFT JOIN big ON big.id_b = forum.id_big LEFT JOIN enligne AS E1 ON E1.id_m_join = topics.id_auteur LEFT JOIN enligne AS E2 ON E2.id_m_join = messages.id_utilisateur WHERE topics.unique = 1 AND (topics.id_forum = '$id_forum' OR topics.deplacer = '$id_forum') ORDER BY messages.date_m DESC";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			while($row = $db->fetch_assoc())
			{	
				if(isset($row['puser_id']) AND $row['puser_invisible'] == 0)
					$p_online = 'online';
				else
					$p_online = 'offline';
				if(isset($row['cuser_id']) AND $row['cuser_invisible'] == 0)
					$c_online = 'online';
				else
					$c_online = 'offline';
				$niveaux_big_titre = $row['cat_title'];
				$niveaux_big_id = $row['cat_id'];
				$niveaux_forum_titre = $row['forum_title'];
				$sujet['spec'] = '<img src="{DOMAINE}/templates/images/{design}/forum/epingle.png" alt="épinglé" />';					
				$sujet['titre'] = $row['topic_title'];
				$sujet['titre_url'] = title2url($row['topic_title']);
				$sujet['sous_titre'] = $row['topic_subtitle'];
				$sujet['id_sujet'] = $row['topic_id'];
				$sujet['id_forum'] = $id_forum;
				$sujet['createur'] = $row['creator_name'];
				$sujet['id_auteur'] = $row['creator_id'];
				$sujet['nb_lecture'] = $row['topic_nb_read'];
				$sujet['nb_reponse'] = $row['topic_nb_answer'];
				$sujet['dernier_posteur'] = $row['luser'];
				$sujet['id_dernier_posteur'] = $row['luser_id'];
				$sujet['date'] = get_date($row['lmessage_date'],$_SESSION['style_date']);
				if($_SESSION['mid'] == 0){
					if(isset($_SESSION['tid'][$sujet['id_sujet']])){
						$row['rmessage_id'] = intval($_SESSION['tid'][$sujet['id_sujet']]);
					}else{
						$row['rmessage_id'] = 0;
					}
				}
				$sujet['flag'] = get_drapeau($row['lmessage_id'],$row['rmessage_id'],$row['topic_nb_answer'],$row['posted']);
				$sujet['nb_page_topic'] = get_pagination_topic($row['topic_nb_answer'],$sujet['id_forum'],$sujet['id_sujet'],$sujet['titre_url']);
				if($row['move'] != 0 AND $row['move'] != $id_forum){
					$sujet['id_forum'] = $row['move'];
				}
				if($row['rmessage_id'] != null AND ($sujet['flag'] != 'f_nonew' AND $sujet['flag'] != 'post_f_nonew' AND $sujet['flag'] != 'f_hotnonew' AND $sujet['flag'] != 'post_f_hotnonew')){
					$gotoLR = '<a href="forum-{id_forum}-{id_sujet}-r'.$row['rmessage_id'].'-{titre_url}.html#r'.$row['rmessage_id'].'"><img src="templates/images/{design}/forum/last_read.png" alt="aller au dernier message lue" /></a>';
				}
				else{
					$gotoLR = '';
				}
				$data = parse_boucle('TOPICS',$data,false,array('gotoLR'=>$gotoLR,'flag'=>$sujet['flag'],'spec'=>$sujet['spec'],
				'id_sujet'=>$sujet['id_sujet'],'id_forum'=>$sujet['id_forum'],'titre_url'=>$sujet['titre_url'],
				'titre'=>$sujet['titre'],'sous_titre'=>$sujet['sous_titre'],'nb_reponse'=>$sujet['nb_reponse'],
				'nb_lecture'=>$sujet['nb_lecture'],'date'=>$sujet['date'],'createur'=>$sujet['createur'],
				'id_auteur'=>$sujet['id_auteur'],
				'id_dernier_posteur'=>$sujet['id_dernier_posteur'],'dernier_posteur'=>$sujet['dernier_posteur'],
				'liste_page_sujet'=>$sujet['nb_page_topic'],'c_enligne'=>$c_online,'p_enligne' => $p_online,'id_last_msg'=>$row['lmessage_id']));
			}
		}
	}
	if($nombre_page > 0){
		$ligne = 1;
		$sql = "SELECT topics.id_t AS topic_id, topics.status AS status, topics.deplacer AS move, topics.resolut AS solve, topics.nb_reponse AS topic_nb_answer, topics.nb_lecture AS topic_nb_read, topics.titre AS topic_title, topics.sous_titre AS topic_subtitle, big.nom_b AS cat_title, big.id_b AS cat_id,
		forum.nom AS forum_title, forum.id_f AS forum_id, membres.id_m AS creator_id, membres.pseudo AS creator_name,
		messages_lus.last_message_id AS rmessage_id, messages_lus.post AS posted, E2.id_m_join AS puser_id, E2.invisible AS puser_invisible, E1.id_m_join AS cuser_id,
		E1.invisible AS cuser_invisible, messages.date_m AS lmessage_date, messages.id_ms AS lmessage_id, messages.utilisateur AS luser, messages.id_utilisateur AS luser_id
		FROM topics LEFT JOIN messages ON messages.id_ms = topics.id_last_message LEFT JOIN membres ON membres.id_m = topics.id_auteur LEFT JOIN messages_lus ON (messages_lus.topics_id = topics.id_t AND messages_lus.id_membre = '$_SESSION[mid]') LEFT JOIN forum ON forum.id_f = '$id_forum' LEFT JOIN big ON big.id_b = forum.id_big LEFT JOIN enligne AS E1 ON E1.id_m_join = topics.id_auteur LEFT JOIN enligne AS E2 ON E2.id_m_join = messages.id_utilisateur WHERE topics.unique = 0 AND (topics.id_forum = '$id_forum' OR topics.deplacer = '$id_forum') ORDER BY messages.date_m DESC LIMIT $page_limite, ".$_SESSION['nombre_sujet']."";
		$result = $db->requete($sql);
		while($row = $db->fetch_assoc($result))
		{
			if(isset($row['puser_id']) AND $row['puser_invisible'] == 0)
				$p_online = 'online';
			else
				$p_online = 'offline';
			if(isset($row['cuser_id']) AND $row['cuser_invisible'] == 0)
				$c_online = 'online';
			else
				$c_online = 'offline';
				
			$niveaux_big_titre = $row['cat_title'];
			$niveaux_big_id = $row['cat_id'];
			$niveaux_forum_titre = $row['forum_title'];
			if($row['status'] == 0)
				$sujet['spec'] = '<img src="{DOMAINE}/templates/images/{design}/forum/fermer.png" alt="fermer" />';
			else
			{
				if($row['move'] != 0 AND $row['move'] != $id_forum)
					$sujet['spec'] = '<img src="{DOMAINE}/templates/images/{design}/forum/deplacer.png" alt="déplacer" />';
				elseif($row['solve'] == 1)
					$sujet['spec'] = '<img src="{DOMAINE}/templates/images/{design}/resolut.png" alt="résolut" />';
				else
					$sujet['spec'] = '&nbsp;';
			}
			$sujet['titre'] = $row['topic_title'];
			$sujet['titre_url'] = title2url($row['topic_title']);
			$sujet['sous_titre'] = $row['topic_subtitle'];
			$sujet['id_sujet'] = $row['topic_id'];
			$sujet['id_forum'] = $row['forum_id'];
			$sujet['createur'] = $row['creator_name'];
			$sujet['id_auteur'] = $row['creator_id'];
			$sujet['nb_lecture'] = $row['topic_nb_read'];
			$sujet['nb_reponse'] = $row['topic_nb_answer'];
			$sujet['dernier_posteur'] = $row['luser'];
			$sujet['id_dernier_posteur'] = $row['luser_id'];
			$sujet['date'] = get_date($row['lmessage_date'],$_SESSION['style_date']);
			
			if($_SESSION['mid'] == 0){
				if(isset($_SESSION['tid'][$sujet['id_sujet']])){
					$row['rmessage_id'] = intval($_SESSION['tid'][$sujet['id_sujet']]);
				}else{
					$row['rmessage_id'] = 0;
				}
			}
			
			$sujet['flag'] = get_drapeau($row['lmessage_id'],$row['rmessage_id'],$row['topic_nb_answer'],$row['posted']);
			if($row['rmessage_id'] != null AND ($sujet['flag'] != 'f_nonew' AND $sujet['flag'] != 'post_f_nonew' AND $sujet['flag'] != 'f_hotnonew' AND $sujet['flag'] != 'post_f_hotnonew')){
				$gotoLR = '<a href="forum-{id_forum}-{id_sujet}-r'.$row['rmessage_id'].'-{titre_url}.html#r'.$row['rmessage_id'].'"><img src="templates/images/{design}/forum/last_read.png" alt="aller au dernier message lue" /></a>';
			}
			else{
				$gotoLR = '';
			}
			$sujet['nb_page_topic'] = get_pagination_topic($row['topic_nb_answer'],$sujet['id_forum'],$sujet['id_sujet'],$sujet['titre_url']);
			if($row['move'] != 0 AND $row['move'] != $id_forum){
				$sujet['id_forum'] = $row['move'];
			}
			$data = parse_boucle('TOPICS',$data,false,array('gotoLR'=>$gotoLR,'flag'=>$sujet['flag'],'spec'=>$sujet['spec'],
			'id_sujet'=>$sujet['id_sujet'],'id_forum'=>$sujet['id_forum'],'titre_url'=>$sujet['titre_url'],
			'titre'=>$sujet['titre'],'sous_titre'=>$sujet['sous_titre'],'nb_reponse'=>$sujet['nb_reponse'],
			'nb_lecture'=>$sujet['nb_lecture'],'date'=>$sujet['date'],'createur'=>$sujet['createur'],
			'id_auteur'=>$sujet['id_auteur'],
			'id_dernier_posteur'=>$sujet['id_dernier_posteur'],'dernier_posteur'=>$sujet['dernier_posteur'],
			'liste_page_sujet'=>$sujet['nb_page_topic'],'c_enligne'=>$c_online,'p_enligne' => $p_online,'id_last_msg'=>$row['lmessage_id'], 'ligne'=>$ligne));
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
	}
	if($nombre_page < 1 and $db->num($result) == 0){
		$sql = "SELECT * FROM forum LEFT JOIN big ON big.id_b = forum.id_big WHERE forum.id_f = '$id_forum'";
		$row = $db->fetch($db->requete($sql));
		$data = get_file(TPL_ROOT.'forum/sujet_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>0,'id_cat'=>$row['id_b'],'design'=>$_SESSION['design'],'cat_titre'=>$row['nom_b'],'niveaux_forum_titre'=>$row['nom'],'niveaux_forum_id'=>$row['id_f'],'cat_titre_url'=>title2url($row['nom_b']),'niveaux_forum_titre_url'=>title2url($row['nom']),'titre_page'=>$row['nom'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''));
	}
	else{
		$data = parse_boucle('TOPICS',$data,TRUE);
		$niveaux_forum_titre_url = title2url($niveaux_forum_titre);
		$niveaux_big_titre_url = title2url($niveaux_big_titre);
		$liste_page = get_liste_page_forum($page,$nombre_page,$niveaux_forum_id,$niveaux_forum_titre_url);
		if($droits['ajouter'] == 1){
			$ajouterSujet = '<a href="ajouter-sujet-{niveaux_forum_id}.html"><img src="{DOMAINE}/templates/images/{design}/forum/ajout.png" alt="Ajouter un sujet" /></a>';
		}else{
			$ajouterSujet = '';
		}
		$data = parse_var($data,array('ajouter'=>$ajouterSujet,'titre_page'=>$niveaux_forum_titre.' - '.SITE_TITLE,'liste_page'=>$liste_page,'niveaux_forum_id'=>$niveaux_forum_id,'niveaux_forum_titre'=>$niveaux_forum_titre,'niveaux_forum_titre_url'=>$niveaux_forum_titre_url,'id_cat'=>$niveaux_big_id,'cat_titre'=>$niveaux_big_titre,'cat_titre_url'=>$niveaux_big_titre_url,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
}
else{
	$message = 'Vous n\'avez pas accé à ce forum.';
	$redirection = 'Javascript:history.go(-1)';
	$data = display_notice($message,'important',$redirection);
}
?>