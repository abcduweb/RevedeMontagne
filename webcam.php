<?php
define('ROOT','./');
require_once(ROOT.'fonctions/mini.fonction.php');
if(!empty($_GET['url'])){
	if(file_get_contents($_GET['url'])){
		$image  = file_get_contents($_GET['url']);
		$open = fopen(ROOT.'images/temp/tmpimg','w');
		fwrite($open,$image);
		fclose($open);
		miniaturisation('tmpimg',ROOT.'images/temp/');
		$size = getimagesize(ROOT.'images/temp/tmpimg');
		header("Content-type: ".$size['mime']);
		switch($size['mime']){
			case "image/jpeg":
				$image = imagecreatefromjpeg(ROOT.'images/temp/mini/tmpimg');
				imagejpeg($image);
			break;
			case "image/x-png":
				$image = imagecreatefrompng(ROOT.'images/temp/mini/tmpimg');
				imagepng($image);
			break;
			case "image/png":
				$image = imagecreatefrompng(ROOT.'images/temp/mini/tmpimg');
				imagepng($image);
			break;
			case "image/gif":
				$image = imagecreatefromgi(ROOT.'images/temp/mini/tmpimg');
				imagegif($image);
			break;
		}
	}
}else{
	echo 'rien';
}