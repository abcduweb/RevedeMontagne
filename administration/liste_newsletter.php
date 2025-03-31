<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id']))
{
	$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
	$redirection = DISPLAY_ROOT.'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	if($auth['id_group'] == 1)
	{
		$type = intval($_GET['type']);
		if($type >= 1 AND $type <= 2)
		{
			$data = get_file(TPL_ROOT.'admin/liste_newsletter.tpl');
			if(isset($_GET['page']))
				$page = intval($_GET['page']);
			else
				$page = 1;
			########################################Calcul des pages#################################
				$nb_message_page = 20;																	 #
				$retour = $db->requete("SELECT * FROM newsletter WHERE status_newsletter = '$type'");	         #
				$nb_enregistrement = $db->num($retour);													 #
				$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							 #
				if($nombre_de_page < $page)	$page = $nombre_de_page;									 #
				$limite = ($page - 1) * $nb_message_page;												 #
				$liste_page = get_list_page($page,$nombre_de_page);  			 #
				$pages = '';
				foreach($liste_page as $page_n){
					if($page_n == $page)
						$pages .= $page_n.' ';
					else
						$pages .= '<a href="liste-newsletter-'.$type.'-p'.$page_n.'">'.$page_n.'</a> ';
				}
				$liste_page = $pages;
			######################################################################################	
			$result = $db->requete("SELECT * FROM newsletter WHERE status_newsletter = '$type' ORDER BY date_news DESC LIMIT $limite,$nb_message_page");
			while($row = $db->fetch($result))
			{
				$supprimer = '';
				$modifier = '';
				$data = parse_boucle('NEWS',$data,FALSE,array(
					'newsletter_id'=>$row['id_newsletter'],
					'date-news'=>date('d/m/Y à H\hi',$row['date_news']),
					'titre_news'=>$row['titre'],
					'titre_news_url'=>title2url($row['titre']),
					'supprimer_news'=>$supprimer,
					'modifier_news'=>$modifier
				));
			}
			$data = parse_boucle('NEWS',$data,TRUE);
			
			
			include(INC_ROOT.'header.php');
			$stat = array(1=>'en cours de rédaction',2=>'envoyé');
			$data = parse_var($data,array('design'=>1,'nb_requetes'=>$db->requetes,'liste_page'=>$liste_page,'titre_page'=>'Administration news - '.SITE_TITLE,'status'=>$stat[$type],'ROOT'=>''));
		}
		else
		{
			$message = 'Action inconue.';
			$redirection = 'admin.html';
			$data = display_notice($message,'important',$redirection);
		}
			
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'accéder à cette partie.';
		$redirection = 'index.html';
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>