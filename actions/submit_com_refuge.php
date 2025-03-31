<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
if (isset ($_SESSION['ses_id'])) {
	if(!empty($_GET['pid'])){
		$pid = intval($_GET['pid']);
		if (isset ($_POST['texte']) AND !empty ($_POST['texte']) AND strlen(trim($_POST['texte'])) > 2) {
			$sql = "SELECT nom_refuge, com_point.id_m AS id_m, date_ajout, UNIX_TIMESTAMP(date_ajout) FROM c_refuge 
					LEFT JOIN com_point ON com_point.id_point = c_refuge.id_point 
					WHERE c_refuge.id_point = '$pid' ORDER BY date_ajout DESC";
			$db->requete($sql);
			$row = $db->fetch_assoc();
			if($db->num() > 0){
				$sql = "SELECT ajouter_com FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
				$db->requete($sql);
				$right = $db->row();
				if($right[0] == 1){
					$date_limit = $row['UNIX_TIMESTAMP(date_ajout)'] + (60 * 60 * 24);
					//echo $row['date_ajout'].'-'.$date_limit.'-'.time();
					if($row['id_m'] != $_SESSION['mid'] OR ($row['id_m'] == $_SESSION['mid'] AND $date_limit < time())){
						$text_parser = zcode(stripslashes($_POST['texte']));
						//$text_parser = htmlentities($_POST['texte'],ENT_QUOTES);
						$text = htmlentities($_POST['texte'],ENT_QUOTES);
						if(!empty($_POST['sign']))
							$sign = 1;
						else
							$sign = 0;
						$sql = "INSERT INTO com_point VALUES('','$_SESSION[mid]','$pid',NOW(), '', '$text','$text_parser','$sign')";
						$db->requete($sql);
						$msg_id = $db->last_id();
						$message = "Votre commentaire a bien été ajouté.";
						$redirection = ROOT.'detail-'.title2url($row['nom_refuge']).'-'.$pid.'.html#r'.$msg_id;
						
						if(isset($_SESSION['tmp_Img'])){
							$sql = "UPDATE images SET tmp = '0' WHERE dir = '6' AND s_dir = '".$pid."' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
							$db->requete($sql);				
							if(isset($_SESSION['SsubDir']['tmp'])){
								$key = array_keys($_SESSION['SsubDir']['tmp']);
								unset($_SESSION['dir'.$key[0]]);
								unset($_SESSION['SsubDir']);
							}
							unset($_SESSION['tmp_Img']);
						}
						
						$data = display_notice($message,'ok',$redirection);
					}else{
						$message = "Vous êtes le dernier à avoir ajouter un commentaire. Vous devez donc attendre 24H avant d'ajouter un nouveau commentaire.";
						$redirection = ROOT.'detail-'.title2url($row['nom_refuge']).'-'.$pid.'.html';
						$data = display_notice($message,'important',$redirection);
					}
				}else{
					$redirection = ROOT.'detail-'.title2url($row['nom_refuge']).'-commentaires-'.$pid.'.html';
					$data = display_notice("Vous n'avez pas le droit d'ajouter de commentaires. Ceci n'est peut être que temporaire.",'important',$redirection);
				}
			}else{
				$data = display_notice("La fiche de ce refuge n'existe pas.",'important',ROOT.'album-photos.html');
			}
		}
	}else{
		$data = display_notice("Aucun refuge de sélectionner.",'important',ROOT.'album-photos.html');
	}
}else{
	$data = display_notice("Vous devez être enregistrer pour ajouter des commentaires.",'important',ROOT.'connexion.html');
}
$db->deconnection();
echo $data;