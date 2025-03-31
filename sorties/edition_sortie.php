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
	if($auth['redacteur_sortie'] == 1)
	{
		
		$sortie = intval($_GET['s']);
		
		
		//Je selectionne la fiche en question
		$reponse =  $db->requete("SELECT *
								FROM sortie
								 WHERE id_sortie = '".$sortie."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
		
		//Je vérifis qu'elle appartiens au membre en question
		
		if($_SESSION['mid'] == $donnees['id_m'])
		{
			$data = get_file(TPL_ROOT.'sorties/edition_sortie.tpl');
			include(INC_ROOT.'header.php');
			$data = parse_var($data,array('id_sortie'=>$sortie, 'meteo'=>$donnees['meteos'], 'recit'=>$donnees['recit']));
			$date = date("d-m-Y", strtotime($donnees['dates']));
			
			$date_explosee = explode("-", $donnees['dates']);
 
            $annee = $date_explosee[0];
			$mois = $date_explosee[1];
			$jour = $date_explosee[2];

			
			echo $jour;
			//On gére l'édition de la date
			
			//jour
			$selected='';
			$jour3='';
			foreach($js as $cle_js => $jour2)
			{
				if($jour2 == $jour)
					$selected='selected="selected"';
				else
					$selected='';
				$jour3.='<option value="'.$jour2.'" '.$selected.'>'.$jour2.'</option>';
			}
			//moi
			$selected='';
			$mois3='';
			foreach($ms as $cle_ms => $ms2)
			{
				if($cle_ms == $mois)
					$selected='selected="selected"';
				else
					$selected='';
				$mois3.='<option value="'.$cle_ms.'" '.$selected.'>'.$ms2.'</option>';
			}
			
			//jour
			$selected='';
			$annee3='';
			foreach($ae as $cle_ae => $ae2)
			{
				if($ae2 == $annee)
					$selected='selected="selected"';
				else
					$selected='';
				$annee3.='<option value="'.$ae2.'" '.$selected.'>'.$ae2.'</option>';
			}		

			//Fichier GPX
						//$sql = $db->requete("SELECT * FROM c_refuge WHERE id_refuge = '".$m."'");
			$sql = $db->requete("SELECT id_sortie, sortie.id_mapgpx FROM sortie 
								 LEFT JOIN map_gpx ON map_gpx.id_mapgpx = sortie.id_mapgpx
								 WHERE id_sortie = '".$sortie."'");
			$sort = $db->fetch($sql);
			
			
			$sql = "SELECT * FROM map_gpx WHERE id_m = '".$_SESSION['mid']."' ORDER BY id_mapgpx DESC";
			$result = $db->requete($sql);
			while($row = $db->fetch_assoc($result))
			{
				if ($row['id_mapgpx'] == $sort['id_mapgpx'])
					$select = 'selected="selected"';
				else
					$select = $row['id_mapgpx'].'/'.$sort['id_mapgpx'].'/'.$sortie;
							
				$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>'', 'TYPE.id_gpx'=>$row['id_mapgpx'], 'TYPE.date_gpx'=>date("d/m/Y", strtotime($row['date_mapgpx'])),'TYPE.nom_gpx'=>$row['nom_mapgpx'], 'TYPE.select'=>$select));
			}
			$data = parse_boucle('TYPE',$data,TRUE);
				
				
			$data = parse_var($data,array('jour'=>$jour3, 'mois'=>$mois3, 'annee'=>$annee3, 'edition'=>'&e='.$sortie,'titre_page'=>'Edition sortie du '.$date.' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
			echo $data;		
		}
		else
		{
			$message = 'Cette sortie ne vous appartient pas...';
			$redirection = 'liste-des-sorties.html';
			echo display_notice($message,'important',$redirection);
		}
		
	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à éditer une sortier. Ceci n\'est peut être que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>