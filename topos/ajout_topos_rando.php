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
	//echo $_SESSION['ses_id'].'ee';
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_topo'] == 1){
		
		$sommet = intval($_GET['s']);
						
		$data = get_file(TPL_ROOT.'topos/ajout_topos_rando.tpl');
		include(INC_ROOT.'header.php');
				
		$sql = "SELECT * FROM type_gps WHERE type_point = 2 ORDER BY nom_type DESC";
		$result1 = $db->requete($sql);
				
		$sql = $db->requete("SELECT * FROM point_gps
							LEFT JOIN sommets ON sommets.id_point = point_gps.id_point
							LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
							WHERE point_gps.id_point = '".$sommet."'");
		$result2 = $db->fetch($sql);
		
		$data = parse_var($data,array('id_massif'=>$result2['id_massif']));
			
		$sql = "SELECT * FROM cartes ORDER BY num_carte DESC";
		$result3 = $db->requete($sql);
		
		$sql = "SELECT * FROM departs WHERE statut = 1 AND id_massif = '".$result2['id_massif']."' ORDER BY id_depart DESC";
		$result4 = $db->requete($sql);
		
		$sql = "SELECT * FROM type_topo ORDER BY id_type_iti DESC";
		$result5 = $db->requete($sql);
		
		if (!isset($_GET['m']))
		{
		//echo $_GET['s'];	
			$sql = "SELECT * FROM point_gps WHERE id_point = '".$_GET['s']."'";
			$result6 = $db->requete($sql);
			if($db->num() < 0){
				echo 'erreure';
				exit;
			}
			$mass = $db->fetch($result6);
			//echo $mass['id_massif'].'aa';
			//echo $mass['nom_massif'];
		
			$data = parse_var($data,array('nom_topo'=>'', 'nom_sommet'=>'', 'altitude'=>'', 'lat'=>'', 'long'=>''));
			
			while($row = $db->fetch_assoc($result3))
			{
				$data = parse_boucle('TYPE2',$data,FALSE,array('TYPE2.select'=>'', 'TYPE2.id_carte'=>$row['id_carte'], 'TYPE2.nom_carte'=>$row['nom_carte'], 'TYPE2.num_carte'=>$row['num_carte']));
			}
			$data = parse_boucle('TYPE2',$data,TRUE);
			
			while($row = $db->fetch_assoc($result4))
			{
				$data = parse_boucle('TYPE3',$data,FALSE,array('TYPE3.select'=>'', 'TYPE3.id_depart'=>$row['id_depart'], 'TYPE3.lieu_depart'=>$row['lieu_depart'], 'TYPE3.alt_depart'=>$row['alt_depart']));
			}
			$data = parse_boucle('TYPE3',$data,TRUE);
			
			while($row = $db->fetch_assoc($result5))
			{
				$data = parse_boucle('TYPE4',$data,FALSE,array('TYPE4.select'=>'', 'TYPE4.id_type_iti'=>$row['id_type_iti'], 'TYPE4.nom_type_iti'=>$row['nom_type']));
			}
			$data = parse_boucle('TYPE4',$data,TRUE);	
			
				$value = "ajouter";

				$data = parse_var($data,array('massif'=>$result2['nom_massif'], 'id_som'=>$sommet, 'sommet'=>$result2['nom_som'], 's'=>$sommet, 'm'=>$mass['id_massif'], 'denni'=>'', 'pente'=>'', 'edition'=>'', 'intro'=>'','conclu'=>'','titre_page'=>'Ajouter un topo - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
				echo $data;
		}
		else
		{
			//echo $_GET['m'];
			$m = intval($_GET['m']);
			//$sql = $db->requete("SELECT * FROM c_refuge WHERE id_refuge = '".$m."'");
			$sql = $db->requete("SELECT * FROM point_gps
									LEFT JOIN sommets ON sommets.id_point = sommets.id_point
									LEFT JOIN massif ON massif.id_massif = sommets.id_massif 
									WHERE point_gps.id_point = '".$m."'");
			$sommet = $db->fetch($sql);
			
			$data = parse_var($data,array('id_massif'=>$sommet['id_massif']));
			
			if ($sommet['mid_1'] == $_SESSION['mid'] OR $_SESSION['group'] == 1)
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
				
				
				while($row = $db->fetch_assoc($result3))
					{
						if ($row['id_carte'] == $sommet['id_carte'])
							$select = 'selected="selected"';
						else
							$select = '';
							
						$data = parse_boucle('TYPE2',$data,FALSE,array('TYPE2.select'=>$select, 'TYPE2.id_carte'=>$row['id_carte'], 'TYPE2.nom_carte'=>$row['nom_carte'], 'TYPE2.num_carte'=>$row['num_carte']));
					}
					$data = parse_boucle('TYPE2',$data,TRUE);
					
				while($row = $db->fetch_assoc($result2))
					{
						if ($row['id_massif'] == $sommet['id_massif'])
							$select = 'selected="selected"';
						else
							$select = '';
						$data = parse_boucle('MASSIF',$data,FALSE,array('MASSIF.select'=>$select, 'MASSIF.id_massif'=>$row['id_massif'], 'MASSIF.nom_massif'=>$row['nom_massif']));
					}
				$data = parse_boucle('MASSIF',$data,TRUE);
			
				
				$data = parse_var($data,array('nom_sommet'=>$sommet['nom_som'], 'gps'=>$sommet['GPS'],
				'altitude'=>$sommet['altitude_som'], 'lat'=>$sommet['lat_point'], 'long'=>$sommet['long_point'],
				));
				
				//$sommet = intval($_GET['s']);
				$data = parse_var($data,array('s'=>intval($_GET['s']), 'm'=>$result2['id_massif'], 'edition'=>'&e='.$sommet['id_point'], 'intro'=>$sommet['acces'],'conclu'=>$sommet['remarques'],'titre_page'=>'Editer un point - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'','design'=>$_SESSION['design']));
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
		$message = 'Vous n\'étes pas autorisé à ajouter un topo. Ceci peut être que temporaire.';
		$redirection = 'index.php';
		echo display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
?>