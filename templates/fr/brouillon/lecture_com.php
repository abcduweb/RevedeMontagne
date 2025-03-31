<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$data = get_file(TPL_ROOT . 'lecture_com.tpl');
if (!empty ($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;
$id_news = intval($_GET['nid']);
$sql = "SELECT * FROM nm_news WHERE id_news = '$id_news'";
$news = $db->fetch($db->requete($sql));
$rights = array('modifier_news'=>0);
if($news['status_news'] == 1){
	if(isset($_GET['id_mes']) and !empty($_GET['id_mes'])){
		$page_com = intval($_GET['id_mes']);
		$num = $db->row($db->requete("SELECT COUNT(*) FROM nm_comnews WHERE idnews = $id_news AND id_com <= $page_com"));
		$page = ceil($num[0] / $_SESSION['nombre_message']);
	}

	//Calcul des pages//
	$nb_message_page = $_SESSION['nombre_message'];
	$retour = $db->requete('SELECT COUNT(*) FROM nm_comnews WHERE `idnews` = ' . $id_news . '');
	$nb_enregistrement = $db->row($retour);
	$nombre_de_page = ceil($nb_enregistrement[0] / $nb_message_page);
	if ($nombre_de_page < $page)
		$page = $nombre_de_page;
	$limite = ($page -1) * $nb_message_page;
	$liste_page = get_list_page($page, $nombre_de_page);
	//Fin
	$titre_page = 'Commentaires - ' . $news['titre'] . ' - '.SITE_TITLE;
}else{
	$sql = "SELECT modifier_news FROM autorisation_globale WHERE id_group = $_SESSION[group]";
	$db->requete($sql);	
	$rights = $db->fetch_assoc();
	$nombre_de_page = 0;
	$titre_page = 'Lecture news - ' . $news['titre'] . ' - '.SITE_TITLE;
}
if ($news['id_news'] == null) {
	$data = display_notice('Cette news n\'existe pas.','important','javascript:history.back(-1);');
} else if($news['status_news'] == 1 OR ($_SESSION['mid'] == $news['id_auteur'] OR $rights['modifier_news'] == 1)){
	if ($page > 1) {
		$nb_message_page++;
		$limite--;
	}
	if ($nombre_de_page > 0 AND $news['status_news'] == 1) {
		$result = $db->requete('SELECT m1.avatar AS avatar,m1.signature_parser AS signature, m1.id_m AS id_posteur,m1.pseudo AS posteur, m2.id_m AS id_auteur, auth1.img_group AS img_group, auth1.nom_group AS nom_group, auth2.ajouter_com AS ajouter_com, auth2.supprimer_com AS supprimer_com, auth2.modifier_com AS modifier_com, enligne.id_m_join AS id_m_join, enligne.invisible AS invisible, nm_comnews.attachSign AS attachSign, nm_comnews.com_parser AS com_parser, nm_comnews.date_edit AS date_edit, nm_comnews.com_date AS com_date, nm_comnews.id_com AS id_com FROM nm_comnews LEFT JOIN membres AS m1 ON m1.id_m = nm_comnews.mid LEFT JOIN enligne ON enligne.id_m_join = nm_comnews.mid LEFT JOIN membres AS m2 ON m2.id_m = \'' . $_SESSION['mid'] . '\' LEFT JOIN autorisation_globale AS auth2 ON auth2.id_group = m2.id_group LEFT JOIN autorisation_globale AS auth1 ON auth1.id_group = m1.id_group WHERE idnews = \'' . $id_news . '\' LIMIT ' . $limite . ',' . $nb_message_page . '');
		while ($row = $db->fetch($result)) {
			if (!isset ($authAdd))
				$authAdd = $row['ajouter_com'];
			if ($row['img_group'] != '')
				$img_group = '<img src="{DOMAINE}templates/' . $_SESSION['design'] . '/images/' . $row['img_group'] . '" alt="' . $row['nom_group'] . ' " />';
			else
				$img_group = $row['nom_group'];
			if ($row['supprimer_com'] == 1)
				$supprimer = '<a href="actions/supprimer_commentaire.php?m=' . $row['id_com'] . '"><img src="{DOMAINE}/templates/images/{design}/form/supprimer.png" alt="Supprimer" /></a>';
			else
				$supprimer = '';
			if ($row['modifier_com'] == 1 OR $_SESSION['mid'] == $row['id_posteur'])
				$modifier = '<a href="editer-commentaire-n' . $row['id_com'] . '.html"><img src="{DOMAINE}/templates/images/{design}/form/edit.png" alt="Editer" /></a>';
			else
				$modifier = '';

			if (isset ($row['id_m_join']) AND $row['invisible'] == 0)
				$status = "online";
			else
				$status = "offline";

			if ($row['avatar'] != '')
				$avatar = '<img src="' . $row['avatar'] . '" alt="avatar" />';
			else
				$avatar = '';

			if ($row['attachSign'] == 1)
				$signature = '<div class="signature"><hr/><br/>' . $row['signature'] . '</div>';
			else
				$signature = '';
			$comentaire = stripslashes($row['com_parser']);
			if($page > 1 and !isset($reprise)){
				$comentaire = '<div id="reprise">Reprise du message précèdent :</div>'.$comentaire;
				$reprise = true;
			}
			if($row['date_edit'] != 0){
				$comentaire = parse_var($comentaire,array('date_edit'=>get_date($row['date_edit'],$_SESSION['style_date'])));
			}
			$data = parse_boucle('COMM', $data, FALSE, array (
				'statut' => $status,
				'id_com'=>$row['id_com'],
				'pseudo' => '<a href="' . ROOT . 'membres-' . $row['id_posteur'] . '-fiche.html">' . $row['posteur'] . '</a>',
				'date_com' => get_date($row['com_date'],
				$_SESSION['style_date']
			), 'avatar' => $avatar, 'img_rang' => $img_group, 'editer' => $modifier, 'supprimer' => $supprimer, 'signature' => $signature, 'commentaire' => $comentaire));
		}
		$data = parse_boucle('COMM', $data, TRUE);
		if (isset ($_SESSION['ses_id']) AND $authAdd == 1)
			if($news['status_com'] == 1 AND $news['status_news'] == 1)
				$reponse = '<form action="' . ROOT . 'actions/submit_com_news.php?nid=' . $id_news . '" method="post">
				  		<h1>Ajouter un commentaire</h1>
				  		<textarea name="texte" rows="5" cols="40"></textarea>
				  		<input type="hidden" name="idcomment" value="' . $id_news . '"" /><br/>
				  		<input type="submit" value="Envoyer !" />
				  		</form>';
			else
				$reponse = 'Les commentaires de cette news sont fermés';
		else
			$reponse = 'Vous pouvez poster vos propres messages lorsque vous êtes <a href ="inscription.html">inscris</a>';
		
		include (INC_ROOT . 'header.php');
		$data = parse_var($data, array (
			'design' => $_SESSION['design'],
			'titre_page' => 'Commentaires - ' . $news['titre'] . ' - '.SITE_TITLE,
			'titre_news' => $news['titre'],
			'pseudo_auteur' => '<a href="membres-' . $news['id_auteur'] . '-fiche.html">' . $news['pseudo_auteur'] . '</a>',
			'date_news' => date('d/m/Y à H\hi',
			$news['date_news']
		), 'texte_news' => stripslashes($news['texte_parser']), 'reponse_rapide' => $reponse, 'nb_requetes' => $db->requetes,'ROOT'=>''));
		foreach($liste_page as $page_n){
			if($page_n == $page)
				$page_s = $page.' ';
			else
				$page_s = '<a href="commentaires-de-' . title2url($news['titre']) . '-n' . $id_news . '-p'.$page_n.'.html">'.$page_n.'</a> ';
			$data = parse_boucle('PAGES',$data,FALSE,array('page'=>$page_s));
		}
		$data = parse_boucle('PAGES',$data,TRUE);
	} else {
		$data = get_file(TPL_ROOT . 'lecture_com_empty.tpl');
		include (INC_ROOT . 'header.php');
		$sql = "SELECT ajouter_com FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
		$db->requete($sql);
		$auth = $db->fetch();
		if (isset ($_SESSION['ses_id']) AND $auth['ajouter_com'] == 1){
			if($news['status_com'] == 1)
				$reponse = '<form action="' . ROOT . 'actions/submit_com_news.php?nid=' . $id_news . '" method="post">
				  		<h1>Ajouter un commentaire</h1>
				  		<textarea name="texte" rows="5" cols="40"></textarea>
				  		<input type="hidden" name="idcomment" value="' . $id_news . '"" /><br/>
				  		<input type="submit" value="Envoyer !" />
				  		</form>';
			else
				$reponse = 'Les commentaires de cette news sont fermés';
		}
		else
			$reponse = 'Vous pouvez poster vos propres messages lorsque vous êtes <a href ="inscription.html">inscris</a>';	
		$data = parse_var($data, array (
			'design' => $_SESSION['design'],
			'titre_page' => $titre_page,
			'titre_news' => $news['titre'],
			'pseudo_auteur' => '<a href="' . ROOT . 'membres-' . $news['id_auteur'] . '-fiche.html">' . $news['pseudo_auteur'] . '</a>',
			'date_news' => date('d/m/Y à H\hi',
			$news['date_news']
		), 'texte_news' => stripslashes($news['texte_parser']), 'reponse_rapide' => $reponse, 'nb_requetes' => $db->requetes,'ROOT'=>''));
	}
}else{
	$data = display_notice("Vous n'avez pas le droit de lire cette news.","important",ROOT.'index.html');
}
echo $data;
$db->deconnection();
?>
