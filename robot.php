<?php
$site = 'http://www.google.fr';
$site = str_replace('http://', '', $site); // On enlève le HTTP:// à l'url du site
include("connect.php"); //Connexion à la BDD
$verif = mysql_query("SELECT COUNT(*) AS nb_site FROM sites WHERE url='$site'") or die(mysql_error()); //On cherche le nombre de site ayant déjà une même URL dans la BDD
$nb_verif = mysql_fetch_array($verif);
$n = $nb_verif['nb_site'];
if ($n<1) // Si l'URL n'est pas encore dans la  BDD
{
$source = file_get_contents('http://'.$site.''); // On récupère la source du site
$titre = preg_replace("#<title>(.+)</title>#i", '$1', $source); // On capture le titre du site
$description = preg_replace("#<meta name=\"description\" content=\"(.+)\">#i", '$1', $source); // On capture la description contenue dans la baise meta
$motcle= preg_replace("#<meta name=\"keywords\" content=\"(.+)\">#i", '$1', $source); // On capture les mots clées
$titre = mysql_escape_string(str_replace(' ', '&space;', '$titre'));
$description = mysql_escape_string(str_replace(' ', '&space;', '$description'));
$motcle = mysql_escape_string(str_replace(' ', '&space;', '$motcle'));
$url=$site;
include ('calcul_rank.php');
mysql_query("INSERT INTO sites VALUES(''.$url.'', '100', ''.$titre.'', ''.$description.'', ''.$motcle.'',)");
echo ''.$titre.' '.$description.' '.$motcle.'';
}
mysql_close(); // On termine la connexion
?>
