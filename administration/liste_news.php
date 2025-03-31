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
	$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
	$redirection = DISPLAY_ROOT.'connexion.html';
	$data = display_notice($message,'important',$redirection);
}
else
{
	$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'"));
	if($auth['modifier_news'] == 1){
		$type = intval($_GET['type']);
		if($type >= 1 AND $type <= 3){
			$data = get_file(TPL_ROOT.'admin/liste_news.tpl');
			if(isset($_GET['page']))
				$page = intval($_GET['page']);
			else
				$page = 1;
			########################################Calcul des pages#################################
			$nb_message_page = $_SESSION['nombre_message'];																	 #
			$retour = $db->requete("SELECT * FROM nm_news WHERE status_news = '$type'");	         #
			$nb_enregistrement = $db->num($retour);													 #
			$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							 #
			if($nombre_de_page < $page)	$page = $nombre_de_page;									 #
			$limite = ($page - 1) * $nb_message_page;												 #
			$liste_page = get_list_page($page,$nombre_de_page);  			 #
			$pages = '';
			foreach($liste_page as $page_n){
				if($page_n == $page)
					$pages .= '<span class="current">&#8201;'.$page_n.'&#8201;</span> ';
				else
					$pages .= '<a href="liste-news-'.$type.'-p'.$page_n.'.html">&#8201;'.$page_n.'&#8201;</a> ';
			}
			$liste_page = $pages;
			##################################################################################
			
			$stat = array(1=>'valid&eacute;es',2=>'en attentes de validation',3=>'en cours d\'&eacute;dition');
			
			if ($nb_enregistrement < 1)
			{
				$message = 'Il n\'y a aucune news dans la cat&eacute;gorie '.$stat[$type];
				$redirection = 'admin.html';
				$data = display_notice($message,'important',$redirection);
			}
			else
			{
				$result = $db->requete("SELECT * FROM nm_news WHERE status_news = '$type' ORDER BY date_news DESC LIMIT $limite,$nb_message_page");
				$ligne = 1;
				while($row = $db->fetch($result)){
					if($auth['valider_news'] == 1){
						if($type == 1)
							$devalider = '<a href="actions/action_news.php?action=5&amp;nid='.$row['id_news'].'"><img src="'.$config['domaine'].'templates/images/1/tick.png" alt="topo mis en ligne" /></a>';
						else
							$devalider = '<a href="actions/action_news.php?action=4&amp;nid='.$row['id_news'].'"><img src="'.$config['domaine'].'/templates/images/1/form/faire_valider.png" alt="Demander une validation"></a>';
					}
					else
						$devalider = '';
					if($auth['supprimer_news'] == 1)
						$supprimer = '<a href="actions/action_news.php?action=6&amp;nid='.$row['id_news'].'"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a>';
					else
						$supprimer = '';
					if($auth['modifier_news'] == 1)
						$modifier = '<a href="editer-'.$row['id_news'].'-news.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>';
					else
						$modifier = '';
						
					if($ligne == 1)
						$ligne = 2;
					else
						$ligne = 1;
				
					$data = parse_boucle('NEWS',$data,FALSE,array('pseudo'=>'<a href="membres-'.$row['id_auteur'].'-fiche.html">'.$row['pseudo_auteur'].'</a>', 'NEWS.id_news'=>$row['id_news'],'date-news'=>get_date($row['date_news'],$_SESSION['style_date']),'titre_news'=>$row['titre'], 'NEWS.url_news'=>title2url($row['titre']), 'supprimer_news'=>$supprimer,'devalider_news'=>$devalider,'modifier_news'=>$modifier, 'ligne'=>$ligne));
				}
				$data = parse_boucle('NEWS',$data,TRUE);
				include(INC_ROOT.'header.php');
				
				$data = parse_var($data,array('design'=>1,'nb_requetes'=>$db->requetes,'liste_page'=>$liste_page,'titre_page'=>'Administration news - '.SITE_TITLE,'status'=>$stat[$type],'ROOT'=>''));
			}
		}
		else
		{
			$message = 'Action inconue.';
			$redirection = 'admin.html';
			$data = display_notice($message,'important',$redirection);
		}
	}
	else{
		$message = 'Vous n\'avez pas le droit d\'acc&eacute;der à cette partie.';
		$redirection = 'index.html';
		$data = display_notice($message,'important',$redirection);
	}
}
$db->deconnection();
echo $data;
?>