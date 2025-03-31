<?php
function get_file($file)
{
	if(file_exists($file))
	{
		$info = pathinfo($file);
		$info['filename'] = str_replace('.'.$info['extension'],'',$info['basename']);
		//if($_SESSION['mid'] != 2 AND file_exists($info['dirname'].'/'.$info['filename'].'_log.'.$info['extension'])) $file = $info['dirname'].'/'.$info['filename'].'_log.'.$info['extension'];
		
		$open = fopen($file,'r');
		$data = fread($open,filesize($file));
		fclose($open);
		if(preg_match_all('`<include file="(.+)" \/>`',$data,$matches)){
			foreach($matches[1] as $file)
			{
				$data = str_replace('<include file="'.$file.'" />',get_file($info['dirname'].'/'.$file),$data);
			}
		}
		if(preg_match_all('`<include form="(.+)" prev="(.+)" sign="(0|1)" url="(.+)" \/>`',$data,$matches)){
			foreach($matches[1] as $key=>$file){
				$form = parse_var(get_file($info['dirname'].'/'.$matches[1][$key]),array('prev'=>$matches[2][$key],'url'=>$matches[4][$key]));
				if($matches[3][$key] == 1)$form = parse_boucle('SIGNACT',$form,false,array('url'=>$matches[4][$key]));
				$form = parse_boucle('SIGNACT',$form,TRUE);
				$data = str_replace('<include form="'.$matches[1][$key].'" prev="'.$matches[2][$key].'" sign="'.$matches[3][$key].'" url="'.$matches[4][$key].'" />',$form,$data);
			}
		}
		return $data;
	}
	else
	{
		exit("Erreur le fichier $file n'existe pas");
	}
}

function parse_var($data,$vars)
{
	foreach($vars as $key => $var)
	{
		$variables[] = '{'.$key.'}';
		$valeurs[] = $var;
	}
	$data = str_replace($variables,$valeurs,$data);
	return $data;
}

function parse_boucle($boucle,$data,$clear=true,$vars=false,$imbrication=false)
{
	global $boucle_cache;
	if(!isset($boucle_cache[$boucle])){
		preg_match("`<---$boucle--->(.+)<\/---$boucle--->`sU",$data,$matches);
		$boucle_cache[$boucle] = $matches;
	}
	$matches = $boucle_cache[$boucle];
	if(!$clear)
	{
		$data = parse_var($data,$vars);
		$data = str_replace("<---$boucle--->","",$data);
		if(!$imbrication)$data = str_replace("</---$boucle--->","<---$boucle--->".$matches[1]."</---$boucle--->",$data);
	}
	else
	{
		$data = str_replace("<---$boucle--->".$matches[1]."</---$boucle--->",'',$data);
		$data = str_replace("</---$boucle--->",'',$data);
	}
	return $data;
}
function imbrication($boucle,$data)
{
	global $boucle_cache;
	$data = str_replace("</---$boucle--->","<---$boucle--->".$boucle_cache[$boucle][1]."</---$boucle--->",$data);
	return $data;
}
?>