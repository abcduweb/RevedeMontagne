<?php
include('topos/commun.php');
$ref_cotation_rando = array('T1','T2','T3','T4','T5','T6');
if(isset($_POST['cot_rando']) AND in_array($_POST['cot_rando'],$ref_cotation_rando)){
	$cotation_rando = $_POST['cot_rando'];
}
else
	$cotation_rando = '??';

$intro = parse_var(get_file(TPL_ROOT.'zCode_topo/escalade.tpl'),array('orientation'=>$orientation,
'alt-max'=>$alt_max,'alt-min'=>$alt_min,'den-max'=>$deniv_pos,'den-min'=>$deniv_neg,
'type-parcours'=>$type_itineraire,'tps-parcours'=>$temps,'cotation'=>$cotation_rando,
'qt-equipement'=>$qualite_equipement,'config'=>$configuration_topo));
$intro_parser = $db->escape(zcode($intro));
$intro = htmlentities($intro,ENT_QUOTES);

$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
$db->requete($sql);
$id = $db->last_id();
$sql = "INSERT INTO articles_part VALUES('','$id',1,'Description','$description','$description_parser')";
$db->requete($sql);
?>