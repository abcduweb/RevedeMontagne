<?php
/*
 * Créer le 26 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: le listing des photos
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id'])){
	$message = "Vous devez être enregistrer pour valider un article.";
	$redirection = "index.html";
	$data = display_notice($message,'important',$redirection);
}else{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
	$testTextarea = explode('?',$_SERVER['REQUEST_URI']);
	if(isset($testTextarea[1])){
		$textarea = explode('=',$testTextarea[1]);
		$textarea = htmlentities(str_replace('-','',$textarea[1]),ENT_QUOTES);
		$textareaUrl = '?textarea='.$textarea;
		$textareaRoot = '-'.$textarea;
  	}
  	else{
    	$textarea = '';
		$textareaUrl = '';
		$textareaRoot = '';
	}
	if(empty($_GET['dir']) and empty($_GET['sdir'])){
		$data = get_file(TPL_ROOT.'upload/dirPhotos.tpl');
		$sql = "SELECT regroupement FROM pm_album_photos";
		$result = $db->requete($sql);
		$regroupName = array();
		$b = 0;
		while($row = $db->fetch($result)){
			if(!in_array($row['regroupement'],$regroupName)){
				$regroupName[] = $row['regroupement'];
				if($b > 3){
					$b = -1;
					$endline = "</tr>\n<tr>";
				}
				else
					$endline = "";
				$data = parse_boucle("FOLDERS",$data,false,array('endline'=>$endline,'titreDir'=>$row['regroupement'],'idDir'=>title2url($row['regroupement'])));
				$b++;
			}
		}
		$data = parse_boucle("FOLDERS",$data,true);
		$data = parse_var($data,array('textareaRoot'=>$textareaRoot,'textarea'=>$textareaUrl,'design'=>$_SESSION['design'],'titre_page' => 'Album Photos - '.SITE_TITLE,'DOMAINE'=>DOMAINE));
	}else{
		if(!empty($_GET['dir']) and empty($_GET['sdir'])){
			$dir = htmlentities(str_replace('-','/',$_GET['dir']),ENT_QUOTES);
			$sql = "SELECT * FROM pm_album_photos WHERE regroupement = '$dir'";
			$result = $db->requete($sql);
			if($db->num($result) > 0){
				$data = get_file(TPL_ROOT.'upload/sdirPhotos.tpl');
				$b = 0;
				while($row = $db->fetch($result)){
					if($b > 3){
						$b = -1;
						$endline = "</tr>\n<tr>";
					}
					else
						$endline = "";
					$data = parse_boucle("FOLDERS",$data,false,array('titre_page'=>$row['regroupement'].' - '.SITE_TITLE,'dirName'=>$row['regroupement'],'endline'=>$endline,'titreDir'=>$row['nom_categorie'],'idSub'=>$row['id_categorie'],'idDir'=>title2url($row['regroupement'])));
					$b++;
				}
				$data = parse_boucle("FOLDERS",$data,true);
				$data = parse_var($data,array('textareaRoot'=>$textareaRoot,'textarea'=>$textareaUrl,'design'=>$_SESSION['design'],'DOMAINE'=>DOMAINE));
			}else{
				$message = "Cet album n'existe pas.";
				$redirection = "photos.html";
				$data = display_notice($message,'important',$redirection);
			}
		}elseif(!empty($_GET['dir']) and !empty($_GET['sdir'])){
			$sdir = intval($_GET['sdir']);
			$sql = "SELECT * FROM pm_album_photos WHERE id_categorie = '$sdir'";
			$result = $db->requete($sql);
			if($db->num($result) > 0){
				$data = get_file(TPL_ROOT.'upload/ssdirPhotos.tpl');
				$b = 0;
				$sql = "SELECT * FROM pm_photos WHERE id_categorie = '$sdir' AND mid = '$_SESSION[mid]'";
				$result2 = $db->requete($sql);
				while($row = $db->fetch($result2)){
					if($b > 3){
						$b = -1;
						$endline = "</tr>\n<tr>";
					}
					else
						$endline = "";
					if($textarea != ''){
                		$insert = '<a href="#" onclick="insere(\''.$textarea.'\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\')"><img src="'.DOMAINE.'/templates/{design}/images/inserer.png" alt="Insérer" title="Insérer" /></a>
		            	<a href="#" onclick="insere(\''.$textarea.'\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\',\''.DOMAINE.'/images/autres/{imgDir}/mini/{imgName}\')"><img src="'.DOMAINE.'/templates/{design}/images/inserer_miniature.png" alt="Insérer miniature" title="Insérer miniature" /></a>';
		          	}
		          	else{
                		$insert = '';
		          	}
		          	if($auth['ajouter_photo'] == 1){
		          		$supprimer = '<a href="actions/supprimer_photo.php?pid='.$row['id_album'].'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
		          	}else{
		          		$supprimer = '';
		          	}
					$data = parse_boucle('IMG',$data,false,array('supprimer'=>$supprimer,'titre'=>$row['titre'],'insert'=>$insert,'imgDir'=>ceil($row['id_album']/1000),'imgName'=>$row['fichier'],'legende'=>'img','endline'=>$endline));
					$b++;
				}
				$data = parse_boucle("IMG",$data,true);
				$row = $db->fetch($result);
				$data = parse_var($data,array('titre_page'=>$row['nom_categorie'].' - '.SITE_TITLE,'textareaRoot'=>$textareaRoot,'textarea'=>$textareaUrl,'idDir'=>title2url($row['regroupement']),'dirName'=>$row['regroupement'],'subDirTitle'=>$row['nom_categorie'],'idSubDir'=>$row['id_categorie'],'design'=>$_SESSION['design'],'DOMAINE'=>DOMAINE));
			}else{
				$message = "Cet album n'existe pas.";
				$redirection = "photos.html";
				$data = display_notice($message,'important',$redirection);
			}
		}
	}
}
echo $data;
$db->deconnection();
?>