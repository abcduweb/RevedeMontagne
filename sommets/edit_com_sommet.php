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
			$db->requete('SELECT id_m, id_com, commentaire, attachSign, c_refuge.id_refuge, c_refuge.id_point
							FROM com_point
							LEFT JOIN c_refuge ON c_refuge.id_point = com_point.id_point 
							WHERE id_com = \''.$id_com.'\'');
			$row = $db->fetch_assoc();
			if($row['id_com'] != null AND ($_SESSION['mid'] == $row['id_m'] OR $auth['modifier_com'] == 1)){
				$data = get_file(TPL_ROOT.'refuge/edit_com_refuge.tpl');
				$_GET['id_msg'] = $id_com;
				if($row['attachSign'] == 1)
					$attach_sign = 'checked="checked"';
				else
					$attach_sign = '';
				$data = parse_var($data,array(
				'msg'=>$row['id_com'],
				'attache_sign'=>$attach_sign,
				'titre_album_url'=>'title2url($row[\'nom_categorie\'])',
				'titre_album'=>'',
				'id_album'=>'',
				'texte'=>$row['commentaire'],
				'envoi'=>'',
				'id_point'=>$row['id_point'],
				'titre_page'=>'Editer le commentaire d\'un refuge - '.SITE_TITLE));
				
				$pid = $row['id_refuge'];
				$sql = "SELECT COUNT(*) FROM com_point WHERE id_point = '$pid'";
				$db->requete($sql);
				$num = $db->row();
				if($num[0] > 0){
					$_GET['pid'] = $pid;
					$data = parse_boucle('LISTE_MSG',$data,false,array(''=>''));
					$data = parse_boucle('LISTE_MSG',$data,TRUE);
					$load_tpl = false;
					include(ROOT.'refuge/lecture_com_refuge.php');
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
