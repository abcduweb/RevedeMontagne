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
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
	
}
else
{	include(ROOT.'fonctions/discutions.fonction.php');	
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;
	//Calcul des pages//
	$nb_message_page = $_SESSION['nombre_sujet'];
	$retour = $db->requete("SELECT id_discution_l FROM discutions_lues WHERE id_membre = '$_SESSION[mid]' AND `in` = 1");
	$nb_enregistrement = $db->num($retour);
	$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);
	if($nombre_de_page < $page)	$page = $nombre_de_page;
	$limite = ($page - 1) * $nb_message_page;
	$liste_page = get_list_page_d('liste-mp-p',$page,$nombre_de_page);
	//fin//
	
	if($nb_enregistrement > 0){
		$data = get_file(TPL_ROOT.'discution.tpl');
		include(INC_ROOT.'header.php');
		$discPassed = array();
		$ligne = 1;
		$sql = "SELECT liste_discutions.id_discution AS mp_id, liste_discutions.titre AS mp_title, liste_discutions.sous_titre AS mp_subtitle,
		liste_discutions.nb_mp_reponse AS mp_nb_answer, liste_discutions.nb_mp_lecture AS mp_nb_read,
		E1.id_m_join AS creator_id,E1.invisible AS creator_invisible, E2.id_m_join AS puser_id, E2.invisible AS puser_invisible,
		MC.pseudo AS creator_name, MR.pseudo AS puser_name, creatorDisc.`in` AS creator_in, discutions_lues.id_dernier_mp_l AS rmp_id,
		messages_discution.id_m_disc AS lmp_id, messages_discution.`date` AS lmp_date
		FROM discutions_lues LEFT JOIN liste_discutions ON liste_discutions.id_discution = discutions_lues.id_discution_l LEFT JOIN messages_discution ON messages_discution.id_m_disc = liste_discutions.id_dernier_mp LEFT JOIN enligne AS E1 ON E1.id_m_join = liste_discutions.id_createur LEFT JOIN enligne AS E2 ON E2.id_m_join = messages_discution.id_m_post LEFT JOIN membres AS MC ON MC.id_m = liste_discutions.id_createur LEFT JOIN membres AS MR ON MR.id_m = messages_discution.id_m_post LEFT JOIN discutions_lues AS creatorDisc ON (creatorDisc.id_membre = liste_discutions.id_createur AND creatorDisc.id_discution_l = discutions_lues.id_discution_l)WHERE discutions_lues.in = 1 AND discutions_lues.id_membre = $_SESSION[mid] ORDER BY messages_discution.date DESC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		while($row = $db->fetch_assoc($result)){
			if(!in_array($row['mp_id'],$discPassed)){
				if(isset($row['puser_id']) AND $row['puser_invisible'] == 0)
	  				$p_online = 'online';
	  			else
	  				$p_online = 'offline';
	  			if(isset($row['creator_id']) AND $row['creator_invisible'] == 0)
	  				$c_online = 'online';
	  			else
	  				$c_online = 'offline';
	  			if($row['lmp_id'] > $row['rmp_id'])
	  				$flag = 'new';
	  			else
	  				$flag = 'no_new';
	  			
	  			if($row['creator_in'] == 0){
					$createur = '<strike><a href="membres-'.$row['creator_id'].'-fiche.html">'.$row['creator_name'].'</a></strike>';
				}
				else{
					$createur = '<a href="membres-'.$row['creator_id'].'-fiche.html">'.$row['creator_name'].'</a>';
				}
	  			$data = parse_boucle('DISCUTIONS',$data,false,array('ligne'=>$ligne, 'id_disc'=>$row['mp_id'],
	  			'titre_url'=>title2url($row['mp_title']),'c_enligne'=>$c_online,'p_enligne' => $p_online,
	  			'createur'=>$createur,'id_last_msg'=>$row['lmp_id'],
	  			'dernier_posteur'=>'<a href="membres-'.$row['puser_id'].'-fiche.html">'.$row['puser_name'].'</a>',
	  			'date'=>get_date($row['lmp_date'],$_SESSION['style_date']),'titre'=>$row['mp_title'],'sous_titre'=>$row['mp_subtitle'],
	  			'nb_reponse'=>$row['mp_nb_answer'],'nb_lecture'=>$row['mp_nb_read'],'liste_page_sujet'=>get_liste_page_mp($row['mp_nb_answer'],$row['mp_id'],title2url($row['mp_title'])),'flag'=>$flag));
	  			$discPassed[] = $row['mp_id'];
				if($ligne == 1)
					$ligne = 2;
				else
					$ligne = 1;
			}
		}
		$data = parse_boucle('DISCUTIONS',$data,TRUE);
		$data = parse_var($data,array('ROOT'=>'','design'=>$_SESSION['design'],'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des Messages Privés - '.SITE_TITLE));
	}
	else{
		$data = get_file(TPL_ROOT.'discution_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('ROOT'=>'','design'=>$_SESSION['design'],'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des Messages Privés - '.SITE_TITLE));
	}
	echo $data;
}
$db->deconnection();
?>
