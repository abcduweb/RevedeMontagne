<?php
require_once(ROOT.'fonctions/commun.fonction.php');
require_once(ROOT.'fonctions/categorie.fonction.php');

$id_big = intval($_GET['c']);
$sql = "SELECT * FROM big LEFT JOIN forum ON forum.id_big = big.id_b LEFT JOIN topics ON forum.id_last_topics = topics.id_t LEFT JOIN messages ON topics.id_last_message = messages.id_ms LEFT JOIN auth_list ON (forum.id_f = auth_list.id_forum AND auth_list.afficher = 1) LEFT JOIN messages_lus ON (messages_lus.topics_id = forum.id_last_topics AND messages_lus.id_membre = '$_SESSION[mid]') LEFT JOIN enligne ON enligne.id_m_join = messages.id_utilisateur WHERE auth_list.id_group = '$_SESSION[group]' AND big.id_b = $id_big ORDER BY id_f ASC";
$db->requete($sql);
if($db->num() > 0){
	$data = get_file(TPL_ROOT.'forum/categorie.tpl');
	$ligne = 1;
	while($row = $db->fetch()){
		if(!isset($titre_theme))$titre_theme = $row['nom_b'];
		$titre_forum = $row['nom'];
		$titre_url = title2url($row['nom']);
		$id_forum = $row['id_f'];
		$description = $row['description'];
		$nombre_de_reponse = $row['nb_reponse_t'];
		$nombre_de_sujet = $row['nb_topic'];
		$date_dernier_message = get_date($row['date_m'],$_SESSION['style_date']);
		if(isset($row['id_m_join']) AND $row['invisible'] == 0)
				$online = 'online';
			else	
				$online = 'offline';
		if($row['id_last_message'] != null)
		{
			$id_dernier_message = $row['id_last_message'];
			$titre_dernier_sujet = $row['titre'];
			$titre_dernier_sujet_url = title2url($row['titre']);
			$id_dernier_sujet = $row['id_t'];
			$dernier_posteur = $row['utilisateur'];
			$id_dernier_posteur = $row['id_utilisateur'];
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
					$row['last_message_id'] = intval($_SESSION['tid'][$id_dernier_sujet]);
				else{
					$row['last_message_id'] = 0;
				}
			}else{
				$row['last_message_id'] = 0;
			}
		}		
		$drapeau = get_drapeau($row['last_message_id'],$id_dernier_message);
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
	$data = parse_var($data,array('titre_page'=>'Forum - {info_theme_titre} - '.SITE_TITLE,'id_cat'=>$id_big,'info_theme_titre'=>$titre_theme,'cat_titre_url'=>title2url($titre_theme),'design'=>$_SESSION['design'],'ROOT'=>''));
}else{
	echo display_notice('Vous n\'avez pas accé à ce forum','important','javascript:history.back(-1);');
}
?>