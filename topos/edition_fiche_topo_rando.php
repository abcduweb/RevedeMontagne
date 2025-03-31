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
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	//print_r($orient_topo);
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
	{
		
		$topo = intval($_GET['t']);
		
		
		//Je selectionne la fiche en question
		$reponse =  $db->requete("SELECT nom_massif, nom_point, 
									nom_topo, denniveles, topos.id_m AS id_m, id_sommet,
									orientation, difficulte_topo, nb_jours, departs.id_depart AS id_depart, type_topo.id_type_iti AS id_type_iti,
									itineraire, remarque, massif.id_massif
									FROM topos
									LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
									LEFT JOIN departs ON departs.id_depart = topos.id_depart
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE topos.id_topo = '".$topo."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
		
		//Je vérifis qu'elle appartiens au membre en question
		 
		if($_SESSION['mid'] == $donnees['id_m'] OR $auth['administrateur_topo'] == 1)
		{
			
			$data = get_file(TPL_ROOT.'topos/edition_fiche_topos_rando2.tpl');
			include(INC_ROOT.'header.php');
		
		
			//Gestion de l'orientation
			$orientation='';
			$selected='';
			foreach($orient_topo as $cle_orienta => $orient)
			{
				if($orient == $donnees['orientation'])
					$selected='selected="selected"';
				else
					$selected='';
				$orientation.='<option value="'.$orient.'" '.$selected.'>'.$orient.'</option>';
			}
			
			//Gestion de la difficultés montee 
			$diff_topo_monte2='';
			$selected='';
			foreach($diff_topo_monte as $cle_diff_topo => $diff_topo2)
			{
				if($diff_topo2 == $donnees['difficulte_topo'])
					$selected='selected="selected"';
				else
					$selected='';
				$diff_topo_monte2.='<option value="'.$diff_topo2.'" '.$selected.'>'.$diff_topo2.'</option>';
			}
			
			//Gestion du nombre de jours
			$nb_jours2='';
			$selected='';
			foreach($nb_jours as $cle_nbj => $nbj)
			{
				if($nbj == $donnees['nb_jours'])
					$selected='selected="selected"';
				else
					$selected='';
				$nb_jours2.='<option value="'.$nbj.'" '.$selected.'>'.$nbj.'</option>';
			}
			
			//On recuère la liste des départs
			$sql = "SELECT * FROM departs WHERE statut = 1 AND id_massif = '".$donnees['id_massif']."' ORDER BY id_depart DESC";
			$result = $db->requete($sql);
			$depart = '';
			while($row = $db->fetch_assoc($result))
			{
				if($row['id_depart'] == $donnees['id_depart'])
					$depart.='<option value="'.$row['id_depart'].'" selected="selected">'.$row['lieu_depart'].' - '.$row['alt_depart'].' m</option>';
				else
					$depart.='<option value="'.$row['id_depart'].'">'.$row['lieu_depart'].' - '.$row['alt_depart'].' m</option>';
			}
			
			//On récupère le type d'itinéraire
			$sql = "SELECT * FROM type_topo ORDER BY id_type_iti DESC";
			$result = $db->requete($sql);
			$type_iti = '';
			while($row = $db->fetch_assoc($result))
			{
				if($row['id_type_iti'] == $donnees['id_type_iti'])
					$type_iti.='<option value="'.$row['id_type_iti'].'" selected="selected">'.$row['nom_type'].'</option>';
				else
					$type_iti.='<option value="'.$row['id_type_iti'].'">'.$row['nom_type'].'</option>';
			}
			
			//On récupére les cartes selectionnées
			//On met dans un tableau les valeurs existentes
			$carte_utilise = array();
			$sql = "SELECT * FROM utiliser_carte LEFT JOIN cartes ON cartes.id_carte = utiliser_carte.id_carte WHERE id_topo = ".$topo;
			$result = $db->requete($sql);
			while($row = $db->fetch_assoc($result))
			{
				$carte_utilise[$row['id_carte']] = $row['nom_carte'];
			}
			
			//On prend toutes les cartes
			$sql = "SELECT * FROM cartes";
			$result = $db->requete($sql);
			$carte_edite = '';
			while($row = $db->fetch_assoc($result))
			{
				if (array_key_exists($row['id_carte'], $carte_utilise))
					$carte_edite .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'" checked="checked">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
				else
					$carte_edite .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
			}
			
			
			//print_r($carte_utilise);
			//<input type="checkbox" name="carte[]" id="carte[]" value="{TYPE2.id_carte}">{TYPE2.num_carte} - {TYPE2.nom_carte}<br />
			
			$data = parse_var($data,array('id_topo'=>$topo, 'massif'=>$donnees['nom_massif'], 'sommet'=>$donnees['nom_point'],
										'nom_topo'=>$donnees['nom_topo'], 'denni'=>$donnees['denniveles'],
										'orientation'=>$orientation, 'diff_topo_monte'=>$diff_topo_monte2,
										'nb_jours'=>$nb_jours2, 'depart'=>$depart, 'type_iti'=>$type_iti, 'carte'=>$carte_edite,
										'intro'=>$donnees['itineraire'], 'conclu'=>$donnees['remarque']));
			
			
				
			$data = parse_var($data,array('edition'=>'&e='.$topo, 's'=>$donnees['id_sommet'], 'titre_page'=>'Edition du topo '.$donnees['nom_point'].', '.$donnees['nom_topo'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
			echo $data;		
		}
		else
		{
			$message = 'Ce topo ne vous appartient pas...';
			$redirection = 'liste-des-topos-de-randonnee.html';
			echo display_notice($message,'important',$redirection);
		}
		
	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à ajouter un topo de ski. Ceci peut être que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>