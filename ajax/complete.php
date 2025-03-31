<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  #
define('ROOT', '../');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
/*
#######A METTRE SUR CHAQUE PAGE#######
define('ROOT','../');			     #
define('INC_ROOT',ROOT.'includes/'); #
session_start();					 #
include(INC_ROOT.'config.php');		 #
include(INC_ROOT.'db.class.php');	 #
$db = new mysql($sql_serveur,$sql_login,$sql_pass,$sql_bdd,1,'Erreur sur la base de donnée');
include(ROOT.'fonctions/session.fonction.php');	 #
############FIN ######################
*/

$pseudo = htmlentities($_POST['recherche']);
$sql = "SELECT pseudo FROM membres WHERE pseudo LIKE '$pseudo%'";
$result = $db->requete($sql);
while($row = $db->fetch($result)){
	$p[] = $row['pseudo'];
}
$open = fopen('test_comp.txt','w');
$q = $_POST['recherche']; $i = 0;
if ($pseudo != "") {
  echo '<ul>';
  foreach($p as $prn) {
      echo '<li><a href="#" onclick="return false">'.htmlentities($prn).'</a></li>';
      if (++$i >= 10) die('<li>...</li></ul>');
  }
  echo '</ul>';
}
?>