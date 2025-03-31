<?php

/*
 * Créer le 15 sept. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: redimentionnement d'images
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if (!isset ($_SESSION['ses_id'])) {
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'index.php';
	echo display_notice($message,'important',$redirection);
} else {
	if (!empty ($_GET['pid']) AND !empty ($_GET['type'])) {
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		if (isset ($_GET['textarea'])) {
			$textarea = '-' . htmlentities($_GET['textarea'], ENT_QUOTES);
			$textarea2 = '&amp;textarea=' . htmlentities($_GET['textarea'], ENT_QUOTES);
		} else {
			$textarea = '';
			$textarea2 = '';
		}
		$pid = intval($_GET['pid']);
		if ($_GET['type'] == 1)
			$sql = "SELECT * FROM images LEFT JOIN images_folder ON images.dir = images_folder.id_folder WHERE id_image = '$pid' AND id_owner = '$_SESSION[mid]'";
		elseif ($_GET['type'] == 2)
			$sql = "SELECT * FROM pm_photos LEFT JOIN pm_album_photos ON pm_album_photos.id_categorie = pm_photos.id_categorie WHERE id_album = '$pid' AND mid = '$_SESSION[mid]'";
		else {
			$message = 'Action inconnue.';
			$redirection = 'upload.html';
			echo display_notice($message,'important',$redirection);
			$db->deconnection();
			exit;
		}
		$db->requete($sql);
		if ($db->num() > 0) {
			$data = get_file(TPL_ROOT . 'upload/redim.tpl');
			$data = parse_var($data, array (
				'titre_page' => 'Redimentionnement d\'image - '.SITE_TITLE,
				'design' => $_SESSION['design']
			));
			if ($_GET['type'] == 1) {
				$row = $db->fetch();
				$data = parse_boucle('PHOTOS', $data, TRUE);
				$data = parse_boucle('UPLOAD', $data, false, array (
					''
				), true);
				if (isset ($row['s_dir']) AND $row['s_dir'] != 0) {
					$sql = "SELECT * FROM $row[linkedTable] WHERE $row[linkedField] = $row[s_dir]";
					$row2 = $db->fetch($db->requete($sql));
					$data = parse_boucle("SUBDIR", $data, false, array (
						'idSubDir' => $row['s_dir'],
						'subDirTitle' => $row2[$row['displayField']]
					));
				}
				$data = parse_boucle("SUBDIR", $data, TRUE);
				$data = parse_boucle('UPLOAD', $data, TRUE);
				$data = parse_var($data, array (
					'id_photo' => $row['id_image'],
					'photo' => 'images/autres/' . ceil($row['id_image'] / 1000
				) . '/' . $row['nom'], 'textarea2' => $textarea2, 'dirTitle' => $row['name_folder'], 'idDir' => $row['dir'], 'textarea' => $textarea));
			} else {
				$row = $db->fetch();
				$data = parse_boucle("UPLOAD", $data, TRUE);
				$data = parse_boucle('PHOTOS', $data, false, array (
					'idDir' => title2url($row['regroupement']
				), 'idSubDir' => $row['id_categorie'], 'textarea' => $textarea), true);
				$data = parse_boucle('SUBDIRP', $data, false, array (
					'dirName' => $row['regroupement'],
					'subDirTitle' => $row['nom_categorie'],
					'photo' => 'images/album/' . ceil($row['id_album'] / 1000
				) . '/' . $row['fichier'], 'textarea2' => $textarea2));
				$data = parse_boucle("SUBDIRP", $data, true);
				$data = parse_boucle("PHOTOS", $data, true);
			}
		} else {			
			$message = 'Impossible de modifier cette image.';
			$redirection = 'upload.html';
			$data = display_notice($message,'important',$redirection);
		}
	} else {		
		$message = 'Aucune image de sélectioner.';
		$redirection = 'upload.html';
		$data = display_notice($message,'important',$redirection);
	}
	echo $data;
}
$db->deconnection();
?>