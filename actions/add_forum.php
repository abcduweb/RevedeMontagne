<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

$result = $db->requete("SELECT * FROM big LEFT JOIN forum ON forum.id_big = big.id_b LEFT JOIN auth_list ON (auth_list.id_forum = forum.id_f AND auth_list.afficher = '1') WHERE auth_list.id_group = '$_SESSION[group]' AND auth_list.add_forum = 1 ORDER BY id_b");
$i = 0;
while($row = $db->fetch($result)){
	if($i == 0)
	{
		$theme['id'][$row['id_b']] = $row['id_b'];
		$theme['titre'][$row['id_b']] = $row['nom_b'];
		$past_big = $row['id_b'];
		$i++;
	}
	if($i > 0 AND $past_big != $row['id_b'])
	{
		$theme['id'][$row['id_b']] = $row['id_b'];
		$theme['titre'][$row['id_b']] = $row['nom_b'];
		$past_big = $row['id_b'];
		$i++;
	}
}
if($i > 0){
	if(isset($_GET['validation']) AND $_GET['validation'] == 1){
		if($theme['id'][$_POST['cat']]){
			$id_big = intval($_POST['cat']);
			$row = $db->row($db->requete("SELECT MAX(position) FROM forum WHERE id_big = '$id_big'"));
			$position = $row[0] + 1;
			$sql = "INSERT INTO forum VALUES ('',0,'$id_big','$position','".htmlentities($_POST['nom_forum'],ENT_QUOTES)."','".htmlentities($_POST['description'],ENT_QUOTES)."',0,0)";
			$db->requete($sql);
			$id_forum = $db->last_id();
			$sql = "SELECT * FROM autorisation_globale LEFT JOIN auth_list ON (auth_list.id_group = autorisation_globale.id_group AND id_big = $id_big)";
			$result = $db->requete($sql);
			$is_on = array('on'=>1,''=>0);
			$pas_group = array();
			while($row = $db->fetch($result)){
				if(!in_array($row['id_group'],$pas_group)){
					$pas_group[] = $row['id_group'];
					if(!isset($row['add_forum'])) $row['add_forum'] == 0;
					$db->requete("INSERT INTO auth_list VALUES($id_big,$id_forum,$row[id_group],".$is_on[$_POST['auth'][$row['id_group']]['add']].",".$is_on[$_POST['auth'][$row['id_group']]['modifier']].",".$is_on[$_POST['auth'][$row['id_group']]['supprimer']].",".$is_on[$_POST['auth'][$row['id_group']]['afficher']].",".$is_on[$_POST['auth'][$row['id_group']]['close']].",".$is_on[$_POST['auth'][$row['id_group']]['move']].",".$row['add_forum'].")");
				}
			}
			$message = "Forum ajouté!";
			$redirection = ROOT."admin.html";
			$data = display_notice($message,"ok",$redirection);
		}
		else{
			$message = "Vous ne pouvez pas ajouter de forum dans cette catégorie!";
			$redirection = ROOT."admin.html";
			$data = display_notice($message,"important",$redirection);
		}
	}
	else{
		if(isset($_POST['cat']) AND !empty($_POST['nom_forum'])){
			if($theme['id'][$_POST['cat']]){
				$data = get_file(TPL_ROOT.'form_perso.tpl');
				$id_big = intval($_POST['cat']);
				$form = '<form action="add_forum.php?validation=1" method="post">
				<fieldset>
					<legend>Ajouter un forum</legend>
					<input type="hidden" name="cat" value="'.intval($_POST['cat']).'" />
					<label for="nom">Nom : </label>
					<input type="text" name="nom_forum" value="'.htmlentities($_POST['nom_forum'],ENT_QUOTES).'" /><br />
					<label for="description">Description : </label>
					<input type="text" name="description" /><br />';
				$sql = "SELECT * FROM autorisation_globale LEFT JOIN auth_list ON (auth_list.id_group = autorisation_globale.id_group AND id_big = $id_big)";
				$result = $db->requete($sql);
				$onoff = array(1=>'checked="checked"',0=>'',''=>'');
				$past_group = array();
				while($row = $db->fetch($result)){
					if(!in_array($row['nom_group'],$past_group)){
						$form .= '<label for="auth['.$row['id_group'].']">'.$row['nom_group'].'</label>
				<input type="checkbox" name="auth['.$row['id_group'].'][add]" '.$onoff[$row['ajouter']].' title="ajouter message et sujet" />
				<input type="checkbox" name="auth['.$row['id_group'].'][modifier]" '.$onoff[$row['modifier_tout']].' title="modifier tous les messages" />
				<input type="checkbox" name="auth['.$row['id_group'].'][supprimer]" '.$onoff[$row['supprimer']].' title="supprimer les messages" />
				<input type="checkbox" name="auth['.$row['id_group'].'][afficher]" '.$onoff[$row['afficher']].' title="lire le forum" />
				<input type="checkbox" name="auth['.$row['id_group'].'][close]" '.$onoff[$row['interdire_topics']].' title="fermer les sujets" />
				<input type="checkbox" name="auth['.$row['id_group'].'][move]" '.$onoff[$row['move']].' title="déplacer un sujet" /><br />';
						$past_group[] = $row['nom_group'];
					}
				}
				$form .= '<input type="submit" value="ajouter" />
			</fieldset>
			</form>';
			$data = parse_var($data,array('form'=>$form,'DOMAINE'=>DOMAINE,'DESIGN'=>$_SESSION['design']));
			}
			else{
				$message = "Vous ne pouvez pas ajouter de forum dans cette catégorie!";
				$redirection = ROOT."admin.html";
				$data = display_notice($message,"important",$redirection);
			}
		}
		else{
			$message = "Vous n'avez pas donnée le nom du forum!";
			$redirection = ROOT."admin.html";
			$data = display_notice($message,"important",$redirection);
		}
	}
}
else{
	$message = "Vous n'avez pas accé à cette partie!";
	$redirection = ROOT."admin.html";
	$data = display_notice($message,"important",$redirection);
}
$db->deconnection();
echo $data;
?>
