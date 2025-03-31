<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if($_SESSION['group'] == 1){
	if(isset($_POST['group']) AND !empty($_POST['group']) AND strlen(trim($_POST['group'])) > 3){
			if(isset($_POST['global']['modifier_news']))
				$modifier_news = 1;
			else
				$modifier_news = 0;
			if(isset($_POST['global']['supprimer_news']))
				$supprimer_news = 1;
			else
				$supprimer_news = 0;
			if(isset($_POST['global']['valider_news']))
				$valider_news = 1;
			else
				$valider_news = 0;
			if(isset($_POST['global']['modifier_topo']))
				$modifier_topo = 1;
			else
				$modifier_topo = 0;
			if(isset($_POST['global']['supprimer_topo']))
				$supprimer_topo = 1;
			else
				$supprimer_topo = 0;
			if(isset($_POST['global']['ajouter_album']))
				$ajouter_album = 1;
			else
				$ajouter_album = 0;
			if(isset($_POST['global']['supprimer_album']))
				$supprimer_album = 1;
			else
				$supprimer_album = 0;
			if(isset($_POST['global']['supprimer_photo']))
				$supprimer_photo = 1;
			else
				$supprimer_photo = 0;
			if(isset($_POST['global']['modifier_com']))
				$modifier_com = 1;
			else
				$modifier_com = 0;
			if(isset($_POST['global']['supprimer_com']))
				$supprimer_com = 1;
			else
				$supprimer_com = 0;
			if(isset($_POST['global']['ban']))
				$punnir = 1;
			else
				$punnir = 0;
			if(isset($_POST['other']['photos']))
				$ajouter_s_photos = 1;
			else
				$ajouter_s_photos = 0;
			if(isset($_POST['other']['news']))
				$ajouter_s_news = 1;
			else
				$ajouter_s_news = 0;
			if(isset($_POST['other']['articles']))
				$ajouter_s_articles = 1;
			else
				$ajouter_s_articles = 0;
			if(isset($_POST['other']['com']))
				$ajouter_s_com = 1;
			else
				$ajouter_s_com = 0;
			if(isset($_POST['other']['mp']))
				$ajouter_mp = 1;
			else
				$ajouter_mp = 0;
			if (isset ($_POST['other']['redacOff']))
				$redacOff = 1;
			else
				$redacOff = 0;
			$nameGroup = htmlentities($_POST['group'],ENT_QUOTES);
			$sql = "INSERT INTO autorisation_globale VALUES('','$nameGroup','','$punnir','$modifier_news','$supprimer_news','$valider_news','$modifier_topo','$supprimer_topo','$ajouter_album','$supprimer_album','$supprimer_photo','$modifier_com','$supprimer_com','$ajouter_s_photos','$ajouter_s_news','$ajouter_s_articles','$ajouter_s_com','$redacOff','$ajouter_mp','')";
			$db->requete($sql);
			$id_group = $db->last_id();
			if(isset($_POST['adminMenu'])){
        $team_group_id[] = $id_group;
        $conf = '<?php ';
    		$open = fopen(INC_ROOT.'admin_rights.php','w');
    		$conf .= '$team_group_id = '.var_export($team_group_id,TRUE).';';
    		$conf .= '?>';
    		fwrite($open,$conf);
    		fclose($open);
      }
			$sql = "SELECT * FROM forum";
			$result = $db->requete($sql);
			while($row = $db->fetch($result)){
				$add = 0;
				$modifier = 0;
				$supprimer = 0;
				$afficher = 0;
				$close = 0;
				$ban = 0;
				$move = 0;
				$add_forum = 0;
				if(isset($_POST['auth'][$row['id_f']])){
					foreach($_POST['auth'][$row['id_f']] as $key => $var){
						${$key} = 1;
					}
					if(!isset($_POST['add_forum'][$row['id_big']]))
						$add_forum = 0;
					else
						$add_forum = 1;
				}
				$sql = "INSERT INTO auth_list VALUES($row[id_big],$row[id_f],$id_group,$add,$modifier,$supprimer,$afficher,$close,$move,$add_forum)";
				$db->requete($sql);
			}
			$message = "Groupe ajouté!";
			$type = "ok";
			$redirection = ROOT."admin.html";
	}
	else{
		if(!isset($_POST['group']) OR empty($_POST['group'])){
			$message = "Vous n'avez pas donnée le nom du groupe!";
			$type = "important";
			$redirection = ROOT."javascript:history.back(-1);";
		}
		else{
			if(strlen(trim($_POST['group'])) < 4){
				$message = "Le nom du groupe est trop court";
				$type = "important";
				$redirection = ROOT."javascript:history.back(-1);";
			}
		}
	}
}
else{
	$message = "Vous n'avez pas accé à cette partie!";
	$type = "important";
	$redirection = ROOT."admin.html";
}
echo display_notice($message,$type,$redirection);
?>
