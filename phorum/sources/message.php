<?php
if(!isset($load_tpl))$load_tpl = true;
require_once(ROOT.'fonctions/message.fonction.php');
require_once(ROOT.'fonctions/niveaux.fonction.php');
$id_topic = (int)$_GET['t'];
$id_forum = (int)$_GET['f'];
if(isset($_GET['id_mes']) and !empty($_GET['id_mes'])){
	$id_message = intval($_GET['id_mes']);
	if($_SESSION['order'] == 'ASC')
		$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_topic AND id_ms <= $id_message"));
	else
		$num = $db->num($db->requete("SELECT * FROM messages WHERE id_topics = $id_topic AND id_ms >= $id_message"));
	$page = ceil($num + 1 / $_SESSION['nombre_message']);
	$_GET['limite'] = $page;
}
if(isset($_SERVER['HTTP_REFERER'])){
	$old = parse_url($_SERVER['HTTP_REFERER']);
	$get_var_old = explode('-',$old['path']);
	$page_old = explode('/',$get_var_old[0]);
	$get_var_new = explode('-',$_SERVER['REQUEST_URI']);
	if((isset($get_var_old[1]) AND isset($get_var_new[1]) AND $get_var_old[1] != $get_var_new[1])OR (isset($get_var_old[2]) AND isset($get_var_new[2]) AND $get_var_old[2] != $get_var_new[2])){
		$db->requete("UPDATE topics SET nb_lecture = nb_lecture + 1 WHERE id_t = '$id_topic'");
	}
}
else
	$db->requete("UPDATE topics SET nb_lecture = nb_lecture + 1 WHERE id_t = '$id_topic'");
$ordre = $_SESSION['order'];
$page = (int)$_GET['limite'];
$result = $db->requete("SELECT * FROM messages LEFT JOIN topics ON (topics.id_t = '$id_topic') LEFT JOIN forum ON (forum.id_f = '$id_forum') LEFT JOIN big ON forum.id_big = big.id_b LEFT JOIN auth_list ON (auth_list.id_forum = '$id_forum' AND auth_list.id_group = '$_SESSION[group]') WHERE messages.id_topics = '$id_topic'");
$row = $db->fetch($result);
$niveau['cat']['titre'] = $row['nom_b'];
$niveau['cat']['titre_url'] = title2url($niveau['cat']['titre']);
$niveau['cat']['id'] = $row['id_b'];
$niveau['forum']['titre'] = $row['nom'];
$niveau['forum']['titre_url'] = title2url($niveau['forum']['titre']);
$niveau['forum']['id'] = $row['id_f'];
$niveau['sujet']['titre'] = $row['titre'];
$niveau['sujet']['titre_url'] = title2url($niveau['sujet']['titre']);
$niveau['sujet']['id'] = $row['id_t'];
$auth['affichage'] = $row['afficher'];
$auth['ajouter'] = $row['ajouter'];
$auth['modifier'] = $row['modifier_tout'];
$auth['supprimer'] = $row['supprimer'];
$auth['interdire'] = $row['interdire_topics'];
$auth['sujet_clos'] = $row['status'];
$auth['sujet_epingle'] = $row['unique'];
$auth['deplacer'] = $row['move'];

$nb_total_message = $db->num($result);
$nb_page = ceil($nb_total_message / $_SESSION['nombre_message']);
if($page > $nb_page)$page = $nb_page;
$liste_page = get_liste_page_message($page,$nb_page,$niveau['forum']['id'],$niveau['sujet']['id'],$niveau['sujet']['titre_url']);

$page_limite = get_limite($page);

