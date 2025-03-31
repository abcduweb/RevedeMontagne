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
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
else{
	if(isset($_POST['new_avatar'])){
		$avatar = htmlentities($_POST['new_avatar'],ENT_QUOTES);
	}
	elseif(isset($_POST['new_avatard'])){
		$avatar = htmlentities($_POST['new_avatard'],ENT_QUOTES);
	}else{
		$avatar = '';
	}
	if($avatar != ''){
		if(isset($_POST['new_avatar']))
			$size = getimagesize('../'.$avatar);
		else
			$size = getimagesize($avatar);
		if($size[1] > 132 AND $size[0] > 138){
			$message = 'Avatar trop grand.';
			$type = 'important';
			$redirection = 'javascript:history.back(-1);';
		}else{
			$sql  = "UPDATE membres SET avatar = '$avatar' WHERE id_m = '$_SESSION[mid]'";
			$db->requete($sql);
			$message = "Avatar changé.";
			$type = "ok";
			$redirection = ROOT."mes_options.html";
		}
	}else{
		$sql  = "UPDATE membres SET avatar = '$avatar' WHERE id_m = '$_SESSION[mid]'";
		$db->requete($sql);
		$message = "Avatar changé.";
		$type = "ok";
		$redirection = ROOT."mes_options.html";
	}
	
}
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>
