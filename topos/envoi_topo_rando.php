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

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistr&eacute; pour pouvoir acc&eacute;der à cette partie.'.$_SESSION['mid'];
	$type = "important";
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
	$auth = $db->fetch($db->requete($sql));
	if($auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
	{
		
			
		//On v&eacute;rifi la suppr&eacute;ssion
		if(isset($_GET['del']) AND $_GET['del'] == 1)
		{
			$idt = intval($_GET['idt']);
			$del = intval($_GET['del']);
			
			$reponse =  $db->requete("SELECT 
				topos.id_topo, nom_point, nom_topo, denniveles, topos.id_m AS id_m, pente, id_sommet,
				orientation, difficulte_topo, difficulte, exposition, nb_jours, itineraire, remarque
				FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.id_topo = '".$idt."'");
			$num = $db->num();
			$donnees = $db->fetch($reponse);
			if($num == 1 AND $donnees['id_m'] == $_SESSION['mid'] OR $auth['administrateur_topo'] == 1)
			{
				if(isset($_GET['valider']) AND $_GET['valider'] == 1)
				{
					//On met en paramètre des variables pour le MP à l'&eacute;quipe			'
					$nomtopo = $donnees['nom_point'].', '.$donnees['nom_topo'];
					
					//On passe le topo à 0
					$sql = "UPDATE topos SET visible = 3 WHERE id_topo = '".$idt."'";
					$db->requete($sql);
					// d&eacute;late les sorties correspondante au topo
					$db->requete("DELETE FROM sortie WHERE id_topo = '".$idt."'");
					unlink(ROOT.'caches/.htcache_index');
					
					$message = 'le topo a &eacute;t&eacute; supprim&eacute;';
					$type = "ok";
					$redirection = DOMAINE.'mes-topos-randonnees.html';
					$data = display_notice($message,$type,$redirection);
					
					//On envoi un Mp aux administrateur des topos
					$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_topo = 1";
					$validateur = $db->requete($sql);
					$num = $db->num($newser);
					if($num > 5){
						$limite = mt_rand(0,$num);
					}
					else
						$limite = 0;
						
					$text_parser = 'le topo <a href="topo-'.title2url($donnees['nom_topo']).'-tr'.$donnees['id_topo'].'.html">'.$nomtopo.'</a>
									 vient d\&ecirc;tre supprim&eacute;<br /><br />
									-----------------<br />
									<span class="tpetit">ce message est g&eacute;n&eacute;r&eacute; automatiquement</span>';
					$text = 'test'; //htmlentities($_POST['texte'],ENT_QUOTES);
					$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
					$db->requete($sql);
					$idM = $db->last_id();
					$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_topo = 1 LIMIT $limite,5";
					$validateur = $db->requete($sql);
					$sql = "INSERT INTO liste_discutions VALUES('','<strong>[Topo supprim&eacute;]</strong> ".$nomtopo."','',$idM,$_SESSION[mid],0,0,0)";
					$db->requete($sql);
					$idDiscu = $db->last_id();
					$nb_participant = 0;
					while($to = $db->fetch($validateur)){
						if($to['id_m'] != null AND $to['id_m'] != $_SESSION['mid']){
							$sql = "INSERT INTO discutions_lues VALUES('$to[id_m]','$idDiscu',0,1)";
							$db->requete($sql);
							if(file_exists(ROOT.'caches/.htcache_mpm_'.$to['id_m'])){
								include(ROOT.'caches/.htcache_mpm_'.$to['id_m']);
								$img_mp = 'messages';
								$nb_mp++;
								write_cache(ROOT.'caches/.htcache_mpm_'.$to['id_m'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
							}
							$nb_participant++;
						}
					}
					$db->requete("INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$idDiscu','$idM',1)");
					$nb_participant++;
					$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
					$db->requete("UPDATE liste_discutions SET nb_participant = '$nb_participant' WHERE id_discution = '$idDiscu'");
					
					//FIn MP à l'&eacute;quipe
					
					
				}
				else
				{
					$url = 'envoi_topo_rando.php?idt='.$idt.'&amp;del='.$del.'&amp;valider=1';
					$message = 'Etes vous s&ucirc;r de vouloir supprimer ce topo?';
					$data = display_confirm($message,$url);
				}
				
			}
			else
			{
				$message = 'Vous ne pouvez pas supprimer ce topo';
				$type = "important";
				$redirection = DOMAINE.'liste-des-topos-skis-rando.html';
				$data = display_notice($message,$type,$redirection);
			}
			
		}
		elseif(isset($_GET['del']) AND $_GET['del'] == 1)
		{
			$message = "Action non permise";
			$redirection = ROOT."liste-des-topos-skis-rando.html";
			$data = display_notice($message,'important',$redirection);
			$data = display_notice($message,$type,$redirection);
		}
		//On v&eacute;rifi la mise en ligne du topo
		elseif(isset($_GET['val']) AND $_GET['val'] == 1)
		{
			$idt = intval($_GET['idt']);
			$val = intval($_GET['val']);
			
			$reponse =  $db->requete("SELECT topos.id_m, topos.id_topo, nom_point, nom_topo   FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.id_topo = '".$idt."'");
			$num = $db->num();
			$donnees = $db->fetch($reponse);
			if($num == 1 AND $donnees['id_m'] == $_SESSION['mid'] OR $auth['administrateur_topo'] == 1)
			{
				if(isset($_GET['valider']) AND $_GET['valider'] == 1)
				{
					//On met en paramètre des variables pour le MP à l'&eacute;quipe			'
					$nomtopo = $donnees['nom_point'].', '.$donnees['nom_topo'];
					
					//On passe le topo à 0
					$sql = "UPDATE topos SET visible = 1 WHERE id_topo = '".$idt."'";
					$db->requete($sql);
					unlink(ROOT.'caches/.htcache_index');
					
					$message = 'le topo a &eacute;t&eacute; mis en ligne';
					$type = "ok";
					$redirection = DOMAINE.'mes-topos-randonnees.html';
					$data = display_notice($message,$type,$redirection);
					
					
					//On envoi un Mp aux administrateur des topos
					$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_topo = 1";
					$validateur = $db->requete($sql);
					$num = $db->num($newser);
					if($num > 5){
						$limite = mt_rand(0,$num);
					}
					else
						$limite = 0;
						
					$text_parser = 'Un nouveau topo de randonn&eacute;e vient d\&ecirc;tre mis en ligne<br /> 
									Vous pouvez le consulter ici : <a href="topo-'.title2url($donnees['nom_topo']).'-tr'.$donnees['id_topo'].'.html">'.$nomtopo.'</a><br /><br />
									-----------------<br />
									<span class="tpetit">ce message est g&eacute;n&eacute;r&eacute; automatiquement</span>';//$db->escape(zcode($_POST['texte']));
					$text = 'test'; //htmlentities($_POST['texte'],ENT_QUOTES);
					$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
					$db->requete($sql);
					$idM = $db->last_id();
					$sql = "SELECT * FROM autorisation_globale LEFT JOIN membres ON membres.id_group = autorisation_globale.id_group WHERE autorisation_globale.administrateur_topo = 1 LIMIT $limite,5";
					$validateur = $db->requete($sql);
					$sql = "INSERT INTO liste_discutions VALUES('','<strong>[Topo randonn&eacutee]</strong> ".$nomtopo."','',$idM,$_SESSION[mid],0,0,0)";
					$db->requete($sql);
					$idDiscu = $db->last_id();
					$nb_participant = 0;
					while($to = $db->fetch($validateur)){
						if($to['id_m'] != null AND $to['id_m'] != $_SESSION['mid']){
							$sql = "INSERT INTO discutions_lues VALUES('$to[id_m]','$idDiscu',0,1)";
							$db->requete($sql);
							if(file_exists(ROOT.'caches/.htcache_mpm_'.$to['id_m'])){
								include(ROOT.'caches/.htcache_mpm_'.$to['id_m']);
								$img_mp = 'messages';
								$nb_mp++;
								write_cache(ROOT.'caches/.htcache_mpm_'.$to['id_m'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
							}
							$nb_participant++;
						}
					}
					$db->requete("INSERT INTO discutions_lues VALUES('$_SESSION[mid]','$idDiscu','$idM',1)");
					$nb_participant++;
					$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
					$db->requete("UPDATE liste_discutions SET nb_participant = '$nb_participant' WHERE id_discution = '$idDiscu'");
					
					//FIn MP à l'&eacute;quipe
							
				}
				else
				{
					$url = 'envoi_topo_rando.php?idt='.$idt.'&amp;val='.$val.'&amp;valider=1';
					$message = 'Etes vous s&ucirc;r de vouloir mettre en ligne ce topo?';
					$data = display_confirm($message,$url);
				}
				
			}
			else
			{
				$message = 'Vous ne pouvez pas mettre en ligne ce topo';
				$type = "important";
				$redirection = DOMAINE.'liste-des-topos-skis-rando.html';
				$data = display_notice($message,$type,$redirection);
			}
		}
		else
		{
			//On v&eacute;rifi que tous les champs soit rempli
			
			if( (isset($_POST['nom_topo']) AND strlen(trim($_POST['nom_topo'])) > 2) 
				AND (isset($_POST['orientation']) AND strlen(trim($_POST['orientation'])) > 0) 
				AND (isset($_POST['denni']) AND strlen(trim($_POST['denni'])) > 0) 
				AND (isset($_POST['diff_monte']) AND strlen(trim($_POST['diff_monte'])) > 0) 
				AND (isset($_POST['carte'])) 
				AND (isset($_POST['depart']) AND strlen(trim($_POST['depart'])) > 0) 
				AND (isset($_POST['nb_jours']) AND strlen(trim($_POST['nb_jours'])) > 0) 
				AND (isset($_POST['type_iti']) AND strlen(trim($_POST['type_iti'])) > 0) 
				AND (isset($_POST['intro']) AND strlen(trim($_POST['intro'])) > 0) 
				AND (isset($_POST['conclu']) AND strlen(trim($_POST['conclu'])) > 0)			
			  )
			{
				
				//On protège les diff&eacute;rentes valeurs envoy&eacute;s
				$nom_topo    = htmlentities($_POST['nom_topo'],ENT_QUOTES, 'UTF-8');
				$massif      = intval($_GET['m']);
				$orientation = htmlentities($_POST['orientation'],ENT_QUOTES, 'UTF-8');
				$denni       = intval($_POST['denni']);
				$diff_monte  = htmlentities($_POST['diff_monte'],ENT_QUOTES, 'UTF-8');
				$carte       = $_POST['carte'];
				$depart      = intval($_POST['depart']);
				$nb_jours    = htmlentities($_POST['nb_jours'],ENT_QUOTES, 'UTF-8');
				$type_iti    = intval($_POST['type_iti']);
				$intro       = htmlentities($_POST['intro'],ENT_QUOTES, 'UTF-8');
				//echo $intro;
				$intro_parser = $db->escape(zcode($_POST['intro']));
				$conclu      = htmlentities($_POST['conclu'],ENT_QUOTES, 'UTF-8');
				$conclu_parser = $db->escape(zcode($_POST['conclu']));
				$sommet = intval($_GET['s']);
				
				//Cr&eacute;ation des sessions
				$_SESSION['nom_topo'] = $nom_topo;    
				$_SESSION['massif'] = $massif;      
				$_SESSION['orientation'] = $orientation;
				$_SESSION['denni'] = $denni;       
				$_SESSION['diff_monte'] = $diff_monte;         
				$_SESSION['carte'] = $carte;       
				$_SESSION['depart'] = $depart;           
				$_SESSION['nb_jours'] = $nb_jours;    
				$_SESSION['type_iti'] = $type_iti;    
				$_SESSION['intro'] = $intro;       
				$_SESSION['intro_parser'] = $intro_parser; 
				$_SESSION['conclu'] = $conclu;      
				$_SESSION['conclu_parser'] = $conclu_parser; 
				
				
				if (!isset($_GET['e']))
				{		
							
					//Insertion des donn&eacute;es dans la table topo
					$sql = "INSERT INTO topos VALUES
							(
							'',
							'$nom_topo',
							NOW(),
							'".$_SESSION['mid']."',
							'$massif',
							'$orientation',
							'$denni',
							'$type_iti',
							'$intro',
							'$intro_parser',
							'$conclu',
							'$conclu_parser',
							'$depart',
							'$sommet',
							'2',
							'1',
							'',
							'$diff_monte',
							'$nb_jours',
							'0',
							'1'
							)";
					$db->requete($sql);
					$topo = $db->last_id();
					
					//Insertion des donn&eacute;es dans la table utiliser carte
					foreach($carte as $selectValue){
						$sql = "INSERT INTO utiliser_carte VALUES
								(
								'$topo',
								'$selectValue'
								)";
						$db->requete($sql);	
					}
					
					//On insert les photos en attente
					if(isset($_SESSION['tmp_Img'])){
						$sql = "UPDATE images SET s_dir = '$topo',tmp = 0 WHERE dir = '8' AND tmp = 1 AND  s_dir = 0 AND id_owner = '$_SESSION[mid]'";
						$db->requete($sql);
						if(isset($_SESSION['SsubDir']['tmp'])){
					$key = array_keys($_SESSION['SsubDir']['tmp']);
					unset($_SESSION['dir'.$key[0]]);
					unset($_SESSION['SsubDir']);
					}
						unset($_SESSION['tmp_Img']);
					}
					
					$message = 'Ajout de la fiche effectu&eacute;e';
					$type = "ok";
					$redirection = DOMAINE.'/mes-topos-randonnees.html';
					$data = display_notice($message,$type,$redirection);
				
				}
				else
				{
					$e = intval($_GET['e']);
		
					$reponse =  $db->requete("SELECT nom_massif, nom_point, 
												nom_topo, denniveles, topos.id_m AS id_m, id_sommet,
												orientation, difficulte_topo, nb_jours, departs.id_depart AS id_depart, type_topo.id_type_iti AS id_type_iti,
												itineraire, remarque
												FROM topos
												LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
												LEFT JOIN departs ON departs.id_depart = topos.id_depart
												LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
												LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
												LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
											WHERE topos.id_topo = '".$e."'
											AND topos.id_m = '".$_SESSION['mid']."'");
					$num = $db->num();
					$donnees = $db->fetch($reponse);
					if($num == 1 AND $auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
					{

						//On update les donn&eacute;es de la table topos
						$sql = "UPDATE topos 
						SET nom_topo = '$nom_topo',
							orientation = '$orientation',
							denniveles = '$denni',
							id_type_iti = $type_iti,
							itineraire = '$intro',
							itineraire_parser  = '$intro_parser',
							remarque = '$conclu',
							remarque_parser = '$conclu_parser',
							id_depart = '$depart',
							id_sommet = '$sommet',
							difficulte_topo = '$diff_monte',
							nb_jours = '$nb_jours',
							statut = '1',
							visible = '0'
						WHERE id_topo = '".$e."'";
						$db->requete($sql);
						
						// d&eacute;late les carte correspondante au utiliser_carte
						$db->requete("DELETE FROM utiliser_carte WHERE id_topo = '".$e."'");
						
						//On rentre les nouvelles donn&eacute;es dans utiliser_carte
						foreach($carte as $selectValue){
							$sql = "INSERT INTO utiliser_carte VALUES
									(
									'$e',
									'$selectValue'
									)";
							$db->requete($sql);	
						}
						
						//On insert les photos en attente
						if(isset($_SESSION['tmp_Img'])){
							$sql = "UPDATE images SET tmp = '0' WHERE dir = '8' AND s_dir = '".$_SESSION['tmp_Img']['subDir'][0]."' AND tmp = '1'";
							$db->requete($sql);
							
							
							if(isset($_SESSION['SsubDir']['tmp'])){
								
							$key = array_keys($_SESSION['SsubDir']['tmp']);
							unset($_SESSION['dir'.$key[0]]);
							unset($_SESSION['SsubDir']);
							}
						  unset($_SESSION['tmp_Img']);
						}
						
						$message = 'Edition du topo effectu&eacute;e';
						$type = "ok";
						$redirection = $config['domaine'].'/mes-topos-randonnees.html';
						$data = display_notice($message,$type,$redirection);
					}
					else
					{
					$message = 'Ce topo ne vous appartient pas';
						$type = "important";
						$redirection = $config['domaine'].'liste-des-topos-skis-rando.html';
						$data = display_notice($message,$type,$redirection);
					}
				}		
			}			
			else
			{
				$message = 'Un des champs est mal renseign&eacute;';
				$type = "important";
				$redirection = 'javascript:history.back(-1);';
				$data = display_notice($message,$type,$redirection);
			}
		}
	}
	else
	{
		$message = 'Vous n\'&ecirc;tes pas autoris&eacute; à ajouter un topo. Ceci peut être que temporaire.';
		$type = "important";
		$redirection = 'index.php';
		$data = display_notice($message,$type,$redirection);
	}
$db->deconnection();
echo $data;

}
?>
