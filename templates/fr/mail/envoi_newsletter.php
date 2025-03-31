<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
define('DOMAINE', 'http://www.revedemontagne.fr/');
###########################################################
$sql = "SELECT * FROM autorisation_globale WHERE id_group = '$_SESSION[group]'";
$auth = $db->fetch($db->requete($sql));
if($auth['id_group'] == 1)
{
	$liste = "";
	/*On récupére la liste des personnes ayant souscrit à la newsletter*/
	$result = $db->requete("SELECT id_m, pseudo, newsletter, email FROM membres WHERE newsletter = 1 ORDER BY id_m DESC");
	while($row = $db->fetch($result))
	{
		$liste .= ','; 
		$liste .= $row['email'];
	}
	
	$destinataire = 'newsletters@revedemontagne.fr';
	$date = date("d/m/Y");
 
	$objet = "Actualités sur Rêve de montagne du $date"; 
	
	//On définit le reste des paramètres.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: R&#234;ve de montagne <newsletters@revedemontagne.fr>' . "\r\n";
	$headers .= 'Bcc:' . $liste . '' . '\r\n';
    $dataMail = get_file(TPL_ROOT.'mail/newsletter.tpl');
	
	require_once(ROOT.'caches/.htcache_index');
	foreach($cache as $var)
	{
		$dataMail = parse_var($dataMail,$var);
	}
    $dataMail = parse_var($dataMail,array('DOMAINE'=>DOMAINE));
	mail($destinataire,$objet,$dataMail,$headers);	
	
	$data = display_notice("La newsletter a été envoyé.".$liste."","ok",ROOT.'index.html');
	
}
else
{
	$data = display_notice("Vous n'avez pas le droit de lire cette news.","important",ROOT.'index.html');
}
echo $data;
$db->deconnection();
?>

