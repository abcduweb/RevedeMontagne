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
		
		//On v�rifi la suppr�ssion
		if(isset($_GET['del']) AND $_GET['del'] == 1)
		{
			$idt = intval($_GET['idt']);
			$del = intval($_GET['del']);
			
			$reponse =  $db->requete("SELECT *
				FROM point_gps
				WHERE id_point = '".$idt."' AND type_point BETWEEN '9' AND '10'");
			$num = $db->num();
			$donnees = $db->fetch($reponse);
			if($num == 1 AND $donnees['id_m'] == $_SESSION['mid'] OR $auth['administrateur_points'] == 1)
			{
				if(isset($_GET['valider']) AND $_GET['valider'] == 1)
				{
					//On passe le topo � 0
					$sql = "UPDATE point_gps SET statut = 0 WHERE id_point = '".$idt."'";
					$db->requete($sql);
					unlink(ROOT.'caches/.htcache_index');
					
					$message = 'le sommet a �t� supprim�';
					$type = "ok";
					$redirection = DOMAINE.'mes-sommets-m'.$_SESSION['mid'].'.html';
					$data = display_notice($message,$type,$redirection);
				}
				else
				{
					$url = 'envoi_sommet.php?idt='.$idt.'&amp;del='.$del.'&amp;valider=1';
					$message = 'Etes vous s�r de vouloir supprimer ce point?';
					$data = display_confirm($message,$url);
				}
				
			}
			else
			{
				$message = 'Vous ne pouvez pas supprimer ce sommet';
				$type = "important";
				$redirection = DOMAINE.'mes-sommets-m'.$_SESSION['mid'].'';
				$data = display_notice($message,$type,$redirection);
			}
			
		}
		elseif(isset($_GET['del']) AND $_GET['del'] != 1)
		{
			$message = "Action non permise";
			$redirection = ROOT."mes-sommets-m'".$_SESSION['mid']."'";
			//$data = display_notice($message,'important',$redirection);
			$data = display_notice($message,$type,$redirection);
		}
		else
		{
			//On v�rifi que tous les champs soit rempli
			
			if(	(isset($_POST['type_sommet']) AND strlen(trim($_POST['type_sommet'])) > 0) 
				AND (isset($_POST['departement']) AND strlen(trim($_POST['departement'])) > 0) 
				AND (isset($_POST['altitude']) AND strlen(trim($_POST['altitude'])) > 0) 
				AND (isset($_POST['altitude']) AND strlen(trim($_POST['altitude'])) < 5) 
				AND (isset($_POST['lat']) AND strlen(trim($_POST['lat'])) > 0) 
				AND (isset($_POST['lat']) AND strlen(trim($_POST['lat'])) < 10) 
				AND (isset($_POST['lng']) AND strlen(trim($_POST['lng'])) > 0) 
				AND (isset($_POST['lng']) AND strlen(trim($_POST['lng'])) < 10) 
				AND (isset($_GET['idm'])) 
			  )
			{
				
				$nom_sommet = htmlentities($_POST['nom_sommet'],ENT_QUOTES);		
				$type = intval($_POST['type_sommet']);
				$departement = intval($_POST['departement']);
				$altitude = intval($_POST['altitude']);
				$latitude = htmlentities($_POST['lat'],ENT_QUOTES);
				$longitude = htmlentities($_POST['lng'],ENT_QUOTES);
				$massif = intval($_GET['idm']);
				$carte = serialize ($_POST['carte']);
				//$idcarte = intval($_POST['type_carte']);
				//$gps = htmlentities($_POST['gps'],ENT_QUOTES);
				
					
				if (!isset($_GET['e']))
				{
				
					$sql = $db->requete("SELECT * FROM type_gps WHERE id_type = '".$type."'");
					$pointgps = $db->fetch($sql);
						
					$sql = "INSERT INTO point_gps VALUES 
					('', '$nom_sommet', '$latitude', '$longitude', '$altitude', '".$pointgps['icon_carte']."', '$massif', '".$type."', '".$_SESSION['mid']."', NOW(), '$carte', '0', '1', '".$departement."')";
					$db->requete($sql);
					
					$id_som = $db->last_id();
					
					$message = 'Ajout de la fiche effectu�e';
					$type = "ok";
					$redirection = DOMAINE.'mes-sommets-m'.$_SESSION['mid'].'.html';
					$data = display_notice($message,$type,$redirection);
				
				}
				else
				{
					$e = intval($_GET['e']);
					$m = intval($_GET['ids']);
					//ON v�rifis que le topo appartiens bien au membre
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
						$redirection = ROOT.'liste-des-sommets-m'.intval($_GET['idm']).'.html';
						$data = display_notice($message,$type,$redirection);
					}
					else
					{
						//Je r�cup�re le type de point
						$sql = $db->requete("SELECT * FROM type_gps WHERE id_type = '".$type."'");
						$pointgps = $db->fetch($sql);
						//print_r($_POST['carte']);
						//On update les donn�es de la table point_gps
						$sql = "UPDATE point_gps 
						SET nom_point = '$nom_sommet',
							lat_point = '$latitude',
							long_point = '$longitude',
							altitude = '$altitude',
							icones = '".$pointgps['icon_carte']."',
							id_massif = $massif,		
							idcarte = '$carte',
							statut = '1',
							departement_id = '".$departement."'
						WHERE id_point = '".$m."'";
						$db->requete($sql);
									
						$message = 'mise � jour de la fiche effectu�e';
						$type = "important";
						$redirection = ROOT.'mes-sommets-m'.$_SESSION['mid'].'.html';
						$data = display_notice($message,$type,$redirection);
					}				
				}
				
				

			}			
			else
			{
				$message = 'Un des champs est mal renseign�';
				$type = "important";
				$redirection = $config['domaine'].'ajouter-un-sommet-m'.$_GET['idm'].'.html';
				$data = display_notice($message,$type,$redirection);
			}
		}
	}
	else
	{
		$message = 'Vous n\'�tes pas autoris� � ajouter un refuge. Ceci peut �tre que temporaire.';
		$type = "important";
		$redirection = 'index.php';
		$data = display_notice($message,$type,$redirection);
	}

}
else
{
	$message = "Vous devez �tre enregistrer pour ajouter/modifier/supprimer un article";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
	$data = display_notice($message,$type,$redirection);
}
$db->deconnection();
echo $data;
?>
