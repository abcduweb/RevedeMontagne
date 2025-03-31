<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
$data = get_file(TPL_ROOT.'album_photos.tpl');
include(INC_ROOT.'header.php');
$result = $db->requete('SELECT * FROM pm_album_photos ORDER BY id_categorie');
while ($resultat = $db->fetch($result))
{
	$resultat['regroupement'] = str_replace('/','',$resultat['regroupement']);
	$cat[$resultat['regroupement']][] = array($resultat['regroupement'].'.regroupement' => '<a href="album-'.title2url($resultat['nom_categorie']).'-c'.$resultat['id_categorie'].'.html">'.$resultat['nom_categorie'].'</a>', $resultat['regroupement'].'.nb' => $resultat['nb_images']);
}
foreach($cat as $key => $vars)
{
	foreach($vars as $var)
	{
		$data = parse_boucle($key,$data,FALSE,$var);
	}
	$data = parse_boucle($key,$data,TRUE);
}
$data = parse_var($data,array('titre_page'=>'Album photos - '.SITE_TITLE,'ROOT'=>'','design'=>$_SESSION['design'],'nb_requetes'=>$db->requetes));
echo $data;
$db->deconnection();
?>