<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$id_t = intval($_GET['t']);
$sql = "SELECT * FROM topics LEFT JOIN forum ON topics.id_forum = forum.id_f LEFT JOIN auth_list ON (auth_list.id_group = '".$_SESSION['group']."' AND auth_list.id_forum = forum.id_f) WHERE topics.id_t = '$id_t'";
$result = $db->requete($sql);
$row2 = $db->fetch($result);
if($row2['move'] == 1){
	if(isset($row2['id_t']) AND !empty($row2['id_t'])){
		if(!isset($_POST['id_forum'])){
			$data = get_file(TPL_ROOT.'forum/deplacer_sujet.tpl');
			$form = '<form action="deplacer_sujet.php?t='.$id_t.'" method="post">
			<fieldset>
				<legend>Déplacer le sujet: '.$row2['titre'].'</legend>
				<label for="id_forum">Déplacer dans: </label>
				<select name="id_forum">';
			$sql = "SELECT * FROM big LEFT JOIN forum ON forum.id_big = big.id_b ORDER BY big.id_b";	
			$result = $db->requete($sql);
			$current_theme = 0;
			while($row = $db->fetch($result)){
				if($current_theme != $row['id_b']){
					if($current_theme != 0)$form .= '</optgroup>';
					$form .= '<optgroup label="'.$row['nom_b'].'">';
					$current_theme = $row['id_b'];
				}
				$form .= '<option value="'.$row['id_f'].'">'.$row['nom'].'</option>';
			}
			$form .='	</select>';
			$form .='<br />
			<label for="trace">Ne pas laisser de trace</label>
			<input type="checkbox" name="trace" /><br />
			<input type="submit" value="déplacer" />
			</fieldset>
			</form>';
			$data = parse_var($data,array('DOMAINE'=>DOMAINE,'form'=>$form,'DESIGN'=>$_SESSION['design']));
		}
		else{
			$id_forum = intval($_POST['id_forum']);
			$sql = "SELECT * FROM forum WHERE id_f = '$id_forum'";

			if($db->num($db->requete($sql))){
				if($_POST['id_forum'] != $row2['id_forum'] AND ($row2['deplacer'] == 0 OR $_POST['id_forum'] != $row2['deplacer'])){
					if(isset($_POST['trace'])){
						$sql = "UPDATE topics SET id_forum = '$id_forum',deplacer = '0' WHERE id_t = '$id_t'";
					}
					else{
						$sql = "UPDATE topics SET deplacer = '$id_forum' WHERE id_t = '$id_t'";
					}
					$db->requete($sql);
					$redirection = ROOT.'forum-'.$row2['id_forum'].'-'.title2url($row2['nom']).'.html';
					$message = "Le sujet a bien été déplacé.";
					$data = display_notice($message,'ok',$redirection);
				}
				else{
					$redirection = ROOT.'forum-'.$id_forum.'-'.title2url($row2['nom']).'.html';
					$message = "Le sujet est déjà dans cette catégorie.";
					$data = display_notice($message,'important',$redirection);
				}
			}
			else{
				$redirection = ROOT.'forum-'.$row2['id_forum'].'-'.title2url($row2['nom']).'.html';
				$message = "Ce forum n\'existe pas.";
				$data = display_notice($message,'important',$redirection);
			}
		}
	}
	else{
		$redirection = ROOT."forum.html";
		$message = "Sujet inexistant.";
		$data = display_notice($message,'important',$redirection);
	}
}
else{
	$message = "Vous n'avez pas le droit d'effectuer cette action";
	$redirection = ROOT."forum.html";
	$data = display_notice($message,'important',$redirection);
}
$db->deconnection();
echo $data;
?>