<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/zcode.fonction.php');

if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$type = 'important';
	$redirection = ROOT.'connexion.html';
}
else
{
	if(!empty($_POST['nb_message']) AND !empty($_POST['nb_sujet']) AND !empty($_POST['nb_news']) AND !empty($_POST['ordre_msg']) AND !empty($_POST['date_style'])){
		$nbsujet = intval($_POST['nb_sujet']);
		$nbmessage = intval($_POST['nb_message']);
		$nbnews = intval($_POST['nb_news']);
		if($_POST['ordre_msg'] == 'ASC' OR $_POST['ordre_msg'] == 'DESC'){
			if($nbnews > 4 AND $nbnews < 51){
				if($nbsujet > 4 AND $nbsujet < 101){
					if($nbmessage > 4 AND $nbmessage < 51){
						if(isset($_POST['sign']))
							$sign = 1;
						else
							$sign = 0;
						if(isset($_POST['email']))
							$email = 1;
						else
							$email = 0;
						$date = htmlentities($_POST['date_style'],ENT_QUOTES);
						$sql = "UPDATE membres SET style_date = '$date',attach_sign = '$sign',afficher_mail='$email',nb_news_page = '$nbnews',ordre = '$_POST[ordre_msg]',nb_sujet_afficher = '$nbsujet',nombre_message_afficher = '$nbmessage' WHERE id_m = '$_SESSION[mid]'";
						$db->requete($sql);
						$_SESSION['nombre_sujet'] = $nbsujet;
						$_SESSION['nombre_message'] = $nbmessage;
						$_SESSION['nombre_news'] = $nbnews;
						$_SESSION['order'] = $_POST['ordre_msg'];
						$_SESSION['style_date'] = $date;
						$message = "Affichage modifi&eacute;.";
						$type = "ok";
						$redirection = ROOT."mes_options.html";
					}else{
						$message = "Le nombre de messages minimum est de 5 et le nombre maximum est de 50.";
						$type = "important";
						$redirection = "javascript:history.back(-1);";
					}
				}else{
					$message = "Le nombre de sujets minimum est de 5 et le nombre maximum est de 100.";
					$type = "important";
					$redirection = "javascript:history.back(-1);";
				}
			}else{
				$message = "Le nombre de news minimum est de 5 et le nombre maximum est de 50.";
				$type = "important";
				$redirection = "javascript:history.back(-1);";
			}
		}else{
			$message = "Ordre de message inconnue.";
			$type = "important";
			$redirection = "javascript:history.back(-1);";
		}
	}else{
		$message = "Un des champs suivant au moins est vide:<ul>
		<li>Style des dates</li>
		<li>Nombre de messages par page</li>
		<li>Nombre de sujets par page</li>
		<li>Nombre de news par page</li>
		<li>Ordre des messages</li>
		<ul>";
		$type = "important";
		$redirection = "javascript:history.back(-1);";
	}
}
$db->deconnection();
echo display_notice($message,'important',$redirection);
?>