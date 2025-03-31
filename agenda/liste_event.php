<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$auth = $db->fetch($db->requete($sql));

$data = get_file(TPL_ROOT.'agenda/liste_event.tpl');
	
if(isset($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;

	
	$nb_message_page = $_SESSION['nombre_news'];
	
	$sql = ("SELECT * FROM agendas WHERE status_event = 1");	
	$db->requete($sql);
	//$nb_pages = $db->num();
	$nb_enregistrement = $db->num();
	$nb_page = ceil($nb_enregistrement / $nb_message_page);
	if($page > $nb_page) $page = $nb_page;
	$limite = ($page - 1) * $nb_message_page;
	
	$liste_page = '';
	foreach(get_list_page($page,$nb_page) as $var){
		switch($var){
			case $page:
				$liste_page .= '<span class="current">&#8201;'.$var.'&#8201;</span> ';
			break;
			case '<a href="#">&#8201;...&#8201;</a> ':
				$liste_page .= $var;
			break;
			default:
			$liste_page .= '<a href="liste-des-prochains-evenements-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	

//On vérifi les droits pour rajouté un événements		
if(!isset($_SESSION['ses_id'])){
	$ajout_event = 'Pour ajouter un topo il faut vous <a href="inscription.html">inscrire</a> ou vous <a href="connexion.html">connecter</a>';}
else{
	$ajout_event = '<a href="'.$config['domaine'].'ajouter-un-evenement.html"><img src="'.$config['domaine'].'/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>';}
	
$result = $db->requete("SELECT * FROM agendas WHERE status_event = 1 ORDER BY date_debut_event DESC LIMIT $limite,$nb_message_page");
while($row = $db->fetch($result))
{
	if(!isset($_SESSION['ses_id']))
		{
			$hcol_action = '';
			$nb_colonne = 5;
			$colaction='';	
		}
	elseif($row['id_m'] == $_SESSION['mid'] AND $auth['redacteur_topo'] == 1 OR $auth['administrateur_topo'] == 1)
		{
			$nb_colonne = 6;
			$hcol_action='<th>Actions</th>';	
			$colaction='<td class="centre"><a href="#.html"><img src="'.$config['domaine'].'/templates/images/1/form/edit.png" alt="Editer"></a>
						<a href="'.$config['domaine'].'"><img src="'.$config['domaine'].'/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>';
		}
	else
		{
			$nb_colonne = 6;
			$hcol_action='<th>Actions</th>';	
			$colaction='<td class="centre"> - </td>';	
		}
	$data = parse_boucle('EVENT',$data,FALSE,array('EVENT.datedeb'=>$row['date_debut_event'], 
												  'EVENT.datefin'=>$row['date_fin_event'],
												  'EVENT.url_nom_event'=>title2url($row['name_event']),
												  'EVENT.nom_event'=>$row['name_event'],
												  'EVENT.id_event'=>$row['id_event'],
												  'EVENT.lieu'=>$row['lieu'],
												  'EVENT.col_action'=>$colaction));
}
$data = parse_boucle('EVENT',$data,TRUE);
include(INC_ROOT.'header.php');
$data = parse_var($data,array('ajout_event'=>$ajout_event,'hcol_action'=>$hcol_action, 'design'=>1,'nb_requetes'=>$db->requetes,'liste_page'=>$liste_page,'titre_page'=>'Liste des prochains événements - '.SITE_TITLE,'ROOT'=>''));

$db->deconnection();
echo $data;
?>