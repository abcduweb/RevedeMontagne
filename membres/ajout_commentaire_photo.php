<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'connexion.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	if(!empty($_GET['pid'])){
		$auth = $db->fetch_assoc($db->requete("SELECT ajouter_com,attach_sign FROM autorisation_globale LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE autorisation_globale.id_group = $_SESSION[group]"));
		if($auth['ajouter_com'] == 1){
			$pid = intval($_GET['pid']);
			$db->requete('SELECT id_album, pm_photos.id_categorie, pm_album_photos.nom_categorie FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie WHERE id_album = \''.$pid.'\'');
			$row = $db->fetch_assoc();
			if($row['id_album'] != null){
				$data = get_file(TPL_ROOT.'ajout_com_photo.tpl');
				if($auth['attach_sign'] == 1)
					$attach_sign = 'checked="checked"';
				else
					$attach_sign = '';
				$data = parse_var($data,array('attache_sign'=>$attach_sign,'titre_album_url'=>title2url($row['nom_categorie']),'titre_album'=>$row['nom_categorie'],'id_album'=>$row['id_categorie'],'texte'=>'','envoi'=>'','titre_page'=>'Ajouter un commentaire à une photo - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'./','design'=>$_SESSION['design']));
				$sql = "SELECT COUNT(*) FROM pm_comphotos WHERE id_photo = '$pid'";
				$db->requete($sql);
				$num = $db->row();
				if($num[0] > 0){
					$data = parse_boucle('LISTE_MSG',$data,false,array(''=>''));
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
					$load_tpl = false;
					include(ROOT.'lecture_com_photos.php');
				}else{
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
				}
				include(INC_ROOT.'header.php');
				$data = parse_var($data,array('id_photo'=>$pid, 'ROOT'=>''));
				echo $data;
			}else{
				$message = 'La photo demandée n\'existe pas.';
				$redirection = 'javascript:history.back(-1);';
				echo display_notice($message,'important',$redirection);
			}
		}
		else{
			$message = 'Vous n\'étes pas autorisé à ajouter de commentaires. Ceci peut être que temporaire.';
			$redirection = ROOT.'index.html';
			echo display_notice($message,'important',$redirection);
		}
	}else{
		$message = 'Aucune photo de sélectionner.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>