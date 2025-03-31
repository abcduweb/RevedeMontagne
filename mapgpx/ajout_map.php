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
	$data = get_file(TPL_ROOT.'mapgpx/ajout_map.tpl');
	if (isset($_GET['nid']) AND !empty($_GET['nid'])){
		$id = intval($_GET['nid']);
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		$row = $db->fetch($db->requete("SELECT * FROM map_gpx WHERE id_mapgpx = '$id'"));
		if($_SESSION['mid'] == $row['id_auteur'] OR ($auth['modifier_trace'] == 1 AND $auth['ajouter_trace'] == 1)){
			$titrenews = $row['titre'];
			$contenu = $row['texte'];
			$action_news = 'action=2&amp;nid='.$row['id_news'];
			$titre_page = "Edition d'une trace";
			if($_SESSION['mid'] == $row['id_auteur'])
				$urlupload = 'popupload-9{subDir}-texte.html';
			else
				$urlupload = 'upload-texte.html';
			$subDir = '-'.$row['id_news'];
		}
		else{
			$db->deconnection();
			$message = 'Vous n\'avez pas les droits pour modifier cette trace.';
			$redirection = 'index.php';
			$data = display_notice($message,'important',$redirection);
			exit($data);
		}
	}
	else{
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		if($auth['redacteur_topo'] == 1)
		{
			$idt = intval($_GET['idt']);
			$idmapgpx = $db->num($db->requete("SELECT * FROM topos WHERE id_topo = '".$idt."'"));
			if (!isset($idt) OR $idmapgpx == 0)
			{
				$db->deconnection();
				$message = 'Veuillez selectionner un topo pour ajouter votre fichier GPX';
				$redirection = 'javascript:history.back(-1);';
				$data = display_notice($message,'important',$redirection);
				exit($data);
			}
			else
			{
				$idact = intval($_GET['a']);
				$idt = intval($_GET['idt']);
				$titrenews = '';
				$contenu = '';
				$action_news = 'action=1';
				$titre_page = "Envoi d'une trace GPX";
				$urlupload = 'popupload-9-texte.html';
				$subDir = '';
				$data = parse_var($data,array('idact' => $idact, 'idt' => $idt));
			}
		}
		else{
			$db->deconnection();
			$message = 'Vous ne pouvez pas ajouter de trace. Ceci n\'est peut être que temporaire.';
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

