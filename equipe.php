<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$data = get_file(TPL_ROOT.'equipe.tpl');
include(INC_ROOT.'header.php');
$reponse = $db->requete('SELECT * FROM membres LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group WHERE membres.id_group = 1');
$ligne = 1;
while ($donnees = $db->fetch($reponse))
{
	$pseudo = '<a href="membres-'.$donnees['id_m'].'-fiche.html">'.$donnees['pseudo'].'</a>';
	$avatar ='<img src="'.$donnees['avatar'].'" alt="avatar de '.$donnees['pseudo'].'"/>';
	$equipe[$donnees['nom_group']][] = array($donnees['nom_group'].'.avatar' => $avatar,$donnees['nom_group'].'.nom' => $pseudo, $donnees['nom_group'].'.ligne' => $ligne, $donnees['nom_group'].'.signature'=>stripslashes($donnees['signature_parser']));
	
	if($ligne == 1)
		$ligne = 2;
	else
		$ligne = 1;
}
foreach($equipe as $key => $vars)
{
	foreach($vars as $var)
	{
		$data = parse_boucle($key,$data,FALSE,$var);
	}
	$data = parse_boucle($key,$data,TRUE);
}
$data = parse_var($data,array('titre_page'=>'L\'&eacute;quipe du '.SITE_TITLE,'nb_requetes'=>$db->requetes,'design'=>$_SESSION['design'],'ROOT'=>''));
echo $data;
$db->deconnection();
?>