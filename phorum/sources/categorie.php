<?php
require_once(ROOT.'fonctions/commun.fonction.php');
require_once(ROOT.'fonctions/categorie.fonction.php');

$sql = "SELECT big.id_b AS cat_id, big.nom_b AS cat_title, forum.id_f AS forum_id, forum.nom AS forum_title, forum.description AS forum_desc,forum.nb_topic AS forum_nb_topic,forum.nb_reponse_t AS forum_nb_answer, topics.id_t AS topic_id, topics.titre AS topic_title, topics.id_last_message AS lmessage_id, messages.date_m AS lmessage_date, messages.id_utilisateur AS luser_id, messages.utilisateur AS luser, messages_lus.last_message_id AS rmessage_id,enligne.id_m_join AS idOnline,enligne.invisible AS invisible  FROM big LEFT JOIN forum ON forum.id_big = big.id_b LEFT JOIN topics ON forum.id_last_topics = topics.id_t LEFT JOIN messages ON topics.id_last_message = messages.id_ms LEFT JOIN auth_list ON (forum.id_f = auth_list.id_forum AND auth_list.afficher = 1) LEFT JOIN messages_lus ON (messages_lus.topics_id = forum.id_last_topics AND messages_lus.id_membre = '$_SESSION[mid]') LEFT JOIN enligne ON enligne.id_m_join = messages.id_utilisateur WHERE auth_list.id_group = '$_SESSION[group]' ORDER BY forum.id_big ASC,forum.position ASC";

$result = $db->requete($sql);
$theme_count = 0;
$current_theme = 0;
$ligne = 1;
while($row = $db->fetch_assoc($result))
{
	if($current_theme != $row['cat_id']){
		if($current_theme != 0){
			$data = parse_boucle('FORUM',$data,TRUE);
			$data = imbrication('THEMES',$data);
			$ligne = 1;
		}
		$current_theme = $row['cat_id'];
		$theme_count++;
		$data = parse_boucle('THEMES',$data,false,array('info_theme_titre'=>$row['cat_title']),true);
	}
	$titre_forum = $row['forum_title'];
	$titre_url = title2url($row['forum_title']);
	$id_forum = $row['forum_id'];
	$description = $row['forum_desc'];
	$nombre_de_reponse = $row['forum_nb_answer'];
	$nombre_de_sujet = $row['forum_nb_topic'];
	$date_dernier_message = get_date($row['lmessage_date'],$_SESSION['style_date']);
	if(isset($row['idOnline']) AND $row['invisible'] == 0)
			$online = 'online';
		else	
			$online = 'offline';
	if($row['lmessage_id'] != null)
	{
		$id_dernier_message = $row['lmessage_id'];
		$titre_dernier_sujet = $row['topic_title'];
		$titre_dernier_sujet_url = title2url($row['topic_title']);
		$id_dernier_sujet = $row['topic_id'];
		$dernier_posteur = $row['luser'];
		$id_dernier_posteur = $row['luser_id'];
	}
	else
	{
		$id_dernier_message = 0;
		$titre_dernier_sujet = '-';
		$titre_dernier_sujet_url = '-';
		$id_dernier_sujet = '-';
		$dernier_posteur = '-';
		$id_dernier_posteur = '-';
	}
	if($_SESSION['mid'] == 0){
		if(isset($_SESSION['tid'])){
			if(isset($_SESSION['tid'][$id_dernier_sujet]))
				$row['rmessage_id'] = intval($_SESSION['tid'][$id_dernier_sujet]);
			else{
				$row['rmessage_id'] = 0;
			}
		}else{
			$row['rmessage_id'] = 0;
		}
	}
	$drapeau = get_drapeau($row['rmessage_id'],$id_dernier_message);
	$data = parse_boucle('FORUM',$data,false,array('flag'=>$drapeau,'id_forum'=>$id_forum,
	'titre_url'=>$titre_url,'titre_forum'=>$titre_forum,'description'=>$description,'nombre_de_sujet'=>$nombre_de_sujet,
	'nombre_de_reponse'=>$nombre_de_reponse,'date_dernier_message'=>$date_dernier_message,
	'titre_dernier_sujet'=>$titre_dernier_sujet,'titre_dernier_sujet_url'=>$titre_dernier_sujet_url,
	'id_dernier_sujet'=>$id_dernier_sujet,'id_dernier_posteur'=>$id_dernier_posteur,'dernier_posteur'=>$dernier_posteur,'enligne'=>$online, 'ligne'=>$ligne));
	
	if($ligne == 1)
		$ligne = 2;
	else
		$ligne = 1;
}
$data = parse_boucle('FORUM',$data,TRUE);
$data = parse_boucle('THEMES',$data,TRUE);
$data = parse_var($data,array('titre_page'=>'Forum - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));

if($theme_count == 0) header('location:connexion.html');
?>
