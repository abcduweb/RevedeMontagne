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
			$id_mass = intval($_GET['massif']);
			$nb_message_page = $_SESSION['nombre_news'];
			$sql = ("SELECT * FROM point_gps
						LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
						LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
						WHERE type_point > 0
						AND type_point < 8
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
					case '<a href="liste-des-refuges-p....html">&#8201;...&#8201;</a> ':
						$liste_page .= $var;
					break;
					default:
					$liste_page .= '<a href="liste-des-refuges-m'.$id_mass.'-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
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
						$redirection = $config['domaine'].'liste-des-refuges.html';
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
							WHERE point_gps.type_point > 0
							AND point_gps.type_point < 8
							AND point_gps.statut>0
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
							$liste_page .= '<a href="mes-refuges-m'.$id_m.'-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
						}
					}
					if($nb_enregistrement > 0)
					{
						$data = get_file(TPL_ROOT.'refuge/mes_refuges.tpl');
						
						if ($id_m == $_SESSION['mid'])
							{
								$hcol_action = '<th>Actions</th>';
								$nb_colonne = 5;
							}
							else
							{
								$hcol_action = '';
								$nb_colonne = 4;
							}
							
						if(!isset($_SESSION['ses_id']))
							{
								$ajout_refuge = 'Pour ajouter un refuge il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
							}
							else
							{
								$ajout_refuge = '<a href="ajouter-un-refuge.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
							}
			
						include(INC_ROOT.'header.php');
								$sql = "SELECT * FROM point_gps
										LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
										LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
										LEFT JOIN refuge ON refuge.id_point = point_gps.id_point
										LEFT JOIN type_gps ON type_gps.id_type = refuge.type_refuge
										WHERE point_gps.type_point > 0
										AND point_gps.type_point < 8
										AND point_gps.id_m='".$id_m."'
										AND point_gps.statut>0
										ORDER BY point_gps.id_point DESC LIMIT $limite,$nb_message_page";
						$result = $db->requete($sql);
						
						$ligne = 1;
						while ($row = $db->fetch($result))
						{						
						if($row['id_m'] == $_SESSION['mid'])
							$colaction='<td class="centre"><a href="'.$config['domaine'].'edition-fiche-refuge-'.$row['id_point'].'.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
											<a href="'.$config['domaine'].'refuge/envoi_refuge.php?idt='.$row['id_point'].'&del=1"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
						else
							$colaction='';
							
							$data = parse_boucle('refuges',$data,FALSE,array(
							'refuges.url_nom_refuges'=>title2url($row['nom_point']),
							'refuges.id_refuge'=>$row['id_point'],
							'refuges.nom_refuge'=>$row['nom_point'],
							'refuges.mass'=>$row['nom_point'],
							'refuges.denniveles'=>$row['altitude'],
							'refuges.type'=>$row['nom_type'],
							'refuges.col_action'=>$colaction,
							'refuges.ligne'=>$ligne
							));
							if($ligne == 1)
								$ligne = 2;
							else
								$ligne = 1;
						}
						$data = parse_boucle('refuges',$data,TRUE);
						
						$data = parse_var($data,array('pseudo'=>$mbre['pseudo'], 'ajout_som'=>$ajout_refuge, 'hcol_action'=>$hcol_action, 'nb_colonne'=>$nb_colonne, 'liste_page'=>$liste_page, 'nb_requetes'=>$db->requetes,'titre_page'=>'Refuges / Cabanes proposés par '.$mbre['pseudo'].' - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
					}
					else
					{
						$data = get_file(TPL_ROOT.'refuge/mes_refuges_empty.tpl');
						include(INC_ROOT.'header.php');
						$data = parse_var($data,array('pseudo'=>$mbre['pseudo'], 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Refuges / Cabanes proposés par '.$mbre['pseudo'].' - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
					}
				}
			}
			else
			{
				$data = get_file(TPL_ROOT.'refuge/liste_refuge_empty_mass.tpl');
				include(INC_ROOT.'header.php');
				
				
				
					//requête du haut de page
					$sql = "SELECT *, massif.id_massif AS idm
					FROM massif_groupe 
					LEFT JOIN massif ON massif.idg = massif_groupe.idg_massif 
					LEFT JOIN (
							SELECT type_point, IF( COUNT(id_point) = 0, 0, COUNT(id_point) ) AS nb_refuge, id_massif
							FROM point_gps
							WHERE point_gps.type_point BETWEEN 1 AND 7
							AND point_gps.statut>0
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

						
						
						$data = parse_boucle('MASSIF',$data,false,array('MASSIF.nb_refuge'=>intval($row['nb_refuge']),'MASSIF.id_massif'=>$row['idm'],'MASSIF.nom_massif'=>$row['nom_massif'], 'ligne'=> $ligne));
						if($ligne == 1)
							$ligne = 2;
						else
							$ligne = 1;
					}
					
					$data = parse_boucle('MASSIF',$data,TRUE);
					$data = parse_boucle('MASSIFG',$data,TRUE);
				$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'Liste des refuges - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
			}
		}
	elseif($nb_enregistrement > 0){
		if(!isset($_SESSION['ses_id']))
		{
			$ajout_sommet = 'Pour ajouter un refuge il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';
		}
		else
		{
			$ajout_sommet = '<a href="ajouter-un-refuge.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';
		}
		
		
		$data = get_file(TPL_ROOT.'refuge/liste_refuge.tpl');
		$data = parse_var($data,array('ajout_refuge'=>$ajout_sommet));
		include(INC_ROOT.'header.php');
		$sql = "SELECT * FROM point_gps
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
				LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
				LEFT JOIN refuge ON refuge.id_point = point_gps.id_point
				LEFT JOIN type_gps ON type_gps.id_type = refuge.type_refuge
				WHERE point_gps.type_point BETWEEN 1 AND 7
				AND point_gps.id_massif='".$id_mass."'
				AND point_gps.statut>0
				ORDER BY point_gps.id_point ASC LIMIT $limite,$nb_message_page";
		$result = $db->requete($sql);
		$ligne = 1;
		while ($row = $db->fetch($result))
		{			

			$data = parse_boucle('listerefuge',$data,FALSE,array(
			'listerefuge.id_point'=>$row['id_point'],
			'listerefuge.nom_refuge_url'=>title2url($row['nom_point']),
			'listerefuge.nom_refuge'=>$row['nom_point'],
			'listerefuge.altitude'=>$row['altitude'],
			'listerefuge.type'=>$row['nom_type'],
			'ligne'=>$ligne
			));
			$massif=$row['nom_massif'];
			$id_massif = $row['id_massif'];
			$type_point = $row['id_type'];
			
			if($ligne == 1)
				$ligne = 2;
			else
				$ligne = 1;
		}
		$data = parse_boucle('listerefuge',$data,TRUE);
		$data = parse_var($data,array('idmassif'=> $id_massif, 'typepoint'=> $type_point,'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>$massif.', liste des refuges - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	else{
		$data = get_file(TPL_ROOT.'refuge/liste_refuge_empty.tpl');
		include(INC_ROOT.'header.php');
		
		$sql = "SELECT * FROM massif WHERE id_massif='".$id_mass."'";
		$massif = $db->fetch($db->requete($sql));
	
		$data = parse_var($data,array('nom_massif' => $massif['nom_massif'], 'liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des refuges - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
	}
	echo $data;

$db->deconnection();
?>