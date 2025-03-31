<?php 
/*################################################################################################################################
Réalisation SAS ABCduWeb
Date de création : 04/04/2024
Date de mise à jour : 03/07/2024
Contact : contact@abcduweb.fr
################################################################################################################################*/
include(INC_ROOT.'admin_rights.php');


$config['lang'] = 'fr';
$config['local'] = true;
$config['developpement'] = true;
$config['key_IGN'] = 'XXXXXXXXXXXXXXXX';
if ($config['developpement'] == true and !isset($_SESSION['ses_id']) and $config['local'] <> true)
{
	if($_SERVER['REQUEST_URI'] == '/connexion.html' OR $_SERVER['REQUEST_URI'] == '/actions/connexion.php')
	{
	}
	else
	{
		header('Location: https://revedemontagne.fr');
	}
}

//initialisation balises facebook
$config['og_facebook_image'] = '';
$config['og_facebook_image_alt'] = '';
$config['og_facebook_width'] = '';
$config['og_facebook_height'] = '';
$config['og_facebook_description'] = 'RêvedeMontagne, le site des passionnés de sport de Montagne';
$config['og_facebook_url'] = 'https://revedemontagne.fr';
$config['og_facebook_title'] = 'RêvedeMontagne';

if($config['local'] == true)
{
	//configuration des variables//
	$config['site_title'] = "(version local)";
	$sql_serveur = 'localhost';
	$sql_login = 'root';
	$sql_pass = '';
	$sql_bdd = 'revedemoieadrien';
	$config['domaine'] = 'http://127.0.0.1/revedemontagne/';

}
elseif ($config['developpement'] == true)
{
	//configuration des variables//
	$config['site_title'] = "(version développement)";
	$sql_serveur = 'localhost';
	$sql_login = 'XXXXXXXXXXXXXXXX';
	$sql_pass = 'XXXXXXXXXXXXXXXX';
	$sql_bdd = 'XXXXXXXXXXXXXXXX';
	$config['domaine'] = 'https://revedemontagne.com/';	
		function stripslashes_r($var) // Fonction qui supprime l'effet des magic quotes
	{
        if(is_array($var)) // Si la variable pass&eacute;e en argument est un array, on appelle la fonction stripslashes_r dessus
        {
                return array_map('stripslashes_r', $var);
        }
        else // Sinon, un simple stripslashes suffit
        {
                return stripslashes($var);
        }
	}
	  
	/*if(get_magic_quotes_gpc()) // Si les magic quotes sont activés, on les désactive avec notre super fonction ! <img src="../../bundles/tinymce/vendor/tiny_mce/plugins/emotions/img/clin.png" title=";)" alt=";)">
	{
	   $_GET = stripslashes_r($_GET);
	   $_POST = stripslashes_r($_POST);
	   $_COOKIE = stripslashes_r($_COOKIE);
	}*/
}
else
{
	//configuration des variables//
	$config['site_title'] = "R&#234;ve de Montagne";
	$sql_serveur = 'localhost';
	$sql_login = 'XXXXXXXXXXXXXXXX';
	$sql_pass = 'XXXXXXXXXXXXXXXX';
	$sql_bdd = 'XXXXXXXXXXXXXXXX';
	$config['domaine'] = 'https://revedemontagne.fr/';	
	function stripslashes_r($var) // Fonction qui supprime l'effet des magic quotes
	{
        if(is_array($var)) // Si la variable pass&eacute;e en argument est un array, on appelle la fonction stripslashes_r dessus
        {
                return array_map('stripslashes_r', $var);
        }
        else // Sinon, un simple stripslashes suffit
        {
                return stripslashes($var);
        }
	}
	  
	/*if(get_magic_quotes_gpc()) // Si les magic quotes sont activés, on les désactive avec notre super fonction ! <img src="../../bundles/tinymce/vendor/tiny_mce/plugins/emotions/img/clin.png" title=";)" alt=";)">
	{
	   $_GET = stripslashes_r($_GET);
	   $_POST = stripslashes_r($_POST);
	   $_COOKIE = stripslashes_r($_COOKIE);
	}*/
}
	


$orient_topo = array('','N','NE','E','SE','S','SW','W','NW','Toutes');
$diff_topo_monte = array('','R', 'F', 'PD-', 'PD', 'PD+', 'AD-', 'AD', 'AD+', 'D-', 'D', 'D+', 'TD-', 'TD', 'TD+');
$diff_topo_ski = array('','1.1', '1.2', '1.3', '2.1', '2.2', '2.3', '3.1', '3.2', '3.3', '4.1', '4.2', '4.3', '5.1', '5.2', '5.3', '5.4', '5.5', '5.6');
$expo = array('', '1', '2', '3', '4');
$nb_jours = array('', '0,5', '1', '2', '3', '4', '5', '6', '+6');
$js = array('','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$ms = array('','Janvier','F&eacute;vrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','D&eacute;cembre');
$ae = array('','2012','2013', '2014', '2015', '2016', '2017', '2018', '2019', '2020', '2021');
$act = array('','1','2');
?>
