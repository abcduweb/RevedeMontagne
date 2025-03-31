<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistr&eacute; pour pouvoir acc&eacute;der à cette partie.';
	$redirection = ROOT.'connexion.html';
	$type = 'important';
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$result = $db->requete($sql);
	$auth = $db->fetch($result);
	if($auth['mp'] == 1){
		$data = get_file(TPL_ROOT.'system_ei.tpl');
		if(isset($_GET['idd']) AND !empty($_GET['idd'])){
			$id_disc = intval($_GET['idd']);
			$sql = "SELECT * FROM discutions_lues LEFT JOIN liste_discutions ON liste_discutions.id_discution = discutions_lues.id_discution_l WHERE discutions_lues.id_discution_l = '$id_disc' AND discutions_lues.`in` = 1";
			$result = $db->requete($sql);
			$destinataire = array();
			$in_discution = false;
			while($row = $db->fetch($result)){
				$titre = $row['titre'];
				if($row['id_membre'] != $_SESSION['mid']){
					$destinataire[] = $row['id_membre'];
				}
				else{
					$in_discution = true;
				}
			}
			if($in_discution AND count($destinataire) > 0){
				if(isset($_POST['texte']) AND !empty($_POST['texte']) AND strlen(trim($_POST['texte'])) > 1){
					$sql = 'SELECT * FROM `messages_discution` LEFT JOIN discutions_lues ON (discutions_lues.id_membre = \''.$_SESSION['mid'].'\' AND discutions_lues. id_discution_l = messages_discution.id_disc AND discutions_lues.`in` = 1) WHERE messages_discution.id_m_disc > discutions_lues.id_dernier_mp_l AND messages_discution.id_disc = \''.$id_disc.'\'';
					$db->requete($sql);
					$nb_new_mp = $db->num();
					
					$text = $_POST['texte'];
					$text_parser = $db->escape(zcode($text));
					$text = htmlentities($text,ENT_QUOTES);
					if(isset($_POST['sign']))
						$attach_sign = 1;
					else
						$attach_sign = 0;
					$sql = "INSERT INTO messages_discution VALUES('','$id_disc','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]','$attach_sign')";
					$db->requete($sql);
					$id_mp = $db->last_id();
					$sql = "UPDATE liste_discutions SET id_dernier_mp = '$id_mp', nb_mp_reponse = nb_mp_reponse + 1 WHERE id_discution = '$id_disc'";
					$db->requete($sql);
					foreach($destinataire as $id){
						if(file_exists(ROOT.'caches/.htcache_mpm_'.$id)){
							include(ROOT.'caches/.htcache_mpm_'.$id);
							$img_mp = 'messages';
							$nb_mp++;
							write_cache(ROOT.'caches/.htcache_mpm_'.$id,array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
						}
					}
					$sql = "UPDATE discutions_lues SET id_dernier_mp_l = '$id_mp' WHERE id_membre = '$_SESSION[mid]' AND id_discution_l = '$id_disc'";
					$db->requete($sql);
					
					$message = "Votre r&eacute;ponse a bien &eacute;t&eacute; ajout&eacute;e.";
					$type = "ok";
					$redirection = ROOT."mp-$id_disc-gotoL-".title2url($titre).".html#r$id_mp";
					
					if(isset($_SESSION['tmp_Img'])){
					$sql = "UPDATE images SET tmp = '0' WHERE dir = '".$_SESSION['tmp_Img']['dir'][0]."' AND s_dir = '".$_SESSION['tmp_Img']['subDir'][0]."' AND tmp = '1' AND id_owner = '$_SESSION[mid]'";
					if(isset($_SESSION['SsubDir']['tmp'])){
					$key = array_keys($_SESSION['SsubDir']['tmp']);
					unset($_SESSION['dir'.$key[0]]);
					unset($_SESSION['SsubDir']);
					
            }
            unset($_SESSION['tmp_Img']);
					}
					if($nb_new_mp > 0){
						if(file_exists(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid'])){
							include(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid']);
							$nb_mp = $nb_mp - $nb_new_mp;
							$img_mp = 'no_message';
							write_cache(ROOT.'caches/.htcache_mpm_'.$_SESSION['mid'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>ROOT,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
						}
					}
				}
				else{
					$message = 'Votre message est trop court.';
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
			else{
				if(!$in_discution)$message = "Vous ne faite pas/plus parti de cette discution.";
				if(count($destinataire) < 1)$message = "Vous ne pouvez plus ajouter de message dans cette discution, car il n'y a plus de destinataire.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
		}
		else{
			$message = "Aucune discution de s&eacute;lectionner";
			$type = "important";
			$redirection = ROOT."liste-mp.html";
		}
	}
	else{
		$message = "Vous ne pouvez pas ajouter de message. Ceci n'est peut être que temporaire.";
		$type = "important";
		$redirection = ROOT."mp-$id_disc-".title2url($titre).".html";
	}
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
