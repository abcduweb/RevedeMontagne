<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['group'] == 1){
	$sql = "SELECT * FROM autorisation_globale LEFT JOIN auth_list ON (auth_list.id_group = autorisation_globale.id_group AND id_forum = 1)";
	$result = $db->requete($sql);
	$onoff = array(1=>'checked="checked"',0=>'',''=>'');
	$data = get_file(TPL_ROOT.'admin/add_cat.tpl');
	include(INC_ROOT.'header.php');
	while($row = $db->fetch($result)){
		$data = parse_boucle('GROUPES',$data,false,array('nom_group'=>$row['nom_group'],'id_group'=>$row['id_group'],
		'ajouter.checked' => $onoff[$row['ajouter']],
		'modifier_tout.checked' => $onoff[$row['modifier_tout']],
		'supprimer.checked' => $onoff[$row['supprimer']],
		'afficher.checked' => $onoff[$row['afficher']],
		'interdire_topics.checked' => $onoff[$row['interdire_topics']],
		'move.checked' => $onoff[$row['move']],
		'add_forum.checked' => $onoff[$row['add_forum']]));
	}
	$data = parse_boucle('GROUPES',$data,TRUE);
	$data = parse_var($data,array('titre_page'=>'Ajouter categorie de forums - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'design'=>$_SESSION['design'],'ROOT'=>''));
	echo $data;
}else{
	$message = "Vous n'avez pas accé à cette partie";
	$redirection = "index.html";
	echo display_notice($message,'important',$redirection);
}
$db->deconnection();
?>