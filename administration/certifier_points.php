<?php
/*
 * Créer le 17 sept. 13 par abcduweb
 *
 * Ceci est un morceau de code de http://www.revedemontagne.com
 * Cette partie est: la suppression de discution
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
require_once(INC_ROOT.'facebook.php');
				
if(!isset($_SESSION['ses_id']))
{
	$data = get_file(TPL_ROOT.'system_ei.tpl');
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
	$data = parse_var($data,array('message'=>$message,'type'=>$type,'redirection'=>$redirection,'TPL_ROOT'=>ROOT.'templates/','DESIGN'=>$_SESSION['design']));
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	
	if($auth['administrateur_points'] == 1)
	{
		if(isset($_POST['action']) AND $_POST['action'] == "validate")
		{
			$sql = "SELECT id_point FROM point_gps 					
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
					LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
					WHERE statut = '1'";
			$db->requete($sql);
			$i = 0;
			$idpts = array();
			$pts_valider = array();
			while($row = $db->fetch_assoc()){
				$idpts[] = $row['id_point'];
			}
			foreach($_POST['pts'] as $key => $var){
				if(!in_array($key,$idpts)){
					$message = "Vous ne pouvez pas certifier certains points.";
					$redirection = ROOT."certifier-des-points.html";
					echo display_notice($message,'important',$redirection);
					$db->deconnection();
					exit;
				}else{
					if(!isset($sqlEnd)){
						$sqlEnd = intval($key);
						$pts_valider[] = intval($key);
					}else{
						$sqlEnd .= ', '.intval($key);
						$pts_valider[] = intval($key);
					}
					$i++;
				}
			}
			
			//print_r($pts_valider);
			foreach($pts_valider as $key => $var)
			{
				$sql2 = $db->requete("SELECT id_group, id_t, id_type, id_point, membres.id_m, nom_point, nom_type, icon_carte, lat_point, long_point, altitude FROM point_gps 					
				LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
				LEFT JOIN membres ON membres.id_m = point_gps.id_m
				WHERE id_point = '".$var."'");
				$fiche = $db->fetch($sql2);
			
				if($fiche['id_t'] == 0)
				{
					if($fiche['id_group'] != 1)
					{
						//On envoi le message privé
						$sql = "INSERT INTO messages_discution VALUES('','','Nous venons de valider : ".$fiche['nom_type']." ".$fiche['nom_point']."','Nous venons de valider : ".$fiche['nom_type']." ".$fiche['nom_point']."',UNIX_TIMESTAMP(),0,0)";
						$db->requete($sql);
						$idM = $db->last_id();
						$sql = "INSERT INTO liste_discutions VALUES('','<strong>[Certification]</strong> ".$fiche['nom_point']."','',$idM,'0',1,0,0)";
						$db->requete($sql);
						$idDiscu = $db->last_id();
						$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
						$db->requete("INSERT INTO discutions_lues VALUES('".$fiche['id_m']."','$idDiscu','0','1')");
						//unlink(ROOT.'caches/.htcache_mpm_'.$fiche['id_m']);
					}
					
					//Ajout du topic
					if($fiche['id_type'] < 8){
						$lien = 'detail-'.title2url($fiche['nom_point']).'-'.$fiche['id_point'].'-1.html';
						$f = 28;
					}elseif($fiche['id_type'] < 11){
						$lien = 'detail-'.title2url($fiche['nom_point']).'-'.$fiche['id_point'].'-2.html';
						$f = 29;
					}else{
						$lien='';
						$f = '';
					}
					
					$titre = $fiche['nom_type'].' - '.$fiche['nom_point'];
					$sous_titre = '';

					$text = htmlentities("Vous avez des remarques, un compl&eacute;ment d&#039;information &agrave; faire pour <a href=\"'".$lien."'\">".$fiche['nom_point']."</a>, c&#039;est ici qu&#039;il faut le faire...",ENT_QUOTES);
					$text_parser = $db->escape(zcode(stripslashes("Vous avez des remarques, un compl&eacute;ment d'information &agrave; faire pour <lien url='".$lien."'>".$fiche['nom_point']."</lien>, c'est ici qu'il faut le faire...")));
					
					$sql = "INSERT INTO topics VALUES('','0','$f','$titre','$sous_titre',2,UNIX_TIMESTAMP(),'0','0','1','0','0','0')";
					$result = $db->requete($sql);
					$id_t = $db->last_id();
				
					$sql = "INSERT INTO messages VALUES('','$id_t','2','Revedemontagne','$text','$text_parser',UNIX_TIMESTAMP(),0,1)";
					$result = $db->requete($sql);
					$id_m = $db->last_id();
					
					$sql = "UPDATE topics SET id_last_message = '$id_m',nb_reponse = nb_reponse + 1 WHERE id_t = '$id_t'";
					$result = $db->requete($sql);
				
					$sql = "UPDATE forum SET id_last_topics = '$id_t', nb_topic = nb_topic + 1 WHERE id_f = '$f'";
					$result = $db->requete($sql);
							
					$sql = "UPDATE membres SET last_post = UNIX_TIMESTAMP(),nb_post_m = nb_post_m + 1  WHERE id_m = 2";
					$result = $db->requete($sql);
					
					$sql = "UPDATE point_gps SET id_t = '$id_t' WHERE id_point = '".$var."'";
					$result = $db->requete($sql);
				}
				else
				{
					//Revalidation du dispositif
					//On envoi le message privé
					$sql = "INSERT INTO messages_discution VALUES('','','Nous venons de valider les modifications apportées à : ".$fiche['nom_point']."','Nous venons de valider les modifications apportées à ".$fiche['nom_point']."',UNIX_TIMESTAMP(),2,0)";
					$db->requete($sql);
					$idM = $db->last_id();
					$sql = "INSERT INTO liste_discutions VALUES('','<strong>[Certification]</strong> ".$fiche['nom_point']."','',$idM,'2',1,0,0)";
					$db->requete($sql);
					$idDiscu = $db->last_id();
					$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
					$db->requete("INSERT INTO discutions_lues VALUES('".$fiche['id_m']."','$idDiscu','0','1')");	
					
					$sql = "UPDATE point_gps SET id_t = '$id_t' WHERE id_point = '".$var."'";
					$result = $db->requete($sql);					
				}
				
			}
			
			$sql = "UPDATE point_gps SET `statut` = 2 WHERE `statut` = 1 AND id_point IN (".$sqlEnd.')';
			$db->requete($sql);
			
		
			$message = 'Vous venez de certifier '.$i.' points.';
			$type = 'ok';
			$redirection = ROOT.'certifier-des-points.html';
			$data = display_notice($message,$type,$redirection);
		}
		else
		{
			if(isset($_GET['page']))
				$page = intval($_GET['page']);
			else
				$page = 1;
			
			$nb_message_page = $_SESSION['nombre_news'];
			$sql = ("SELECT * FROM point_gps
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
					LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
					WHERE point_gps.statut = 1");	
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
					case '<a href="certifier-des-points-p....html">&#8201;...&#8201;</a> ':
					$liste_page .= $var;
					break;
					default:
					$liste_page .= '<a href="certifier-des-points-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
				}
			}

			if($nb_enregistrement > 0)
			{
				$data = get_file(TPL_ROOT.'admin/certifier_points.tpl');
				include(INC_ROOT.'header.php');
				
				$sql = ("SELECT * FROM point_gps
						LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
						LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
						LEFT JOIN type_gps ON type_gps.id_type = point_gps.type_point
						WHERE point_gps.statut = 1
						ORDER BY point_gps.id_point ASC LIMIT $limite,$nb_message_page");	
				$result = $db->requete($sql);

								
				while ($row = $db->fetch($result))
				{
					$selected1 = '';
					$selected2 = '';
					
					if($row['statut']==1)
						$selected1 = 'checked="checked"';
					else
						$selected2 = 'checked="checked"';
						
					$data = parse_boucle('listepoints',$data,FALSE,array(
					'listepoints.id_som'=>$row['id_point'],
					'listepoints.nom_som_url'=>title2url($row['nom_point']),
					'listepoints.nom_som'=>$row['nom_point'],
					'listepoints.mass'=>$row['nom_massif'],
					'listepoints.alt'=>$row['altitude'],
					'listepoints.lat'=>$row['lat_point'],
					'listepoints.lng'=>$row['long_point'],
					'listepoints.type'=>$row['nom_type'],
					'listepoints.selected1'=>$selected1,
					'listepoints.selected2'=>$selected2,
					));
				}
							
				$data = parse_boucle('listepoints',$data,TRUE);
				$data = parse_var($data,array('liste_page'=>$liste_page, 'nb_requetes'=>$db->requetes,'titre_page'=>'Certification points - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));

			}
			else
			{
				$data = get_file(TPL_ROOT.'admin/liste_pts_a_certifier_empty.tpl');
				include(INC_ROOT.'header.php');
				$data = parse_var($data,array('liste_page'=>$liste_page,'nb_requetes'=>$db->requetes,'titre_page'=>'Liste des sommets - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
			}
		}
	}
	else
	{
		$message = 'Vous n\'êtes pas autorisé à accéder à cette partie du site.';
		$type = 'important';
		$redirection = ROOT.'index.html';
		$data = display_notice($message,$type,$redirection);
	}
}

echo $data;

$db->deconnection();
?>