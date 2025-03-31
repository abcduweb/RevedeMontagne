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

	if(!empty($_GET['sortie']))
	{
		$sortie = intval($_GET['sortie']);
				
		//Je selectionne la fiche en question
		$reponse =  $db->requete("SELECT * FROM sortie WHERE id_sortie = '".$sortie."' AND id_m = '".$_SESSION['mid']."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);	
		if($_SESSION['mid'] == $donnees['id_m'] OR $auth['administrateur_topo'] == 1)
		{	
			$data = get_file(TPL_ROOT."sorties/ajout_photos.tpl");
			include(INC_ROOT.'header.php');
			$data = parse_var($data,array('idp'=>$sortie, 'titre_page'=>'Ajouter des photos - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
		}
		else
		{
			$message = 'Vous n\'avez pas le droit d\'ajouter des photos à cette sortie';
			$redirection = 'javascript:history.back(-1);';
			$data = display_notice($message,'important',$redirection);
		}
		
	}else
	{
		$message = 'Veuillez choisir une sortie avant d\'ajouter une photo';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>