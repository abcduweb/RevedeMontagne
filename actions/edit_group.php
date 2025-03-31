<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if ($_SESSION['group'] == 1) {
	if ((isset ($_GET['gid']) AND !empty ($_GET['gid'])) AND (isset ($_POST['groupName']) AND !empty ($_POST['groupName']) AND strlen(trim($_POST['groupName'])) > 3)) {
		$id_group = intval($_GET['gid']);
		if (isset ($_POST['global']['modifier_news']))
			$modifier_news = 1;
		else
			$modifier_news = 0;
		if (isset ($_POST['global']['supprimer_news']))
			$supprimer_news = 1;
		else
			$supprimer_news = 0;
		if (isset ($_POST['global']['valider_news']))
			$valider_news = 1;
		else
			$valider_news = 0;
		if (isset ($_POST['global']['modifier_topo']))
			$modifier_topo = 1;
		else
			$modifier_topo = 0;
		if (isset ($_POST['global']['supprimer_topo']))
			$supprimer_topo = 1;
		else
			$supprimer_topo = 0;
		if (isset ($_POST['global']['ajouter_album']))
			$ajouter_album = 1;
		else
			$ajouter_album = 0;
		if (isset ($_POST['global']['supprimer_album']))
			$supprimer_album = 1;
		else
			$supprimer_album = 0;
		if (isset ($_POST['global']['supprimer_photo']))
			$supprimer_photo = 1;
		else
			$supprimer_photo = 0;
		if (isset ($_POST['global']['ban']))
			$punnir = 1;
		else
			$punnir = 0;
		if (isset ($_POST['global']['modifier_com']))
			$modifier_com = 1;
		else
			$modifier_com = 0;
		if (isset ($_POST['global']['supprimer_com']))
			$supprimer_com = 1;
		else
			$supprimer_com = 0;
		if (isset ($_POST['other']['photos']))
			$ajouter_s_photos = 1;
		else
			$ajouter_s_photos = 0;
		if (isset ($_POST['other']['news']))
			$ajouter_s_news = 1;
		else
			$ajouter_s_news = 0;
		if (isset ($_POST['other']['articles']))
			$ajouter_s_articles = 1;
		else
			$ajouter_s_articles = 0;
		if (isset ($_POST['other']['com']))
			$ajouter_s_com = 1;
		else
			$ajouter_s_com = 0;
		if (isset ($_POST['other']['mp']))
			$ajouter_mp = 1;
		else
			$ajouter_mp = 0;
		if (isset ($_POST['other']['redacOff']))
			$redacOff = 1;
		else
			$redacOff = 0;
		if (isset ($_POST['adminMenu'])) {
			if (!in_array($id_group, $team_group_id)) {
				$team_group_id[] = $id_group;
				$conf = '<?php ';
				$open = fopen(ROOT . 'includes/config.php', 'w');
				$conf .= '$sql_serveur = ' . var_export($sql_serveur, TRUE) . ';';
				$conf .= '$sql_login = ' . var_export($sql_login, TRUE) . ';';
				$conf .= '$sql_pass = ' . var_export($sql_pass, TRUE) . ';';
				$conf .= '$sql_bdd = ' . var_export($sql_bdd, TRUE) . ';';
				$conf .= '$team_group_id = ' . var_export($team_group_id, TRUE) . ';';
				$conf .= '$siteTitle = '.var_export($siteTitle,TRUE).';';
				$conf .= '?>';
				fwrite($open, $conf);
				fclose($open);
			}
		} else {
			if (in_array($id_group, $team_group_id)) {
				foreach ($team_group_id as $var) {
					if ($var != $id_group)
						$new_team_group_id[] = $var;
				}
				$conf = '<?php ';
				$open = fopen(ROOT . 'includes/config.php', 'w');
				$conf .= '$sql_serveur = ' . var_export($sql_serveur, TRUE) . ';';
				$conf .= '$sql_login = ' . var_export($sql_login, TRUE) . ';';
				$conf .= '$sql_pass = ' . var_export($sql_pass, TRUE) . ';';
				$conf .= '$sql_bdd = ' . var_export($sql_bdd, TRUE) . ';';
				$conf .= '$team_group_id = ' . var_export($new_team_group_id, TRUE) . ';';
				$conf .= '$siteTitle = '.var_export($siteTitle,TRUE).';';
				$conf .= '?>';
				fwrite($open, $conf);
				fclose($open);
			}
		}
		$groupName = htmlentities($_POST['groupName'], ENT_QUOTES);
		$sql = "UPDATE autorisation_globale SET punnir = '$punnir', modifier_news = '$modifier_news',supprimer_news = '$supprimer_news',valider_news = '$valider_news', modifier_topo = '$modifier_topo',supprimer_topo = '$supprimer_topo',ajouter_album = '$ajouter_album',supprimer_album = '$supprimer_album',supprimer_photo = '$supprimer_photo',modifier_com = '$modifier_com',supprimer_com = '$supprimer_com',nom_group = '$groupName',ajouter_photo = '$ajouter_s_photos',ajouter_news = '$ajouter_s_news',ajouter_article = '$ajouter_s_articles',ajouter_com = '$ajouter_s_com',mp = '$ajouter_mp',artOfficiel = '$redacOff' WHERE id_group = '$id_group'";
		$db->requete($sql);
		$sql = "SELECT * FROM forum";
		$result = $db->requete($sql);
		while ($row = $db->fetch($result)) {
			if (isset ($_POST['auth'][$row['id_f']])) {
				$add = 0;
				$modifier = 0;
				$supprimer = 0;
				$afficher = 0;
				$close = 0;
				$ban = 0;
				$move = 0;
				foreach ($_POST['auth'][$row['id_f']] as $key => $var) {
					${ $key } = 1;
				}
				if (!isset ($_POST['add_forum'][$row['id_big']]))
					$add_forum = 0;
				else
					$add_forum = 1;
			} else {
				$add = 0;
				$modifier = 0;
				$supprimer = 0;
				$afficher = 0;
				$close = 0;
				$ban = 0;
				$move = 0;
				$add_forum = 0;
			}
			$sql = "UPDATE auth_list SET ajouter = $add, modifier_tout = $modifier,supprimer = $supprimer, afficher = $afficher, interdire_topics = $close,move = $move,add_forum = $add_forum WHERE id_forum = '$row[id_f]' AND id_group = '$id_group'";
			$db->requete($sql);
		}
		$message = "Groupe edité!";
		$type = "ok";
		$redirection = ROOT . "editer-groupes.html";
	} else {
		if (isset ($_GET['gid']) AND !empty ($_GET['gid'])) {
			$id_group = intval($_GET['gid']);
			$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$id_group'";
			$result = $db->requete($sql);
			if ($db->num($result) < 0) {
				$data = get_file(TPL_ROOT . 'system_ei.tpl');
				$message = "Le groupe sélectionné n'existe pas!";
				$type = "important";
				$redirection = ROOT . "editer-groupes.html";
			}

		} else {
			$message = "Vous n'avez pas sélectioné de groupe!";
			$type = "important";
			$redirection = ROOT . "editer-groupes.html";
		}
		if (isset ($_POST['group']) OR !empty ($_POST['group'])) {
			$data = get_file(TPL_ROOT . 'system_ei.tpl');
			$message = "Vous n'avez pas donnée le nom du groupe!";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		} else {
			if (strlen(trim($_POST['group'])) < 4) {
				$message = "Le nom du groupe est trop court";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
		}
	}
} else {
	$message = "Vous n'avez pas accé à cette partie!";
	$type = "important";
	$redirection = ROOT . "admin.html";
}
echo display_notice($message,$type,$redirection);
?>
