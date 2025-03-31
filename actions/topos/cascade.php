<?php
include('topos/commun.php');
$ref_cot_glace = array('1','2','3','3+','4','4+','5','5+','6','6+','7','7+');
$ref_cotation_mixte = array('M1','M2','M3','M3+','M4','M4+','M5','M5+','M6','M6+','M7','M7+','M8','M8+','M9','M9+','M10','M10+','M11','M11+','M12','M12+');
if(isset($_POST['cot_glace']) AND in_array($_POST['cot_glace'],$ref_cot_glace))
	$cotation_glace = $_POST['cot_glace'];
else
	$cotation_glace = '??';
	
if(isset($_POST['cot_mixte']) AND in_array($_POST['cot_mixte'],$ref_cotation_mixte))
	$cotation_mixte = $_POST['cot_mixte'];
else
	$cotation_mixte = '??';

if(isset($_POST['cot_glob']) AND in_array($_POST['cot_glob'],$ref_cotation_globale))
	$cotation_globale = $_POST['cot_glob'];
else
	$cotation_globale = '??';
	
if(isset($_POST['qt_equip']) AND $_POST['qt_equip'] != 'null' AND $_POST['qt_equip'] > 0 AND $_POST['qt_equip'] < 5)
	$qualite_equipement = $ref_qt_equip[intval($_POST['qt_equip'])];
else
	$qualite_equipement = '??';

$intro = parse_var(get_file(TPL_ROOT.'zCode_topo/cascade.tpl'),array('orientation'=>$orientation,
'alt-max'=>$alt_max,'alt-min'=>$alt_min,'den-max'=>$deniv_pos,'den-min'=>$deniv_neg,
'type-parcours'=>$type_itineraire,'tps-parcours'=>$temps,'cot-glace'=>$cotation_glace,'cot-mixte'=>$cotation_mixte,
'cot-glob'=>$cotation_globale,'qt-equipement'=>$qualite_equipement,
'config'=>$configuration_topo));
$intro_parser = $db->escape(zcode($intro));
$intro = htmlentities($intro,ENT_QUOTES);

$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
$db->requete($sql);
$id = $db->last_id();
$sql = "INSERT INTO articles_part VALUES('','$id',1,'Description','$description','$description_parser')";
$db->requete($sql);
?>