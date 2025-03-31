<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	if(!empty($_GET['m'])){
		$auth = $db->fetch_assoc($db->requete("SELECT modifier_com,ajouter_com FROM autorisation_globale WHERE autorisation_globale.id_group = $_SESSION[group]"));
		if($auth['ajouter_com'] == 1){
			$id_com = intval($_GET['m']);
			$db->requete('SELECT com_point.id_com, com_point.id_m, com_point.commentaire,com_point.attachSign, membres.pseudo, c_refuge.nom_refuge, c_refuge.id_refuge
							FROM com_point
							LEFT JOIN membres ON membres.id_m = com_point.id_m
							LEFT JOIN c_refuge ON c_refuge.id_point = com_point.id_point
							WHERE id_com = \''.$id_com.'\'');
			$row = $db->fetch_assoc();
			if($row['id_com'] != null AND ($_SESSION['mid'] == $row['id_m'] OR $auth['modifier_com'] == 1)){
				if(!empty($_POST['texte']) AND strlen(trim($_POST['texte'])) > 4){
					$text_parser = zcode(stripslashes($_POST['texte']));
					//$text_parser = htmlentities($_POST['texte'],ENT_QUOTES);
					$text = htmlentities($_POST['texte'],ENT_QUOTES);
					if($_SESSION['mid'] == $row['id_m']){
						$edit_part = '<div class="user_edit">Edité {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$row['pseudo'].'</a></div>';
					}
					else{
						$sql = "SELECT * FROM membres WHERE id_m = '$_SESSION[mid]'";
						$result = $db->fetch($db->requete($sql));
						$edit_part = '<div class="team_edit">Edité le {date_edit} par: <a href="membres-'.$_SESSION['mid'].'-fiche.html">'.$result['pseudo'].'</a></div>';
					}
					$text_parser .= $edit_part;
					
					if(!empty($_POST['sign']))
						$sign = 1;
					else
						$sign = 0;
					$db->requete("UPDATE com_point SET 
						commentaire = '$text', 
						commentaire_parser = '$text_parser',
						attachSign = '$sign', 
						date_edit = NOW() 
					WHERE id_com = '$id_com'");
					$message = 'Le commentaire a bien été édité.';		
					$redirection = ROOT.'detail-'.title2url($row['nom_refuge']).'-'.$row['id_refuge'].'.html';
					
					if(isset($_SESSION['tmp_Img'])){
							$sql = "UPDATE images SET tmp = '0' WHERE dir = '6' AND s_dir = '".$pid."' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
							$db->requete($sql);
							/*$sql = "INSERT INTO c_com VALUES('','$_SESSION[mid]','$pid',NOW(), '', '$text','$text_parser','$sign')";
							$db->requete($sql);*/
						
							if(isset($_SESSION['SsubDir']['tmp'])){
								$key = array_keys($_SESSION['SsubDir']['tmp']);
								unset($_SESSION['dir'.$key[0]]);
								unset($_SESSION['SsubDir']);
							}
							unset($_SESSION['tmp_Img']);
						}
						
						
					echo display_notice($message,'ok',$redirection);
				}else{
					$message = 'Votre commentaire est vide ou trop court';
					$redirection = 'javascript:history.back(-1);';
					echo display_notice($message,'important',$redirection);
				}
			}else{
				$message = 'Vous ne pouvez pas éditer ce message.';
				$redirection = 'javascript:history.back(-1);';
				echo display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = 'Vous n\'étes pas autorisé à ajouter de commentaires. Ceci peut être que temporaire.';
			$redirection = ROOT.'index.html';
			echo display_notice($message,'important',$redirection);
		}
	}else{
		$message = 'Aucun commentaire de sélectionner.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>