<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################


	$midi = htmlentities($_GET['mpgpx']);
	$reponse =  $db->requete("SELECT * FROM map_gpx
							  LEFT JOIN topos on topos.id_topo = map_gpx.id_topo
							  WHERE cle_mapgpx = '$midi' ");
	if($db->num() > 0)
	{
		if(isset($_SESSION['ses_id']))
		{
	
			$donnees = $db->fetch($reponse);

			$date = gmdate('D, d M Y H:i:s');
			 
			header("Content-Type: text/xml"); //Ici par exemple c'est pour un fichier XML, a changer en fonction du type mime du fichier voulu.
			header('Content-Disposition: attachment; filename='.$donnees['url_mapgpx'].'');
			header('Last-Modified: '. $date . ' GMT');
			header('Expires: ' . $date);
			//header specifique IE :s parce que sinon il aime pas
			if(preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT'])){
			  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			  header('Pragma: public');
			}else{
			  header('Pragma: no-cache');
			}
			readfile('GPX/'.$donnees['url_mapgpx']); 
			
			//On incrémente le conteur
			$sql = "UPDATE map_gpx SET telechargement = telechargement + 1 WHERE id_mapgpx = '".$donnees['id_mapgpx']."'";
			$db->requete($sql);
			
			//echo $CONTENU_DE_NOTRE_FICHIER; // ou ; En fonction du type de fichier.
		
		}
		else
		{
			$donnees = $db->fetch($reponse);
			$data = get_file(TPL_ROOT.'mapgpx/telecharger_trace_visiteur.tpl');
			include(INC_ROOT.'header.php');
			$data = parse_var($data,array('idfichier'=>$donnees['id_mapgpx'], 'nom_trace'=>$donnees['nom_topo']));
			$data = parse_var($data,array('nb_requetes'=>$db->requetes,'titre_page'=>'T&eacute;l&eacute;charger la trace '.$donnees['nom_topo'].' - '.SITE_TITLE,'design'=>$_SESSION['design'],'ROOT'=>''));
			echo $data;
		}

	}
	else
	{
		$message = 'La trace n\'éxiste pas';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
		echo $data;
	}
	$db->deconnection();

?>
