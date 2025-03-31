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
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_points'] == 1){
		
		
		$data = get_file(TPL_ROOT.'refuge/ajout_refuge.tpl');
		include(INC_ROOT.'header.php');
				
		$sql = "SELECT * FROM type_gps WHERE type_point = 1 ORDER BY nom_type DESC";
		$result1 = $db->requete($sql);	

		
		if (!isset($_GET['m']))
		{
			$choix_massif = '';
			
			$data = parse_var($data,array('lat'=>'45.74836', 'lng'=>'4.80652', 'nom_refuge'=>'', 'nbre_place'=>'', 'altitude'=>'', 'latitude'=>'', 'longitude'=>''));
			
			while($row = $db->fetch_assoc($result1))
			{
				$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>'', 'TYPE.id_type'=>$row['id_type'], 'TYPE.nom_type'=>$row['nom_type']));
			}
			$data = parse_boucle('TYPE',$data,TRUE);
			
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
				
				if($choix_massif != 0 AND $choix_massif == $row['id_massif'])
					$selected = 'selected="selected"';
				else
					$selected = '';
				
				$data = parse_boucle('MASSIF',$data,false,array('MASSIF.id_massif'=>$row['id_massif'],'MASSIF.nom_massif'=>$row['nom_massif'], 'MASSIF.selected'=>$selected));
			}
			
			$data = parse_boucle('MASSIF',$data,TRUE);
			$data = parse_boucle('MASSIFG',$data,TRUE);
			
			//On prend toutes les cartes
			$sql = "SELECT * FROM cartes";
			$result = $db->requete($sql);
			$carte = '<label for="carte">Carte :</label><span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">';
			while($row = $db->fetch_assoc($result))
			{
				$carte .= '<input type="checkbox" name="carte[]" id="carte[]" value="'.$row['id_carte'].'">'.$row['num_carte'].' - '.$row['nom_carte'].'<br />';
			}
			$carte .= '</span>';
			
			$sql = "SELECT * FROM departement ORDER BY departement_id ASC";
			$dpt = $db->requete($sql);	
			while($row = $db->fetch_assoc($dpt))
				{
					$select = '';
					$departement = $row['departement_nom'];
					$data = parse_boucle('DPT',$data,FALSE,array('DPT.select'=>$select, 'DPT.id_dpt'=>$row['departement_id'], 'DPT.nom_dpt'=> $departement));
				}
			$data = parse_boucle('DPT',$data,TRUE);		
				
			$value = "ajouter";
			$data = parse_var($data,array('id_point'=>'', 'edit_com_point'=>'', 'idm'=>$_SESSION['mid'], 'nom_membre'=>$_SESSION['membre'], 'carte_edite'=>$carte, 'edition'=>'', 'intro'=>'','conclu'=>'','titre_page'=>'Ajouter un point - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
			echo $data;
		}
		else
		{
			$m = intval($_GET['m']);
			$edit_com_point = '';
			//$sql = $db->requete("SELECT * FROM c_refuge WHERE id_refuge = '".$m."'");
			$sql = $db->requete("SELECT * FROM point_gps
									LEFT JOIN refuge ON refuge.id_point = point_gps.id_point
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
									WHERE point_gps.id_point = '".$m."'");
			$nbre_reponse = $db->num();
			$refuge = $db->fetch($sql);
			
			if ($nbre_reponse < 1)
			{
				$message = $nbre_reponse;
				$redirection = DOMAINE.'/liste-refuge.html';
				echo display_notice($message,'important',$redirection);
			}
			elseif ($refuge['id_m'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
			{
				//ON récupére les cartes
				$refuge2 = unserialize($refuge['idcarte']);
				if(!empty($refuge2))
				{
					$result =  $db->requete("SELECT * FROM cartes");
					
					$carte_edite = '<label for="carte">Carte :</label><span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">';
					while ($row = $db->fetch($result))
					{
						if (in_array($row['id_carte'], $refuge2))
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
				
				
				while($row = $db->fetch_assoc($result1))
					{
						if ($row['id_type'] == $refuge['type_refuge'])
							$select = 'selected="selected"';
						else
							$select = '';
							
						$data = parse_boucle('TYPE',$data,FALSE,array('TYPE.select'=>$select, 'TYPE.id_type'=>$row['id_type'], 'TYPE.nom_type'=>$row['nom_type']));
					}
				$data = parse_boucle('TYPE',$data,TRUE);
					
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
					
					if($refuge['id_massif'] != 0 AND $refuge['id_massif'] == $row['id_massif'])
						$selected = 'selected="selected"';
					else
						$selected = '';
					
					$data = parse_boucle('MASSIF',$data,false,array('MASSIF.id_massif'=>$row['id_massif'],'MASSIF.nom_massif'=>$row['nom_massif'], 'MASSIF.selected'=>$selected));
				}
				
				$data = parse_boucle('MASSIF',$data,TRUE);
				$data = parse_boucle('MASSIFG',$data,TRUE);
				
				$sql = "SELECT * FROM departement ORDER BY departement_id ASC";
				$dpt = $db->requete($sql);	
				while($row = $db->fetch_assoc($dpt))
					{
						if ($row['departement_id'] == $refuge['departement_id'])
							$select = 'selected="selected"';
						else
							$select = '';
						
						$departement = $row['departement_nom'];
						$data = parse_boucle('DPT',$data,FALSE,array('DPT.select'=>$select, 'DPT.id_dpt'=>$row['departement_id'], 'DPT.nom_dpt'=> $departement));
					}
				$data = parse_boucle('DPT',$data,TRUE);	
			
				if ($auth['administrateur_points'] == 1)
				{
					$edit_com_point = '
					<label for="type">Commentaires :</label>
					<select name="com_forum" id="com_forum">';
					$sql4 = "SELECT * FROM topics WHERE id_forum = 28";
					$com_point = $db->requete($sql4);
							
					$selected = '<option value="0" selected="selected">Aucun</option>';
					$listeitem = '';
					while($row4 = $db->fetch_assoc($com_point))
					{
						if ($row4['id_t'] == $refuge['id_t'])
							$selected = '<option value="'.$row4['id_t'].'" selected="selected">Sujet n&deg;'.$row4['id_t'].' - '.$row4['titre'].'</option>';
						else						
							$listeitem .= '<option value="'.$row4['id_t'].'">Sujet n&deg;'.$row4['id_t'].' - '.$row4['titre'].'</option>';
						
					}
					$edit_com_point .= $selected . $listeitem . '</select>';
				}
								
				$data = parse_var($data,array('nom_refuge'=>$refuge['nom_point'], 'nbre_place'=>$refuge['places_couchage'],
				'altitude'=>$refuge['altitude_refuge'], 'lat'=>$refuge['lat_point'], 'lng'=>$refuge['long_point'],
				'edit_com_point'=>$edit_com_point
				));
				
				
				$data = parse_var($data,array('id_point'=>'-'.$m,'idm'=>$_SESSION['mid'], 'nom_membre'=>$_SESSION['membre'], 'carte_edite'=>$carte_edite, 'edition'=>'?e='.$refuge['id_point'].'&m=', 'intro'=>$refuge['acces'],'conclu'=>$refuge['remarques'],'titre_page'=>'Editer un point - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
				echo $data;
			}
			else
			{
				$message = 'Cette fiche n\'est pas à vous';
				$redirection = DOMAINE.'/liste-des-refuges.html';
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