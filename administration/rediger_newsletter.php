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
{
	$data = get_file(TPL_ROOT.'admin/rediger_newsletter.tpl');
	if (isset($_GET['nid']) AND !empty($_GET['nid'])){
		$id = intval($_GET['nid']);
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		$row = $db->fetch($db->requete("SELECT * FROM newsletter WHERE id_newsletter = '$id'"));
		if($auth['id_group'] == 1){
			$titrenews = $row['titre'];
			$contenu = $row['texte'];
			$action_news = 'action=2&amp;nid='.$row['id_newsletter'];
			$titre_page = "Edition d'une newsletter";
			$urlupload = 'upload-texte.html';
			$subDir = '-'.$row['id_newsletter'];
		}
		else{
			$db->deconnection();
			$message = 'Vous n\'avez pas les droits pour modifier cette news.';
			$redirection = 'index.php';
			$data = display_notice($message,'important',$redirection);
			exit($data);
		}
	}
	else{
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		if($auth['id_group'] == 1){
	  		$titrenews = '';
	  		$contenu = '';
	  		$action_news = 'action=1';
	  		$titre_page = "Rédaction d'une newsletter";
			$urlupload = 'popupload-1-texte.html';
	  		$subDir = '';
		}
		else{
			$db->deconnection();
			$message = 'Vous ne pouvez pas ajouter de news. Ceci n\'est peut être que temporaire.';
			$redirection = 'index.php';
			$data = display_notice($message,'important',$redirection);
			exit($data);
		}
	}
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('titre_page'=>$titre_page.' - '.SITE_TITLE,'titre'=>$titrenews,'texte'=>$contenu,'action_news'=>$action_news,'url_upload'=>$urlupload,'subDir'=>$subDir,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>
