<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
// On vérifie si le champ "recaptcha-response" contient une valeur
	if(empty($_POST['recaptcha-response'])){
		header('Location: index.php');
	}else{
       // On prépare l'URL
       $url = "https://www.google.com/recaptcha/api/siteverify?secret=6LeAlM8ZAAAAAGWPL1MNtaKMVdgSp7JdH_vSDC6A&response={$_POST['recaptcha-response']}";

       // On vérifie si curl est installé
		if(function_exists('curl_version')){
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
        }else{
            // On utilisera file_get_contents
            $response = file_get_contents($url);
        }

        // On vérifie qu'on a une réponse
        if(empty($response) || is_null($response)){
            header('Location: index.php');
        }else{
            $data = json_decode($response);
            if($data->success){

				if (isset ($_POST['nom']) AND !empty ($_POST['nom']) AND isset ($_POST['email']) AND !empty ($_POST['email']))
				{
							$idfichier = intval($_GET['idfichier']);

							$reponse =  $db->requete("SELECT * FROM map_gpx 
													LEFT JOIN topos on topos.id_topo = map_gpx.id_topo
													LEFT JOIN point_gps on point_gps.id_point = topos.id_sommet
													WHERE id_mapgpx = '$idfichier' ");
							$donnees = $db->fetch($reponse);
								
							$nom = htmlentities($_POST['nom'], ENT_QUOTES);
							$mail = htmlentities($_POST['email'], ENT_QUOTES);
							$fichier = $donnees['url_mapgpx'];


							//$mail = 'Rêve de Montagne'; // Déclaration de l'adresse de destination.
							if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
							{
								$passage_ligne = "\r\n";
							}
							else
							{
								$passage_ligne = "\n";
							}

							//choix de l'activité
							if($donnees['id_activite'] == 1)
								$choix_activite = "t";
							elseif($donnees['id_activite'] == 2)
								$choix_activite = "tr";
							else
								$choix_activite = "";
								
							//=====Déclaration des messages au format texte et au format HTML.
							$message_txt = "Salut à tous, voici un e-mail envoyé par un script PHP.";
							//$message_html = "<html><head></head><body><b>Salut à tous</b>, voici un e-mail envoyé par un <i>script PHP</i>.</body></html>";
							$message_html = get_file(TPL_ROOT.'mail/envoi_gpx.tpl');
							$message_html = parse_var($message_html,array('nom'=>$nom,'mail'=>$mail, 'nom_point_url'=>title2url($donnees['nom_point']), 'choix_activite'=>$choix_activite, 'nom_topo_url'=>title2url($donnees['nom_topo']), 'idtopo'=>$donnees['id_topo']));
							//{nom_point_url}-{nom_topo_url}-{choix_activite}{idtopo}
							//==========
							  
							//=====Lecture et mise en forme de la pièce jointe.
							$fichier   = fopen("".ROOT."mapgpx/GPX/".$donnees['url_mapgpx']."", "r");
							$attachement = fread($fichier, filesize("".ROOT."mapgpx/GPX/".$donnees['url_mapgpx'].""));
							$attachement = chunk_split(base64_encode($attachement));
							fclose($fichier);
							//==========
							  
							//=====Création de la boundary.
							$boundary = "-----=".md5(rand());
							$boundary_alt = "-----=".md5(rand());
							//==========
							  
							//=====Définition du sujet.
							$sujet = "Téléchargement de la trace ".$donnees['nom_point']." ".$donnees['nom_topo'];
							//=========
							  
							//=====Création du header de l'e-mail.
							$header = "From: \"Rêve de Montagne\"<contact@revedemontagne.fr>".$passage_ligne;
							$header.= "Reply-to: \"Rêve de Montagne\" <contact@revedemontagne.fr>".$passage_ligne;
							$header.= "MIME-Version: 1.0".$passage_ligne;
							$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
							//==========
							  
							//=====Création du message.
							$message = $passage_ligne."--".$boundary.$passage_ligne;
							$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
							$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
							//=====Ajout du message au format texte.
							$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
							$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
							$message.= $passage_ligne.$message_txt.$passage_ligne;
							//==========
							  
							$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
							  
							//=====Ajout du message au format HTML.
							$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
							$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
							$message.= $passage_ligne.$message_html.$passage_ligne;
							//==========
							  
							//=====On ferme la boundary alternative.
							$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
							//==========
							  
							  
							  
							$message.= $passage_ligne."--".$boundary.$passage_ligne;
							  
							//=====Ajout de la pièce jointe.
							$message.= "Content-Type: gpx=application/gpx+xml; name=\"fichier GPX\"".$passage_ligne;
							$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
							$message.= "Content-Disposition: attachment; filename=\"fichier GPX\"".$passage_ligne;
							$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
							$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
							//==========
							//=====Envoi de l'e-mail.
							mail($mail,$sujet,$message,$header);
							  
							//==========

							//enregistrement dans la base de données
							$ipvisiteur = get_ip();
							
							$reponse =  $db->requete("SELECT * FROM visiteur_gpx WHERE id_mapgpx = '".$donnees['id_mapgpx']."' and ip =  '".$ipvisiteur."' and email = '".$mail."'");
							if($db->num() == 0)
							{			
								$sql = "INSERT INTO visiteur_gpx VALUES ('', NOW(), '$mail', '$nom', '$ipvisiteur', '".$donnees['id_mapgpx']."' ,0 )";
								$db->requete($sql);
							}
							
							//On incrémente le conteur
							$sql = "UPDATE map_gpx SET telechargement = telechargement + 1 WHERE id_mapgpx = '".$idfichier."'";
							$db->requete($sql);
							
							//'nom_point_url'=>title2url($donnees['nom_point']), 'choix_activite'=>$choix_activite, 'nom_topo_url'=>title2url($donnees['nom_topo']), 'idtopo'=>$donnees['id_topo'])		
							$message = 'Nous venons de vous envoyer le fichier GPX';
							$redirection = ROOT.'traceGPX-'.title2url($donnees['nom_point']).'-'.title2url($donnees['nom_topo']).'-m'.$idfichier.'.html';
							echo display_notice($message,'ok',$redirection);
					
				}
				else
				{
					$db->deconnection();
					$message = 'l\'email ou le nom ne sont pas renseigné';
					$redirection = 'javascript:history.back(-1);';
					echo display_notice($message,'important',$redirection);
					exit;
					
				}
			}else{
                header('Location: index.php');
            }
		}
	}
			
}else{
	http_response_code(405);
	echo 'Méthode non autorisée';
}
	

?>