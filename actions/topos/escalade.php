<?php
include('topos/commun.php');
$cotation_libre_ref = array('II','III','III+','IV-','IV','IV+','5a','5b','5c','6a','6a+','6b',
'6b+','6c','6c+','7a','7a+','7b','7b+','7c','7c+','8a','8a+','8b','8b+','8c','8c+','9a','9a+','9b');
if(isset($_POST['cot_libre']) AND in_array($_POST['cot_libre'],$cotation_libre_ref)){
	$cotation_libre = $_POST['cot_libre'];
}else{
	$cotation_libre = '??';
}
if(isset($_POST['cot_glob']) AND in_array($_POST['cot_glob'],$ref_cotation_globale))
	$cotation_globale = $_POST['cot_glob'];
else
	$cotation_globale = '??';
if(isset($_POST['qt_equip']) AND $_POST['qt_equip'] != 'null' AND $_POST['qt_equip'] > 0 AND $_POST['qt_equip'] < 5)
	$qualite_equipement = $ref_qt_equip[intval($_POST['qt_equip'])];
else
	$qualite_equipement = '??';
$intro = parse_var(get_file(TPL_ROOT.'zCode_topo/escalade.tpl'),array('orientation'=>$orientation,
'alt-max'=>$alt_max,'alt-min'=>$alt_min,'den-max'=>$deniv_pos,'den-min'=>$deniv_neg,
'type-parcours'=>$type_itineraire,'tps-parcours'=>$temps,'cot-technique'=>$cotation_libre,
'cot-glob'=>$cotation_globale,'qt-equipement'=>$qualite_equipement,'config'=>$configuration_topo));
$intro_parser = $db->escape(zcode($intro));
$intro = htmlentities($intro,ENT_QUOTES);

$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
$db->requete($sql);
$id = $db->last_id();
$sql = "INSERT INTO articles_part VALUES('','$id',1,'Description','$description','$description_parser')";
$db->requete($sql);
?>