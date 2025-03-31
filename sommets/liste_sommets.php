<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

// Headers requis
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Max-Age: 3600");
// header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if(isset($_GET['page']))
		$page = intval($_GET['page']);
	else
		$page = 1;
	
	$id_m = 0;
	$id_mass = 0;
	
	if(isset($_GET['massif']))
		{
			$id_mass = $_GET['massif'];
			$nb_message_page = $_SESSION['nombre_news'];
			$sql = ("SELECT * FROM point_gps
						LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
						LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
						WHERE point_gps.type_point > 8
						AND point_gps.type_point < 15
						AND point_gps.statut>0
						AND point_gps.id_massif='".$id_mass."'");	
			$db->requete($sql);
			
			//$nb_pages = $db->num();
			$nb_enregistrement = $db->num();
			$nb_page = ceil($nb_enregistrement / $nb_message_page);
			if($page > $nb_page) $page = $nb_page;
			$limite = ($page - 1) * $nb_message_page;
			
			$liste_page = '';
			foreach(get_list_page($page,$nb_page) as $var){
				switch($var){
					case $page:
						$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ';
					break;
					case '<a href="liste-des-sommets-p....html">&#8201;...&#8201;</a> ':
						$liste_page .= $var;
					break;
					default:
					$liste_page .= '<a href="liste-des-sommets-m'.$id_mass.'-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
				}
			}
		}
	elseif(isset($_GET['idm']))
		{
		$id_m = intval($_GET['idm']);
		}
	else
		{
		$id_mass = 0;
		}

	if($id_mass == 0)
		{
		if($id_m > 0)
			{
				$sql = $db->requete("SELECT * FROM membres WHERE id_m='".$id_m."'");	
				$mbre_exist = $db->num();
				
				
				if($mbre_exist < 1)
				{
						$message = "Ce membre n'éxiste pas";
						$redirection = $config['domaine'].'liste-des-sommets.html.';
						$data = display_notice($message,'important',$redirection);
				}
				else
				{
					$mbre = $db->fetch($sql);
					
					if(isset($_GET['page']))
						$page = intval($_GET['page']);
					else
						$page = 1;

					$nb_message_page = $_SESSION['nombre_news'];
					$sql = ("SELECT * FROM point_gps
							LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
							LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
							LEFT JOIN refuge ON refuge.id_point = point_gps.id_point
							LEFT JOIN type_gps ON type_gps.id_type = refuge.type_refuge
							WHERE point_gps.type_point > 8
							AND point_gps.type_point < 15
							AND point_gps.statut > 0
							AND id_m='".$id_m."'");	
					$db->requete($sql);
					//$nb_pages = $db->num();
					$nb_enregistrement = $db->num();
					$nb_page = ceil($nb_enregistrement / $nb_message_page);
					if($page > $nb_page) $page = $nb_page;
					$limite = ($page - 1) * $nb_message_page;
					
					$liste_page = '';
					foreach(get_list_page($page,$nb_page) as $var){
						switch($var){
							case $page:
								$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ';
							break;
							case '<a href="#">&#8201;...&#8201;</a> ':
								$liste_page .= $var;
							break;
							default:
							$liste_page .= '<a href="mes-sommets-m'.$id_m.'-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
						}
					}
					if($nb_enregistrement > 0)
					{
						$data = get_file(TPL_ROOT.'sommets/mes_sommets.tpl');
						
						if ($id_m == $_SESSION['mid'])
							{
								$hcol_action = '<th>Actions</th>';
								$nb_colonne = 6;
							}
							else
							{
								$hcol_action = '';
								$nb_colonne = 5;
							}
							
		
						include(INC_ROOT.'header.php');
						
						$sql = "SELECT * FROM point_gps
							LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
							LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
							LEFT JOIN membres ON membres.id_m = point_gps.id_m
							LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
							WHERE point_gps.type_point > 8
							AND point_gps.type_point < 15
							AND point_gps.id_m='".$id_m."'
							AND point_gps.statut > 0
							ORDER BY point_gps.id_point ASC LIMIT $limite,$nb_message_page";
						$result = $db->requete($sql);

						$ligne = 1;
						while ($row = $db->fetch($result))
						{		


							if($row['id_m'] == $_SESSION['mid'] AND $auth['redacteur_points'] == 1 OR $auth['administrateur_points'] == 1)
							{
								$nb_colonne = 6;
								$hcol_action='<th>Actions</th>';	
								$colaction='<td class="centre"><a href="'.$config['domaine'].'edition-fiche-sommet-'.$row['id_point'].'-m'.$row['id_massif'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
												<a href="'.$config['domaine'].'sommets/envoi_sommet.php?idt='.$row['id_point'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
							}
							else
							{
								$hcol_action = '';
								$nb_colonne = 5;
								$colaction='';	
							}
							
							$id_mass = $row['id_massif'];
							
							$data = parse_boucle('listesom',$data,FALSE,array(
							'listesom.id_som'=>$row['id_point'],
							'listesom.nom_som_url'=>title2url($row['nom_point']),
							'listesom.nom_som'=>$row['nom_point'],
							'listesom.mass'=>$row['nom_massif'],
							'listesom.alt'=>$row['altitude'],
							'listesom.lat'=>$row['lat_point'],
							'listesom.lng'=>$row['long_point'],
							'listesom.type'=>$row['nom_type'],
							'listesom.col_action'=>$colaction,
							'listesom.ligne'=>$ligne
							));
							$massif=$row['nom_massif'];
							if($ligne == 1)
								$ligne = 2;
							else
								$ligne = 1;
						}
					
						$data = parse_boucle('listesom',$data,TRUE);
						
						if(!isset($_SESSION['ses_id']))
							{
								$ajout_refuge = 'Pour ajouter un sommet il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
							}
							else
							{
								$ajout_refuge = '<a href="ajouter-un-sommet.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
							}
						
						$data = parse_var($data,array('idmassif'=> $id_mass, 'typepoint'=> $row['type_point'], 'hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'pseudo'=>$mbre['pseudo'], 'ajout_som'=>$ajout_refuge, 'hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'liste_page'=>$liste_page, 'nb_requetes'=>$db->requetes,'titre_page'=>'Sommets / cols proposés par '.$mbre['pseudo'].' - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
					}
					else
					{
						$data = get_file(TPL_ROOT.'sommets/mes_sommets_empty.tpl');
						include(INC_ROOT.'header.php');
						$data = parse_var($data,array('pseudo'=>$mbre['pseudo'], 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Sommets / Cols proposés par '.$mbre['pseudo'].' - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
					}
				}
			}
			else
			{
				
				
				$data = get_file(TPL_ROOT.'sommets/liste_sommets_empty_mass.tpl');
				include(INC_ROOT.'header.php');
				
				
				
					//requête du haut de page
					$sql = "SELECT *, massif.id_massif AS idm
					FROM massif_groupe 
					LEFT JOIN massif ON massif.idg = massif_groupe.idg_massif 
					LEFT JOIN (
							SELECT type_point, IF( COUNT(id_point) = 0, 0, COUNT(id_point) ) AS nb_topo, id_massif
							FROM point_gps 
							WHERE point_gps.type_point > 8
							AND point_gps.type_point < 15
							GROUP BY id_massif 
							) pt_gps
						ON pt_gps.id_massif = massif.id_massif
					ORDER BY idg_massif
					";
					
					/*$sql = "SELECT IF( COUNT(id_point) = 0, '0', COUNT(id_point) ) AS nb_refuge, nom_massif, massif.id_massif, idg_massif, nomg_massif, type_point
					FROM point_gps 
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN massif_groupe ON massif_groupe.idg_massif = massif.idg
					WHERE type_point = 1
					GROUP BY massif.id_massif";*/
					
					$result = $db->requete($sql);
					$theme_count = 0;
					$current_theme = 0;
					$ligne = 1;
					while($row = $db->fetch_assoc($result))
					{
						if($current_theme != $row['idg_massif']){
							if($current_theme != 0){
								$data = parse_boucle('MASSIF',$data,TRUE);
								$data = imbrication('MASSIFG',$data);
								$ligne = 1;
							}
							$current_theme = $row['idg_massif'];
							$theme_count++;
							$data = parse_boucle('MASSIFG',$data,false,array('MASSIFG.nomg'=>$row['nomg_massif']),true);

						}

						
						
						$data = parse_boucle('MASSIF',$data,false,array('MASSIF.nb_topo'=>intval($row['nb_topo']),'MASSIF.id_massif'=>$row['idm'],'MASSIF.nom_massif'=>$row['nom_massif'], 'MASSIF.ligne'=>$ligne));
						if($ligne == 1)
							$ligne = 2;
						else
							$ligne = 1;
					}
					
					$data = parse_boucle('MASSIF',$data,TRUE);
					$data = parse_boucle('MASSIFG',$data,TRUE);
				$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'Liste des sommets - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
			}
		}
	elseif($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_sommet = 'Pour ajouter un sommet il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_sommet = '<a href="ajouter-un-sommet-m'.$id_mass.'.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
		}
		
		
		$data = get_file(TPL_ROOT.'sommets/liste_sommets.tpl');
		$data = parse_var($data,array('ajout_som'=>$ajout_sommet));
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM point_gps
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
				LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
				LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
				WHERE point_gps.type_point > 8
				AND point_gps.type_point < 15
				AND point_gps.id_massif='".$id_mass."'
				AND point_gps.statut>0
				ORDER BY point_gps.id_point ASC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		
		$ligne = 1;
		while ($row = $db->fetch($result))
		{
			if(!isset($_SESSION['ses_id']))
			{
				$hcol_action = '';
				$nb_colonne = 4;
				$colaction='';	
			}
			elseif($row['id_m'] == $_SESSION['mid'] AND $auth['redacteur_points'] == 1 OR $auth['administrateur_points'] == 1)
			{
				$nb_colonne = 5;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"><a href="'.$config['domaine'].'edition-fiche-sommet-'.$row['id_point'].'-m'.$row['id_massif'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
							<a href="'.$config['domaine'].'sommets/envoi_sommet.php?idt='.$row['id_point'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
			}
			else
			{
				$nb_colonne = 5;
				$hcol_action='<th>Actions</th>';	
				$colaction='<td class="centre"> - </td>';	
			}
			
			$data = parse_boucle('listesom',$data,FALSE,array(
			'listesom.id_som'=>$row['id_point'],
			'listesom.nom_som_url'=>title2url($row['nom_point']),
			'listesom.nom_som'=>$row['nom_point'],
			'listesom.alt'=>$row['altitude'],
			'listesom.lat'=>$row['lat_point'],
			'listesom.lng'=>$row['long_point'],
			'listesom.type'=>$row['nom_type'],
			'listesom.col_action'=>$colaction,
			'listesom.ligne'=>$ligne
			));
			$massif=$row['nom_massif'];
			$id_massif = $row['id_massif'];
			$type_point = $row['id_type'];
			
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('listesom',$data,TRUE);
		$data = parse_var($data,array('idmassif'=> $id_massif, 'typepoint'=> $type_point, 'hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>$massif.', liste des sommets - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'sommets/liste_sommets_empty.tpl');
		include(INC_ROOT.'header.php');
		$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des sommets - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	//echo print_r($_SESSION);
	echo $data;

$db->deconnection();
?>