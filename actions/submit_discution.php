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
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = ROOT.'connexion.html';
	$type = 'important';
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$result = $db->requete($sql);
	$auth = $db->fetch($result);
	if($auth['mp'] == 1){
		if(isset($_POST['titre']) AND !empty($_POST['titre']) AND strlen(trim($_POST['titre'])) > 3){
			if(isset($_POST['dest']) AND !empty($_POST['dest']) AND strlen($_POST['dest']) > 3){
				$dests = explode("\r\n",$_POST['dest']);
				if($dests[count($dests) - 1] == "") unset($dests[count($dests) - 1]);
				if(count($dests) < 6){
					foreach($dests as $key=>$desti){
						$dests[$key] = "'".htmlentities($desti,ENT_QUOTES)."'";
					}
					$sql = "SELECT * FROM `membres` WHERE `pseudo` IN (".implode(",",$dests).") AND `status_m` = 1 AND id_m != '$_SESSION[mid]'";
					$result = $db->requete($sql);
					if($db->num() != count($dests)){
						$message = "Un des membres au moins ne peux recevoir de message ou n'existe pas.";
						$redirection = "javascript:history.back(-1);";
						echo display_notice($message,'important',$redirection);
						$db->deconnection();
						exit;
					}else{
						if(!empty($_POST['texte']) AND strlen(trim($_POST['texte'])) > 5){
							$titre = htmlentities($_POST['titre'],ENT_QUOTES);
							$description = htmlentities($_POST['description'],ENT_QUOTES);
							$text = $_POST['texte'];
							$text_parser = $db->escape(zcode($text));
							$text = htmlentities($text,ENT_QUOTES);
							if(isset($_POST['sign']))
								$attach_sign = 1;
							else
								$attach_sign = 0;
							$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]','$attach_sign')";
							$db->requete($sql);
							$id_m = $db->last_id();
							$sql = "INSERT INTO liste_discutions VALUES('','$titre','$description','$id_m','$_SESSION[mid]',".(count($dests)+1).",0,0)";
							$db->requete($sql);
							$id_d = $db->last_id();
							$sql = "UPDATE messages_discution SET id_disc = '$id_d' WHERE id_m_disc = $id_m";
							$db->requete($sql);
							while($row = $db->row($result)){
								if(!isset($sqlDest))
									$sqlDest = "INSERT INTO discutions_lues VALUES('$row[0]','$id_d',0,1)";
								else
									$sqlDest .= ",('$row[0]','$id_d',0,1)";
								if(file_exists(ROOT.'caches/.htcache_mpm_'.$row[0])){
									include(ROOT.'caches/.htcache_mpm_'.$row[0]);
									$img_mp = 'messages';
									$nb_mp++;
									write_cache(ROOT.'caches/.htcache_mpm_'.$row[0],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
								}
							}
							$db->requete($sqlDest);
							$sql = "INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$id_d',$id_m,1)";
							$db->requete($sql);
							$message = "Votre discution a bien été ajoutée.";
							$type = "ok";
							$redirection = ROOT."mp-$id_d-".title2url($titre).".html";
							if(isset($_SESSION['tmp_Img'])){
								$sql = "UPDATE images SET tmp = '0',s_dir='$id_d' WHERE dir = '5' AND s_dir = '0' AND tmp = '1'  AND id_owner = '$_SESSION[mid]'";
								$db->requete($sql);
								if(isset($_SESSION['SsubDir']['tmp'])){
									$key = array_keys($_SESSION['SsubDir']['tmp']);
									unset($_SESSION['dir'.$key[0]]);
									unset($_SESSION['SsubDir']);
								}
								unset($_SESSION['tmp_Img']);
							}
						}else{
							$message = "Votre message est trop court.";
							$type = "important";
							$redirection = "javascript:history.back(-1);";
						}
					}
				}else{
					$message = "Vous pouvez créer une discution pour 5 personnes maximum.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}	
			}else{
				$message = "Il faut entré au moins 1 destinataire.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
				
		}else{
			$message = "Vous n'avez pas entré de titre ou celui-ci est trop court.";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		}
	}else{
		$message = 'Vous ne pouvez pas créer de nouvelle discution. Ceci n\'est peut être que temporaire.';
		$type = 'important';
		$redirection = ROOT.'index.php';
	}
}
echo display_notice($message,$type,$redirection);;
?>
