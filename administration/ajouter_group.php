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
	echo display_notice($message,'important',$redirection);;
	
}
else{
	$data = get_file(TPL_ROOT.'admin/ajouter_group.tpl');
	include(INC_ROOT.'header.php');
	$sql = "SELECT * FROM forum LEFT JOIN big ON big.id_b = forum.id_big ORDER BY forum.id_big ASC";
	$result = $db->requete($sql);
	$curent_theme = 0;
	$j = 0;
	while($row = $db->fetch($result)){
		if($curent_theme != $row['id_b']){
			if($j != 0){
				$data = parse_boucle('FORUM',$data,TRUE);
				$data = imbrication('THEMES',$data);
			}
			$curent_theme = $row['id_b'];
			if(!isset($row['add_forum'])) $row['add_forum'] = 0;
			$j = 0;
			$data = parse_boucle('THEMES',$data,false,array('theme.titre'=>$row['nom_b'],'theme.id'=>$row['id_b']),true);
		}
		$data = parse_boucle('FORUM',$data,false,array('forum.titre'=>$row['nom'],'forum.id'=>$row['id_f']));
		$j++;
	}
	$data = parse_boucle('FORUM',$data,TRUE);
	$data = parse_boucle('THEMES',$data,TRUE);
	$data = parse_var($data,array('ROOT'=>'','design'=>$_SESSION['design'],'titre_page'=>'Ajouter un groupe - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'action'=>'Ajouter'));
	echo $data;
}
$db->deconnection();
?>
