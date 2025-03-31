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
	$db->deconnection();
	exit;
} else {
	if (!empty ($_GET['m'])) {
		$id_m = intval($_GET['m']);
	} else {
		$message = "Aucun commentaire de sélectionner.";
		$redirection = "javascript:history.back(-1);";
		echo display_notice($message,'important',$redirection);
		$db->deconnection();
		exit;
	}
	$sql = "SELECT * FROM nm_comnews LEFT JOIN nm_news ON nm_news.id_news = nm_comnews.idnews WHERE nm_comnews.id_com = '$id_m'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	$id_news = $row['id_news'];
	if ($row['status_news'] == 1 AND $row['status_com'] == 1) {
		$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
		$row2 = $db->fetch($db->requete($sql));
		if (($row['mid'] == $_SESSION['mid'] AND $row2['ajouter_com'] == 1) OR ($row2['modifier_com'] == 1)) {
			$txt = $row['com'];
			if (!isset ($titreNews))
				$titreNews = $row['titre'];
			$data = get_file(TPL_ROOT . 'edit_com_news.tpl');
			include (INC_ROOT . 'header.php');
			$result = $db->requete('SELECT * FROM nm_comnews LEFT JOIN membres AS m1 ON m1.id_m = nm_comnews.mid LEFT JOIN enligne ON enligne.id_m_join = nm_comnews.mid LEFT JOIN membres AS m2 ON m2.id_m = \'' . $_SESSION['mid'] . '\' LEFT JOIN autorisation_globale AS auth2 ON auth2.id_group = m2.id_group LEFT JOIN autorisation_globale AS auth1 ON auth1.id_group = m1.id_group WHERE idnews = \'' . $id_news . '\' ORDER BY com_date DESC LIMIT 0,10');
			while ($row = $db->fetch($result)) {
				if ($row['img_group'] != '')
					$img_group = '<img src="' . DISPLAY_ROOT . 'templates/images/' . $_SESSION['design'] . '/' . $row['img_group'] . '" alt="' . $row['nom_group'] . ' " />';
				else
					$img_group = $row['nom_group'];
				if ($row['attach_sign'] == 1)
					$sign = $row['signature_parser'];
				else
					$sign = '';
				if (isset ($row['id_m_join']) AND $row['invisible'] == 0)
					$status = "online";
				else
					$status = "offline";

				if ($row[27] != '')
					$avatar = '<img src="' . $row[27] . '" alt="avatar" />';
				else
					$avatar = '';

				if ($row['attachSign'] == 1)
					$signature = '<div class="signature"><hr/><br/>' . $row[31] . '</div>';
				else
					$signature = '';
				$comentaire = stripslashes($row['com_parser']);
				if($row['date_edit'] != 0){
					$comentaire = parse_var($comentaire,array('date_edit'=>get_date($row['date_edit'],$_SESSION['style_date'])));
				}
				$data = parse_boucle('COMM', $data, FALSE, array (
					'statut' => $status,
					'pseudo' => '<a href="' . ROOT . 'membres-' . $row[8] . '-fiche.html">' . $row[11] . '</a>',
					'date_com' => get_date($row['com_date'],
					$_SESSION['style_date']
				), 'avatar' => $avatar, 'img_rang' => $img_group, 'signature' => $signature, 'commentaire' => $comentaire));
			}
			$data = parse_boucle('COMM', $data, TRUE);
			$data = parse_var($data, array (
				'design' => $_SESSION['design'],
				'titre_page' => 'Edition commentaires - ' . $titreNews . ' - '.SITE_TITLE,
				'titre_news' => $titreNews,
				'nb_requetes' => $db->requetes,
				'titre_news_url' => title2url($titreNews
			), 'id_news' => $id_news,'id_com'=>$id_m, 'texte' => $txt,'ROOT'=>''));
			echo $data;
		} else {
			$message = "Vous n'avez pas le droit de modifier ce commentaire.";
			$redirection = "javascript:history.back(-1);";
			echo display_notice($message,'important',$redirection);
		}
	} else {
		if ($row['status_news'] != 1)
			$message = "Cette news n'est pas encore validée.";
		elseif ($row['status_com'] != 1) $message = "Les commentaires de cette news sont désactivés.";
		$redirection = "javascript:history.back(-1);";
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>