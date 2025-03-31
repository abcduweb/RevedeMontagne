<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
include(ROOT.'fonctions/zcode.fonction.php');

if(isset($_SESSION['ses_id']))
{
	if((isset($_POST['titre']) AND strlen(trim($_POST['titre'])) > 1) AND (isset($_POST['intro']) AND strlen(trim($_POST['intro'])) > 1) AND isset($_POST['model'])){
		$titre = htmlentities($_POST['titre'],ENT_QUOTES);
		switch($_POST['model']){
			case 'vierge':
				$intro_parser = $db->escape(zcode($_POST['intro']));
				$intro = htmlentities($_POST['intro'],ENT_QUOTES);
				if(isset($_POST['conclu'])){
					$conclu_parser = $db->escape(zcode($_POST['conclu']));
					$conclu = htmlentities($_POST['conclu'],ENT_QUOTES);
				}else{
					$conclu_parser = '';
					$conclu = '';
				}
				$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
				$db->requete($sql);
				$id = $db->last_id();
			break;
			case 'topo':
				if(isset($_POST['type_topo'])){
					switch($_POST['type_topo']){
						case 'escalade':
							include('topos/escalade.php');
						break;
						case 'rocher':
							include('topos/escalade.php');
						break;
						case 'alpinisme':
							include('topos/alpinisme.php');
						break;
						case 'ski_rando':
							include('topos/ski.php');
						break;
						case 'rando':
							include('topos/rando.php');
						break;
						case 'cascade':
							include('topos/cascade.php');
						break;
						case 'refuge':
							include('topos/refuge.php');
						break;
						default:
							$message = "Type de topo inconnue.";
							$type = "important";
							$redirection = 'javascript:history.back(-1);';
							$db->deconnection();
							echo display_notice($message,$type,$tredirection);
							exit;
						break;
					}
				}else{
					$message = "Vous n'avez pas sélectionné de type de topo";
					$type = "important";
					$redirection = 'javascript:history.back(-1);';
					$db->deconnection();
					echo display_notice($message,$type,$redirection);
					exit;
				}
			break;
		}
		$message = "Votre article a bien été ajouté. Vous pouvez l'éditer et en suite demander à ce qu'il soit publié sur le site";
		$type = "ok";
		$redirection = ROOT."editer-article-$id.html";
		if(isset($_SESSION['tmp_Img'])){
			$sql = "UPDATE images SET s_dir = '$id',tmp = 0 WHERE dir = '4' AND tmp = 1 AND  s_dir = 0 AND id_owner = '$_SESSION[mid]'";
			$db->requete($sql);
			if(isset($_SESSION['SsubDir']['tmp'])){
        $key = array_keys($_SESSION['SsubDir']['tmp']);
        unset($_SESSION['dir'.$key[0]]);
        unset($_SESSION['SsubDir']);
      }
			unset($_SESSION['tmp_Img']);
		}
	}
	else{
		if(!isset($_POST['titre']) OR strlen(trim($_POST['titre'])) < 1)
			$message = "Vous n'avez pas entré de titre";
		elseif(!isset($_POST['intro']) AND strlen(trim($_POST['intro'])) < 1)
			$message = "Vous n'avez pas entré d'introduction";
		else
			$message = "Vous n'avez sélectioné aucun modèle d'article";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
	}
}
else
{
	$message = "Vous devez être enregistrer pour ajouter/modifier/supprimer un article";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
