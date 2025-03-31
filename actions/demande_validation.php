<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

require_once(ROOT.'fonctions/zcode.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

if (isset ($_SESSION['ses_id'])) {
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$auth = $db->fetch($db->requete($sql));
	if (isset ($_GET['artid']) AND !empty ($_GET['artid'])) {
		$id_article = intval($_GET['artid']);
		$sql = "SELECT * FROM articles_intro_conclu WHERE id_article = '$id_article' AND article_status = 3";
		$result = $db->requete($sql);
		$row = $db->fetch($result);
		$num = $db->num($result);
		if ($row['id_membre'] == $_SESSION['mid']) {
			if ($num > 0) {
				if (isset ($_POST['cat'])) {
					$cat = explode('|', $_POST['cat']);
					$sql = "SELECT * FROM articles WHERE BD = '" . intval($cat[0]) . "'";
					$result = $db->requete($sql);
					if ($db->num($result) > 0) {
						$sql = "UPDATE articles_intro_conclu SET article_status = '2',id_cat = '" . intval($cat[0]) . "' WHERE id_article = '$id_article'";
						$db->requete($sql);
						$message = 'Votre demande a bien été prise en compte.';
						$type = 'ok';
						$redirection = DOMAINE . 'mes-articles.html';
						
						$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_article = 1";
						$validateur = $db->requete($sql);
						$num = $db->num($newser);
						if($num > 5){
							$limite = mt_rand(0,$num);
						}
						else
							$limite = 0;
						$text_parser = $db->escape(zcode($_POST['texte']));
						$text = htmlentities($_POST['texte'],ENT_QUOTES);
						$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
						$db->requete($sql);
						$idM = $db->last_id();
						$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_article = 1 LIMIT $limite,5";
						$validateur = $db->requete($sql);
						$sql = "INSERT INTO liste_discutions VALUES('','<strong>[ARTICLE]</strong> Demande de validation','',$idM,$_SESSION[mid],0,0,0)";
						$db->requete($sql);
						$idDiscu = $db->last_id();
						$nb_participant = 0;
						while($to = $db->fetch($validateur)){
							if($to['id_m'] != null AND $to['id_m'] != $_SESSION['mid']){
								$sql = "INSERT INTO discutions_lues VALUES('$to[id_m]','$idDiscu',0,1)";
								$db->requete($sql);
								if(file_exists(ROOT.'caches/.htcache_mpm_'.$to['id_m'])){
									include(ROOT.'caches/.htcache_mpm_'.$to['id_m']);
									$img_mp = 'messages';
									$nb_mp++;
									write_cache(ROOT.'caches/.htcache_mpm_'.$to['id_m'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
								}
								$nb_participant++;
							}
						}
						$db->requete("INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$idDiscu','$idM',1)");
						$nb_participant++;
						$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
						$db->requete("UPDATE liste_discutions SET nb_participant = '$nb_participant' WHERE id_discution = '$idDiscu'");
					} else {
						$message = 'La catégorie demandée n\'existe pas.';
						$type = 'important';
						$redirection = 'javascript:history.back(-1);';
					}
				} else {
					$data = get_file(TPL_ROOT . 'demandes.tpl');
					include (INC_ROOT . 'header.php');
					$url = 'demande-validation-'.$id_article.'.html';
					$autre = '<label for="cat">Ajouter dans : </label><select name="cat">';
					$sql = "SELECT * FROM articles AS T1 LEFT JOIN articles AS T2 ON ( T2.BG > T1.BG AND T2.BD < T1.BD AND T1.level = T2.level - 1)ORDER BY T1.`BG` ASC ";
					$result = $db->requete($sql);
					$i = 0;
					$cat = array ();
					$past = array ();
					while ($row = $db->fetch($result)) {
						if ($i == 0 OR $past[$i -1] != $row[1]) {
							$past[$i] = $row[1];
							$cat[$row[1]]['label'] = $row[2];
							$cat[$row[1]]['BD'] = $row[1];
							$cat[$row[1]]['level'] = $row[3];
							$added_scat = array ();
							$i++;
							if ($row['label'] != null) {
								$cat[$row[1]]['s_cat'][] = array (
									'label' => $row['label'],
									'BD' => $row['BD'],
									'level' => $row['level']
								);
								$added_scat[] = $row['BD'];
							}
						} else {
							if ($cat[$past[$i -1]]['level'] + 1 == $row['level'] AND !in_array($row['BD'], $added_scat)) {
								$cat[$past[$i -1]]['s_cat'][] = array (
									'label' => $row['label'],
									'BD' => $row['BD'],
									'level' => $row['level']
								);
								$added_scat[] = $row['BD'];
							}
						}
					}
					$autre .= develop($cat, $cat[$past[0]], 0);
					$autre .= '</select><br /><br />';
					$data = parse_var($data, array (
						'texte' => '',
						'titre_page' => 'Demande de validation - '.SITE_TITLE,
						'url' => $url,
						'autre' => $autre,
						'design' => $_SESSION['design'],
						'nb_requetes'=>$db->requetes,'ROOT'=>'../'
					));
					$db->deconnection();
					echo $data;
					exit;
				}
			} else {
				$message = "Cet article n'existe pas ou est déjà validé ou encore en cours de demande.";
				$type = "important";
				$redirection = ROOT . "index.php";
			}
		} else {
			$message = "Vous n'avez pas le droit de demmander une validation pour cet article.";
			$type = "important";
			$redirection = ROOT . "index.php";
		}
	} else {
		$message = "Aucun article de sélectionner.";
		$type = "important";
		$redirection = ROOT . "index.php";
	}
} else {
	$message = "Vous devez être enregistrer pour demander la validation d'un article.";
	$type = "important";
	$redirection = ROOT . "connexion.html";
}

$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>
