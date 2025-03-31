<?php
$itin_type_array = array(1=>'Aller-Retour',2=>'Boucle',3=>'Traversée');
$ref_cotation_globale = array('F','PD-','PD','PD+','AD-','AD','AD+','D-','D','D+','TD-','TD','TD+','ED-','ED','ED+','ABO-','ABO');
$ref_qt_equip = array(1=>'Bien équipé',2=>'Partiellement équipé',3=>'Peu équipé',4=>'Pas équipé');

if(isset($_POST['orientation']) AND $_POST['orientation'] != 'null')
	$orientation = $_POST['orientation'];
else
	$orientation = '??';
if(!empty($_POST['alt_max']))
	$alt_max = intval($_POST['alt_max']);
else
	$alt_max = '??';
if(!empty($_POST['alt_min']))
	$alt_min = intval($_POST['alt_min']);
else
	$alt_min = '??';
if(!empty($_POST['deniv_pos']))
	$deniv_pos = intval($_POST['deniv_pos']);
else
	$deniv_pos = '??';
if(!empty($_POST['deniv_neg']))
	$deniv_neg = intval($_POST['deniv_neg']);
else
	$deniv_neg = '??';
if(isset($_POST['itin_type']) AND $_POST['itin_type'] != 'null' AND ($_POST['itin_type'] > 0 AND $_POST['itin_type'] < 4))
	$type_itineraire = $itin_type_array[intval($_POST['itin_type'])];
else
	$type_itineraire = '??';
if(isset($_POST['temps']) AND $_POST['temps'] != 'null' AND ($_POST['temps'] > 0 AND $_POST['temps'] < 12)){
	$temps = intval($_POST['temps']);
	if($temps > 1)
		$temps .= 'Jours';
	else
		$temps .= 'Journée';
}else
	$temps = '??';
if(isset($_POST['configurations'])){
	foreach($_POST['configurations'] as $var){
		if(!isset($configuration_topo))
			$configuration_topo = '<liste><puce>'.$var.'</puce>';
		else
			$configuration_topo .= '<puce>'.$var.'</puce>';
	}
}
if(!isset($configuration_topo))
	$configuration_topo = '??';
else
	$configuration_topo .= '</liste>';
	
$description_parser = $db->escape(zcode($_POST['intro']));
$description = htmlentities($_POST['intro'],ENT_QUOTES);
if(isset($_POST['conclu'])){
	$conclu_parser = $db->escape(zcode($_POST['conclu']));
	$conclu = htmlentities($_POST['conclu']);
}else{
	$conclu_parser = '';
	$conclu = '';
}

?>