<?php
if(!isset($load_tpl)){
$load_tpl = true;
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
}
if(!empty($_GET['pid']))
{
	if($load_tpl){
		$pid = intval($_GET['pid']);
	}else{
		$num = 1;
	}
		
		if(isset($_GET['page']))
				$page = intval($_GET['page']);
			else
				$page = 1;
				
			if(isset($_GET['id_msg']) and !empty($_GET['id_msg'])){
				$page_com = intval($_GET['id_msg']);
				$num = $db->row($db->requete("SELECT COUNT(*) FROM com_point WHERE id_point = '$pid' AND id_com <= $page_com"));
				$page = ceil($num[0] / $_SESSION['nombre_message']);
			}
			
			$nb_par_page = $_SESSION['nombre_message'];
			$limite = ($page - 1) * $nb_par_page;
			
			if(!$load_tpl)
				$msg_order = 'DESC';
			else{
				$msg_order = $_SESSION['order'];
				$sql = $db->requete("SELECT COUNT(*) FROM com_point WHERE id_point = '$pid'");
				$nb_enregistrement = $db->row($sql);
				//echo print_r($nb_enregistrement);
				//echo $nb_enregistrement[0];
				$nombre_de_page = ceil($nb_enregistrement[0] / $nb_par_page);
				if ($nombre_de_page < $page)$page = $nombre_de_page;
				$liste_page = get_list_page($page, $nombre_de_page);
				
				//$data = get_file(TPL_ROOT.'refuge/fiche_refuge.tpl');
				if ($page > 1) {
					//$nb_message_page++;
					$limite--;
				}
			}
			
	//echo $nb_enr;
	//if ($nb_enregistrement[0] == 0)		
		$data = get_file(TPL_ROOT."sommets/fiche_sommet_com_empty.tpl");
	/*else
		$data = get_file(TPL_ROOT."sommets/fiche_sommet.tpl");*/
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);
	if($load_tpl)
	{
		$reponse =  $db->requete("SELECT * FROM point_gps
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
									LEFT JOIN membres ON membres.id_m = point_gps.id_m
									LEFT JOIN enligne ON enligne.id_m_join = point_gps.id_m
									LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
								WHERE id_point = '".$midi."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
	}else
	{
		$num = 1;
	}
	if($num > 0){
		//$donnees = $db->fetch($reponse);
	
	//On vérifi la validation du point GPS par l'équipe
	if($donnees['statut']==2)
	{
		$retour = $db->requete('SELECT COUNT(*) FROM messages WHERE id_topics = "'.$donnees['id_t'].'"');
		$nb_coms = $db->row($retour);		
		$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe.png" alt="validé par l\'équipe" /></a>';
		$com='<li>Discussions : <a href="'.$config['domaine'].'forum-29-'.$donnees['id_t'].'-'.title2url($donnees['nom_point']).'.html">('.$nb_coms[0].') commentaire(s)</a></li>';
	}
	else
	{
		$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe_encours.png" alt="validé par l\'équipe" /></a>';
		$com='';
	}
	if(isset($donnees['id_m_join']) AND $donnees['invisible'] == 0)
		$online = 'online';
	else	
		$online = 'offline';
	
	if($donnees['avatar'] != '')
		$avatar = '<img src="'.$donnees['avatar'].'" class="emplacement_avatar" alt="avatar" />';
	else
		$avatar = '';
				
		$data = parse_var($data,array(
			'nom_sommet'=>$donnees['nom_point'],
			'nom_massif_url'=>title2url($donnees['nom_massif']),
			'id_massif'=>$donnees['id_massif'],
			'alt_som'=>$donnees['altitude'],
			'massif'=>$donnees['nom_massif'],
			'lat'=>round($donnees['lat_point'], 3),
			'long'=>round($donnees['long_point'], 3),
			'iconRDM' => $donnees['icon_carte'],
			'design'=>$_SESSION['design'],
			'titre_page'=>$donnees['nom_point'].' ('.$donnees['altitude'].' m)- '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>$config['domaine'],
			'zoom'=>'11',
			'validation'=>$validate,
			'coms'=>$com,
			'avatar'=>$avatar,
			'enligne'=>$online,
			'id_m'=>$donnees['id_m'],
			'pseudo'=>$donnees['pseudo'],
			'info_bulle' => '<span style=\"font-weight:bold;\">'.$donnees['nom_point'].'</span><br />GPS : Lat : '.$donnees['lat_point'].' Long : '.$donnees['long_point'].'<br />Altitude : '.$donnees['altitude'].' m'
			));
		//Récupération des cartes...
		if(isset($donnees['idcarte']))
		{
			$id_carte = unserialize($donnees['idcarte']);
			$result =  $db->requete("SELECT * FROM cartes");
				while ($row = $db->fetch($result))
				{
					if (isset($row['id_carte']))
					{
						if (in_array($row['id_carte'], $id_carte))
						{
							$data = parse_boucle('CARTE',$data,FALSE,array(
							'CARTE.nom_carte'=>$row['num_carte'],
							'CARTE.nom_url_carte'=>title2url($row['nom_carte']),
							'CARTE.id_carte'=>$row['id_carte']
							));
						}
					}
				}	
			$data = parse_boucle('CARTE',$data,TRUE);
		}
		else
		{
			$data = parse_boucle('CARTE',$data,FALSE,array('CARTE.nom_carte'=>'Aucunes'));
			$data = parse_boucle('CARTE',$data,TRUE);
		}
		//On cherche les derniers topos entrés en base
		$sql = "SELECT topos.id_topo, visible, nom_topo, nom_point, orientation, difficulte_topo, altitude, id_activite, denniveles, topos.statut
				FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
			WHERE id_sommet = '".$donnees['id_point']."'
			AND topos.statut != 0
			AND visible = 1
			ORDER BY id_point DESC LIMIT 0,5";
		
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			if($row['id_activite'] == 1)
				{$r = '';}
			else
				{$r = 'r';}
			$data = parse_boucle('TOPOS',$data,FALSE,array(
			'TOPOS.id_topo'=>$row['id_topo'],
			'TOPOS.nom_topo'=>$row['nom_point'].', '.$row['nom_topo'],
			'TOPOS.nom_topo_url'=>title2url($row['nom_topo']),
			'TOPOS.r'=>$r,
			'TOPOS.orientation'=>$row['orientation'],
			'TOPOS.diff1'=>$row['difficulte_topo'],
			'TOPOS.alti'=>$row['denniveles'],
			'TOPOS.idact'=>$row['id_activite']
			));
		}
		
		$data = parse_boucle('TOPOS',$data,TRUE);

		//On cherche les dernières sorties
		$sql = "SELECT * FROM sortie
					LEFT JOIN topos ON topos.id_topo = sortie.id_topo
					LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
					LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
					LEFT JOIN departs ON departs.id_depart = topos.id_depart
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
					LEFT JOIN membres ON membres.id_m = sortie.id_m
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
			WHERE topos.id_sommet = '".$donnees['id_point']."'
			ORDER BY id_point DESC LIMIT 0,5";
		
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$text_lien = '';
				
			if($row['id_activite'] == 1)
				$text_lien = '[skis de randonnée] - '.$row['nom_point'].', '.$row['nom_topo'].'';
			else
				$text_lien = ''.$row['nom_point'].', '.$row['nom_topo'].'';
		
			$data = parse_boucle('SORTIES',$data,FALSE,array(
			'SORTIES.id_sortie'=>$row['id_sortie'],
			'SORTIES.date'=> date("d/m/Y", strtotime($row['dates'])),
			'SORTIES.text_lien'=>$text_lien,
			'SORTIES.url_sommet'=>title2url($row['nom_point']),
			'SORTIES.url_topo'=>title2url($row['nom_topo']),
			'SORTIES.pseudo'=>$row['pseudo']
			));
		}
		
		$data = parse_boucle('SORTIES',$data,TRUE);
		
			$data = parse_var($data,array('ids'=>$midi,'nom_massif'=>$donnees['nom_massif'], /*'repondre'=>$reponse,*/ 'design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));
	}	
	
}else
{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
