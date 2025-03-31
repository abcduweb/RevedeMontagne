<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
define('Z_ROOT',ROOT.'./phorum/');

if(isset($_GET['limite']))
	$_GET['limite'] = $_GET['limite'];
else
	$_GET['limite'] = 1;
if(!isset($_GET['f']) and !isset($_GET['t'])){
	if(isset($_GET['c'])){
		//echo 'cc';
		include(Z_ROOT.'sources/forum.php');
	}
	else{
		$data = get_file(TPL_ROOT.'forum/forum.tpl');
		//echo 'bb';
		include(Z_ROOT.'sources/categorie.php');
	}
}
elseif(isset($_GET['f']) and !isset($_GET['t'])){
	$data = get_file(TPL_ROOT.'forum/sujet.tpl');
	//echo 'dd';
	include(Z_ROOT.'sources/sujet.php');
}
elseif(isset($_GET['f']) and isset($_GET['t']))
{
	//echo 'ee';
	include(Z_ROOT.'sources/message.php');
}
include(INC_ROOT.'header.php');
$data = parse_var($data,array('nb_requetes'=>$db->requetes,'ROOT'=>''));
echo $data;
$db->deconnection();
?>