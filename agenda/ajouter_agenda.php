<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(!isset($_SESSION['ses_id'])){
	$message = 'Vous devez être enregistré pour pouvoir accéder à cette partie.';
	$redirection = 'inscription.html';
	echo display_notice($message,'important',$redirection);
}
else
{
	$data = get_file(TPL_ROOT.'agenda/ajouter_agenda.tpl');
	if (isset($_GET['nid']) AND !empty($_GET['nid'])){
		$id = intval($_GET['nid']);
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		$row = $db->fetch($db->requete("SELECT * FROM agendas WHERE id_event = '$id'"));
		if($_SESSION['mid'] == $row['id_auteur'] OR ($auth['modifier_news'] == 1 AND $auth['ajouter_news'] == 1)){
			$titre_event = $row['name_event'];
			$contenu = $row['texte'];
			$url_event = $row['url_event'];
			$action_news = 'action=2&amp;nid='.$row['id_news'];
			$titre_page = "Edition d'une actualité";
			if($_SESSION['mid'] == $row['id_auteur'])
				$urlupload = 'popupload-1{subDir}-texte.html';
			else
				$urlupload = 'upload-texte.html';
			$subDir = '-'.$row['id_news'];
		}
		else{
			$db->deconnection();
			$message = 'Vous n\'avez pas les droits pour modifier cette événement.';
			$redirection = 'index.php';
			$data = display_notice($message,'important',$redirection);
			exit($data);
		}
	}
	else{
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		if($auth['ajouter_news'] == 1){
	  		$titre_event = '';
	  		$contenu = '';
			$url_event = '';
	  		$action_news = 'action=1';
	  		$titre_page = "Rédaction d'un événement";
			$urlupload = 'popupload-1-texte.html';
	  		$subDir = '';
		}
		else{
			$db->deconnection();
			$message = 'Vous ne pouvez pas ajouter d\'événement. Ceci n\'est peut être que temporaire.';
			$redirection = 'index.php';
			$data = display_notice($message,'important',$redirection);
			exit($data);
		}
		$jour =	'<option value="1">1
			</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8
			</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15
			</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22
			</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29
			</option><option value="30">30</option><option value="31">31</option>';
		$mois = '<option value="1">Janvier</option><option value="2">Fevrier</option><option value="3">Mars</option><option value="4">Avril</option><option value="5">Mai
			</option><option value="6">Juin</option><option value="7">Juillet</option><option value="8">Aout</option><option value="9">Septembre</option><option value="10">Octobre</option><option value="11">Novembre
			</option><option value="12">D&eacute;cembre</option>';
		$annee = '<option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option>';
	}
	$data = parse_var($data,array('annee'=>$annee, 'mois'=>$mois, 'jour'=>$jour));
	include(INC_ROOT.'header.php');
	$data = parse_var($data,array('action_agenda'=>'1', 'titre_page'=>$titre_page.' - '.SITE_TITLE,'titre'=>$titre_event, 'url_event'=>$url_event,'texte'=>$contenu,'action_news'=>$action_news,'url_upload'=>$urlupload,'subDir'=>$subDir,'design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes,'ROOT'=>''));
	echo $data;
}
$db->deconnection();
?>
