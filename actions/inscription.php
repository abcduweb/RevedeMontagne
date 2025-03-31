<?php
/*
 * Créer le 14 juil. 2007 par NeoZer0
 * Ceci est un morceau de code de http://www.montagardesalpes.fr
 * Cette partie est: le traitement de l'inscription.
 */
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$sql = 'SELECT * FROM membres WHERE ip = \''.get_ip().'\'';
$result = $db->requete($sql);
while($row = $db->fetch($result)){
	if($row['id_group'] == '7'){
		$message = "Vous ne pouvez pas vous inscrir.";
		$db->deconnection();
		echo display_notice($message,'important',$redirection);
		exit;
	}
}
if (isset ($_SESSION['ses_id'])) {
	$db->deconnection();
	$message = "Vous avez déjà un compte.";
	$type = "important";
	echo display_notice($message,'important',$redirection);
	exit;
} else {
	
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
				
				$error = array ();
				if (isset ($_POST['pseudo']) AND !empty ($_POST['pseudo'])) {
					if(strlen(trim($_POST['pseudo'])) > 3){
						$pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
						$sql = "SELECT * FROM membres WHERE pseudo = '$pseudo'";
						$result = $db->requete($sql);
						if ($db->num($result) > 0) {
							//pseudo utiliser
							$error[8] = true;
						}
					}else{
						//pseudo trop cour
						$error[9] = true;
					}
				} else {
					// pas de pseudo
					$error[1] = true;
				}
				if (isset ($_POST['mdp1']) AND !empty ($_POST['mdp1'])) {
					if (isset ($_POST['mdp2']) AND !empty ($_POST['mdp2'])) {
						if ($_POST['mdp1'] == $_POST['mdp2']) {
							$pass = md5($_POST['mdp1']);
						} else {
							//vérif et pass différent
							$error[4] = true;
						}
					} else {
						//pas de vérif
						$error[3] = true;
					}
				} else {
					//pas de pass
					$error[2] = true;
				}
				if (isset ($_POST['email1']) AND !empty ($_POST['email1'])) {
					if (isset ($_POST['email2']) AND !empty ($_POST['email2'])) {
						if(preg_match('`^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$`',$_POST['email1'])){
							if ($_POST['email1'] == $_POST['email2']) {
								$mail = htmlentities($_POST['email1'], ENT_QUOTES);
								$sql = "SELECT * FROM membres WHERE email = '$mail'";
								$result = $db->requete($sql);
								if($db->num($result) > 0){
									$error[13] = true;
								}
							} else {
								//mail différent
								$error[7] = true;
							}
						}else{
							//mail pas correcte
							$error[12] = true;
						}
					} else {
						//pas de vérification
						$error[6] = true;
					}
				} else {
					//pas de mail
					$error[5] = true;
				}
				
				if (in_array(true, $error)) {
					$msg = '';
					foreach($error as $key => $var){
						if($var == true){
							switch ($key){
								case 0:
									$msg .= 'Vous n\'avez pas accepter le réglement.<br />';
								break;
								case 1:
									$msg .= 'Vous n\'avez pas entré de pseudo.<br />';
								break;
								case 2:
									$msg .= 'Vous n\'avez pas entré de mot de passe.<br />';
								break;
								case 3:
									$msg .= 'Vous n\'avez pas entré une deuxième fois votre mot de passe.<br />';
								break;
								case 4:
									$msg .= 'Les deux mots de passe sont différents.<br />';
								break;
								case 5:
									$msg .= 'Vous n\'avez pas entrer d\'adresse mail.<br />';
								break;
								case 6:
									$msg .= 'Vous n\'aver pas entrer une deuxième fois votre adresse mail.<br />';
								break;
								case 7:
									$msg .= 'Les deux adresse mail sont différentes.<br />';
								break;
								case 8:
									$msg .= 'Le pseudo est déjà utilisé.<br />';
								break;
								case 9:
									$msg .= 'Le pseudo est trop court.<br />';
								break;
								case 10:
									$msg .= 'Code de vérification incorrect.<br />';
								break;
								case 11:
									$msg .= 'Code de vérification vide.<br />';
								break;
								case 12:
									$msg .= 'L\'adresse mail est incorrecte.<br />';
								break;
								case 13:
									$msg .= 'L\'adresse mail est déjà utilisée.<br />';
								break;
								case 14:
									$msg .= 'Nom vide ou trop court.<br />';
								break;
								case 15:
									$msg .= 'Prenom vide ou trop court.<br />';
								break;
							}
						}
					}
					$message = $msg;
					$redirection = "javascript:history.back(-1);";
					echo display_notice($message,'important',$redirection);
				} else {
					$codeActivation = uniqid(mt_rand(),true);
					$codeActivation .= md5($mail);
					$codeActivation = md5($pseudo).$codeActivation;
					$codeActivation = md5($codeActivation);
					$ipNewMembre = get_ip();
					$sql = "INSERT INTO membres VALUES ('','5','0','$pseudo','$pass',UNIX_TIMESTAMP(),'0','0','0','1','ASC','50','30','8','Le %A %d %B %Y à %Hh%M','0','5','0','1','1','','$mail','','','','','','','','','','$codeActivation','fr','','0','','','$ipNewMembre','0','','','','')";
					$db->requete($sql);
					$message = "Votre inscription a bien &eacute;t&eacute; prise en compte.<br /> Votre compte est pour l'instant inactif, un email vous a &eacute;t&eacute; envoy&eacute; pour l'activer.";
					$redirection = ROOT . "index.php";
					
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: Revedemontagne <noreply@revedemontagne.fr>' . "\r\n";
					$dataMail = get_file(TPL_ROOT.'mail/validation.tpl');
					$dataMail = parse_var($dataMail,array('nom'=>$nom,'prenom'=>$prenom,'pseudo'=>$pseudo,'mail'=>$mail,'validation'=>$codeActivation));
					mail($mail,"Revedemontagne - confirmation inscription ".$pseudo,$dataMail,$headers);
					echo display_notice($message,'ok',$redirection);
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
	
}
$db->deconnection();
?>