if($auth['affichage'] == 1)
{

	if($load_tpl){
		$data = get_file(TPL_ROOT.'forum/message.tpl');
	}
	else{
		$ordre = 'DESC';
	}
	if($page > 1){
		$bounds = $_SESSION['nombre_message'] + 1;
		$sql = "SELECT * FROM messages LEFT JOIN membres ON membres.id_m = messages.id_utilisateur LEFT JOIN messages_lus ON (messages_lus.id_membre = '$_SESSION[mid]' AND messages_lus.topics_id = '$id_topic') LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group LEFT JOIN enligne ON enligne.id_m_join = messages.id_utilisateur WHERE messages.id_topics = '$id_topic' ORDER BY date_m $ordre LIMIT $page_limite,$bounds";
	}
	else
		$sql = "SELECT * FROM messages LEFT JOIN membres ON membres.id_m = messages.id_utilisateur LEFT JOIN messages_lus ON (messages_lus.id_membre = '$_SESSION[mid]' AND messages_lus.topics_id = '$id_topic') LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group LEFT JOIN enligne ON enligne.id_m_join = messages.id_utilisateur WHERE messages.id_topics = '$id_topic' ORDER BY date_m $ordre LIMIT $page_limite,".$_SESSION['nombre_message']."";
	$result = $db->requete($sql);
	$first = true;
	$ligne = 1;
	while($row = $db->fetch($result))
	{
		$message['id'] = $row['id_ms'];
		$message['text'] = $row['text_parser'];
		$message['auteur'] = $row['utilisateur'];
		$message['id_auteur'] = $row['id_utilisateur'];
		$message['date'] = get_date($row['date_m'],$_SESSION['style_date']);
		$message['signature'] = $row['signature_parser'];
		$message['attach_sign'] = $row['attachSign'];
		$message['avatar'] = $row['avatar'];
		$message['nom_group'] = $row['nom_group'];
		$message['image_group'] = $row['img_group'];
		if(!isset($last_message_id))$last_message_id = $row['last_message_id'];
		$last_message_topics_id = $row['topics_id'];
		$actions = '';
		/*$niveauxPostUser = getNiveauUserPost($row['nb_post_m']);
		$titreUserPost = getNiveauPostName($niveauxPostUser);*/
		$niveauxPostUser = '';
		$titreUserPost = '';
		
		if($message['avatar'] != null) $message['avatar'] = '<img src="'.$message['avatar'].'" alt="avatar de '.$message['auteur'].'" class="emplacement_avatar"/>';
		if($row['img_group'] != '') $message['nom_group'] = '<img src="{DOMAINE}/templates/images/1/'.$message['image_group'].'" alt="'.$message['nom_group'].'" />';
		if($first AND $page > 1)
		{
			$message['text'] = '<div id="reprise">Reprise du message précèdent :</div>'.$message['text'];
			$first = false;
		}
		if($message['attach_sign'] == 1) $message['text'] .= '<div class="signature_message">'.$message['signature'].'</div>';
		if($auth['sujet_clos'] == 1 AND $auth['ajouter'] == 1) $actions .= '<a href="citer-'.$niveau['forum']['id'].'-'.$niveau['forum']['titre_url'].'-'.$niveau['sujet']['id'].'-'.$message['id'].'.html"><img src="{DOMAINE}/templates/images/{design}/form/quote.png" alt="citer" title="Citer" /></a>';
		if($auth['modifier'] == 1 OR $message['id_auteur'] == $_SESSION['mid']){
			$actions .= '<a href="edition-'.$message['id'].'-message.html"><img src="{DOMAINE}/templates/images/{design}/form/edit.png" alt="Editer" title="Editer" /></a>';
			$edit_rapide = ' ondblclick="inlineMod('.$message['id'].', this);"';
		}
		else
			$edit_rapide = '';
		if($auth['supprimer'] == 1) $actions .= '<a href="actions/supprimer_message.php?m='.$message['id'].'"><img src="{DOMAINE}/templates/images/{design}/form/supprimer.png" alt="Supprimer" title="Supprimer" /></a>';
		
		if(isset($row['id_m_join']) AND $row['invisible'] == 0)
			$online = 'online';
		else	
			$online = 'offline';
		$data = parse_boucle('MESSAGES',$data,false,array('id_message'=>$message['id'],'date'=>$message['date'],
		'message'=>stripslashes($message['text']),'actions_possibles'=>$actions,'edit_rapide'=>$edit_rapide,'avatar'=>$message['avatar'],
		'group'=>$message['nom_group'],'auteur'=>$message['auteur'],'id_auteur'=>$message['id_auteur'],'enligne'=>$online,'userPostNiveau'=>$niveauxPostUser,'userPostNiveauName'=>$titreUserPost, 'ligne'=>$ligne));
		if($row['date_edit'] != 0){
      $data = parse_var($data,array('data_edit'=>get_date($row['date_edit'],$_SESSION['style_date'])));
    }
		if($ordre == "DESC" AND $message['id'] > $last_message_id AND $load_tpl AND $_SESSION['mid'] != 0){
			if($last_message_id == 0 AND $last_message_topics_id == 0)
			{	
				$sql = "INSERT INTO messages_lus VALUES('$_SESSION[mid]','$id_topic','$id_forum','".$message['id']."','0')";
			}
			else
			{
				$sql = "UPDATE messages_lus SET last_message_id = '".$message['id']."' WHERE id_membre = '$_SESSION[mid]' AND topics_id = '$id_topic'";
			}
			$last_message_id = $message['id'];
			$db->requete($sql);
		}
		if($ligne == 1)
			$ligne = 2;
		else
			$ligne = 1;
	}
	$data = parse_boucle('MESSAGES',$data,true);
	if($ordre == "ASC" AND $message['id'] > $last_message_id AND $load_tpl AND $_SESSION['mid'] != 0)
	{
		if($last_message_id == 0 AND $last_message_topics_id == 0)
		{	
			$sql = "INSERT INTO messages_lus VALUES('$_SESSION[mid]','$id_topic','$id_forum','".$message['id']."','0')";
		}
		else
		{
			$sql = "UPDATE messages_lus SET last_message_id = '".$message['id']."' WHERE id_membre = '$_SESSION[mid]' AND topics_id = '$id_topic'";
		}
		$db->requete($sql);
	}elseif($_SESSION['mid'] == 0){
		$_SESSION['tid'][$id_topic] = $message['id'];
	}
	$repondre = '';
	if(($auth['ajouter'] == 1 AND $auth['sujet_clos'] == 1) OR ($auth['ajouter'] == 1 AND $auth['interdire'] == 1)){ $repondre = '<a href="repondre-'.$niveau['forum']['id'].'-'.$niveau['forum']['titre_url'].'-'.$niveau['sujet']['id'].'.html"><img src="templates/images/{design}/forum/repondre.png" alt="Répondre" /></a>';
	}
	if(($auth['deplacer'] == 1)){
		$deplacer = '<a href="actions/deplacer_sujet.php?t='.$niveau['sujet']['id'].'"><img src="{DOMAINE}/templates/images/{design}/forum/deplacer_sujet.png" alt="Déplacer" /></a>';
	}
	else{
		$deplacer = "";
	}
	if($auth['interdire'] == 0 AND $auth['sujet_clos'] == 0){
		$opcl = '<img src="{DOMAINE}/templates/images/{design}/forum/sujet_fermer.png" alt="Sujet fermer" />';
	}
	else{
		$opcl='';
	}
	if($auth['interdire'] == 1 AND $auth['sujet_clos'] == 1){
		$opcl = '<a href="actions/opcl_sujet.php?t='.$niveau['sujet']['id'].'&amp;action=0"><img src="{DOMAINE}/templates/images/{design}/forum/fermer_sujet.png" alt="Fermer" /></a>';
	}
	if($auth['interdire'] == 1 AND $auth['sujet_clos'] == 0){
		$opcl = '<a href="actions/opcl_sujet.php?t='.$niveau['sujet']['id'].'&amp;action=1"><img src="{DOMAINE}/templates/images/{design}/forum/ouvrir_sujet.png" alt="Ouvrir" /></a>';
	}
	if($auth['interdire'] == 1 AND $auth['sujet_epingle'] == 1){
		$epingle = '<a href="actions/epingler.php?t='.$niveau['sujet']['id'].'&amp;action=0"><img src="{DOMAINE}/templates/images/{design}/forum/detacher_sujet.png" alt="Détacher" /></a>';
	}
	elseif($auth['interdire'] == 1 AND $auth['sujet_epingle'] == 0){
		$epingle = '<a href="actions/epingler.php?t='.$niveau['sujet']['id'].'&amp;action=1"><img src="{DOMAINE}/templates/images/{design}/forum/epingler_sujet.png" alt="Epingler" /></a>';
	}
	else{
		$epingle = '';
	}
	$data = parse_var($data,array('titre_page'=>$niveau['sujet']['titre'].' - '.SITE_TITLE,'repondre'=>$repondre,'liste_page'=>$liste_page,'niveau_cat_id'=>$niveau['cat']['id'],
	'niveau_cat_titre'=>$niveau['cat']['titre'],'niveau_cat_titre_url'=>$niveau['cat']['titre_url'],
	'niveau_forum_id'=>$niveau['forum']['id'],'niveau_forum_titre'=>$niveau['forum']['titre'],
	'niveau_forum_titre_url'=>$niveau['forum']['titre_url'],'niveau_sujet_id'=>$niveau['sujet']['id'],
	'niveau_sujet_titre'=>$niveau['sujet']['titre'],'niveau_sujet_titre_url'=>$niveau['sujet']['titre_url'],'opcl'=>$opcl,'epingle'=>$epingle,'deplacer'=>$deplacer,'design'=>$_SESSION['design'],'ROOT'=>''));
}
else{
	$message = 'Vous n\'avez pas accé à ce forum.';
	$redirection = 'Javascript:history.go(-1)';
	$data = display_notice($message,'important',$redirection);
}
?>
