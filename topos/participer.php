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
	if(!isset($_GET['ida']))
		$ida = "";
	else
		$ida = intval($_GET['ida']);
	
	if(!isset($_GET['ids']))
		$ids = "";
	else
		$ids = intval($_GET['ids']);
	
	if($ida == "")
	{
		$data = get_file(TPL_ROOT.'topos/particip_activite_vide.tpl');
		include(INC_ROOT.'header.php');
		
		$sql = "SELECT * FROM activites";
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$data = parse_boucle('ACTIVITE',$data,FALSE,array(
			'ACTIVITE.id_act'=>$row['id_activite'],
			'ACTIVITE.nom_act'=>$row['nom_activite']));
			
			$data = parse_var($data,array('ida'=>$row['id_activite']));
		}
		
		$data = parse_boucle('ACTIVITE',$data,TRUE);
		
		if($ida == 1)
			$lien = 'ajouter-un-topo-de-skis-de-rando-'.$ids.'.html';
		elseif($ida == 2)
			$lien = 'ajouter-un-topo-de-randonnees-'.$ids.'.html';
		else
			$lien = 'participer.html?ida='.$ida.'&ids='.$ids;

				
		$data = parse_var($data,array('lien'=>$lien,'ids'=>$ids,'ida'>$ida,'nb_requetes'=>$db->requetes,'titre_page'=>'participer - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
		echo $data;
		
	}
	else
	{
		$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
		$auth = $db->fetch($db->requete($sql));
		if($auth['redacteur_topo'] == 1)
		{
			
			if(in_array($ida, $act))
			{
				$liste = '';
				$liste_sommet = '';
				//Variable choix du massif
				if(isset($_POST['massif']))
					$choix_massif = intval($_POST['massif']);
				else
					$choix_massif = 0;

				//On charge le template en fonction
				if($choix_massif == 0)
					$data = get_file(TPL_ROOT.'topos/particip_vide.tpl');
				else
					$data = get_file(TPL_ROOT.'topos/particip.tpl');
					
					
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
					
					if($choix_massif != 0 AND $choix_massif == $row['id_massif'])
						$selected = 'selected="selected"';
					else
						$selected = '';
					
					$data = parse_boucle('MASSIF',$data,false,array('MASSIF.id_massif'=>$row['id_massif'],'MASSIF.nom_massif'=>$row['nom_massif'], 'MASSIF.selected'=>$selected));
				}
				
				$data = parse_boucle('MASSIF',$data,TRUE);
				$data = parse_boucle('MASSIFG',$data,TRUE);
				
				
				//Si le choix du massif a été fait
				if($choix_massif != 0)
				{
						
					//echo $choix_massif;
					$sql1 = "SELECT * FROM point_gps  WHERE point_gps.id_massif = ".$choix_massif." AND type_point BETWEEN '9' AND '10'";
					$result1 = $db->requete($sql1);
					
					while($row1 = $db->fetch($result1))
					{
										//Choix de l'activité
					if($ida == 1)
						{$liste_sommet .= '<tr><td><a href="./detail-'.title2url($row1['nom_point']).'-'.$row1['id_point'].'-2.html">'.$row1['nom_point'].'</a> (<a href="ajouter-un-topo-de-skis-de-rando-'.$row1['id_point'].'.html">Ajouter un topos</a>)';}
					else	
						{$liste_sommet .= '<tr><td><a href="./detail-'.title2url($row1['nom_point']).'-'.$row1['id_point'].'-2.html">'.$row1['nom_point'].'</a> (<a href="ajouter-un-topo-de-randonnees-'.$row1['id_point'].'.html">Ajouter un topos</a>)';}
					
						$sql2 = "SELECT * FROM topos  WHERE id_sommet = ".$row1['id_point']." AND id_activite =".$ida." AND statut > 0";
						$result2 = $db->requete($sql2);
						$nb_enregistrement = $db->num($result2);
						
						if($nb_enregistrement > 0);
							$liste_sommet .= '<ul>';
							
						while($row2 = $db->fetch($result2))
						{
							if($ida == 1)
								{$liste_sommet .='<li><a href="'.title2url($row2['nom_topo']).'-t'.$row2['id_topo'].'.html">'.$row2['nom_topo'].'</a></li>';}
							else
								{$liste_sommet .='<li><a href="'.title2url($row2['nom_topo']).'-tr'.$row2['id_topo'].'.html">'.$row2['nom_topo'].'</a></li>';}	
						}
						
						if($nb_enregistrement > 0);
							$liste_sommet .= '</ul>';
							
						$liste_sommet .= '</td></tr>';
					}
					$data = parse_var($data,array('massif'=>$choix_massif));
				}
				$data = parse_var($data,array('ida'=>$ida,'sommet'=>$liste_sommet,'nb_requetes'=>$db->requetes,'titre_page'=>'participer - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
				echo $data;
			}
			else
			{		
				$message = 'Cette activité n\'éxiste pas';
				$redirection = 'index.php';
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
}
$db->deconnection();
?>