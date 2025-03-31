<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$row = $db->fetch($db->requete($sql));
	if(empty($_GET['action'])){
		$message = "Aucune action de selectioner.";
		$type = "important";
		$redirection = ROOT.'liste-album.html';
	}else{
		$action = intval($_GET['action']);
		if(empty($_GET['alid'])){
			$message = "Aucun album de selectioner.";
			$type = "important";
			$redirection = ROOT.'liste-album.html';
		}else{
			$id_album = intval($_GET['alid']);
			$sql = "SELECT * FROM pm_album_photos WHERE id_categorie = '$id_album'";
			$db->requete($sql);
			if($db->num() == 0){
				$message = "Cet album n'existe pas.";
				$type = "important";
				$redirection = ROOT.'liste-album.html';
			}else{
				switch($action){
					case 3:
						if($row['ajouter_album'] == 1){
							$valide = array('faune/flore','activites','divers');
							if(isset($_POST['cat']) AND !empty($_POST['cat']) AND in_array($_POST['cat'],$valide)){
								$db->requete("UPDATE pm_album_photos SET regroupement = '".htmlentities($_POST['cat'],ENT_QUOTES)."' WHERE  id_categorie = '$id_album'");
								$message = "Album déplacé.";
								$type = "ok";
								$redirection = ROOT.'liste-album.html';
							}
							else{
								$data = get_file(TPL_ROOT.'form_perso.tpl');
								$form = '<form action="album.php?action='.$action.'&amp;validation=1&amp;alid='.$id_album.'" method="post">
							<fieldset>
							<legende>Déplacer un album</legende>
							<label for="cat">Vers : </label>
							<select name="cat">
								<option value="faune/flore">Faune/Flore</option>
								<option value="activites">Activités</option>
								<option value="divers">Divers</option>
							</select><br />
							<input type="submit" value="déplacer" />
							</fieldset>
							</form>';
								$data = parse_var($data,array('form'=>$form,'DOMAINE'=>DOMAINE,'DESIGN'=>$_SESSION['design']));
								echo $data;
								$db->deconnection();
								exit;
							}
						}
						else{
							$message = "Vous n'avez pas le droit d'accéder à cette partie.";
							$type = "important";
							$redirection = 'javascript:history.back(-1);';
						}
					break;
					case 4:
						if($row['supprimer_album'] == 1){
							if($_POST['valider'] == 1){
								$sql = "DELETE FROM pm_album_photos WHERE id_categorie = '$id_album'";
								$db->requete($sql);
								$sql = "SELECT * FROM pm_photos WHERE id_categorie = '$id_album'";
								$db->requete($sql);
								while($row = $db->fetch($result)){
									unlink(ROOT.'images/album/'.ceil($row['id_album'] /1000).'/'.$row['fichier']);
									unlink(ROOT.'images/album/'.ceil($row['id_album'] /1000).'/mini/'.$row['fichier']);
								}
								$db->requete("DELETE FROM pm_photos WHERE id_categorie = '$id_album'");
								$message = "Album photos supprimer avec succés.";
								$type = "ok";
								$redirection = ROOT.'liste-album.html';
							}else{
								$db->deconnection();
								$url = "album.php?alid=$id_album&amp;action=$action";
								$message = "Etes vous sur de vouloir supprimer cet album?";
								echo display_confirm($message,$url);
								exit;
							}
						}
						else{
							$message = "Vous n'avez pas le droit de supprimer un album.";
							$type = "important";
							$redirection = 'javascript:history.back(-1);';
						}
					break;
				}
			}
		}
	}
}
else{
	$message = "Vous n'avez pas le droit d'accéder à cette partie.";
	$type = "important";
	$redirection = "javascript:history.back(-1);";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>