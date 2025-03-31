<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$data = get_file(TPL_ROOT."who-online.tpl");
include(INC_ROOT.'header.php');
$ligne = 1;
$result =  $db->requete("SELECT membres.id_m, membres.pseudo, autorisation_globale.nom_group FROM enligne LEFT JOIN membres ON membres.id_m = enligne.id_m_join LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE enligne.id_m_join != '0'");
while($donnees = $db->fetch_assoc()){
	$data = parse_boucle('ENLIGNE',$data,false,array('ligne'=>$ligne,'pseudo'=>$donnees['pseudo'],'mid'=>$donnees['id_m'],'groupe'=>$donnees['nom_group']));
	if($ligne == 1)
		$ligne = 2;
	else
		$ligne = 1;
}
$data = parse_boucle('ENLIGNE',$data,TRUE);
$data = parse_var($data,array('titre_page'=>'Liste des connectés - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'design'=>$_SESSION['design'],'ROOT'=>''));
echo $data;
$db->deconnection();
?>
