<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'index.php';
	$data = display_notice($message,'important',$redirection);
}
else
{
	$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE autorisation_globale.id_group = '$_SESSION[group]'";
	$result = $db->requete($sql);
	$auth = $db->fetch($result);
	if($auth['mp'] == 1){
		$destinataireGet = '';
		if(isset($_GET['midi'])){
			$sql = "SELECT * FROM membres WHERE id_m = ".intval($_GET['midi'])." LIMIT 0,1";
			$db->requete($sql);
			if($db->num() > 0){
				$row = $db->fetch();
				$destinataireGet = $row['pseudo'];
			}else{
				$db->deconnection();
				$message = "Ce membres n'existe pas";
				$redirection = "javascript:history.back(-1);";
				echo display_notice($message,'important',$redirection);
				exit;
			}
		}
		$data = get_file(TPL_ROOT.'ajouter_discution.tpl');
		include(INC_ROOT.'header.php');
		if($auth['attach_sign'] == 1)
			$attach_sign = 'checked="checked"';
		else
			$attach_sign = '';
		$data = parse_var($data,array('texte'=>'','destinataire'=>$destinataireGet,'attache_sign'=>$attach_sign,'titre_page'=>'Créer une discution - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$message = 'Vous ne pouvez pas créer de nouvelle discution. Ceci n\'est peut être que temporaire.';
		$redirection = 'liste-mp.html';
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>