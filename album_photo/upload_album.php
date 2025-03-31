<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT."album_photo/upload_album.tpl");
include(INC_ROOT.'header.php');


$data = parse_var($data,array('design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));


echo $data;
$db->deconnection();
?>