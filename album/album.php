<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
define('ALBUM_ROOT','./images/album/');
$data = get_file(TPL_ROOT.'album.tpl');
$categorie = intval($_GET['cat']);
if(isset($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;
########################################Calcul des pages#################################
$nb_message_page = 10;																	 #
$retour = $db->requete("SELECT * FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie WHERE pm_photos.id_categorie = '$categorie'");       									#
$nb_enregistrement = $db->num($retour); 												 #
$row = $db->fetch_assoc($retour);				 												 #
$nombre_de_page = ceil($nb_enregistrement / $nb_message_page);							 #
if($nombre_de_page < $page)	$page = $nombre_de_page;									 #
$limite = ($page - 1) * $nb_message_page;												 #
$liste_page = get_list_page($page,$nombre_de_page);#
##################################################################################
$pages = '';
foreach($liste_page as $page_l){
	if ($page == $page_l)
		$pages .= '<span class="current">&#8201;'.$page_l.'&#8201;</span>';
	elseif($page_l == '...')
		$pages .= '<a href="#">&#8201;'.$page_l.'&#8201;</a>';
	else
		$pages .= '<a href="album-'.title2url($row['nom_categorie']).'-c'.$categorie.'-p'.$page_l.'.html">&#8201;'.$page_l.'&#8201;</a> ';
}
$liste_page = $pages;
if ($nb_enregistrement > 0)
{
	$album = $db->requete("SELECT pm_photos.date, pm_photos.titre, pm_photos.id_album,
	pm_photos.fichier,pm_photos.commentaire_parser, pm_photos.nbcom, pm_photos.mid, pm_photos.id_album,
	membres.pseudo FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie LEFT JOIN membres ON membres.id_m = pm_photos.mid WHERE pm_photos.id_categorie = '$categorie' ORDER BY date DESC LIMIT $limite,$nb_message_page");
}
else
{
	$album = $db->requete("SELECT pm_photos.date, pm_photos.titre, pm_photos.id_album,
	pm_photos.fichier,pm_photos.commentaire_parser, pm_photos.nbcom, pm_photos.mid, pm_photos.id_album,
	membres.pseudo FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie LEFT JOIN membres ON membres.id_m = pm_photos.mid WHERE pm_photos.id_categorie = '$categorie' ORDER BY date DESC");
}

if($db->num($album) > 0)
{
	$index = $limite;
	$ligne = 1;
	while ($resultat = $db->fetch_assoc($album)){
		$pseudo = '<a href="membres-'.$resultat['mid'].'-fiche.html">'.$resultat['pseudo'].'</a>';
		$date = get_date($resultat['date'],$_SESSION['style_date']);
		$commentaire = $resultat['nbcom'] . ' commentaire';
		if($resultat['nbcom'] > 1)$commentaire .= 's';
		
		$data = parse_boucle("Album",$data,FALSE,array('Album.titre_photo_url'=>title2url($resultat['titre']),'Album.id_photo'=>$resultat['id_album'],'Album.commentaire'=>$commentaire,'Album.titre'=>$resultat['titre'],'Album.image'=>ALBUM_ROOT.ceil($resultat['id_album']/1000).'/'.$resultat['fichier'],'Album.mini'=>ALBUM_ROOT.ceil($resultat['id_album']/1000).'/mini/'.$resultat['fichier'],'Album.normal'=>ALBUM_ROOT.ceil($resultat['id_album']/1000).'/'.$resultat['fichier'],'Album.commentaires'=>stripslashes($resultat['commentaire_parser']),'Album.auteur' => $pseudo,'Album.date'=>$date,'index_photo'=>$index,'categorie_url'=>title2url($row['nom_categorie']),
		'ligne'=>$ligne, 'id_cat'=>$categorie));
		
		$index++;
		if($ligne == 1)
			$ligne = 2;
		else
			$ligne = 1;
	}
	$data = parse_boucle('Album',$data,TRUE);
}
else
{
	$data = get_file(TPL_ROOT.'album_empty.tpl');
	$data = parse_var($data,array('categorie' => 'Pas de photos dans cette catégorie'));
}
include(INC_ROOT.'header.php');
$data = parse_var($data,array('design'=>$_SESSION['design'],'ROOT'=>'','liste_page'=>$liste_page,'categorie' => $row['nom_categorie'],'nb_requetes'=>$db->requetes,'titre_page'=>'Album '.$row['nom_categorie'].' - '.SITE_TITLE,'titre_url'=>title2url($row['nom_categorie']),'nv_categorie'=>$row['nom_categorie'],'id_categorie'=>$row['id_categorie']));
echo $data;
$db->deconnection();
?>