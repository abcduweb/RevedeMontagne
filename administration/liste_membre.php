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
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = 'connexion.html';
	$data = display_notice($message,'important',$redirection);
	
}
else{
	
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	$sql = "SELECT * FROM autorisation_globale";
	$result = $db->requete($sql);
	while($row = $db->fetch($result)){
		$listeGroupe[$row['id_group']] = $row;
	}
	if(!empty($_GET['limite']))
		$page = intval($_GET['limite']);
	else
		$page = 1;
	if(isset($_GET['membres'])){
		$membre = htmlentities($_GET['membres'],ENT_QUOTES);
		$sql = "SELECT * FROM membres WHERE pseudo LIKE '%$membre%'";
	}
	else
		$sql = "SELECT * FROM membres";
	########################################Calcul des pages############################################################
	/*$nb_message_page = 30;																	   						   #
	$retour = $db->requete($sql);	#
	$nb_enregistrement = $db->num($retour);													   						   #
	$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							   						   #
	if($nombre_de_page < $page)	$page = $nombre_de_page;									   						   #
	$limite = ($page - 1) * $nb_message_page;												   						   #
	$liste_page = get_list_page($page,$nombre_de_page);                                            #
	####################################################################################################################
	$liste_page_string = '';
	foreach($liste_page as $var){
		$liste_page_string .= '<a href="admin-membres-p'.$var.'.html">'.$var.'</a> ';
	}*/
	
	$nb_message_page = 30;
	$retour = $db->requete($sql);	
	$nb_enregistrement = $db->num($retour);
	$nb_page = ceil($nb_enregistrement / $nb_message_page);
	if($page > $nb_page) $page = $nb_page;
	$limite = ($page - 1) * $nb_message_page;
			
	$liste_page = '';
	foreach(get_list_page($page,$nb_page) as $var){
		switch($var){
			case $page:
			$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ';
			break;
			case '<a href="admin-membres-p....html">&#8201;...&#8201;</a> ':
			$liste_page .= $var;
			break;
			default:
			$liste_page .= '<a href="admin-membres-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
			
			
	if($nb_enregistrement == 0){
		$data = get_file(TPL_ROOT.'admin/liste_membres_empty.tpl');
	}
	else{
		$sql .= " LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		$data = get_file(TPL_ROOT.'admin/liste_membres.tpl');
		while($row = $db->fetch($result)){
			if($auth['punnir'] == 1)
				$punir = '<form action="actions/pourcent.php?mid='.$row['id_m'].'" method="post">' .
						'<label for="pourcentage">'.$row['pourcent'].'%</label>' .
						'<select name="pourcentage">' .
						'<option value="5">5</option>' .
						'<option value="10">10</option>' .
						'<option value="15">15</option>' .
						'<option value="20">20</option>' .
						'<option value="25">25</option>' .
						'<option value="30">30</option>' .
						'</select>' .
						'<input type="submit" name="punir" value="Ajouter" />' .
						'</form>';
			else
				$punir = '-';
			if($_SESSION['group'] == 1){
				$changerGroupe = '<form action="actions/changer_group.php?mid='.$row['id_m'].'" method="post">' .
								 '<label for="idNGroup">Nouveau groupe</label>' .
								 '<select name="idNGroup">';
				foreach($listeGroupe as $groupe){
					if($groupe['id_group'] != $row['id_group'])$changerGroupe .= '<option value="'.$groupe['id_group'].'">'.$groupe['nom_group'].'</option>';
				}
				$changerGroupe .= '</select><input type="submit" value="changer" />' .
						'</form>';
			}
			else{
				$changerGroupe = '-';
			}
			$data = parse_boucle('MEMBRES',$data,false,array('idMembre'=>$row['id_m'],'groupe'=>$listeGroupe[$row['id_group']]['nom_group'],'pseudo'=>$row['pseudo'],'ip'=>$row['ip'],'punir'=>$punir,'changer_groupe'=>$changerGroupe));
		}
		$data = parse_boucle('MEMBRES',$data,TRUE);
	}
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array("design"=>$_SESSION['design'],"ROOT"=>'',"liste_page"=>$liste_page,'titre_page'=>"Gestion des membres - ".SITE_TITLE,"nb_visiteurs"=>$nb_user_online,'nb_requetes'=>$db->requetes));
}
$db->deconnection();
echo $data;
?>