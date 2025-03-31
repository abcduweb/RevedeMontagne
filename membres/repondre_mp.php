<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'index.php';
	echo display_notice($message,'important',$redirection);
	
}
else{
	if(isset($_GET['idd']) AND !empty($_GET['idd']))
		$id_disc = intval($_GET['idd']);
	else{
		$message = 'Vous n\'avez sélectionné aucune discution.';
		$redirection = 'liste-mp.html';
		echo display_notice($message,'important',$redirection);
	}
	$sql = "SELECT * FROM discutions_lues WHERE id_discution_l = '$id_disc' AND id_membre = '$_SESSION[mid]' AND `in` = '1'";
	$result = $db->requete($sql);
	if($db->num($result) > 0){
		if(isset($_GET['id_mp']) AND !empty($_GET['id_mp'])){
			$id_mp = intval($_GET['id_mp']);
			$sql = "SELECT * FROM messages_discution LEFT JOIN membres ON membres.id_m = messages_discution.id_m_post WHERE id_m_disc = '$id_mp' AND id_disc = '$id_disc'";
			$result = $db->requete($sql);
			$msg = $db->fetch($result);
			$msg = '<citation nom="'.$msg['pseudo'].'">'.$msg['text'].'</citation>';
		}
		else
			$msg = '';
		$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE autorisation_globale.id_group = '$_SESSION[group]'";
		$result = $db->requete($sql);
		$auth = $db->fetch($result);
		if($auth['mp'] == 1){
			$data = get_file(TPL_ROOT.'repondre_mp.tpl');
			include(INC_ROOT.'header.php');
			$load_tpl = false;
			include(ROOT.'membres/lecture_discution.php');
			if($auth['attach_sign'] == 1)
				$attach_sign = 'checked="checked"';
			else
				$attach_sign = '';
			$data = parse_var($data,array('texte'=>'','attache_sign'=>$attach_sign,'titre_page'=>'Répondre - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'msg'=>$msg,'design'=>$_SESSION['design'],'ROOT'=>''));
		}
		else{
			$message = 'Vous ne pouvez pas répondre. Ceci n\'est peut être que temporaire.';
			$redirection = 'liste-mp.html';
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = 'Vous ne faite pas parti de cette discution.';
		$redirection = 'liste-mp.html';
		$data = display_notice($message,'important',$redirection);
	}
	echo $data;
}
?>