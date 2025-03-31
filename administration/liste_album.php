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
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	if($auth['ajouter_album'] == 1 OR $auth['supprimer_album'] == 1){
		$data = get_file(TPL_ROOT.'admin/liste_album.tpl');
		include(INC_ROOT.'header.php');
		$result = $db->requete('SELECT * FROM pm_album_photos ORDER BY id_categorie');
		while ($resultat = $db->fetch($result))
		{
			if($auth['supprimer_album'] == 1){
				$supprimer = '<a href="actions/album.php?action=4&amp;alid='.$resultat['id_categorie'].'">Supprimer</a>';
			}
			else{
				$supprimer = '';
			}
			if($auth['ajouter_album'] == 1){
				$deplacer = '<a href="actions/album.php?action=3&amp;alid='.$resultat['id_categorie'].'">Déplacer</a>';
			}
			else{
				$deplacer = '';
			}
			$resultat['regroupement'] = str_replace('/','',$resultat['regroupement']);
			$cat[$resultat['regroupement']][] = array($resultat['regroupement'].'.regroupement' => '<a href="album-'.title2url($resultat['nom_categorie']).'-c'.$resultat['id_categorie'].'.html">'.$resultat['nom_categorie'].'</a>', $resultat['regroupement'].'.nb' => $resultat['nb_images'],$resultat['regroupement'].'.supprimer'=>$supprimer,$resultat['regroupement'].'.deplacer'=>$deplacer);
		}
		foreach($cat as $key => $vars)
		{
			foreach($vars as $var)
			{
				$data = parse_boucle($key,$data,FALSE,$var);
			}
			$data = parse_boucle($key,$data,TRUE);
		}
		$data = parse_var($data,array('titre_page'=>'Album photos - '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
		$redirection = 'index.html';
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>