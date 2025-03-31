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
			$db->requete('SELECT * FROM sommets WHERE id_point = \''.$pid.'\'');
			$row = $db->fetch_assoc();
			if($row['id_point'] != null){
				$data = get_file(TPL_ROOT.'sommets/ajout_com_sommet.tpl');
				if($auth['attach_sign'] == 1)
					$attach_sign = 'checked="checked"';
				else
					$attach_sign = '';
				
				$data = parse_var($data,array('id_som'=>$row['id_point'], 'nom_sommet'=>$row['nom_som'], 'nom_sommet_url'=>title2url($row['nom_som'])));
				$data = parse_var($data,array('attache_sign'=>$attach_sign,'texte'=>'','envoi'=>'','titre_page'=>'Ajouter un commentaire sur cette fiche - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'./','design'=>$_SESSION['design']));
				$sql = "SELECT COUNT(*) FROM com_point WHERE id_point = '$pid'";
				$db->requete($sql);
				$num = $db->row();
				if($num[0] > 0){
					$data = parse_boucle('LISTE_MSG',$data,false,array(''=>''));
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
					$load_tpl = false;
					include(ROOT.'sommet/lecture_com_sommet.php');
				}else{
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
				}
				include(INC_ROOT.'header.php');
				$data = parse_var($data,array('id_photo'=>$pid));
				echo $data;
			}else{
				$message = 'Le sommet demandé n\'existe pas.';
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