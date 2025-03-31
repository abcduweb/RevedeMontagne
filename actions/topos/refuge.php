<?php
include('topos/commun.php');
$ref_type = array('gardé', 'non gardé');
$ref_caf = array('oui', 'non');
$ref_hiver = array('oui', 'non');

//altitude du refuge
if(!empty($_POST['altitude']))
	$alt = intval($_POST['altitude']);
else
	$alt = '??';
//denniveles de montée
if(!empty($_POST['denniveles']))
	$denniveles = intval($_POST['denniveles']);
else
	$denniveles = '??';
//temps de montée
if(!empty($_POST['temps']))
	$temps = intval($_POST['temps']);
else
	$temps = '??';
//type de refuge (gardé ou non)
if(isset($_POST['type']) AND in_array($_POST['type'],$ref_type))
	$type = $_POST['type'];
else
	$type = '??';
//nombre de coiuchages
if(!empty($_POST['place']))
	$place = intval($_POST['place']);
else
	$place = '??';
//Est ce un refuge caf
if(isset($_POST['CAF']) AND in_array($_POST['CAF'],$ref_caf))
	$CAF = $_POST['CAF'];
else
	$CAF = '??';

//est il ouvert l'hiver

if(isset($_POST['hiver']) AND in_array($_POST['hiver'],$ref_caf))
	$hiver = $_POST['hiver'];
else
	$hiver = '??';	

$intro = parse_var(get_file(TPL_ROOT.'zCode_topo/refuge.tpl'),array('altitude'=>$altitude,
'type'=>$type,'place'=>$place,'caf'=>$CAF,'accès'=>$acces, 'denniveles'=>$denniveles, 'temps'=>$temps,
'hivers'=>$hiver));
$intro_parser = $db->escape(zcode($intro));
$intro = htmlentities($intro,ENT_QUOTES);

$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
$db->requete($sql);
$id = $db->last_id();
$sql = "INSERT INTO articles_part VALUES('','$id',1,'Description','$description','$description_parser')";
$db->requete($sql);
?>