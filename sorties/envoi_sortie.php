<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');
require_once(ROOT.'fonctions/mini.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');

if(isset($_SESSION['ses_id']))
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_sortie'] == 1)
	{
		//On vérifi que tous les champs soit rempli
				
			$meteo = htmlentities($_POST['meteo'],ENT_QUOTES);		
			$recit = htmlentities($_POST['recit'],ENT_QUOTES);
			$jour = intval($_POST['jour']);
			$mois = intval($_POST['mois']);
			$annee = intval($_POST['annee']);
			$fichier = intval($_POST['gpx']);
			$activite = $_GET['acts'];
			$topo = $_GET['t'];
			
			$sql = "SELECT * FROM topos WHERE id_topo = '$topo'";
			$topo = $db->fetch($db->requete($sql));
			
			if(checkdate($mois, $jour, $annee) == FALSE)
			{
				$message = 'La date est mal renseigné';
				$type = "important";
				$redirection = DOMAINE;
			}
			elseif(!isset($_GET['t']))
			{
				$message = 'merci de selectionner un topo';
				$type = "important";
				$redirection = DOMAINE;
			}
			else
			{
				$date = $annee.'-'.$mois.'-'.$jour;
				$topo = intval($_GET['t']);
				$id_mapgpx = '';
				
				if (!isset($_GET['e']))
				{

					if(isset($_POST['meteo']) AND strlen(trim($_POST['meteo'])) > 2
						AND isset($_POST['recit']) AND strlen(trim($_POST['recit'])) > 2)
					{
						$sql = "INSERT INTO sortie VALUES 
						('', '".$_SESSION['mid']."', '$date', '$meteo', '', '', '$recit', '$recit', '$topo', '$fichier', '')";
						$db->requete($sql);
						
						$id_sortie = $db->last_id();
						
										
						$message = 'Ajout de la sortie effectué';
						$type = "ok";
						if ($activite == 1)
							$redirection = ROOT.'/mes-sorties-skis-de-randonnees.html';
						else	
							$redirection = ROOT.'/mes-sorties-de-randonnees.html';
						
					}
					else
					{
						$message = 'Un des champs est mal renseigné';
						$type = "important";
						$redirection = 'index.php';
					}			

			
				
				}
				else
				{
					$e = intval($_GET['e']);
					//ON vérifis que la sortie appartiens bien au membre
					$reponse =  $db->requete("SELECT * FROM sortie
												WHERE id_sortie = '".$e."'
												AND id_m = '".$_SESSION['mid']."'");
					$num = $db->num();
					$donnees = $db->fetch($reponse);

					if($num < 1)
					{
						$message = 'Vous ne pouvez pas éditer cette sortie';
						$type = "important";
						$redirection = '../mes-sorties.html';
					}
					else
					{
						if(isset($_POST['meteo']) AND strlen(trim($_POST['meteo'])) > 2 
						AND isset($_POST['recit']) AND strlen(trim($_POST['recit'])) > 2)
						{
						
							
							//On update les données de la table sortie
							$sql = "UPDATE sortie 
							SET dates = '$date',
								meteos = '$meteo',
								recit = '$recit',
								recit_parser = '$recit',
								id_mapgpx = '$fichier',
								id_t = ''
							WHERE id_sortie = '".$e."'";
							$db->requete($sql);
							$message = 'mise à jour de la sortie effectuée';
							$type = "important";
							if ($activite == 1)
								$redirection = ROOT.'/mes-sorties-skis-de-randonnees.html';
							else	
								$redirection = ROOT.'/mes-sorties-de-randonnees.html';
						}
						else
						{
						$message = 'Un des champs est mal renseigné';
						$type = "important";
						$redirection = 'index.php';
						}	
					}				
				}
			
			}


	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à ajouter une sortie. Ceci peut être que temporaire.';
		$type = "important";
		$redirection = 'index.php';
	}

}
else
{
	$message = "Vous devez être enregistrer pour ajouter/modifier/supprimer un article";
	$type = "erreur";
	$redirection = ROOT."connexion.html";
}
$db->deconnection();
echo display_notice($message,$type,$redirection);
?>
