<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', './');                         #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
header("Content-type: text/xml");
$data = get_file(TPL_ROOT.'flux_rss.tpl');
$sql = "SELECT * FROM nm_news WHERE status_news = '1' ORDER BY date_news DESC LIMIT 0,10";
$db->requete($sql);
while($row = $db->fetch_assoc()){
	$data = parse_boucle('NEWS',$data,false,array('date'=>date("d/m/Y H:i",$row['date_news']),'titre_news'=>utf8_encode(str_replace(array('<','>'),array('&lt;','&gt;'),html_entity_decode($row['titre'],ENT_NOQUOTES))),'texte'=>htmlspecialchars(utf8_encode(stripslashes($row['texte_parser']))),'id_news'=>$row['id_news'],'titre_url'=>title2url($row['titre']),'newser'=>$row['pseudo_auteur']));
}
$data = parse_boucle('NEWS',$data,true);
echo $data;
$db->deconnection();
?>