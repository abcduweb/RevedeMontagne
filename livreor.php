<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
if(isset($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;
$data = get_file(TPL_ROOT.'livreor.tpl');
include(INC_ROOT.'header.php');

if (!isset($_SESSION['ses_id']))
	$pseudo = '<label for="pseudo">Pseudo : </label><input type="text" name="pseudo" id="pseudo" /><br/>';
else
	$pseudo = '';

$ige = '<img src="'.INC_ROOT.'img_verif.php" alt="recharger la page pour afficher l\'image" />';

	$nb_message_page = 30;
	
	$retour = $db->requete('SELECT * FROM livreor ORDER BY timestamp DESC');
	$nb_enregistrement = $db->num($retour);
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
			$liste_page .= '<a href="livre-d-or-p'.$var.'.html">&#8201;'.$var.'&#8201;</a> ';
		}
	}
	
	
	
//Calcul des pages//
/*$nb_message_page = 5;
$retour = $db->requete('SELECT COUNT(*) FROM livreor');
$nb_enregistrement = $db->row($retour);
$nombre_de_page = ceil($nb_enregistrement[0] / $nb_message_page);
if($nombre_de_page < $page AND $nombre_de_page > 0)	$page = $nombre_de_page;
$limite = ($page - 1) * $nb_message_page;
$liste_page = get_list_page('livre-d-or-p',$page,$nombre_de_page);
$pages = '';
foreach($liste_page as $page_l){
	if($page == $page_l)
		$pages .= $page_l.' ';
	else
		$pages .= '<a href="livre-d-or-p'.$page_l.'">'.$page_l.'</a> ';
}
$liste_page = $pages;*/
//Fin

if($nb_enregistrement[0] > 1)
	$message = 'messages';
else
	$message = 'message';

$sql = "SELECT ip,id,pseudo,`timestamp`,message FROM livreor ORDER BY timestamp DESC LIMIT $limite,$nb_message_page";
$result = $db->requete($sql);
if(in_array($_SESSION['group'],$team_group_id)){
	$delMsg = '<span class="ttpetit"><a href="actions/supprimer_livreor.php?idM={id}">Supprimer</a></span>';
	if($_SESSION['group'] == 1)
		$affichageIP = '<span class="ttpetit">(<a href="actions/ban.php?ip={ip}">{ip}</a>)</span>';
	else
		$affichageIP = '';
}
else{
	$delMsg = '';
	$affichageIP = '';
}
while($row = $db->fetch_assoc()){
	$data = parse_boucle('COMM',$data,FALSE,array('delMsg'=>$delMsg,'affichageIP'=>$affichageIP,'ip'=>$row['ip'],'id'=>$row['id'],'COMM.pseudo'=>$row['pseudo'],'COMM.date'=>get_date($row['timestamp'],'d-m-Y H:i:s'),'COMM.commentaire'=>$row['message']));
}
$data = parse_boucle('COMM',$data,TRUE);
$data = parse_var($data,array('liste_page'=>$liste_page,'pseudo'=>$pseudo,'imgverif'=>$ige,'titre_page'=>'Livre d\'or - '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'messages'=>$message,'nb'=>$nb_enregistrement[0],'nb_requetes'=>$db->requetes));
echo $data;
$db->deconnection();
?>
