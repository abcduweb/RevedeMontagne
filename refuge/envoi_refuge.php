<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
include(ROOT.'fonctions/zcode.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_points'] == 1 OR $auth['administrateur_points'] == 1)
	{
				//On vérifi la suppréssion
		if(isset($_GET['del']) AND $_GET['del'] == 1)
		{
			$idt = intval($_GET['idt']);
			$del = intval($_GET['del']);
			
			$reponse =  $db->requete("SELECT *
				FROM point_gps
				WHERE id_point = '".$idt."' AND type_point BETWEEN '1' AND '7'");
			$num = $db->num();
			$donnees = $db->fetch($reponse);
			if($num == 1 AND $donnees['id_m'] == $_SESSION['mid'] OR $auth['administrateur_points'] == 1)
			{
				if(isset($_GET['valider']) AND $_GET['valider'] == 1)
				{
					//On passe le topo à 0
					$sql = "UPDATE point_gps SET statut = 0 WHERE id_point = '".$idt."'";
					$db->requete($sql);
					unlink(ROOT.'caches/.htcache_index');
					
					$message = 'l\'abris / cabane a &eacute;t&eacute; supprim&eacute;';
					$type = "ok";
					$redirection = DOMAINE.'mes-refuges-m'.$_SESSION['mid'].'.html';
					$data = display_notice($message,$type,$redirection);
				}
				else
				{
					$url = 'envoi_refuge.php?idt='.$idt.'&amp;del='.$del.'&amp;valider=1';
					$message = 'Etes vous sûr de vouloir supprimer ce point?';
					$data = display_confirm($message,$url);
				}
				
			}
			else
			{
				$message = 'Vous ne pouvez pas supprimer cet abris';
				$type = "important";
				$redirection = DOMAINE.'mes-refuges-m'.$_SESSION['mid'].'.html';
				$data = display_notice($message,$type,$redirection);
			}
			
		}
		elseif(isset($_GET['del']) AND $_GET['del'] != 1)
		{
			$message = "Action non permise";
			$redirection = ROOT."mes-refuges-m'".$_SESSION['mid']."'";
			//$data = display_notice($message,'important',$redirection);
			$data = display_notice($message,$type,$redirection);
		}
		else
		{
			//On vérifi que tous les champs soit rempli
			if(	(isset($_POST['type']) AND strlen(trim($_POST['type'])) > 0) 
				AND (isset($_POST['departement']) AND strlen(trim($_POST['departement'])) > 0) 
				AND (isset($_POST['altitude']) AND strlen(trim($_POST['altitude'])) > 0) 
				AND (isset($_POST['altitude']) AND strlen(trim($_POST['altitude'])) < 5) 
				AND (isset($_POST['massif']) AND ($_POST['massif']!= 0) AND isset($_POST['nbre_place']))
				AND (isset($_POST['lat']) AND strlen(trim($_POST['lat'])) > 0) 
				AND (isset($_POST['lat']) AND strlen(trim($_POST['lat'])) < 10) 
				AND (isset($_POST['lng']) AND strlen(trim($_POST['lng'])) > 0) 
				AND (isset($_POST['lng']) AND strlen(trim($_POST['lng'])) < 10) 
				AND (isset($_POST['intro']) AND strlen(trim($_POST['intro'])) > 0) 
				AND (isset($_POST['conclu']) AND strlen(trim($_POST['conclu'])) > 0)
			  )
			{
				
				$nom_refuge = htmlentities($_POST['nom_refuge'],ENT_QUOTES);	
				$nbre_place = intval($_POST['nbre_place']);
				$type = intval($_POST['type']);
				$departement = intval($_POST['departement']);
				$altitude = intval($_POST['altitude']);
				$latitude = htmlentities($_POST['lat'],ENT_QUOTES);
				$longitude = htmlentities($_POST['lng'],ENT_QUOTES);
				$massif = intval($_POST['massif']);
				$intro       = htmlentities($_POST['intro'],ENT_QUOTES);
				$intro_parser = $db->escape(zcode($_POST['intro']));
				$conclu      = htmlentities($_POST['conclu'],ENT_QUOTES);
				$conclu_parser = $db->escape(zcode($_POST['conclu']));
				$carte = serialize ($_POST['carte']);
				if ($auth['administrateur_points'] == 1)
					$statut = 2;
				else
					$statut = 1;
				
					
				if (!isset($_GET['e']))
				{
					
					$sql = $db->requete("SELECT * FROM type_gps WHERE id_type = '".$type."'");
					$pointgps = $db->fetch($sql);
						
					$sql = "INSERT INTO point_gps VALUES 
					('', '$nom_refuge', '$latitude', '$longitude', '$altitude', '".$pointgps['icon_carte']."', '$massif', '$type', '".$_SESSION['mid']."', NOW(), '$carte', '0', '$statut', '".$departement."')";
					$db->requete($sql);
					$id_pts = $db->last_id();
					
					$sql = "INSERT INTO refuge VALUES 
					('', '$id_pts', '".$pointgps['id_type']."', '$nbre_place', NOW(), NOW(), '$altitude', '$latitude', '$longitude', '$intro', '$intro_parser', '$conclu', '$conclu_parser', '1',  '$massif')";
					$db->requete($sql);
					
					//On insert les photos en attente
					
					echo'session'.$_SESSION['tmpImg'].$_SESSION['SsubDir'];
				
					if(isset($_SESSION['tmpImg'])){
					$sql = "UPDATE images SET s_dir = '$id_pts',tmp = 0 WHERE dir = '6' AND tmp = 1 AND  s_dir = 0 AND id_owner = '$_SESSION[mid]'";
					$db->requete($sql);		
					if(isset($_SESSION['SsubDir']['tmp'])){
					$key = array_keys($_SESSION['SsubDir']['tmp']);
					unset($_SESSION['dir'.$key[0]]);
					unset($_SESSION['SsubDir']);
					}
						unset($_SESSION['tmpImg']);
					}
					
					
					$message = 'Ajout de la fiche effectu&eacute;e';
					$type = "ok";
					$redirection = DOMAINE.'/liste-des-refuges-'.$massif.'.html';
					$data = display_notice($message,$type,$redirection);
				
				}
				else
				{
					$e = intval($_GET['e']);
					//ON vérifis que le topo appartiens bien au membre
					$reponse =  $db->requete("SELECT * FROM point_gps
												LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
												LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
												WHERE id_point = '".$e."'
												AND id_m = '".$_SESSION['mid']."'");
					$num = $db->num();
					$donnees = $db->fetch($reponse);
					if($num < 1 AND $_SESSION['group'] != 1)
					{
						$message = 'Cette fiche ne vous appartiens pas';
						$type = "important";
						$redirection = 'liste-des-refuges-m.html';
						$data = display_notice($message,$type,$redirection);
					}
					else
					{
						
						//On sécurise les variables
						$edit_com_point = $_POST['com_forum'];
						//Je récupére le type de point
						$sql = $db->requete("SELECT * FROM type_gps WHERE id_type = '".$type."'");
						$pointgps = $db->fetch($sql);
					
						//On update les données de la table point_gps
						$sql = "UPDATE point_gps 
						SET nom_point = '$nom_refuge',
							lat_point = '$latitude',
							long_point = '$longitude',
							altitude = '$altitude',
							icones = '".$pointgps['icon_carte']."',
							id_massif = '$massif',
							type_point = '$type', 
							idcarte = '$carte',
							statut = '$statut',
							departement_id = '".$departement."',
							id_t = '".$edit_com_point."'
						WHERE id_point = '".$e."'";
						$db->requete($sql);
						
						$sql = "UPDATE refuge
						SET type_refuge = '$type',
							places_couchage = '$nbre_place',
							acces = '$intro',
							acces_parse = '$intro_parser',
							remarques = '$conclu',
							remarque_parse = '$conclu_parser',
							date_maj = now()
						WHERE id_point = '".$e."'";
						$db->requete($sql);
						
						//On insert les photos en attente					
						if(isset($_SESSION['tmpImg'])){
							$sql = "UPDATE images SET s_dir = '$e',tmp = 0 WHERE dir = '6' AND tmp = 1 AND  s_dir = 0 AND id_owner = '$_SESSION[mid]'";
							$db->requete($sql);
							if(isset($_SESSION['SsubDir']['tmp'])){
						$key = array_keys($_SESSION['SsubDir']['tmp']);
						unset($_SESSION['dir'.$key[0]]);
						unset($_SESSION['SsubDir']);
						}
							unset($_SESSION['tmpImg']);
						}

						
						$message = 'mise a jour de la fiche effectu&eacute;e';
						$type = "ok";
						$redirection = DOMAINE.'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-1.html';
						$data = display_notice($message,$type,$redirection);
					}
					
				}
				
				

			}			
			else
			{
				$message = 'Un des champs est mal renseign&eacute;';
				$type = "liste-des-refuges.html";
				$redirection = 'index.php';
				$data = display_notice($message,$type,$redirection);
			}
		}
	}
	else
	{
		$message = 'Vous n\'&eacute;tes pas autoris&eacute; à ajouter un refuge. Ceci peut être que temporaire.';
		$type = "important";
		$redirection = 'liste-des-refuges.html';
		$data = display_notice($message,$type,$redirection);
	}

}
else
{
	$message = "Vous devez être enregistrer pour ajouter/modifier/supprimer un point";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
	$data = display_notice($message,$type,$redirection);
}
$db->deconnection();
echo $data;
?>
