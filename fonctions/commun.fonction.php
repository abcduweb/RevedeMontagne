<?php
function get_list_page($page, $nb_page, $nb = 4)
{
	$list_page = array();
	for ($i=1;$i <= $nb_page;$i++)
	{
		if (($i < $nb) OR ($i > $nb_page - $nb) OR (($i < $page + $nb) AND ($i > $page -$nb)))
		$list_page[] = $i;
		else
		{
			if ($i >= $nb AND $i <= $page - $nb)
			$i = $page - $nb;
			elseif ($i >= $page + $nb AND $i <= $nb_page - $nb)
			$i = $nb_page - $nb;
		$list_page[] = '...';
		}
	}
	return $list_page;
}

function get_date($date,$motif,$lang='fr')
{
	setlocale(LC_TIME, 'french');
	if($date != null){
	  $dateCompare = time();
	  $toDayCompare = date('d-m-Y',$dateCompare);
    $yesteDayCompare =  date('d-m-Y',$dateCompare - (24*3600));
	  if($toDayCompare == date('d-m-Y', $date )){
      return "Ajourd'hui &agrave; ".date("H\hi",$date);
    }
    elseif($yesteDayCompare == date('d-m-Y', $date )){
      return "Hier &agrave; ".date("H\hi",$date);
    }
    else
		  return date($motif, $date );
	}
	else
		return 'Le : -';
}

function title2url($titre)
{
	$titre = strtolower($titre);
	$tofind =array("&#039;","&agrave;","&aacute;","&acirc;","&atilde;","&auml;","&aring;","&ograve;",
	"&oacute;","&ocirc;","&otilde;","&ouml;","&oslash;","&egrave;","&eacute;","&ecirc;","&euml;","&Ccedil;","&ccedil;",
	"&igrave;","&iacute;","&icirc;","&iuml;","&ugrave;","&uacute;","&ucirc;","&uuml;",
	"&yuml;","&ntilde;"," ",".","&deg;");
	$replac = array("","a","a","a","a","a","a","o","o","o","o","o","o","e","e","e","e","c","i","i","i","i","u","u","u","u","y","n","","-","","");
	$titre = str_replace($tofind,$replac,$titre);
	$titre = strtr($titre, 'àáâäéèêëíìîïóòôöúùûüýÿç', 'aaaaeeeeiiiioooouuuuyyc');
	$titre = str_replace(array('!','?',' ','\\','°','+','`','<','>','_','=','}','{','#','@','.','(',')','[',']',';',',',':','/','§','%','*','^','¨','$','£','¤','\'','"','~','|','&'), '-', $titre);
	$titre = str_replace('--', '-', $titre);
	$titre = str_replace('--', '-', $titre);
	$titre = trim ($titre,'-');
	return $titre;
}

function display_notice($message,$type,$redirection){
	$data = get_file(TPL_ROOT . 'system_ei.tpl');
	$data = parse_var($data, array (
		'message' => $message,
		'DESIGN' => $_SESSION['design'],
		'type' => $type,
		'DOMAINE' => DOMAINE,
		'redirection' => $redirection
	));
	return $data;
}

function display_confirm($message,$url){
	$data = get_file(TPL_ROOT . 'system_confirm.tpl');
	$data = parse_var($data, array (
		'message' => $message,
		'DESIGN' => $_SESSION['design'],
		'DOMAINE' => DOMAINE,
		'url' => $url
	));
	return $data;
}

function ajout_depart($message,$type,$redirection, $close){
	$data = get_file(TPL_ROOT . 'ajout_depart.tpl');
	$data = parse_var($data, array (
		'message' => $message,
		'DESIGN' => $_SESSION['design'],
		'type' => $type,
		'DOMAINE' => DOMAINE,
		'close' => $close,
		'redirection' => $redirection
	));
	return $data;
}

?>