<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
//echo $_SESSION['ses_id'];
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_points'] == 1)
	{
		//On vérifi que tous les champs soit rempli
				
			$nom_depart = htmlentities($_POST['nom_depart'],ENT_QUOTES);		
			$altitude = intval($_POST['altitude']);
			$acces = htmlentities($_POST['acces'],ENT_QUOTES);
			$lat = floatval($_POST['lat']);
			$lng = floatval($_POST['lng']);
			$massif = intval($_GET['m']);
			$lienpage = htmlentities($_POST['lienpage'],ENT_QUOTES);
				
			if (!isset($_GET['e']))
			{
				if(isset($nom_depart)
					AND isset($altitude)
					AND isset($acces)
					AND isset($lat)
					AND isset($lng)
					AND isset($massif))
				{
					$sql = "INSERT INTO departs VALUES 
					('', '$nom_depart', '$acces', '$acces', '$lat', '$lng', '$altitude', '$massif', '".$_SESSION['mid']."', '1')";
					$db->requete($sql);			
					$id_depart = $db->last_id();
					$message = 'Ajout du départ effectu&eacute;';
					$type = "ok";
					$redirection = "javascript:this.close();";
					$close = '<script type="text/javascript">window.opener.location = "'.$lienpage.'"; setInterval(\'window.close()\', 5000);</script>';
				}	
				else
				{
					$message = 'Un des champs est mal renseign&eacute;';
					$type = "important";
					$redirection = 'javascript:history.back(-1);';
					$close = "";
				}
			}
			else
			{
				$e = intval($_GET['e']);
				//ON vérifis que le topo appartiens bien au membre
				$reponse =  $db->requete("SELECT * FROM departs
											WHERE id_depart = '".$e."'
											AND id_m = '".$_SESSION['mid']."'");
				$num = $db->num();
				$donnees = $db->fetch($reponse);

				if($num < 1)
				{
					$message = 'Vous ne pouvez pas éditer ce départ';
					$type = "important";
					$redirection = $config['domaine'].'/mes-departs.html';
					$close = '';
				}
				else
				{
					
					//On update les données de la table departs
					$sql = "UPDATE departs 
					SET lieu_depart = '$nom_depart',
						acces = '$acces',
						acces_parser = '$acces',
						lat_depart = '$lat',
						long_depart = '$lng',
						alt_depart = '$altitude',
						id_massif = $massif						
					WHERE id_depart = '".$e."'";
					$db->requete($sql);
				

					$message = 'mise à jour du départ effectuée';
					$type = "ok";
					$redirection = $config['domaine'].'/mes-departs.html';
					$close = '';
				}				
			}
			
			


	}
	else
	{
		$message = 'Vous n\'étes pas autorisé à ajouter un départ. Ceci peut être que temporaire.';
		$type = "important";
		$redirection = 'javascript:history.back(-1);';
		$close = '';
	}
}
$db->deconnection();
echo ajout_depart($message,$type,$redirection, $close);
?>
