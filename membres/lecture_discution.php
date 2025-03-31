<?php
if(!isset($load_tpl)){
	$load_tpl = true;
	########### A METTRE SUR CHAQUE PAGE ############
	session_start();							  # 
	define('ROOT', '../');                        #
	define('INC_ROOT', ROOT . 'includes/'); 	  #
	include (INC_ROOT . 'commun.php'); 			  #
	define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
	##########################################
}
include(ROOT.'fonctions/discution.fonction.php');
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);;
	
}
else{
	$id_disc = intval($_GET['idd']);
	if(!empty($_GET['limite']))
		$_GET['limite'] = $_GET['limite'];
	else
		$_GET['limite'] = 1;
	$sql = "SELECT * FROM discutions_lues WHERE id_discution_l = '$id_disc' AND id_membre = '$_SESSION[mid]' AND `in` = '1'";
	$result = $db->requete($sql);
	if($db->num($result) > 0){
		if($load_tpl){
			$data = get_file(TPL_ROOT."lecture_discution.tpl");
			$ordre = "ASC";
		}
		else{
			$ordre = "DESC";
			$_GET['limite'] == 1;
		}
		if(!empty($_GET['id_mes'])){
			$id_mes = intval($_GET['id_mes']);
			$num = $db->num($db->requete("SELECT * FROM messages_discution WHERE id_disc = $id_disc AND id_m_disc <= $id_mes"));
			$page = ceil($num + 1 / $_SESSION['nombre_message']);
			$_GET['limite'] = $page;
		}
		
		if(isset($_SERVER['HTTP_REFERER']) AND $load_tpl){
			$old = parse_url($_SERVER['HTTP_REFERER']);
			$get_var_old = explode('-',$old['path']);
			$page_old = explode('/',$get_var_old[0]);
			$get_var_new = explode('-',$_SERVER['REQUEST_URI']);
			if(isset($get_var_old[1]) AND isset($get_var_new[1]) AND $get_var_old[1] != $get_var_new[1]){
				$db->requete("UPDATE liste_discutions SET nb_mp_lecture = nb_mp_lecture + 1 WHERE id_discution = '$id_disc'");
			}
		}
		else{
			if($load_tpl) $db->requete("UPDATE liste_discutions SET nb_mp_lecture = nb_mp_lecture + 1 WHERE id_discution = '$id_disc'");
		}
			
		$page = (int)$_GET['limite'];
		$result = $db->requete("SELECT * FROM messages_discution LEFT JOIN liste_discutions ON (liste_discutions.id_discution = '$id_disc') WHERE messages_discution.id_disc = '$id_disc'");
		$row = $db->fetch($result);
		$nb_total_message = $db->num($result);
		$nb_page = ceil($nb_total_message / $_SESSION['nombre_message']);
		if($page > $nb_page)$page = $nb_page;
		$titre_disc = $row['titre'];
		$titre_disc_url = title2url($titre_disc);
		$liste_page = get_liste_page_mp($page,$nb_page,$id_disc,$titre_disc_url);
		$page_limite = get_limite_mp($page);
		if($page > 1)
			$bounds = $_SESSION['nombre_message'] + 1;
		else
			$bounds = $_SESSION['nombre_message'];
		$sql = "SELECT * FROM messages_discution LEFT JOIN membres ON membres.id_m = messages_discution.id_m_post LEFT JOIN discutions_lues ON (discutions_lues.id_membre = '$_SESSION[mid]' AND discutions_lues.id_discution_l = '$id_disc') LEFT JOIN liste_discutions ON liste_discutions.id_discution = '$id_disc' LEFT JOIN enligne ON enligne.id_m_join = messages_discution.id_m_post LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE messages_discution.id_disc = '$id_disc' ORDER BY `date` $ordre LIMIT $page_limite,$bounds";
		
		$result = $db->requete($sql);
		$first = true;
		$nb_read = 0;
		$ligne = 1;
		while($row = $db->fetch($result))
		{
			$message['id'] = $row['id_m_disc'];
			$message['text'] = $row['text_parser'];
			$message['auteur'] = $row['pseudo'];
			$message['id_auteur'] = $row['id_m'];
			$message['date'] = get_date($row['date'],$_SESSION['style_date']);
			$message['signature'] = $row['signature_parser'];
			$message['attach_sign'] = $row['attach_sign_mp'];
			$message['avatar'] = $row['avatar'];
			$message['nom_group'] = $row['nom_group'];
			$message['image_group'] = $row['img_group'];
			$last_message_id = $row['id_dernier_mp_l'];
			$last_message_topics_id = $row['id_disc'];
			$last_message_id_in_discution = $row['id_dernier_mp'];
			if(!isset($createur))$createur = $row['id_createur'];
			if($message['avatar'] != null) $message['avatar'] = '<img src="'.$message['avatar'].'" alt="avatar de '.$message['auteur'].'" class="emplacement_avatar" />';
			if($row['img_group'] != '') $message['nom_group'] = '<img src="'.DOMAINE.'/templates/images/{design}/group/'.$message['image_group'].'" alt="'.$message['nom_group'].'" />';
			if($first AND $page > 1)
			{
				$message['text'] = '<div id="reprise">Reprise du message précèdent :</div>'.$message['text'];
				$first = false;
			}
			if($message['attach_sign'] == 1) $message['text'] .= '<div class="signature_message">'.$message['signature'].'</div>';
			if(isset($row['id_m_join']) AND $row['invisible'] == 0)
				$online = 'online';
			else	
				$online = 'offline';
			$data = parse_boucle('MESSAGES',$data,false,array('id_message'=>$message['id'],'date'=>$message['date'],
			'message'=>stripslashes($message['text']),'citation'=>'<a href="mpciter-'.$id_disc.','.$message['id'].'-'.$titre_disc_url.'.html"><img src="'.DOMAINE.'/templates/images/{design}/form/quote.png" alt="citer" /></a>',
			'avatar'=>$message['avatar'],'group'=>$message['nom_group'],'auteur'=>$message['auteur'],
			'id_auteur'=>$message['id_auteur'],'enligne'=>$online, 'ligne'=>$ligne));
			if($message['id'] > $last_message_id AND $load_tpl){
				$nb_read++;
			}
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('MESSAGES',$data,true);
		if($message['id'] > $last_message_id AND $load_tpl)
		{
			if($last_message_id == 0 AND $last_message_topics_id == 0)
			{	
				$sql = "INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$id_disc','".$message['id']."','1')";
			}
			else
			{
				$sql = "UPDATE discutions_lues SET id_dernier_mp_l = '".$message['id']."' WHERE id_membre = '$_SESSION[mid]' AND id_discution_l = '$id_disc'";
			}
			$db->requete($sql);		
			include(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid']);
			$nb_mp = $nb_mp - $nb_read;
			if($nb_mp == 0) $img_mp = 'no_message';
			write_cache(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>ROOT,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
		}
		if($load_tpl){
			include(INC_ROOT."header.php");
			$sql = "SELECT * FROM discutions_lues LEFT JOIN membres ON membres.id_m = discutions_lues.id_membre WHERE id_discution_l = '$id_disc'";
			$result = $db->requete($sql);
			$nb_participant = 0;
			while($row = $db->fetch($result)){
				if($row['in'] == 1){
					$tpl_in = '';
					$tpl_inend = '';
				}
				else{
					$tpl_in = '<strike>';
					$tpl_inend = '</strike>';
				}
				if($_SESSION['mid'] == $createur AND $tpl_in == ''){
					$supprimer_participant = '<a href="actions/supprimer_destinataire.php?idd={id_disc}&amp;did={id_participant}"><img src="templates/images/'.$_SESSION['design'].'/supprimer.png" alt="supprimer" /></a>';
				}
				else{
					$supprimer_participant = '';
				}
				if($row['id_m'] != $_SESSION['mid']){
					$data = parse_boucle("PARTICIPANTS",$data,false,array('supprimer'=>$supprimer_participant,'in'=>$tpl_in,'inend'=>$tpl_inend,'id_participant'=>$row['id_m'],'pseudo_participant'=>$row['pseudo']));
					if($tpl_in == '')$nb_participant++;
				}
			}
			$data = parse_boucle("PARTICIPANTS",$data,TRUE);
		}
		if($_SESSION['mid'] == $createur AND isset($nb_participant) AND $nb_participant < 6)
			$inviter = '<li><a href="inviter-{id_disc}-participant.html">Inviter</a></li>';
		else
			$inviter = '';
		if(isset($nb_participant) AND $nb_participant > 0)
			$repondre = '<a href="mprepondre-{id_disc}-{titre_url_disc}.html"><img src="'.DOMAINE.'/templates/images/{design}/MP/repondre.png" alt="Répondre" /></a>';
		else{
			$repondre = '<img src="'.DOMAINE.'/templates/images/{design}/MP/fermer.png" alt="Fermer" />';
		}
		$data = parse_var($data,array('nb_requetes'=>$db->requetes,'liste_page'=>$liste_page,'repondre'=>$repondre,'inviter'=>$inviter,'id_disc'=>$id_disc,'titre_disc'=>$titre_disc,'titre_url_disc'=>$titre_disc_url,'titre_page'=>'Message(s) Priv&eacute;(s) - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
		if($load_tpl) echo $data;
	}
	else{
		$message = 'Vous ne faites pas/plus parti de cette discution.';
		$redirection = 'liste-mp.html';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>