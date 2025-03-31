<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT."fichemembre.tpl");
include(INC_ROOT.'header.php');
$midi = intval($_GET['midi']);
$reponse =  $db->requete("SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group LEFT JOIN enligne ON enligne.id_m_join = membres.id_m WHERE id_m = '$midi'");
if($db->num() > 0){
	$donnees = $db->fetch($reponse);
	if($donnees['website'] != '')
		$site = '<a href="'.$donnees['website'].'">'.$donnees['website'].'</a>';
	else
		$site = 'Aucun';
		
	if($donnees['id_m_join'] != 0)
		$connect = '<span class="en_ligne">'.$donnees['pseudo'].' est en ligne</span>';
	else
		$connect = '<span class="hors_ligne">'.$donnees['pseudo'].' est hors ligne</span>';

	$dateco = get_date($donnees['last_log'],$_SESSION['style_date']);
	$dateinsc = get_date($donnees['dateInscr'],$_SESSION['style_date']);
	if($donnees['img_group'] != ''){
		$rang = '<img src="'.DOMAINE.'/templates/images/{design}/grade/'.$donnees['img_group'].'" alt="'.$donnees['nom_group'].'"/>';
	}
	else{
		$rang = $donnees['nom_group'];
	}
	if($donnees['avatar'] != ''){
		$avatar = '<img src="'.$donnees['avatar'].'" alt="avatar" class="emplacement_avatar" />';
	}else{
		$avatar = '';
	}

	if($donnees['afficher_mail'] == 1){
		$mail = '<img src="includes/imageSpam.php?type=1&amp;id='.$donnees['id_m'].'" alt="email" />';
	}else{
		$mail = 'Le membre ne souhaite pas comuniquer son email.';
	}
	if($donnees['msn'] != ''){
		$msn = '<img src="includes/imageSpam.php?type=2&amp;id='.$donnees['id_m'].'" alt="msn" />';
	}else{
		$msn = "Aucune";
	}
	if($donnees['jabber'] != ''){
		$jabber = '<img src="includes/imageSpam.php?type=3&amp;id='.$donnees['id_m'].'" alt="jabber" />';
	}else{
		$jabber = 'Aucune';
	}
	if($donnees['aim'] != '')
		$aim = $donnees['aim'];
	else
		$aim = 'Aucun';
	if($donnees['icq'] != '')
		$icq = $donnees['icq'];
	else
		$icq = 'Aucun';
	$nbpost = $donnees['nb_post_m'];
	$nbsujet = $db->num($db->requete("SELECT * FROM topics WHERE id_auteur = '$donnees[id_m]'"));
	$nbimage = $db->num($db->requete("SELECT * FROM images WHERE id_owner = '$donnees[id_m]'"));
	$data = parse_var($data,array(
		'nom_membre' => $donnees['pseudo'],
		'connecté'=> $connect,
		'num_membre'=> $donnees['id_m'],
		'groupe_membre' => $rang,
		'date_visite' => $dateco,
		'mail_membre' => $mail,
		'MSN_membre' => $msn,
		'Jabber_membre' => $jabber,
		'AIM_membre' => $aim,
		'ICQ_membre' => $icq,
		'avatar_membre' => $avatar,
		'signature_membre' => stripslashes($donnees['signature_parser']),
		'naissance_membre' => date("d/m/Y",$donnees['naissance']),
		'pays' => $donnees['pays'],
		'site_membre' => $site,
		'date_insc' => $dateinsc,
		'nbpost'=>$nbpost,
		'nbsujet'=>$nbsujet,
		'nbimage'=>$nbimage,
		'interets_membre' => $donnees['interest'],
		'biographie_membre' => stripslashes($donnees['biographie_parser']),'design'=>$_SESSION['design'],'titre_page'=>$donnees['pseudo'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''
		));
}else{
	$message = 'Le membre demander n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
