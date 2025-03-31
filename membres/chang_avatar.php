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
	echo display_notice($message,'important',$redirection);;
}
else
{
	$data = get_file(TPL_ROOT.'chang_avatar.tpl');
	include(INC_ROOT.'header.php');
	$db->requete("SELECT * FROM images WHERE dir = 2 AND hauteur <= 132 AND largeur <= 138 AND id_owner = '$_SESSION[mid]'");
	while($avatars = $db->fetch()){
		$data = parse_boucle('AVATARUP',$data,false,array('dir'=>ceil($avatars['id_image'] / 1000),'fichier'=>$avatars['nom'],'titre'=>$avatars['titre']));
	}
	$data = parse_boucle('AVATARUP',$data,true);
	$sql = 'SELECT avatar FROM membres WHERE id_m = \''.$_SESSION['mid'].'\'';
	$db->requete($sql);
	$row = $db->fetch();
	if($row['avatar'] != '')
		$avatar = '<img src="'.$row['avatar'].'" alt="Avatar" />';
	else
		$avatar = '';
	$data = parse_var($data,array('avatar'=>$avatar,"design"=>$_SESSION['design'],"titre_page"=>"Changer Avatar - ".SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>