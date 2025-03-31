<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################

// On vérifie que la méthode POST est utilisée
if($_SERVER['REQUEST_METHOD'] == 'POST'){
// On vérifie si le champ "recaptcha-response" contient une valeur
	if(empty($_POST['recaptcha-response'])){
		header('Location: https://revedemontagne.fr/livre-d-or.html');
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
            header('Location: https://revedemontagne.fr/livre-d-or.html');
        }else{
            $data = json_decode($response);
            if($data->success){
				
			if (isset ($_POST['textarea']) AND !empty ($_POST['textarea']) AND strlen(trim($_POST['textarea'])) > 5) {
				$verification = $db->requete("SELECT * FROM livreor WHERE ip = '" . get_ip() . "' ORDER BY id DESC LIMIT 0,1");
				$ok = $db->fetch($verification);
				$contenu = htmlentities($_POST['textarea'], ENT_QUOTES);

						if (get_ip() == $ok['ip'] AND ($ok['timestamp'] + (3600 * 24)) > time()) {
							$message = 'Vous ne pouvez plus ajouter de message pour le moment';
							$redirection = ROOT . 'index.php';
							$type = 'important';
						} else if (preg_match_all("`&lt;\/?(\w+)(\s(\w+=\\\"[\w\.-:\s;&\?=@-]+\\\"))*\s?/?&gt;`", $contenu,$truc)) {
							$message = 'Votre message contient des donn&eacute;es non valides!!!';
							$redirection = ROOT . 'index.php';
							$type = 'important';
						} else {
							if (!isset ($_SESSION['ses_id'])) {
								if (!empty ($_POST['pseudo']))
									$pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
								else {
									$db->deconnection();
									$message = 'le pseudo n\'est pas enregistr&eacute;, veuillez recommencer';
									$redirection = 'javascript:history.back(-1);';
									echo display_notice($message,'important',$redirection);;
									exit;
								}
							} else
							$pseudo = $_SESSION['membre'];
						
							$db->requete("INSERT INTO livreor VALUES('', '$pseudo','" . get_ip() . "',UNIX_TIMESTAMP(),'$contenu')");
							$message = 'votre message a bien &eacute;t&eacute; envoy&eacute;';
							$redirection = ROOT . 'livre-d-or.html';
							$type = 'ok';
							
							//On envoi un mail à l'administrateur du site
							$headers  = 'MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From: Revedemontagne <contact@revedemontagne.fr>' . "\r\n";
							$dataMail = get_file(TPL_ROOT.'mail/message_livreor.tpl');
							$dataMail = parse_var($dataMail,array('pseudo'=>$pseudo, 'message'=>$contenu));
							$mail_admin = 'adriendubois0726@gmail.com';
							mail($mail_admin,"Nouveau message sur le livre d'or",$dataMail,$headers);
							
							//echo display_notice($message,'ok',$redirection);
						}
					
			}else {
				$message = 'Votre message est vide ou trop court';
				$redirection = 'javascript:history.back(-1);';
				$type = 'important';
			}
			$db->deconnection();
			echo display_notice($message,$type,$redirection);
			
			}else{
                header('Location: https://revedemontagne.fr/livre-d-or.html');
            }
		}
	}
			
}else{
	http_response_code(405);
	echo 'M&eacute;thode non autoris&eacute;e';
}

?>