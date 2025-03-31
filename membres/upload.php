<?php
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
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
	if (isset ($_GET['textarea'])) {
		$textarea = '-' . htmlentities($_GET['textarea'], ENT_QUOTES);
		$textarea_photo = '?textarea='.htmlentities($_GET['textarea'],ENT_QUOTES);
	} else{
		$textarea = '';
		$textarea_photo = '';
	}
	if (!isset ($_GET['dir'])) {
		$sql = "SELECT * FROM images_folder";
		$result = $db->requete($sql);
		$data = get_file(TPL_ROOT . 'upload/root.tpl');
		$b = 1;
		while ($row = $db->fetch($result)) {
			if ($b > 3) {
				$b = -1;
				$endline = "</tr>\n<tr>";
			} else
				$endline = "";
			$data = parse_boucle('FOLDERS', $data, false, array (
				'idDir' => $row['id_folder'],
				'titreDir' => $row['name_folder'],
				'endline' => $endline
			));
			$b++;
		}
		$data = parse_boucle('FOLDERS', $data, TRUE);
		$data = parse_var($data, array (
			'titre_page' => 'Upload - '.SITE_TITLE
		));
	} else {
		$dir = intval($_GET['dir']);
		if (isset ($_GET['tmp']) AND $_GET['tmp'] == 1) {
			$_SESSION['dir' . $dir]['tmp'] = 1;
			if (isset ($_GET['subDir']))
				$_SESSION['SsubDir']['tmp'][$dir] = intval($_GET['subDir']);
		}
		$sql = "SELECT * FROM images_folder WHERE id_folder = '$dir'";
		$result = $db->requete($sql);
		if ($db->num($result) > 0) {
			$infoDir = $db->fetch($result);
			if (isset ($_GET['subDir']) AND $infoDir['linkedTable'] != 'none') {
				if (isset ($_GET['isTmp']) AND $_GET['isTmp'] == 1) {
					$isTmp = 1;
				} else {
					$isTmp = 0;
				}

				$subDir = intval($_GET['subDir']);
				$sql = "SELECT * FROM images LEFT JOIN $infoDir[linkedTable] ON $infoDir[linkedTable].$infoDir[linkedField] = images.s_dir WHERE images.s_dir = '$subDir' AND images.dir = '$dir' AND tmp = '0' AND images.id_owner = '$_SESSION[mid]'";
				$result = $db->requete($sql);
				if ($db->num($result) > 0 AND $isTmp == 0) {
					$data = get_file(TPL_ROOT . 'upload/subdir.tpl');
					if ($auth['ajouter_photo'] == 1) {
						if ($textarea != '')
							$textareaSend = '&amp;textarea=' . substr($textarea, 1);
						else
							$textareaSend = '';
						$data = parse_boucle('FORMUP', $data, FALSE, array (
							'textareaSend' => $textareaSend,
							'dirTitleForm' => $infoDir['name_folder'],
							'idDir' => $infoDir['id_folder']
						));
						$data = parse_boucle('FORMUP', $data, TRUE);
					}
					$b = 0;
					while ($row = $db->fetch($result)) {
						if ($infoDir['restricted'] == 1 AND ((isset ($row['id_auteur']) AND $row['id_auteur'] != $_SESSION['mid']) OR (isset ($row['id_membre']) AND $row['id_membre'] != $_SESSION['mid']))) {
							$message = 'Vous n\'avez pas accé à ce dossier';
							$redirection = 'upload-' . $dir . '.html';
							$db->deconnection();
							echo display_notice($message,'important',$redirection);							
							exit;
						} else {
							if (!isset ($subDirTitle))
								$subDirTitle = $row[$infoDir['displayField']];
							if ($b > 3) {
								$b = -1;
								$endline = "</tr>\n<tr>";
							} else
								$endline = "";
							if ($textarea != '') {
								$insert = '<a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\')"><img src="'.DOMAINE.'/templates/{design}/images/inserer.png" alt="Insérer" title="Insérer" /></a>
										            <a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\',\''.DOMAINE.'/images/autres/{imgDir}/mini/{imgName}\')"><img src="'.DOMAINE.'/templates/images/{design}/inserer_miniature.png" alt="Insérer miniature" title="Insérer miniature" /></a>';
							} else {
								$insert = '';
							}
							if($auth['ajouter_photo'] == 1){
		          				if($textarea != ''){
		          					$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'&amp;dir=\'\'&amp;ssdir=\'\'&amp;textarea='.substr($textarea, 1).'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
		          				}else{
		          					$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
		          				}
		          			}else{
		          				$supprimer = '';
							}
							$data = parse_boucle('IMG', $data, false, array ('supprimer'=>$supprimer,
								'insert' => $insert,
								'imgDir' => 'membre_'.$row['id_owner'].'/'.$row['dir'].'/'.$row['s_dir'],
								'imgName' => $row['nom'], 'legende' => 'img', 'endline' => $endline));
							$b++;
						}
					}
					$data = parse_boucle('IMG', $data, true);
					$data = parse_var($data, array ('titre_page'=>'{dirTitle} - {subDirTitle} - '.SITE_TITLE,
						'dirTitle' => $infoDir['name_folder'],
						'idSubDir' => $subDir,
						'subDirTitle' => $subDirTitle,
						'idSubDirForm' => $subDir
					));
				} else {
					if (isset ($_GET['subDir']) AND isset ($_SESSION['dir' . $dir]['tmp']) AND $_SESSION['dir' . $dir]['tmp'] == 1 AND isset ($_SESSION['SsubDir']['tmp'][$dir]) AND $_SESSION['SsubDir']['tmp'][$dir] == $_GET['subDir']) {
						$data = get_file(TPL_ROOT . 'upload/subdir.tpl');
						$sql = "SELECT * FROM images LEFT JOIN $infoDir[linkedTable] ON $infoDir[linkedTable].$infoDir[linkedField] = images.s_dir WHERE images.s_dir = '" . $_SESSION['SsubDir']['tmp'][$dir] . "' AND images.dir = '$dir' AND tmp = '1' AND images.id_owner = '$_SESSION[mid]'";
						$result = $db->requete($sql);
						if ($auth['ajouter_photo'] == 1) {
							if ($textarea != '')
								$textareaSend = '&amp;textarea=' . substr($textarea, 1);
							else
								$textareaSend = '';
							$data = parse_boucle('FORMUP', $data, FALSE, array (
								'textareaSend' => $textareaSend,
								'dirTitleForm' => 'Dossier temporaire',
								'idDir' => $infoDir['id_folder']
							));
							$data = parse_boucle('FORMUP', $data, TRUE);
						}
						if ($db->num($result) > 0) {
							$b = 0;
							while ($row = $db->fetch($result)) {
								if ($b > 3) {
									$b = -1;
									$endline = "</tr>\n<tr>";
								} else
									$endline = "";
								if ($textarea != '') {
									$insert = '<a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\')"><img src="'.DOMAINE.'/templates/images/{design}/inserer.png" alt="Insérer" title="Insérer" /></a>
											              <a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\',\''.DOMAINE.'/images/autres/{imgDir}/mini/{imgName}\')"><img src="'.DOMAINE.'/templates/images/{design}/inserer_miniature.png" alt="Insérer miniature" title="Insérer miniature" /></a>';
								} else {
									$insert = '';
								}
								if($auth['ajouter_photo'] == 1){
		          					if($textarea != ''){
		          						$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'&amp;textarea='.substr($textarea, 1).'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
		          					}else{
		          						$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
		          					}
		          				}else{
		          					$supprimer = '';
								}
								$data = parse_boucle('IMG', $data, false, array ('supprimer'=>$supprimer,
									'insert' => $insert,
									'imgDir' => 'membre_'.$row['id_owner'].'/'.$row['dir'].'/'.$row['s_dir'],
									'imgName' => $row['nom'], 'legende' => 'img', 'endline' => $endline));
								$b++;
							}
							$data = parse_boucle('IMG', $data, TRUE);
							$data = parse_var($data, array ('titre_page'=>'{dirTitle} - {subDirTitle} - '.SITE_TITLE,
								'dirTitle' => $infoDir['name_folder'],
								'subDirTitle' => 'Dossier Temporaire',
								'idSubDir' => $subDir . '-1',
								'idSubDirForm' => $subDir
							));
						} else {
							$data = parse_boucle('IMG', $data, TRUE);
							$data = parse_var($data, array ('titre_page'=>'{dirTitle} - {subDirTitle} - '.SITE_TITLE,
								'dirTitle' => $infoDir['name_folder'],
								'subDirTitle' => 'Dossier Temporaire',
								'idSubDir' => $subDir . '-1',
								'idSubDirForm' => $subDir
							));
						}
					} else {
						$message = 'Ce sous dossier n\'existe pas';
						$redirection = 'upload-' . $dir . '.html';
						$data = display_notice($message,'important',$redirection);
					}
				}
			} else {
				$data = get_file(TPL_ROOT . 'upload/dir.tpl');
				if ($auth['ajouter_photo'] == 1) {
					if ($textarea != '')
						$textareaSend = '&amp;textarea=' . substr($textarea, 1);
					else
						$textareaSend = '';
					$data = parse_boucle('FORMUP', $data, FALSE, array (
						'textareaSend' => $textareaSend,
						'dirTitle' => $infoDir['name_folder']
					));
				}
				$data = parse_boucle('FORMUP', $data, TRUE);
				if ($infoDir['linkedTable'] != 'none') {
					$sql = "SELECT * FROM images LEFT JOIN $infoDir[linkedTable] ON $infoDir[linkedTable].$infoDir[linkedField] = images.s_dir WHERE images.s_dir != '0' AND tmp = '0' AND images.id_owner = '$_SESSION[mid]' AND images.dir = '$dir' ORDER BY images.s_dir ASC";
					$result = $db->requete($sql);
					$nb_folder = $db->num($result);
					$b = 0;
					$passedSubdir = array ();
					if ($nb_folder > 0) {
						while ($row = $db->fetch($result)) {
							if (!in_array($row[$infoDir['linkedField']], $passedSubdir)) {
								if ($b > 3) {
									$b = -1;
									$endline = "</tr>\n<tr>";
								} else
									$endline = "";
								$data = parse_boucle('FOLDERS', $data, false, array (
									'idDir' => $dir,
									'idSub' => $row[$infoDir['linkedField']],
									'titreDir' => $row[$infoDir['displayField']],
									'endline' => $endline
								));
								$b++;
								$passedSubdir[] = $row[$infoDir['linkedField']];
							}
						}
					}
				} else {
					$nb_folder = 0;
				}
				if (!isset ($b))
					$b = 0;
				if (isset ($_SESSION['dir' . $dir]['tmp']) AND $_SESSION['dir' . $dir]['tmp'] == 1) {
					$nb_folder++;
					if ($b > 3) {
						$b = -1;
						$endline = "</tr>\n<tr>";
					} else
						$endline = "";
					$data = parse_boucle('FOLDERS', $data, false, array (
						'idDir' => $dir,
						'titreDir' => 'Dossier temporaire',
						'endline' => $endline,
						'idSub' => $_SESSION['SsubDir']['tmp'][$dir] . '-1'
					));
					$b++;
				}
				$data = parse_boucle('FOLDERS', $data, TRUE);
				$data = parse_var($data, array (
					'dirTitle' => $infoDir['name_folder']
				));
				$sql = "SELECT * FROM images WHERE dir = '$dir' AND s_dir = '0' AND tmp = '0' AND id_owner = '$_SESSION[mid]'";
				$result = $db->requete($sql);
				$nb_image = $db->num($result);
				if (!isset ($b))
					$b = 0;
				if ($nb_image > 0) {
					while ($row = $db->fetch($result)) {
						if ($b > 3) {
							$b = -1;
							$endline = "</tr>\n<tr>";
						} else
							$endline = "";
						if ($textarea != '') {
							$insert = '<a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\')"><img src="'.DOMAINE.'/templates/images/{design}/inserer.png" alt="Insérer" title="Insérer" /></a>
									              <a href="#" onclick="insere(\'' . substr($textarea, 1) . '\',\''.DOMAINE.'/images/autres/{imgDir}/{imgName}\',\'\',\''.DOMAINE.'/images/autres/{imgDir}/mini/{imgName}\')"><img src="'.DOMAINE.'/templates/images/{design}/inserer_miniature.png" alt="Insérer miniature" title="Insérer miniature" /></a>';
						} else {
							$insert = '';
						}
						if($auth['ajouter_photo'] == 1){
		          			if($textarea != ''){
	          					$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'&amp;textarea='.substr($textarea, 1).'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
	          				}else{
	          					$supprimer = '<a href="actions/supprimer_upload.php?pid='.$row['id_image'].'" title="supprimer cette image"><img src="'.DOMAINE.'/templates/images/{design}/cross.png" alt="supprimer" /></a>';
	          				}
		          		}else{
		          			$supprimer = '';
						}
						$data = parse_boucle('IMG', $data, false, array ('supprimer'=>$supprimer,
							'insert' => $insert,
							'imgDir' => 'membre_'.$row['id_owner'].'/'.$row['dir'].'/'.$row['s_dir'],
							'imgName' => $row['nom'], 'legende' => 'img', 'endline' => $endline));
						$b++;
					}
				}
				$data = parse_boucle('IMG', $data, TRUE);
				if ($nb_image == 0 AND $nb_folder == 0) {
					$data = get_file(TPL_ROOT . 'upload/emptydir.tpl');
					if ($auth['ajouter_photo'] == 1) {
						if ($textarea != '')
							$textareaSend = '&amp;textarea=' . substr($textarea, 1);
						else
							$textareaSend = '';
						$data = parse_boucle('FORMUP', $data, FALSE, array (
							'textareaSend' => $textareaSend
						));
						$data = parse_boucle('FORMUP', $data, TRUE);
					}
				}
				$data = parse_var($data, array ('titre_page'=>'{dirTitle} - '.SITE_TITLE,
					'idDir' => $infoDir['id_folder'],
					'dirTitle' => $infoDir['name_folder']
				));
			}
		} else {
			$message = 'Ce dossier n\'existe pas';
			$redirection = 'javascript:history.back(-1);';
			$data = display_notice($message,'important',$redirection);
		}
	}
	$data = parse_var($data, array (
		'textarea' => $textarea,'textarea_photo'=>$textarea_photo,
		'design' => $_SESSION['design'],'DOMAINE'=>DOMAINE
	));
	echo $data;
}
$db->deconnection();
?>
