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
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
	if($auth['ajouter_photo'] == 1){
		$data = get_file(TPL_ROOT.'ajout_photos.tpl');
		include(INC_ROOT.'header.php');
		$categories = $db->requete('SELECT * FROM pm_album_photos ORDER BY id_categorie DESC');
		while ($reponse = $db->fetch($categories))
		{
			$data = parse_boucle('categ',$data,FALSE,array(
			'categ.nom' => $reponse['nom_categorie'],		
			'categ.id' => $reponse['id_categorie'],
			));
		}
		$data = parse_boucle('categ',$data,TRUE);
		$data = parse_var($data,array('texte'=>'','envoi'=>'','titre_page'=>'Ajouter une photo - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
		echo $data;
	}
	else{
		$message = 'Vous n\'étes pas autorisé à ajouter des photos. Ceci peut être que temporaire.';
		$redirection = 'inscription.html';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>