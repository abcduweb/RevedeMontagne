<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$auth = $db->fetch($db->requete($sql));
if($auth['id_group'] == 1)
{
	$data = get_file(TPL_ROOT . 'admin/lecture_newsletter.tpl');

	$id_newsletter = intval($_GET['nid']);
	$sql = "SELECT * FROM newsletter WHERE id_newsletter = '$id_newsletter'";
	$newsletter = $db->fetch($db->requete($sql));
	
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('titre_newsletter'=>$newsletter['titre'], 'texte_newsletter'=>$newsletter['texte_parser']));
	$data = parse_var($data,array('design'=>1,'nb_requetes'=>$db->requetes,'titre_page'=>'Newsletter - '.SITE_TITLE,'ROOT'=>''));
	
}
else
{
	$data = display_notice("Vous n'avez pas le droit de lire cette news.","important",ROOT.'index.html');
}
echo $data;
$db->deconnection();
?>
