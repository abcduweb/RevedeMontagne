<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if((isset($_GET['num']) AND !empty($_GET['num'])) AND (isset($_GET['artid']) AND !empty($_GET['artid']))){
		$id_article = intval($_GET['artid']);
		$id_part = intval($_GET['num']);
		$sql = "SELECT * FROM articles_part LEFT JOIN articles_intro_conclu ON (articles_intro_conclu.id_article = articles_part.id_article_attach) WHERE id_article_attach = '$id_article' AND num = '$id_part'";
		$result = $db->requete($sql);
		$row = $db->fetch_assoc($result);
		if($db->num($result) > 0){
			if(($row['id_membre'] == $_SESSION['mid'] AND $auth['ajouter_article'] == 1) OR $auth['administrateur_article'] == 1){
				$data = get_file(TPL_ROOT.'edition_partie.tpl');
				include(INC_ROOT."header.php");
				$data = parse_var($data,array('ROOT'=>'','titre_article'=>$row['titre'],'id_article'=>$id_article,'id_part'=>$id_part,'titre'=>$row['titre_part'],'texte'=>$row['texte_part'],'design'=>$_SESSION['design'],'titre_page'=>'Edition d\'une partie d\'un article - '.SITE_TITLE));
				echo $data;
			}
			else{
				$message = 'Vous n\'étes pas autorisé à modifier cet article.';
				$redirection = 'index.php';
				echo display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = 'Cet article et/ou cette partie n\'existe pas/plus';
			$redirection = 'index.php';
			echo display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = 'Vous n\'avez pas sélectioné d\'article.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
else{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'index.php';
	echo display_notice($message,'important',$redirection);
}
$db->deconnection();
?>