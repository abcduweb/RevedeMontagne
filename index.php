<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/beta.fonction.php');
require_once(ROOT.'fonctions/divers.fonction.php');
//require_once(ROOT.'rss/rss_fetch.inc.php');

if(!empty($_GET['page']))
	$page = intval($_GET['page']);
else
	$page = 1;

if (!isset($_SESSION['ses_id']))
	$texteintro='		
		<p class="texteintro">
		Ce site vise &agrave; rassembler dans une communaut&eacute; conviviale et agr&eacute;able tous les passionn&eacute;s de montagnes et de la nature en g&eacute;n&eacute;rale.<br />
		Il vous permet entre autre de partager <a href="photos.html">vos photos</a>,<a href="mes-articles.html">vos articles</a> et <a href="mes-news.html">vos news</a> mais aussi d\'&eacute;changer vos id&eacute;es sur le <a href="forum.html">forum</a>.<br />
		Alors venez vite nous rejoindre, <a href="inscription.html">inscrivez</a> vous d&egrave;s maintenant
		</p>';
else
	$texteintro = '';
	$texteintro = '';
	$data = get_file(TPL_ROOT.'index_revedemontagne.tpl');
	if(!is_cache(ROOT.'caches/.htcache_index')){//on test le cache si il est a recharg&eacute; ou non
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
		
		//Topos skis de randonn&eacute;e
		$result = $db->requete("SELECT * FROM topos
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.statut > '0' AND topos.id_activite = '1' AND visible = 1 ORDER BY topos.id_topo DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$lien_topo_skis = 'topo-'.title2url($row['nom_point']).'-'.title2url($row['nom_topo']).'';
			$cache['toposki'.$i] = array('toposki'.$i => $row['nom_point'].', '.$row['nom_topo'],'idts'.$i => $row['id_topo'],'urlts'.$i=>$lien_topo_skis);
			$i++;
		}
		
		//Topos randonn&eacute;e
		$result = $db->requete("SELECT * FROM topos
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE topos.statut > '0' AND topos.id_activite = '2'  AND visible = 1 ORDER BY topos.id_topo DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$lien_topo_randonnee = 'topo-'.title2url($row['nom_point']).'-'.title2url($row['nom_topo']).'';
			$cache['toporando'.$i] = array('toporando'.$i => $row['nom_point'].', '.$row['nom_topo'],'idtr'.$i => $row['id_topo'],'urltr'.$i=>$lien_topo_randonnee);
			$i++;
		}
		
		//fichiers GPX
		/*$result = $db->requete("SELECT * FROM map_gpx
				LEFT JOIN membres ON membres.id_m = map_gpx.id_m
				LEFT JOIN activites ON activites.id_activite = map_gpx.id_activite
				LEFT JOIN massif ON massif.id_massif = map_gpx.id_massif
				WHERE statut_mapgpx = '0' ORDER BY id_mapgpx DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$cache['gpx'.$i] = array('gpx'.$i => $row['nom_mapgpx'],'actgpx'.$i => $row['nom_activite'],'idgpx'.$i => $row['id_mapgpx'],'urlgpx'.$i=>'map-'.title2url($row['nom_mapgpx']).'-m'.$row['cle_mapgpx'].'.html');
			$i++;
		}*/
		
		//Les news
		$result = $db->requete("SELECT id_news,nb_com, valider_news, supprimer_news, status_com, modifier_news, id_auteur,
		pseudo_auteur,date_news, nm_news.titre, texte_parser FROM nm_news LEFT JOIN membres ON membres.id_m = '$_SESSION[mid]' 
		LEFT JOIN autorisation_globale ON autorisation_globale.id_group = membres.id_group 
		WHERE status_news = '1' ORDER BY date_news DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$cache['news'.$i] = array('news'.$i => $row['titre'],'idn'.$i => $row['id_news'],'urln'.$i=>title2url($row['titre']), 'daten'.$i=>date('d/m',$row['date_news']));
			$i++;
		}
		
		
		//Gestion des news externes
		/*$tab_rss = array
		(
			'http://planet-montagne.fr/feed/',
			'http://www.clubalpinvalence.fr/sortie_rss.php',
		);
		define('MAGPIE_OUTPUT_ENCODING', 'UTF-8');
		for( $n = 0 ; $n < count($tab_rss) ; $n++ )
		{
			$url = $tab_rss[$n];
			$nb_items_affiches=5;
			$taille_resume=300;
			
			  
				$rss = fetch_rss( $url );
				//print_r($rss);
				
				if (is_array($rss->items))
				{	
					// on coupe le tableau en fonction du nombre de billets à afficher
					$items = array_slice($rss->items, 0, $nb_items_affiches);
					$i = 1;
					foreach ($items as $item) 
					{
						$href = $item['link'];
						$title = $item['title'];

						$mois = substr($item['dc']['date'],5,2);
						$jour = substr($item['dc']['date'],8,2);
						$heure = substr($item['dc']['date'],11,2);
						$minute = substr($item['dc']['date'],14,2);

						$resume = substr(strip_tags($item['content']['encoded']),0,$taille_resume)."...";
						$d = $rss->channel['pubDate'];
						
						$link = $rss->channel['link'];		 
						$cache[$link.'['.$i.']'] = array('title'.'['.$link.'_'.$i.']' => $item['title'],'date'.'['.$link.'_'.$i.']' => $d, 'resume'.'['.$link.'_'.$i.']' => $resume,'url_news'.'['.$link.'_'.$i.']'=>$href);
						$i++;
					}		 
					
					write_cache(ROOT.'caches/.rss_externe',array('cache'=>$cache));
				}
				else
				{
				echo "Cette erreur signifie en bon fran&ccedil;ais que le fil RSS "
					.$url." n'a pas pu &ecirc;tre obtenu dans les temps.";
				}
		}
		*/
		
		//Les dernières sorties
		$result = $db->requete("SELECT * FROM sortie
				left join topos ON topos.id_topo = sortie.id_topo
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE dates <= NOW()
				AND topos.visible = 1
				ORDER BY sortie.dates DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$cache['sortie'.$i] = array('sortie'.$i => $row['nom_point'].', '.$row['nom_topo'],
										'sactivites'.$i => $row['nom_activite'],
										'surl'.$i=>title2url($row['nom_point']).'-'.title2url($row['nom_topo']).'-sortie-n'.$row['id_sortie'].'.html',
										'date'.$i=>date("d-m-Y", strtotime($row['dates'])));
			$i++;
		}
		
		//Les prochaines sorties
		$result = $db->requete("SELECT * FROM sortie
				left join topos ON topos.id_topo = sortie.id_topo
				LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
				LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
				LEFT JOIN massif ON massif.id_massif = point_gps.id_massif 
				LEFT JOIN departs ON departs.id_depart = topos.id_depart
				LEFT JOIN activites ON activites.id_activite = topos.id_activite
				WHERE dates > NOW()
				AND topos.visible = 1
				ORDER BY sortie.dates DESC LIMIT 0,6");
		$i = 1;		
		while($row = $db->fetch($result))
		{
			$cache['sortiea'.$i] = array('sortiea'.$i => $row['nom_point'].', '.$row['nom_topo'],
										'sactivitesa'.$i => $row['nom_activite'],
										'surla'.$i=>title2url($row['nom_point']).'-'.title2url($row['nom_topo']).'-sortie-n'.$row['id_sortie'].'.html',
										'datea'.$i=>date("d-m", strtotime($row['dates'])));
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
	
$data = parse_var($data,array('design'=>$_SESSION['design'],'titre_page'=>SITE_TITLE,'ROOT'=>''));

include(INC_ROOT.'header.php');

$data = parse_var($data,array('texte-intro'=>$texteintro,'nb_requetes'=>$db->requetes,'ROOT'=>''));
include(INC_ROOT.'footer.php');

echo $data;
createKeyword($data);
$db->deconnection();
?>
