<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
define('Z_ROOT','../phorum/');

$id_forum = (int)$_GET['f'];
$sql = "SELECT * FROM auth_list LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.id_forum = '$id_forum'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);
if($row2['ajouter'] == 1)
{
	$t = (int)$_GET['t'];
	$sql = "SELECT * FROM topics WHERE id_t = '$t' AND id_forum = '$id_forum'";
	$result = $db->requete($sql);
	$row = $db->fetch($result);
	$ok = $db->num($result);
	if($ok == 0){
		$sql = "SELECT * FROM topics WHERE id_t = '$t' AND deplacer = '$id_forum'";
		$result = $db->requete($sql);
		$row = $db->fetch($result);
		$ok = $db->num($result);
	}	
    if(($ok > 0 AND $row['status'] == 1) OR ($ok > 0 AND $row2['interdire_topics'] == 1)){
		if(isset($_GET['m'])){
			$id_m = (int)$_GET['m'];
			$sql = "SELECT * FROM messages LEFT JOIN topics ON topics.id_t = messages.id_topics LEFT JOIN auth_list ON (auth_list.id_forum = topics.id_forum AND auth_list.id_group = '$_SESSION[group]') WHERE id_ms = '$id_m'";
			$result = $db->requete($sql);
			$row = $db->fetch($result);
			if($row['afficher'] == 1 AND $db->num() > 0){
				$txt = $row['text'];
				$auteur = $row['utilisateur'];
				$quote = "<citation nom=\"$auteur\">$txt</citation>";
			}else{
				$redirection = "javascript:history.back(-1);";
				$message = "Vous ne pouvez citer ce message.";
				echo diplay_notice($message,'important',$redirection);
			}
		}
		else{
			$quote='';
		}
		$_GET['limite'] = 1;
		$data = get_file(TPL_ROOT.'forum/add_message.tpl');
		include(INC_ROOT.'header.php');
		$load_tpl = false;
		include(Z_ROOT.'sources/message.php');
		if($row2['attach_sign'] == 1)
			$attach_sign = 'checked="checked"';
		else
			$attach_sign = '';
		$data = parse_var($data,array('texte'=>$quote,'attache_sign'=>$attach_sign,'id_forum'=>$id_forum,'id_sujet'=>$t,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
		echo $data;
	}
	else{
		$redirection = "javascript:history.back(-1);";
		$message = "Vous ne pouvez pas ajouter de message dans ce sujet.";
		echo display_notice($message,'important',$redirection);
	}
}
else{
	$redirection = "javascript:history.back(-1);";
	$message = "Vous ne pouvez pas ajouter de message dans ce sujet.";
	echo display_notice($message,'important',$redirection);
}
$db->deconnection();
?>