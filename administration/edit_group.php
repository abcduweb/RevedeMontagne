<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['group'] != 1){
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);
	
}
else{
	$data = get_file(TPL_ROOT.'admin/edit_group.tpl');
	$sql = "SELECT * FROM autorisation_globale";
	$result = $db->requete($sql);
	while($row = $db->fetch($result)){
		$data = parse_boucle("GROUPES",$data,false,array('nom'=>$row['nom_group'],'id'=>$row['id_group']));
	}
	$data = parse_boucle("GROUPES",$data,TRUE);
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>'Administration - Liste des groupes - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
?>
