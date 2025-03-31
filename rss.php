<?php
  require_once('rss/rss_fetch.inc.php');

  /* 
  * fonction de parsing du fil RSS prennant en argument l'adresse du fil RSS,
  *  le nombre de billets à afficher (3 par défaut) ainsi que la taille du
  *  résumé des billets (300 caractères par défaut)
  */
  
  $rss_externe = array();
  function parse_rss($url, $nb_items_affiches=5, $taille_resume=300)
  {
    $rss = fetch_rss( $url );

    if (is_array($rss->items))
    {
	
    // on coupe le tableau en fonction du nombre de billets à afficher
    $items = array_slice($rss->items, 0, $nb_items_affiches);

       // on affiche le titre du blog en question et on fait un lien dessus
   /* echo "<h1><a 
        href=\"".$rss->channel['link']."\" 
        title=\"".$rss->channel['tagline']."\">" 
        .$rss->channel['title']."</a></h1>";*/

    // ces lignes ne concernent que ce blog mais c'est pour avoir
    // un exemple de ce que qu'on peut faire...
   /* echo "<div lang=\"fr\">";
    echo "<img 
        src=\"logo_".substr($rss->channel['link'],7,7).".png\" 
        alt=\"".$rss->channel['title']."\" 
        class=\"vignette\" 
        title=\"".$rss->channel['tagline']."\"
         />";*/
    $rss_externe[$rss->channel['title']]='<ul>';

    // pour chacun des billets on affiche le titre, 
    // la date et le résumé (s'ils sont disponibles)
    foreach ($items as $item) {
      $href = $item['link'];
      $title = $item['title'];

      $mois = substr($item['dc']['date'],5,2);
      $jour = substr($item['dc']['date'],8,2);
      $heure = substr($item['dc']['date'],11,2);
      $minute = substr($item['dc']['date'],14,2);

      $resume = substr(strip_tags($item['content']['encoded']),0,$taille_resume)."...";
      $rss_externe[$rss->channel['title']] .= "<li><a href=\"$href\" target=\"blanck\">$title</a>";
      if($jour != '')
         $rss_externe[$rss->channel['title']] .=  " publi&eacute; le $jour/$mois &agrave; $heure h $minute";
      if($resume != '...')
         $rss_externe[$rss->channel['title']] .=  "<br /><span>$resume</span>";
       $rss_externe[$rss->channel['title']] .=  "</li>";
    }
     $rss_externe[$rss->channel['title']] .=  "</ul></div>";
	 
	 print_r($rss_externe);
    }
    else
    {
    echo "Cette erreur signifie en bon fran&ccedil;ais que le fil RSS "
        .$url." n'a pas pu &ecirc;tre obtenu dans les temps.";
    }
}

// création du tableau contenant les fils RSS
$tab_rss = array
(
	'http://planet-montagne.fr/feed/',
    'http://www.kairn.com/rdfnews.xml',
	'http://www.lemonde.fr/rss/une.xml'
);

// on mélange un peu le tableau histoire que ce ne soit pas 
// toujours le même blog qui se retrouve en premier (facultatif)
srand((float)microtime()*1000000);
shuffle($tab_rss);

// on appelle la fonction décrite plus haut pour chacun des 
// fils RSS contenus dans le tableau mélangé
for( $i = 0 ; $i < count($tab_rss) ; $i++ )
{
    parse_rss($tab_rss[$i]);
}
?>