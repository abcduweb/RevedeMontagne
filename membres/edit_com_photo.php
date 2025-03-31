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
	if(!empty($_GET['m'])){
		$auth = $db->fetch_assoc($db->requete("SELECT modifier_com,ajouter_com FROM autorisation_globale WHERE autorisation_globale.id_group = $_SESSION[group]"));
		if($auth['ajouter_com'] == 1){
			$id_com = intval($_GET['m']);
			$db->requete('SELECT pm_comphotos.id_com, pm_comphotos.com,pm_comphotos.attachSign, pm_comphotos.mid, pm_photos.id_album, pm_photos.id_categorie, pm_album_photos.nom_categorie FROM pm_comphotos LEFT JOIN pm_photos ON pm_photos.id_album = pm_comphotos.id_photo LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie WHERE id_com = \''.$id_com.'\'');
			$row = $db->fetch_assoc();
			if($row['id_com'] != null AND ($_SESSION['mid'] == $row['mid'] OR $auth['modifier_com'] == 1)){
				$data = get_file(TPL_ROOT.'edit_com_photo.tpl');
				$_GET['id_msg'] = $id_com;
				if($row['attachSign'] == 1)
					$attach_sign = 'checked="checked"';
				else
					$attach_sign = '';
				$data = parse_var($data,array('msg'=>$row['id_com'],'attache_sign'=>$attach_sign,'titre_album_url'=>title2url($row['nom_categorie']),'titre_album'=>$row['nom_categorie'],'id_album'=>$row['id_categorie'],'texte'=>$row['com'],'envoi'=>'','titre_page'=>'Editer un commentaire d\'une photo - '.SITE_TITLE));
				
				$pid = $row['id_album'];
				$sql = "SELECT COUNT(*) FROM pm_comphotos WHERE id_photo = '$pid'";
				$db->requete($sql);
				$num = $db->row();
				if($num[0] > 0){
					$_GET['pid'] = $pid;
					$data = parse_boucle('LISTE_MSG',$data,false,array(''=>''));
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
					$load_tpl = false;
					include(ROOT.'lecture_com_photos.php');
				}else{
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
				}
				$data = parse_var($data,array('ROOT'=>'','nb_requetes'=>$db->requetes,'design'=>$_SESSION['design']));
				include(INC_ROOT.'header.php');
				echo $data;
			}else{
				$message = 'Vous ne pouvez pas éditer ce message.';
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
		$message = 'Aucun commentaire de sélectionner.';
		$redirection = 'javascript:history.back(-1);';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>
