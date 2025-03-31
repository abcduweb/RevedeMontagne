<?php
/*
 * Créer le 1 sept. 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: la suppression de discution
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	$message = 'Vous devez être enregistr&eacute; pour pouvoir acc&eacute;der à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
	$data = parse_var($data,array('message'=>$message,'type'=>$type,'redirection'=>$redirection,'TPL_ROOT'=>ROOT.'templates/','DESIGN'=>$_SESSION['design']));
}
else{
	if(isset($_POST['discution']) AND !empty($_POST['discution'])){
		if(isset($_POST['valider']) AND $_POST['valider'] == 1){
			$sql = "SELECT id_discution_l FROM discutions_lues WHERE id_membre = '$_SESSION[mid]' AND `in` = '1'";
			$db->requete($sql);
			$idDisc = array();
			while($row = $db->fetch_assoc()){
				$idDisc[] = $row['id_discution_l'];
			}
			foreach($_POST['discution'] as $key => $var){
				if(!in_array($key,$idDisc)){
					$message = "Vous ne pouvez pas supprimer certaines discutions sélectionnées.";
					$redirection = ROOT."liste-mp.html";
					echo display_notice($message,'important',$redirection);
					$db->deconnection();
					exit;
				}else{
					if(!isset($sqlEnd)){
						$sqlEnd = intval($key);
					}else{
						$sqlEnd .= ', '.intval($key);
					}
				}
			}
			$sql = "SELECT * FROM liste_discutions WHERE id_discution IN ($sqlEnd) AND nb_participant = '1'";
			$db->requete($sql);
			while($row = $db->fetch()){
				if(!isset($sqlEnd2))
					$sqlEnd2 = $row['id_discution'];
				else
					$sqlEnd2 .= ', '.$row['id_discution'];
			}
			if(isset($sqlEnd2)){
				$sql = "DELETE FROM messages_discution WHERE id_disc IN ($sqlEnd2)";
				$db->requete($sql);
				$sql = "DELETE FROM liste_discutions WHERE id_discution IN ($sqlEnd2)";
				$db->requete($sql);
				$sql = "DELETE FROM discutions_lues WHERE id_discution_l IN ($sqlEnd2)";
				$db->requete($sql);
			}
			
			$sql = "UPDATE discutions_lues SET `in` = 0 WHERE `in` = 1 AND id_discution_l IN (".$sqlEnd.') AND id_membre = \''.$_SESSION['mid'].'\'';
			$db->requete($sql);
			
			$sql = "UPDATE liste_discutions SET nb_participant = nb_participant - 1 WHERE id_discution IN (".$sqlEnd.')';
			$db->requete($sql);
			
			if(isset($sqlEnd2)){
				$sql = "SELECT * FROM images WHERE s_dir IN ($sqlEnd2) AND dir = '5'";
				$db->requete($sql);
				while($row = $db->fetch()){
					unlink(ROOT.'images/autres/'.ceil($row['id_image']/1000).'/'.$row['fichier']);
					unlink(ROOT.'images/autres/'.ceil($row['id_image']/1000).'/mini/'.$row['fichier']);
				}
				$sql = "DELETE FROM images WHERE s_dir IN ($sqlEnd2) AND dir = '5'";
				$db->requete($sql);
			}
			$message = "Messages supprim&eacute;s.";
			$redirection = ROOT."liste-mp.html";
			$data = display_notice($message,'ok',$redirection);
			
		}else{
			$message = "Etes vous sur de vouloir supprimer les messages s&eacute;lection&eacute;s?";
			foreach($_POST['discution'] as $key => $var){
				$message .= '<input type="hidden" name="discution['.$key.']" value="'.$var.'" />';
			}
			$url = "supprimer_mp.php";
			$data = display_confirm($message,$url);
		}
	}else{
		$message = "Vous ne pouvez pas supprimer certaines discutions s&eacute;lectionn&eacute;es.";
		$redirection = ROOT."liste-mp.html";
		$data = display_notice($message,'important',$redirection);
	}
}
echo $data;
$db->deconnection();
?>