<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
define('Z_ROOT','../phorum/');

$id_forum = (int)$_GET['f'];
$sql = "SELECT * FROM auth_list LEFT JOIN forum ON forum.id_f = auth_list.id_forum LEFT JOIN big ON big.id_b = forum.id_big LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.id_forum = '$id_forum'";

$result = $db->requete($sql);
$row = $db->fetch($result);
if($row['ajouter'] == 1)
{
	$data = get_file(TPL_ROOT.'forum/add_topic.tpl');
	include(INC_ROOT.'header.php');
	if($row['attach_sign'] == 1)
			$attach_sign = 'checked="checked"';
		else
			$attach_sign = '';
	$data = parse_var($data,array('texte'=>'','id_cat'=>$row['id_b'],'cat_titre'=>$row['nom_b'],'cat_titre_url'=>title2url($row['nom_b']),'niveaux_forum_titre'=>$row['nom'],'niveaux_forum_titre_url'=>title2url($row['nom']),'attache_sign'=>$attach_sign,'id_forum'=>$id_forum,'design'=>$_SESSION['design'],'titre_page'=>'Ajouter sujet - Pont diviseur','nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
else{
	$redirection = 'javascript:history.back(-1);';
	$message = "Vous ne pouvez pas ajouter de sujet dans ce forum.";
	echo display_notice($message,'important',$redirection);
}
$db->deconnection();
?>
