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
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'connexion.html';
	$data = display_notice($message,'important',$redirection);
	
}
else
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if(isset($_GET['pid']) AND !empty($_GET['pid'])){
		$pid = intval($_GET['pid']);
		$sql = "SELECT * FROM pm_photos WHERE id_album = '$pid'";
		$result = $db->requete($sql);
		if($db->num($result) > 0){
			$data = get_file(TPL_ROOT.'admin/modifier_photo.tpl');
			$row = $db->fetch($result);
			if(($row['mid'] == $_SESSION['mid'] AND $auth['ajouter_photo'] == 1) OR $auth['supprimer_photo'] == 1){
				include(INC_ROOT.'header.php');
				$data = parse_var($data,array('titre_photo'=>$row['titre'],'texte'=>$row['commentaire'],'ROOT'=>'','design'=>$_SESSION['design'],'titre_page'=>'Modifier photos - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'id'=>$pid));
			}
			else{
				$message = "Vous n'avez pas le droit de modifier cette photo.";
				$redirection = "index.html";
				$data = display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = "La photo sélectionnée n'existe pas.";
			$redirection = "admin.html";
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = "Vous n'avez sélectionné aucune photo.";
		$redirection = "admin.html";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>