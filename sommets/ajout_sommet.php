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
	//$id_massif = intval($_GET['massif']);
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_points'] == 1){	
		
		if (!isset($_GET['m']))
		{
			if(!isset($_GET['massif']))
			{
				$data = get_file(TPL_ROOT.'sommets/ajout_sommet_massif_empty.tpl');
				include(INC_ROOT.'header.php');
				
				//requête du haut de page
				$sql = "SELECT * FROM massif_groupe LEFT JOIN massif ON massif.idg = massif_groupe.idg_massif ORDER BY idg_massif ASC";
				$result = $db->requete($sql);
				$theme_count = 0;
				$current_theme = 0;
				while($row = $db->fetch_assoc($result))
				{
					if($current_theme != $row['idg_massif']){
						if($current_theme != 0){
							$data = parse_boucle('MASSIF',$data,TRUE);
							$data = imbrication('MASSIFG',$data);
						}
						$current_theme = $row['idg_massif'];
						$theme_count++;
						$data = parse_boucle('MASSIFG',$data,false,array('MASSIFG.nomg'=>$row['nomg_massif']),true);
					}
					
						$selected = '';
					
					$data = parse_boucle('MASSIF',$data,false,array('MASSIF.id_massif'=>$row['id_massif'],'MASSIF.nom_massif'=>$row['nom_massif'], 'MASSIF.selected'=>$selected));
				}
				
				$data = parse_boucle('MASSIF',$data,TRUE);
				$data = parse_boucle('MASSIFG',$data,TRUE);
	
				
				$data = parse_var($data,array('edition'=>'', 'titre_page'=>'Ajouter un point, choisir un massif - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
				echo $data;
			}
			else
			{		
			
				$id_massif = intval($_GET['massif']);
				
				$data = get_file(TPL_ROOT.'sommets/ajout_sommet.tpl');
				include(INC_ROOT.'header.php');
						
				$sql = "SELECT * FROM type_gps WHERE type_point = 2 ORDER BY nom_type DESC";
				$result1 = $db->requete($sql);
					
				$sql = "SELECT * FROM departement ORDER BY departement_id ASC";
				$dpt = $db->requete($sql);	
					
				$sql = $result2 = $db->requete("SELECT * FROM massif WHERE id_massif = ".$id_massif."");
				$massif = $db->fetch($sql);
							
				$sql = "SELECT * FROM cartes ORDER BY num_carte DESC";
				$result3 = $db->requete($sql);
				
				//On prend toutes les cartes
				$sql = "SELECT * FROM cartes";
				$result = $db->requete($sql);
				$carte = '<label for="carte">Carte :</label><span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">';
				while($row = $db->fetch_assoc($result))
				{
					$carte .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
				}
				$carte .= '</span>';
				//Choix du departement
				while($row = $db->fetch_assoc($dpt))
					{
						$select = '';
						$departement = $row['departement_nom'];
						$data = parse_boucle('DPT',$data,FALSE,array('DPT.select'=>$select, 'DPT.id_dpt'=>$row['departement_id'], 'DPT.nom_dpt'=> $departement));
					}
				$data = parse_boucle('DPT',$data,TRUE);			
				//Choix du type de point
				while($row = $db->fetch_assoc($result1))
					{
						$select = '';		
						$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>$select, 'TYPE.id_type'=>$row['id_type'], 'TYPE.nom_type'=>$row['nom_type']));
					}
				$data = parse_boucle('TYPE',$data,TRUE);
							
				$data = parse_var($data,array('nom_sommet'=>'',
				'altitude'=>'', 'lat'=>'45.74836', 'lng'=>'4.80652', 'carte_edite'=>$carte
				));
				
				
				$data = parse_var($data,array('massif'=>'?idm='.$massif['id_massif'],'nom_massif'=>$massif['nom_massif'],'edition'=>'', 'titre_page'=>'Ajouter un point, '.$massif['nom_massif'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
				echo $data;
			}		
		}
		else
		{
			$m = intval($_GET['m']);
			$id_massif = intval($_GET['massif']);
			
			$data = get_file(TPL_ROOT.'sommets/ajout_sommet.tpl');
			include(INC_ROOT.'header.php');
					
			$sql = "SELECT * FROM type_gps WHERE type_point = 2 ORDER BY nom_type DESC";
			$result1 = $db->requete($sql);	
			
			$sql = "SELECT * FROM departement ORDER BY departement_id ASC";
			$dpt = $db->requete($sql);	
					
			$sql = $result2 = $db->requete("SELECT * FROM massif WHERE id_massif = ".$id_massif."");
			$massif = $db->fetch($sql);
							
			$sql = "SELECT * FROM cartes ORDER BY num_carte DESC";
			$result3 = $db->requete($sql);
				
			//$sql = $db->requete("SELECT * FROM c_refuge WHERE id_refuge = '".$m."'");
			$sql = $db->requete("SELECT * FROM point_gps
									LEFT JOIN sommets ON sommets.id_point = point_gps.id_point
									LEFT JOIN massif ON massif.id_massif = sommets.id_massif 
									LEFT JOIN departement ON departement.departement_id = point_gps.departement_id
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]' 
									WHERE point_gps.id_point = '".$m."' AND type_point > 8 AND type_point < 15");
			$nbre_reponse = $db->num();
			$sommet = $db->fetch($sql);
			//echo $sommet['idcarte'].'****';
			if ($nbre_reponse < 1)
			{
				$message = 'Cette fiche n\'existe pas';
				$redirection = DOMAINE.'/liste-refuge.html';
				echo display_notice($message,'important',$redirection);
			}
			elseif ($sommet['mid_1'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
			{
				
				while($row = $db->fetch_assoc($result1))
					{
						if ($row['id_type'] == $sommet['id_type'])
							$select = 'selected="selected"';
						else
							$select = '';
							
						$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>$select, 'TYPE.id_type'=>$row['id_type'], 'TYPE.nom_type'=>$row['nom_type']));
					}
				$data = parse_boucle('TYPE',$data,TRUE);
				
				while($row = $db->fetch_assoc($dpt))
					{
						if ($row['departement_id'] == $sommet['departement_id'])
							$select = 'selected="selected"';
						else
							$select = '';
						
						$departement = $row['departement_nom'];
						$data = parse_boucle('DPT',$data,FALSE,array('DPT.select'=>$select, 'DPT.id_dpt'=>$row['departement_id'], 'DPT.nom_dpt'=> $departement));
					}
				$data = parse_boucle('DPT',$data,TRUE);
				
				//print_r(unserialize($sommet['idcarte'])).'aa';
				//On prend toutes les cartes
				if(!empty($sommet['idcarte']))
				{
					$result =  $db->requete("SELECT * FROM cartes");
					$carte = unserialize($sommet['idcarte']);
					$carte_edite = '<label for="carte">Carte :</label><span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">';
					while ($row = $db->fetch($result))
					{
						//echo $row['id_carte'].'//'.$carte.'<br />';
						if (in_array($row['id_carte'], $carte))
						{
							$carte_edite .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'" checked="checked">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
						}
						else
						{
							$carte_edite .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
						}
					}	
					$carte_edite .= '</span>';
				}
				else
				{
					$result =  $db->requete("SELECT * FROM cartes");
					$carte_edite = '<label for="carte">Carte :</label><span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">';
					while ($row = $db->fetch($result))
					{
						$carte_edite .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
					}	
					$carte_edite .= '</span>';
				}

		
				$data = parse_var($data,array('nom_sommet'=>$sommet['nom_point'],
				'altitude'=>$sommet['altitude'], 'lat'=>$sommet['lat_point'], 'lng'=>$sommet['long_point'], 'carte_edite'=>$carte_edite
				));
				
				
				$data = parse_var($data,array('massif'=>'','nom_massif'=>$massif['nom_massif'],'edition'=>'?e='.$sommet['id_point'].'&idm='.$id_massif.'&ids='.$m, 'titre_page'=>'Editer un point - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
				echo $data;
			}
			else
			{
				$message = 'Cette fiche n\'est pas à vous';
				$redirection = DOMAINE.'/liste-refuge.html';
				echo display_notice($message,'important',$redirection);
			}
		}
				
	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à ajouter un refuge. Ceci peut être que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>