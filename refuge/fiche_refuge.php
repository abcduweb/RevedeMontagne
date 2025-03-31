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
		$data = get_file(TPL_ROOT."refuge/fiche_refuge_com_empty.tpl");
	/*else
		$data = get_file(TPL_ROOT."sommets/fiche_sommet.tpl");*/
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);
	if($load_tpl)
	{
		$image_a_la_une = '<img src="'.$config['domaine'].'templates/images/1/abris_125x125.jpg" alt="Image à la une" />';
		$reponse =  $db->requete("SELECT id_m_join, invisible, point_gps.id_m, avatar, pseudo, id_t, nom_point, idcarte, nom_type, icon_carte, places_couchage, DATE_FORMAT(date_maj, 'le %d/%m/%Y &agrave; %H:%i:%s') as datemaj, nom_massif, point_gps.id_massif, altitude, lat_point, long_point, acces_parse, remarque_parse, point_gps.statut AS statut
									FROM point_gps
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN refuge ON refuge.id_point = point_gps.id_point
									LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
									LEFT JOIN membres ON membres.id_m = point_gps.id_m
									LEFT JOIN enligne ON enligne.id_m_join = point_gps.id_m
								WHERE point_gps.id_point = '".$midi."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
	}else
	{
		$num = 1;
	}
	if($num > 0){
	
	//On vérifi la validation du point GPS par l'équipe
	if($donnees['statut']==2)
	{
		$retour = $db->requete('SELECT COUNT(*) FROM messages WHERE id_topics = "'.$donnees['id_t'].'"');
		$nb_coms = $db->row($retour);		
		$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe.png" alt="validé par l\'équipe" /></a>';
		$com='<label>Discussions : </label><a href="'.$config['domaine'].'forum-29-'.$donnees['id_t'].'-'.title2url($donnees['nom_point']).'.html">('.$nb_coms[0].') commentaire(s)</a><br />';
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
		
		//$donnees = $db->fetch($reponse);
		$id_carte = unserialize($donnees['idcarte']);

		if(/*$donnees['point_gps.id_m'] == $_SESSION['id_m'] AND*/ isset($_SESSION['ses_id']))
		{
			$modifier_fiche = '<label>Modifier</label> <a href="'.$config['domaine'].'edition-fiche-refuge-'.$midi.'.html">'.$donnees['nom_point'].'</a><br />';
		}
		else
		{
			$modifier_fiche = "";
		}

		$data = parse_var($data,array(
			'nom_refuge'=>$donnees['nom_point'],
			'type_cabane'=>$donnees['nom_type'],
			'type_icone'=>$donnees['icon_carte'],
			'nbre_place'=>$donnees['places_couchage'],
			'nom_refuge_url'=>title2url($donnees['nom_massif']),
			'id_massif'=>$donnees['id_massif'],
			'alt_refuge'=>$donnees['altitude'],
			'massif'=>$donnees['nom_massif'],
			'lat'=>round($donnees['lat_point'], 3),
			'long'=>round($donnees['long_point'], 3),
			'iconRDM' => $donnees['icon_carte'],
			'intro'=>$donnees['acces_parse'],
			'conclu'=>$donnees['remarque_parse'],
			'design'=>$_SESSION['design'],
			'titre_page'=>$donnees['nom_point'].' ('.$donnees['altitude'].' m)- '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>$config['domaine'],
			'zoom'=>'11',
			'validation'=>$validate,
			'coms'=>$com,
			'avatar'=>$avatar,
			'enligne'=>$online,
			'id_m'=>$donnees['id_m'],
			'pseudo'=>$donnees['pseudo'],
			'maj'=>$donnees['datemaj'],
			'modifier_fiche' => $modifier_fiche,
			'edit_rapide_intro' => 'ondblclick="inlineMod('.$midi.', this, \'intro\');"',
			'edit_rapide_conclu' => 'ondblclick="inlineMod('.$midi.', this, \'conclu\');"',
			'info_bulle' => '<span style=\"font-weight:bold;\">'.$donnees['nom_point'].'</span><br />GPS : Lat : '.$donnees['lat_point'].' Long : '.$donnees['long_point'].'<br />Altitude : '.$donnees['altitude'].' m',
			'image_a_la_une' => $image_a_la_une
			));
		
		//Récupération des cartes...
		$id_carte = unserialize($donnees['idcarte']);
		if(!empty($id_carte))
		{
			$result =  $db->requete("SELECT * FROM cartes");
			while ($row = $db->fetch($result))
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
			
			$data = parse_boucle('CARTE',$data,TRUE);
		}
		else
		{
			$data = parse_boucle('CARTE',$data,FALSE,array('CARTE.nom_carte'=>'Aucunes'));
			$data = parse_boucle('CARTE',$data,TRUE);
		}
		
		$data = parse_var($data,array('nom_massif'=>$donnees['nom_massif'], /*'repondre'=>$reponse,*/ 'design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));
	}	
	
	$config['og_facebook_description'] = $donnees['nom_type'].' situe dans le massif '.$donnees['nom_massif'];
	$config['og_facebook_url'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	$config['og_facebook_title'] = $donnees['nom_point'].' - ('.$donnees['altitude'].' m)';
	$config['og_facebook_image'] = $donnees['icon_carte'];
	include(INC_ROOT.'footer.php');
	
}else
{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>
