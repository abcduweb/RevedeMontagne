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
	$sql = "SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_m = '$_SESSION[mid]'";
	$row = $db->fetch($db->requete($sql));
	$action = intval($_GET['action']);
	if(isset($_GET['nid']))
		$id_mapgpx = intval($_GET['nid']);
	else
		$id_mapgpx = 0;
/*
	1 ajouter news;
	2 modifier news;
	3 demande de validation;
	4 validation;
	5 dévalidation;
	6 supprimer;
*/
  $valider = 0;
	if($action > 1)
	{
		$sql = "SELECT * FROM map_gpx WHERE id_mapgpx = '$id_mapgpx'";
		$result = $db->fetch($db->requete($sql));
	}
	switch($action)
	{
		case 1:
			if($row['ajouter_trace'] == 1){
				$texte = $_POST['texte'];
				$texte_parser = $db->escape(zcode($texte));
				$texte = htmlentities($texte,ENT_QUOTES);
				$titre = htmlentities($_POST['nom'],ENT_QUOTES);
				$titre2url = title2url($titre);
				$activite = intval($_POST['activite']);
				$departement = intval($_POST['departement']);
				
				//echo $activite.'-'.$departement;
				if(strlen(trim($titre)) > 4)
				{
					//Caractèristique d'upload//
					$maxsize = 20000;
					$maxwidth = 10020; 
					$maxheight = 10015;
					
					//Vérification du transfert
					if ($_FILES['icone']['error'] > 0) 
						{
						$message = "Erreur lors du tranfsert"; 
						$type = 'pasbon';
						$image = 'pasbon.png';
						$redirection = ROOT.'envoyer-un-fichier.html';
						$data = display_notice($message,$type,$redirection);
						echo $data;
						exit;
						}

					//Vérification de la taille du fichier
					if ($_FILES['icone']['size'] > $maxsize) 
						{
						$message = "Le fichier est trop gros"; 
						$type = 'pasbon';
						$image = 'pasbon.png';
						$redirection = ROOT.'envoyer-un-fichier.html';
						$data = display_notice($message,$type,$redirection);
						echo $data;
						exit;
						}

					$extensions_valides = array('gpx', 'GPX');
					//1. strrchr renvoie l'extension avec le .
					//2. substr(chaine,1) ignore le premier caractère de chaine
					//3. strtolower met l'extension en minuscule
					$extension_upload = strtolower(  substr(  strrchr($_FILES['fichier']['name'], '.')  ,1)  );
					if ( in_array($extension_upload,$extensions_valides) ) 
					{
					

						
						$image_sizes = getimagesize($_FILES['fichier']['tmp_name']);
						if ($image_sizes[0] > $maxwidth OR $image_sizes[1] > $maxheight)
							{
							$message = "Image trop grande"; 
							$type = 'pasbon';
							$redirection = ROOT.'envoyer-un-fichier.html';
							$image = 'pasbon.png';
							$data = display_notice($message,$type,$redirection);
							echo $data;
							exit;
							}
						
						//si tout est bon on déplace le fichier
						//Créer un dossier 'fichiers/1/'
						//mkdir('../images/photos/', 0777, true);
						
						//Créer un identifiant difficile à deviner
						$nom = md5(uniqid(rand(), true));
						$cle = $nom;
						$up_finalname = $nom.'.'.$extension_upload;	
						$url_mapgpx = $up_finalname;
						$nom = '../mapgpx/GPX/'.$nom.'.'.$extension_upload;
						$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'],$nom);
						if ($resultat) 
							{
								$balises = array ('trkseg', 'trkpt', 'ele'); //-- Nom des Balises à parser )
								$adresse_flux = ROOT.'/mapgpx/GPX/'.$cle.'.'.$extension_upload;
								//echo $adresse_flux;
								if ( !readFeedDom($adresse_flux, $balises) ) 
								{
									$message = "Nous n'acceptons que les fichiers \"trace\""; 
									$type = 'pasbon';
									$redirection = ROOT.'envoyer-un-fichier.html';
									$image = 'pasbon.png';
									unlink($adresse_flux);
									$data = display_notice($message,$type,$redirection);
									echo $data;
									exit;
								}
								else
								{
						   
							
								$filename = $_FILES['fichier']['name']; 
								$filesize = $_FILES['fichier']['size'];
								/*$up_description_parser = mysql_real_escape_string(htmlentities($_POST['textpage'], ENT_QUOTES));
								$up_description = $texte = $db->escape(zcode($_POST['textpage']));*/
								if (empty($_POST['titre']))
									{
									$up_title = $filename;
									}
									else
									{
									$up_title = mysql_real_escape_string(htmlentities($_POST['titre'], ENT_QUOTES));
									}


									//$nom = '../fichiers/pdf/'.$nom.'.'.$extension_upload;
									
									$sql = "INSERT INTO map_gpx VALUES('', NOW(), '$titre', '$url_mapgpx', '$texte','$texte_parser', '$cle',
									'0', '0', '0', '0', '0', '0','', '', '0', '', '', '', '0', '', '','0', '0', '0', '$_SESSION[mid]', '$activite', '$departement')";
									$db->requete($sql);
									$id_trace = $db->last_id();
															
									$xml = $nom;
									$obj = simplexml_load_file($xml, 'SimpleXMLIterator');

									
									//On met les variables à 0
									$nbpoint = 0;
									$longeur = 0; //a faire,
									$den_positif_cumu = number_format(0, 4, '.','');; 
									$den_negatif_cumu = number_format(0, 4, '.','');;
									$altitude_maxi = number_format(0, 4, '.','');
									$altitude_mini = number_format(10000, 4, '.','');
									$altitude_moyenne = 0;
									$altitude_cumul = number_format(0, 4, '.','');
									$duree_positif_cumu = number_format(0, 4, '.',''); 
									$duree_negatif_cumu = number_format(0, 4, '.','');
									
									$latb = '';
									$longb = '';
									$elebp = 0;
									$elebm = 0;
									$dureem = 0;
									$dureed = 0;
									
									$duree_pause = 0;
									$duree_marche = 0; 
									$distancem = number_format(0, 4, '.','');
									$distanced = number_format(0, 4, '.','');
									
									$seuil = 0.5;
												
				
									foreach($obj->trk->trkseg->trkpt as $trkpt)
									{  																
										$datas = array(
										'lon' => $trkpt['lon'],
										'lat' => $trkpt['lat'],
										'elevation' => $trkpt->ele,
										'date' => strftime("%Y-%m-%d %H:%M:%S", strtotime($trkpt->time))
										);	
											
										$dater = strftime("%Y-%m-%d %H:%M:%S", strtotime($trkpt->time));															
										$db->requete("INSERT INTO mapgpx_pts (id_pts, lon, lat, ele, date, idmapgpx) 
										VALUES ('', '".$trkpt['lon']."', '".$trkpt['lat']."', '".$trkpt->ele."', '$dater', '$id_trace')");
		
										$ele = number_format($trkpt->ele, 4, '.','');
										//echo $ele.'pp';
										//Je cumul l'altitude
										$altitude_cumul = $altitude_cumul + $ele;
										
										//Je m'occupe du dénivelé positif
										if ($elebp == 0 AND $elebm == 0)
										{
											$elebp = $ele;
											$elebm = $ele;
											$dureem = $dater;
											$dureed = $dater;
											$erreur = 0;
											//echo $elebp.'aa';
										}
										
										
																			//Je récupère la date de début
										if($nbpoint == 0)
											{
											$date_fin = $dater;
											$date_debut = $dater;								
											}
											
										//Je récupère la date du debut du segment
										$date_debut_seg = $date_fin;
										//Je récupére la date de fin
										$date_fin = $dater;	

										$duree_totale = strtotime($date_fin) - strtotime($date_debut);
										$diff2 = strtotime($date_fin) - strtotime($date_debut_seg);
										$secondes_seg = $diff2;


										
										//Je m'occupe de la distance 
										if (!empty($latb) and !empty($longb))
										{
											$dist = 6366*acos(
															cos(deg2rad($trkpt['lat']))
															*cos(deg2rad($latb))
															*cos(deg2rad($longb)-deg2rad($trkpt['lon']))
															+sin(deg2rad($trkpt['lat']))
															*sin(deg2rad($latb))
															);
											$longueur = $longueur + $dist;
											
											//On vérifis le temps, durée marche / durée pause
											//echo '*'.$dist.'<br />';
											/*echo $dist.'<br />';
											if ($dist < number_format(0.01, 5, '.',''))
												$duree_pause = $duree_pause + $secondes_seg;
											else
												$duree_marche = $duree_marche + $secondes_seg;
											*/
											//echo $date_debut_seg.'*'.$date_fin.'*'.$secondes_seg.'/'.$duree_pause.'/'.$duree_marche.'-'.$diff.'<br />';
										}
										//Calcul de la vitesse
										$secondes_seg = $secondes_seg * 3600 * 24;
										if ($dist > $secondes_seg * 3.6)
											$vitesse = $dist / $secondes_seg * 3.6;  
										else
											$vitesse = 0;
											
										echo $vitesse.'<br />';
										
										if($vitesse > $seuil)
											$duree_marche = $duree_marche + $secondes_seg;
										else
											$duree_pause = $duree_pause + $secondes_seg;
										
										if ($elebp < $ele AND (number_format(($ele - $elebp), 4, '.','') > number_format(10, 4, '.','')))
										{
											
											//$den_positif_cumu = $ele - $elebp;
											$den_positif_cumu = $den_positif_cumu + ($ele - $elebp);
											$duree_positif_cumu = $duree_positif_cumu + strtotime($dater) - strtotime($dureem);
											$distancem = $distancem + $dist;
											
											$elebp = $ele;
											$elebm = $ele;
											$dureem = $dater;
											$dureed = $dater;
											
											$erreur = 1;
										}
										elseif ($elebm > $ele AND (number_format(($elebm - $ele), 4, '.','') > number_format(10, 4, '.','')))
										{
											$den_negatif_cumu = $den_negatif_cumu + ($elebm - $ele);	
											$duree_negatif_cumu = $duree_negatif_cumu + (strtotime($dater) - strtotime($dureed));	
											$distanced = $distanced + $dist;
											
											$elebm = $ele;
											$elebp = $ele;
											$dureem = $dater;
											$dureed = $dater;
											$erreur = 2;

										}
										else
										{

										}
										
																			
										//Je m'occupe de l'altitude maxi
										if ($ele > $altitude_maxi)
										{
											$altitude_maxi = $ele;
										}
										//Je m'occupe de l'altitude mini
										if ($ele < $altitude_mini)
										{
											$altitude_mini = $ele;
										}							
										$nbpoint++;
										$latb = $trkpt['lat'];
										$longb = $trkpt['lon'];
									}		
									
									//Je récupére la vitesse moyenne en km/h
									$vitesse_moyenne = $longueur / ($duree_marche/3600);
									//Je récupére la vitesse_montee en km/h
									//echo $distancem.'-'.$duree_positif_cumu.'-'.$dist;
									$vitesse_montee = $den_positif_cumu / ($duree_positif_cumu/3600);
									//Je récupére la vitesse_descente en km/h
									$vitesse_descente = $den_negatif_cumu / ($duree_negatif_cumu/3600);
									
									//echo $longueur.'-'.$duree_marche.'-'.$vitesse_moyenne;
									
									//Je convertis les seconde de duree totale
									$temp = $duree_totale % 3600;
									$time[0] = ( $duree_totale - $temp ) / 3600 ;
									$time[2] = $temp % 60 ;
									$time[1] = ( $temp - $time[2] ) / 60;
									$duree_totale = $time[0].'h'.$time[1].'m'.$time[2].'s';
									
									//Je convertis les seconde de pause
									echo '***'.$duree_pause.'***';
									$temp = $duree_pause % 3600;
									$time[0] = ( $duree_pause - $temp ) / 3600 ;
									$time[2] = $temp % 60 ;
									$time[1] = ( $temp - $time[2] ) / 60;
									$duree_pause = $time[0].'h'.$time[1].'m'.$time[2].'s';
									
									//Je convertis les seconde de marche
									'***'.$duree_marche.'***';
									$temp = $duree_marche % 3600;
									$time[0] = ( $duree_marche - $temp ) / 3600 ;
									$time[2] = $temp % 60 ;
									$time[1] = ( $temp - $time[2] ) / 60;
									$duree_marche = $time[0].'h'.$time[1].'m'.$time[2].'s';
									
									//Je convertis les temps de montée cumulés
									$temp = $duree_positif_cumu % 3600;
									$time[0] = ( $duree_positif_cumu - $temp ) / 3600 ;
									$time[2] = $temp % 60 ;
									$time[1] = ( $temp - $time[2] ) / 60;
									$duree_positif_cumu = $time[0].'h'.$time[1].'m'.$time[2].'s';
									
									//Je convertis les temps de descente cumulés
									$temp = $duree_negatif_cumu % 3600;
									$time[0] = ( $duree_negatif_cumu - $temp ) / 3600 ;
									$time[2] = $temp % 60 ;
									$time[1] = ( $temp - $time[2] ) / 60;
									$duree_negatif_cumu = $time[0].'h'.$time[1].'m'.$time[2].'s';
									
									$altitude_moyenne = $altitude_cumul / $nbpoint;
									
									$sql  = "UPDATE map_gpx SET 
										nb_points = '$nbpoint', 
										longueur = '$longueur', 
										den_positif_cumu = '$den_positif_cumu',
										den_negatif_cumu = '$den_negatif_cumu',
										altitude_maxi = '$altitude_maxi',
										altitude_mini = '$altitude_mini',
										altitude_moyenne = '$altitude_moyenne',
										date_debut = '$date_debut',
										date_fin = '$date_fin',
										duree_totale = '$duree_totale',
										duree_pause = '$duree_pause',
										duree_marche = '$duree_marche',
										vitesse_moyenne = '$vitesse_moyenne',
										duree_positif_cumu = '$duree_positif_cumu',
										duree_negatif_cumu = '$duree_negatif_cumu',
										vitesse_montee = '$vitesse_montee',
										vitesse_descente = '$vitesse_descente'
										WHERE id_mapgpx = '$id_trace'";
									$db->requete($sql);
									$message = "Votre tracé GPX a été ajoutée.";
									$type = "ok";
									$redirection = ROOT."map-".$titre2url."-m".$cle.".html";
								}
							}


						}
						else
						{
						$message = "extension non permise".$nom."aab".$extension_upload."cc".$extensions_valides; 
						$type = 'pasbon';
						$image = 'pasbon.png';
						$redirection = ROOT.'envoyer-un-fichier.html';
						}
				}
				else
				{
					$message = "Vous n'avez pas entré le titre de la trace.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}
		break;
		case 2:
		if($row['supprimer_trace'] == 1 OR $result['id_m'] == $_SESSION['mid'])
		{
			if($result['id_m'] == $_SESSION['mid'])
			{
			    if(isset($_POST['valider']) AND $_POST['valider'] == 1)
				{
					unlink(ROOT.'mapgpx/GPX/'.$result['url_mapgpx']);
					//echo ROOT.'mapgpx/GPX/'.$result['url_mapgpx'];
					$sql = "DELETE FROM map_gpx WHERE id_mapgpx  = '$id_mapgpx'";
					$db->requete($sql);
					$sql = "DELETE FROM mapgpx_pts WHERE 	idmapgpx  = '$id_mapgpx'";
					$db->requete($sql);
					$message = "Trace supprimée";
					$type = "ok";
					$redirection = ROOT."liste-des-traces-gpx.html";
					$valider = 0;
					$sql = "SELECT * FROM images WHERE s_dir = '$id_mapgpx' AND dir = '1' AND id_owner = '$result[id_m]'";
					$resultNews = $db->requete($sql);
					while($newsRow = $db->fetch($resultNews))
					{
						unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/'.$newsRow['nom']);
						unlink(ROOT.'images/autres/'.ceil($newsRow['id_image']/1000).'/mini/'.$newsRow['nom']);
					}					
					$db->requete("DELETE FROM images WHERE dir = '1' AND s_dir = '$id_mapgpx' AND id_owner = '$result[id_m]'");
				}
				else
				{
					$message = "Etes vous sûr de vouloir supprimer cette trace?";
					$url = 'actions_mapgpx.php?nid='.$id_mapgpx.'&amp;action='.$action;
					$valider = 1;
				}
			}
			else
			{
				if(isset($_POST['valider']) AND $_POST['valider'] == 1)
				{
					unlink(ROOT.'mapgpx/GPX/'.$result['url_mapgpx']);
					$sql = "DELETE FROM map_gpx WHERE id_mapgpx = '$id_mapgpx'";
					$db->requete($sql);
					$sql = "DELETE FROM mapgpx_pts WHERE 	idmapgpx  = '$id_mapgpx'";
					$db->requete($sql);
					
					$text_parser = 'Votre trace GPX '.$result['nom_mapgpx'].' viens d\'être supprimée de notre serveur.<br /> Sans doute ne respectée t\'elle pas nos conditions d\'utilisations. Merci de votre compréhension';
					$text = 'Votre trace GPX '.$result['nom_mapgpx'].' viens d\'être supprimée de notre serveur<br /> Sans doute ne respectée t\'elle pas nos conditions d\'utilisations. Merci de votre compréhension';
					$sql = "INSERT INTO messages_discution VALUES('','','$text_parser','$text',UNIX_TIMESTAMP(),'$_SESSION[mid]',0)";
					$db->requete($sql);
					$idM = $db->last_id();
					$sql = "INSERT INTO liste_discutions VALUES('','<strong>[Trace GPX]</strong> Suppression de la trace','',$idM,'$_SESSION[mid]',0,0,0)";
					$db->requete($sql);
					$idDiscu = $db->last_id();
					$db->requete("UPDATE messages_discution SET id_disc = '$idDiscu' WHERE id_m_disc = '$idM'");
					$db->requete("INSERT INTO discutions_lues VALUES('$result[id_m]','$idDiscu','0','1')");
					if(file_exists(ROOT.'caches/.htcache_mpm_'.$result['id_m']))
					{
						include(ROOT.'caches/.htcache_mpm_'.$result['id_m']);
						$img_mp = 'messages';
						$nb_mp++;
						write_cache(ROOT.'caches/.htcache_mpm_'.$result['id_m'],array('connexion'=>$connexion,'inscription'=>$inscription,'moncompte'=>$moncompte,'root'=>$root,'img_mp'=>$img_mp,'nb_mp'=>$nb_mp));
					}
					$sql = "SELECT * FROM images WHERE s_dir = '$id_mapgpx' AND dir = '1' AND id_owner = '$result[id_m]'";
					$resultNews = $db->requete($sql);
					while($newsRow = $db->fetch($resultNews))
					{
						unlink(ROOT.'images/autres/'.ceil($newRow['id_image']/1000).'/'.$newsRow['nom']);
						unlink(ROOT.'images/autres/'.ceil($newRow['id_image']/1000).'/mini/'.$newsRow['nom']);
					}

					$db->requete("DELETE FROM images WHERE dir = '1' AND s_dir = '$id_mapgpx' AND id_owner = '$result[id_m]'");
					$message = "Trace supprimée";
					$type = "ok";
					$valider = 0;
					$redirection = ROOT."liste-des-traces-gpx.html";
				}
				else
				{
					$message = "Etes vous sûr de vouloir supprimer cette trace?";
					$url = 'actions_mapgpx.php?nid='.$id_mapgpx.'&amp;action='.$action;
					$valider = 1;
				}
			}
		}
		else
		{
			$message = "Vous ne pouvez pas supprimer cette trace";
			$type = "important";
			$redirection = ROOT."index.php";
		}
		break;
	}
}
else
{
	$message = "Vous devez être enregistrer pour ajouter/modifier/supprimer une news";
	$type = "important";
	$redirection = ROOT."connexion.html";
}
switch($valider){
  case 0:
    $data = display_notice($message,$type,$redirection);
  break;
  case 1:
    $data = display_confirm($message,$url);
  break;
}
echo $data;
$db->deconnection();
?>
