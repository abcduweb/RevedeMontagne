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
	//print_r($orient_topo);
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_points'] == 1)
	{
		
		$depart = intval($_GET['d']);
		
		
		//Je selectionne la fiche en question
		$reponse =  $db->requete("SELECT *
									FROM departs
								  WHERE id_depart = '".$depart."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
		
		//Je vérifis qu'elle appartiens au membre en question
		
		if($_SESSION['mid'] == $donnees['id_m'])
		{
			
			$data = get_file(TPL_ROOT.'depart/edition_depart.tpl');
			include(INC_ROOT.'header.php');
		
	
			$data = parse_var($data,array('id_depart'=>$depart, 'nom_depart'=>$donnees['lieu_depart'], 'acces'=>$donnees['acces'],
										'altitude'=>$donnees['alt_depart'], 'lat'=>$donnees['lat_depart'],
										'lng'=>$donnees['long_depart']));
			
			
				
			$data = parse_var($data,array('lienpage'=>$_SERVER["HTTP_REFERER"], 'edition'=>'&e='.$depart, 'id_massif'=>$donnees['id_massif'], 'titre_page'=>'Edition du d&eacute;part '.$donnees['lieu_depart'].', '.$donnees['alt_depart'].'m - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
			echo $data;		
		}
		else
		{
			$message = 'Ce d&eacute;part ne vous appartient pas...';
			$redirection = 'liste-des-departs.html';
			echo display_notice($message,'important',$redirection);
		}
		
	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à ajouter un d&eacute;part. Ceci peut &eacute;tre que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>