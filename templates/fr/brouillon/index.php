<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/beta.fonction.php');
if(!empty($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;

if (!isset($_SESSION['ses_id']))
	$texteintro='		
		<p class="texteintro">
		Ce site vise à rassembler dans une communauté conviviale et agréable tous les passionnés de montagnes et de la nature en générale.<br />
		Il vous permet entre autre de partager <a href="photos.html">vos photos</a>,<a href="mes-articles.html">vos articles</a> et <a href="mes-news.html">vos news</a> mais aussi d\'échanger vos idées sur le <a href="forum.html">forum</a>.<br />
		Alors venez vite nous rejoindre, <a href="inscription.html">inscrivez</a> vous dès maintenant
		</p>';
else
	$texteintro = '';
	
if($page == 1){
	$data = get_file(TPL_ROOT.'index.tpl');
	if(!is_cache(ROOT.'caches/.htcache_index')){//on test le cache si il est a rechargé ou non
		$derniereimage = $db->requete('SELECT * FROM pm_photos LEFT JOIN pm_album_photos ON pm_photos.id_categorie = pm_album_photos.id_categorie ORDER BY pm_photos.id_album DESC limit 0, 1');
		$reponse = $db->fetch($derniereimage);
		$cache['image'] = array('titre_url'=>title2url($reponse['nom_categorie']),'categorie'=>$reponse['nom_categorie'],'id_categorie'=>$reponse['id_categorie'],'image'=>$reponse['fichier'],'titre'=>$reponse['titre'],'description'=>$reponse['commentaire'],'album'=>ceil($reponse['id_album']/1000));
		$result = $db->requete("SELECT * FROM articles_intro_conclu WHERE article_status = '1' ORDER BY date_article DESC LIMIT 0,5");
		$i = 1;
		while($row = $db->fetch($result))
		{
			$cache['rando'.$i] = array('rando'.$i => $row['titre'],'id'.$i => $row['id_article'],'url_rando'.$i=>title2url($row['titre']));
			$i++;
		}
		write_cache(ROOT.'caches/.htcache_index',array('cache'=>$cache));
	}
	else{
		require_once(ROOT.'caches/.htcache_index');
	}
	foreach($cache as $var){
		$data = parse_var($data,$var);
	}
}
else{
	$data = get_file(TPL_ROOT.'news.tpl');
}
$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>SITE_TITLE,'ROOT'=>''));
//Calcul des pages//
$nb_message_page = $_SESSION['nombre_news'];
$retour = $db->requete('SELECT COUNT(*) FROM nm_news WHERE status_news = "1"');
$nb_enregistrement = $db->row();
$nombre_de_page = ceil($nb_enregistrement[0] / $nb_message_page);
if($nombre_de_page < $page)	$page = $nombre_de_page;
$limite = ($page - 1) * $nb_message_page;
$liste_page = get_list_page($page,$nombre_de_page);

$pages = '';
foreach($liste_page as $page_l){
	if ($page == $page_l OR $page_l == '...')
		$pages .= $page_l.' ';
	else
		$pages .= '<a href="index-p'.$page_l.'.html">'.$page_l.'</a> ';
}

if($limite < 0)$limite = 0;
$sql = "SELECT id_news,nb_com, valider_news, supprimer_news, status_com, modifier_news, id_auteur,
pseudo_auteur,date_news, titre, texte_parser FROM nm_news LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' 
LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group 
WHERE status_news = '1' ORDER BY date_news DESC LIMIT $limite,$nb_message_page";

$result = $db->requete($sql);
while($row = $db->fetch_assoc()){
	$nb_com = 'commentaire';
	if($row['nb_com'] > 1) $nb_com .= 's';
	if($row['valider_news'] == 1)
		$devalider = '<a href="actions/action_news.php?action=5&amp;nid='.$row['id_news'].'">Dévalider</a>';
	else
		$devalider = '';
	if($row['supprimer_news'] == 1){
		$supprimer = '<a href="actions/action_news.php?action=6&amp;nid='.$row['id_news'].'">Supprimer</a>';
		if($row['status_com'] == 1)
			$fermer_com = '<a href="actions/fermer_ouvrir_com.php?action=0&amp;nid='.$row['id_news'].'">Fermer</a>';
		else
			$fermer_com = '<a href="actions/fermer_ouvrir_com.php?action=1&amp;nid='.$row['id_news'].'">Ouvrir</a>';
	}
	else{
		$supprimer = '';
		$fermer_com = '';
	}
	if($row['modifier_news'] == 1)
		$modifier = '<a href="editer-'.$row['id_news'].'-news.html">Editer</a>';
	else
		$modifier = '';
	$data = parse_boucle('NEWS',$data,FALSE,array('pseudo'=>'<a href="membres-'.$row['id_auteur'].'-fiche.html">'.$row['pseudo_auteur'].'</a>','date-news'=>date('d/m/Y à H\hi',$row['date_news']),'comm'=>'<a href="commentaires-de-'.title2url($row['titre']).'-n'.$row['id_news'].'.html#commentaires">'.$row['nb_com'].' '.$nb_com.'</a>','texte-news'=>stripslashes($row['texte_parser']),'titre_news'=>$row['titre'],'supprimer_news'=>$supprimer,'devalider_news'=>$devalider,'fermer_com'=>$fermer_com,'modifier_news'=>$modifier));
}

$data = parse_boucle('NEWS',$data,TRUE);
include(INC_ROOT.'header.php');

$data = parse_var($data,array('texte-intro'=>$texteintro,'liste_page'=>$pages,'nb_requetes'=>$db->requetes,'ROOT'=>''));
echo $data;
createKeyword($data);
$db->deconnection();
?>
