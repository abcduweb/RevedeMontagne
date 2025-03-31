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
	$redirection = 'index.php';
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
		$num = $db->num($result);
		if(($auth['ajouter_article'] == 1 OR ($_SESSION['mid'] == $row['id_membre'] AND $auth['ajouter_article'] == 1)) AND $num > 0){
			while($row = $db->fetch($result)){
				$titre = $row['titre'];
				$id_article = $row['id_article'];
				$intro = $row['intro'];
				$conclu = $row['conclu'];
				$part['nom'][] = $row['titre_part'];
				$part['num'][] = $row['num'];
			}
			$data = get_file(TPL_ROOT.'edition_article.tpl');
			include(INC_ROOT."header.php");
			if(isset($part['num'][0])){
				$data = parse_var($data,array('part_enter'=>"<table><thead><tr><th>Titre</th><th>Actions</th></tr></thead><tbody>",'part_out'=>'</tbody></table>'));
				foreach($part['nom'] as $key => $var){
					$data = parse_boucle('PARTIE',$data,false,array('part_titre'=>$var,'id_part'=>$part['num'][$key]));
				}
			}
			else{
				$data = parse_var($data,array('part_enter'=>'<div class="info">Pas de partie dans cette article. Veuillez en ajouter une au minimum','part_out'=>'</div>'));
			}
			$data = parse_boucle('PARTIE',$data,TRUE);
			$data = parse_var($data,array('titre'=>$titre,'id_article'=>$id_article,'intro'=>$intro,'conclu'=>$conclu,'titre_page'=>'Edition article - '.SITE_TITLE,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
			echo $data;
		}
		else{
			if($num == 0)
				$message = 'L\'article sélectionné n\'existe pas/plus.';
			else
				$message = 'Vous n\'étes pas autorisé à modifier cet article.';
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
$db->deconnection();
?>
