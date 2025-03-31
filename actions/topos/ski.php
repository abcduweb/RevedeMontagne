<?php
include('topos/commun.php');
$ref_cot_technique = array('1.1','1.2','1.3','2.1','2.2','2.3','3.1','3.2','3.3','4.1','4.2',
'4.3','5.1','5.2','5.3','5.4','5.5','5.6');
$ref_expo = array('E1','E2','E3','E4');
$ref_cot_ponct = array('S1','S2','S3','S4','S5','S6','S7');
$ref_compatible = array('ski','snowboard','raquettes','initiation');
if(isset($_POST['cot_technique']) AND $_POST['cot_technique'] < 19 AND $_POST['cot_technique'] > 0)
	$cot_technique = $ref_cot_technique[intval($_POST['cot_technique'])];
else
	$cot_technique = '??';

if(isset($_POST['expo']) AND in_array($_POST['expo'],$ref_expo))
	$cot_expo = $_POST['expo'];
else
	$cot_expo = '??';

if(isset($_POST['cot_ponct']) AND in_array($_POST['cot_ponct'],$ref_cot_ponct))
	$cot_ponct = $_POST['cot_ponct'];
else
	$cot_ponct = '??';
	
if(isset($_POST['glacier']))
	$glacier = '<attention>Ce topos se déroule sur un glacier et/ou il peut y avoir des crevasses</attention>';
else
	$glacier = '';	

if(isset($_POST['cot_glob']) AND in_array($_POST['cot_glob'],$ref_cotation_globale))
	$cotation_globale = $_POST['cot_glob'];
else
	$cotation_globale = '??';


if(isset($_POST['compatible'])){
	foreach($_POST['compatible'] as $var){
		if(!isset($compatible))
			$compatible = '<liste><puce>'.$ref_compatible[$var].'</puce>';
		else
			$compatible .= '<puce>'.$ref_compatible[$var].'</puce>';
	}
}
if(!isset($compatible))
	$compatible = '??';
else
	$compatible .= '</liste>';

	
/*$compatible = '<liste>';
if(isset($_POST['compatible'])){
	foreach($_POST['compatible'] as $var){
		if(in_array($var,$ref_compatible)){
			if(!isset($compatible))
				$compatible = '<puce>'.$ref_compatible[$var].'</puce>';
			else
				$compatible = '<puce>'.$ref_compatible[$var].'</puce>';
		}
	}
}
if(isset($compatible))
$compatible .='</liste>';*/

$intro = parse_var(get_file(TPL_ROOT.'zCode_topo/ski.tpl'),array('orientation'=>$orientation,
'alt-max'=>$alt_max,'alt-min'=>$alt_min,'den-max'=>$deniv_pos,'den-min'=>$deniv_neg,
'type-parcours'=>$type_itineraire,'tps-parcours'=>$temps,'cot-technique'=>$cot_technique,
'cot-ponct'=>$cot_ponct,'cot-glob'=>$cotation_globale,'compatible'=>$compatible,
'config'=>$configuration_topo,'glacier'=>$glacier));
$intro_parser = $db->escape(zcode($intro));
$intro = htmlentities($intro,ENT_QUOTES);

$sql = "INSERT INTO articles_intro_conclu VALUES('','0','3','$_SESSION[mid]','$titre',UNIX_TIMESTAMP(),'$intro','$intro_parser','$conclu','$conclu_parser')";
$db->requete($sql);
$id = $db->last_id();
$sql = "INSERT INTO articles_part VALUES('','$id',1,'Description','$description','$description_parser')";
$db->requete($sql);
?>