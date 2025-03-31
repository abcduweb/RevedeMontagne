<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
//echo $_SESSION['ses_id'];
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{

	if(!empty($_GET['massif']))
	{
		
		$data = get_file(TPL_ROOT."depart/ajouter_un_depart.tpl");
			
		include(INC_ROOT.'header.php');
		$id_massif = intval($_GET['massif']);

		//On recherche les massifs
		$sql = $db->requete("SELECT * FROM massif WHERE id_massif = '".$id_massif."'");
		$massif = $db->fetch($sql);
		
		if (!isset($_GET['m']))
		{
		$data = parse_var($data,array('nom_depart'=>'', 'acces'=>'', 'altitude'=>''));
		}
		else
		{
		}
			
		$data = parse_var($data,array('lienpage'=>$_SERVER["HTTP_REFERER"],'edition'=>'','id_massif'=>$massif['id_massif'], 'nom_massif'=>$massif['nom_massif'], 'nom_massif_url'=>title2url($massif['nom_massif'])));		
			
		$data = parse_var($data,array('titre_page'=>'Ajouter un départ - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));

	}else
	{
		$message = 'Veuillez choisir un massif avant d\'ajouter un départ';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>