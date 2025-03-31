<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

require_once(ROOT.'fonctions/zcode.fonction.php');

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
				
			
				if(!empty($_POST['texte']) AND strlen(trim($_POST['texte'])) > 30){
					if(!empty($_POST['sujet']) AND strlen(trim($_POST['sujet'])) > 3){
						if(!empty($_POST['email']) AND preg_match('`^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$`',$_POST['email'])){
							if(!empty($_POST['nom']) AND strlen(trim($_POST['nom'])) > 3){
								
								
								$message = "Votre message a bien &eacute;t&eacute; envoy&eacute; aux webmasters";
								$type = "ok";
								$redirection = ROOT."index.html";
								$nomcontact = htmlentities($_POST['nom']);
								$messagecontact = stripslashes(zcode($_POST['texte']));						
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From: Contact - '.htmlentities($_POST['nom']).' <'.$_POST['email'].'>' . "\r\n";
								$dataMail = get_file(TPL_ROOT.'mail/contact.tpl');
								$dataMail = parse_var($dataMail,array('nom'=>$nomcontact, 'message'=>$messagecontact));
								mail("contact@revedemontagne.fr","[Revedemontagne] - ".$nomcontact,$dataMail,$headers);
								//echo display_notice($message,$type,$redirection);
				
				
				
								/*$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=UTF8' . "\r\n";
								$headers .= 'From: Contact - '.htmlentities($_POST['nom']).' <'.$_POST['email'].'>' . "\r\n";
								$texte = 'De: '.$_POST['email'].'<br />'.stripslashes(zcode($_POST['texte']));
								$sujet = '[Revedemontagne] - '.htmlentities($_POST['sujet']);
								mail('contact@revedemontagne.fr',$sujet,$texte,$headers);*/

							}else{
								$message = "Vous n'avez pas entr&eacute; votre nom ou celui-ci est trop court.";
								$type = "important";
								$redirection = "javascript:history.back(-1);";
							}
						}else{
							$message = "Vous n'avez pas entr&eacute; d'e-mail ou celui-ci est incorrecte.";
							$type = "important";
							$redirection = "javascript:history.back(-1);";
						}
					}else{
						$message = "Vous n'avez pas entr&eacute; de sujet ou celui-ci est trop court.";
						$type = "important";
						$redirection = "javascript:history.back(-1);";
					}
				}else{
					$message = "Vous n'avez pas entr&eacute; de message ou celui-ci est trop court.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}else{
                header('Location: https://revedemontagne.fr');
            }
		}
	}
			
}else{
	http_response_code(405);
	echo 'Méthode non autorisée';
}
	
$db->deconnection();
echo display_notice($message,$type,$redirection);;
?>