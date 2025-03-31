<?php
if(!isset($load_tpl)){
$load_tpl = true;
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
}
if(!empty($_GET['pid']))
{
	
	$data = get_file(TPL_ROOT."agenda/lecture_agenda.tpl");
		
	include(INC_ROOT.'header.php');
	$midi = intval($_GET['pid']);
		$reponse =  $db->requete("SELECT * FROM agendas
									LEFT JOIN membres ON membres.id_m = agendas.id_m
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
									WHERE agendas.id_event = '".$midi."'");
		$num = $db->num();
		$donnees = $db->fetch($reponse);

	if($num > 0){
			
		$data = parse_var($data,array(
			'date_debut_event'=>date('d/m/Y',strtotime($donnees['date_debut_event'])),
			'url_event'=>title2url($donnees['name_event']),
			'id_event'=>$donnees['id_event'],
			'name_event'=>$donnees['name_event'],
			'event_parser'=>$donnees['desc_event_parser'],
			'url_event'=>$donnees['url_event'],
			'pseudo_auteur'=>$donnees['pseudo'],
			'id_m'=>$donnees['id_m'],
			'titre_page'=>date('d/m/Y',strtotime($donnees['date_debut_event'])).' '.$donnees['name_event'].' - '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'',
			));
		
		$data = parse_var($data,array('design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));
	}else
	{
		$message = 'La fiche n\'existe pas';
		$redirection = 'javascript:history.back(-1);';
		$data = display_notice($message,'important',$redirection);
	}
	
	
}else
{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>