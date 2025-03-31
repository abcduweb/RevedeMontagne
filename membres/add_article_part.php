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
	$redirection = ROOT.'index.php';
	echo display_notice($message,'important',$redirection);
}
else
{
	if(isset($_GET['artid']) AND !empty($_GET['artid'])){
		$id_article = intval($_GET['artid']);
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		$sql = "SELECT * FROM articles_intro_conclu LEFT JOIN articles_part ON (articles_part.id_article_attach = articles_intro_conclu.id_article) WHERE articles_intro_conclu.id_article = '$id_article' ORDER BY articles_part.num ASC";
		$result = $db->requete($sql);
		$row = $db->fetch($db->requete($sql));
		if($auth['ajouter_article'] == 1 OR ($_SESSION['mid'] == $row['id_membre'] AND $auth['ajouter_article'] == 1)){
			$data = get_file(TPL_ROOT.'add_article_part.tpl');
			include(INC_ROOT.'header.php');
			$data = parse_var($data,array('ROOT'=>'','intro'=>'','id_article'=>$id_article,'titre_page'=>'Ajout d\'une partie à un article - '.SITE_TITLE,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
			echo $data;
		}
		else{
			$data = get_file(TPL_ROOT.'system_ei.tpl');
			if($auth['ajouter_article'] != 1)
				$message = 'Votre groupe ne peut pas ajouter/modifier d\'article. Ceci peut être que temporaire.';
			else
				$message = 'Vous n\'étes pas autorisé à modifier cet article.';
			$redirection = 'index.php';
			echo display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = 'Aucune partie de sélectionner.';
    	$redirection = 'javascript:history.back(-1);';
    	echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>
