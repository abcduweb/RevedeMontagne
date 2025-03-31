<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

function uploadDir($tmpDir,$virtualDir,$virtualSubdir,$indexFile,$maxSize){
//echo $tmpDir.'/'.$virtualDir.'/'.$virtualSubdir.'/'.$indexFile.'/'.$maxSize;  
global $db;
	$extention = array('image/png'=>".png",'image/jpeg'=>".jpeg","image/jpg"=>".jpg",'image/gif'=>'.gif','image/JPG'=>'.jpg','image/JPEG'=>'.jpeg');
	$mimetype = getimagesize($_FILES[$indexFile]['tmp_name']);
	$fileName = str_replace('.','',uniqid(mt_rand(),true)).$extention[strtolower($mimetype['mime'])];
	$titre = $_FILES[$indexFile]['name'];
	$up = upload($indexFile,$tmpDir,$fileName,$maxSize);
	if ($up['type'] == 'ok')//test upload valide;
	{
		$size = getimagesize($tmpDir.$fileName);
		if(isset($_SESSION['dir'.$virtualDir]['tmp']) AND $_SESSION['dir'.$virtualDir]['tmp'] == 1)
			$tmp = 1;
		else
			$tmp = 0;
		
		//$tmps = 1;
		
		//echo $_SESSION['mid'].'-'.$fileName.'-'.$titre.'-'.$_FILES['fichier']['size'].'-'.$size[1].'-'.$size[0].'-'.$virtualDir.'-'.$virtualSubdir.'-'.$tmp.'<br />';
		$mid = $_SESSION['mid'];
		$taille_fichier = $_FILES['fichier']['size'];
		$size1 = $size[1];
		$size0 = $size[0];
		$vdir = $virtualDir;

		//$db->requete("INSERT INTO images VALUES ('','$_SESSION[mid]','$fileName','$titre','".$_FILES['fichier']['size']."','$size[1]','$size[0]','$virtualDir','$virtualSubdir','$tmp')");
		$db->requete("INSERT INTO images VALUES ('','$mid','$fileName','$titre','$taille_fichier','$size1','$size0','$virtualDir','$virtualSubdir','$tmp')");

		
		$idimage = $db->last_id();
		//echo $idimage.'idimage';
		
		$dir = ceil($idimage/1000);
		if($tmp <> 0)
			$dossier = 'membre_'.$_SESSION['mid'].'/'.$virtualDir.'/'.$virtualSubdir;
		else
			$dossier = 'membre_'.$_SESSION['mid'].'/'.$virtualDir.'/temp';
		
		//echo $dossier;
		if(!is_dir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/')){
			mkdir(ROOT.'images/autres/membre_'.$_SESSION['mid']);
		}
		if(!is_dir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/'.$virtualDir.'/')){
			mkdir(ROOT.'images/autres/membre_'.$_SESSION['mid'].'/'.$virtualDir);
		}
	
			
		if(!is_dir(ROOT.'images/autres/'.$dossier)){
			mkdir(ROOT.'images/autres/'.$dossier);
			mkdir(ROOT.'images/autres/'.$dossier.'/mini');
		}
		rename($tmpDir.$fileName,ROOT.'images/autres/'.$dossier.'/'.$fileName);
		miniaturisation($fileName,ROOT.'images/autres/'.$dossier);
		
		//echo 'aa'.$_SESSION['dir'.$virtualDir]['tmp'].'aa';
		//if(isset($_SESSION['dossier'.$virtualDir]['tmp_name']) AND $_SESSION['dossier'.$virtualDir]['tmp_name'] == 1)
		if(isset($_SESSION['dir'.$virtualDir]['tmp']) AND $_SESSION['dir'.$virtualDir]['tmp'] == 1){
			$_SESSION['tmp_Img']['id'][] = $idimage;
			$_SESSION['tmp_Img']['img'][$idimage] = $fileName;
			$_SESSION['tmp_Img']['dossier'][] = $virtualDir;
			$_SESSION['tmp_Img']['subDir'][] = $virtualSubdir;
			//print_r ($_SESSION['tmp_Img']);
		}
		
		if ($virtualDir == 6)
		{
			$db->requete("INSERT INTO c_photos VALUES ('', '$titre', '$fileName', NOW(),'".$_SESSION['mid']."','$virtualSubdir')");
		}
		
	}
	//echo $tmp;
	//print_r ($_SESSION['tmp_Img']);
	return $up;
}
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez &ecirc;tre enregistr&eacute; pour pouvoir acc&eacute;der &agrave; cette partie.';
	$type = 'important';
	$redirection = ROOT.'membres/inscription.php';
}
else
{
	if(!empty($_GET['dir']))
	{
	  $dir = intval($_GET['dir']);
	  //echo $dir.'=>Dir';
	  $dir = $_GET['dir'];
		$poids_max = 10485760;
		$repertoire = '../images/temp/';
		
		$sql = "SELECT * FROM images_folder WHERE id_folder = $dir";
		$result = $db->requete($sql);
		if($db->num($result) == 0){
			$message = "Dossier innexistant";
			$redirection = "javascript:history.back(-1);";
			$data = display_notice($message,'important',$redirection);
			$db->deconnection();
			exit($data);
		}
		$infoDir = $db->fetch($result);
		
		if(!empty($_GET['subDir'])){
			$subDir = intval($_GET['subDir']);
			$sql = "SELECT * FROM ".$infoDir['linkedTable']." WHERE ".$infoDir['linkedField']." = '$subDir'";
			$result = $db->requete($sql);
			$num = $db->num($result);
			$row = $db->fetch($result);
			if($num == 0 OR ($infoDir['restricted'] == 1 AND ((isset($row['id_auteur']) AND $row['id_auteur'] != $_SESSION['mid']) OR (isset($row['id_membre']) AND $row['id_membre'] != $_SESSION['mid'])))){
				$message = "Dossier innexistant";
				$redirection = "javascript:history.back(-1);";
				$data = display_notice($message,'important',$redirection);
				$db->deconnection();
				exit($data);
			}
		} 
		else
		  $subDir = '0';
		$up = uploadDir($repertoire,$dir,$subDir,'fichier',$poids_max);
		
		$message = $up['message'];
		$type = $up['type'];
		if(isset($_GET['textarea']))
		  $textarea = '-'.htmlentities($_GET['textarea'],ENT_QUOTES);
		else
		  $textarea = '';
		if(isset($_SESSION['dir'.$dir]['tmp']) AND $_SESSION['dir'.$dir]['tmp'] == 1)
			$tmp = '-1';
		else
			$tmp = "";
		$redirection = ROOT.'upload-'.$dir.'-'.$subDir.$tmp.$textarea.'.html';
		
	}
	else
	{
		$message = 'Aucun repertoire de s&eacute;lectionner';
		$type = 'important';
		$redirection = 'javascript:history.back(-1)';
	}
}
echo display_notice($message,$type,$redirection);;
$db->deconnection();
?>
