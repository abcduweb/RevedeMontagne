<?php
function get_ip() {
        return (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
}

function is_ban($ip) {
	$find = ip2long($ip);
	$in = file_get_contents(ROOT.'caches/.htcache_ipban');
	$address = explode("\n",$in);
	$valToReturn = false;
	foreach($address as $key=>$value){
		if($value == $find){
			$valToReturn = true;
		}
	}
	return $valToReturn;

}

function get_ban(){
	$adresses = explode("\n", file_get_contents(ROOT.'caches/.htcache_ipban'));
	$nbr = count($adresses);
	if ($nbr != 0){
		$ip = array();
		foreach ($adresses as $key=>$value) {
		        if ($value != '')$ip[] = long2ip($value);
		}
	}
	else
	     $ip = false;
	return $ip;
}

function add_ban($ip){
	if (!empty($ip)) {
	  $ip = ip2long($ip);
	  if ($ip != false && $ip != -1) {
		   //Si l'ip est valide
		   if (!is_ban(long2ip($ip))) {
				$fichier = fopen(ROOT.'caches/.htcache_ipban', 'a');
				fwrite($fichier, $ip . "\n");
				fclose($fichier);
				return 'ok';
		   }
		   else
				return 'Cette adresse est d&eacute;jà bannie.';
	  }
	  else
		   return 'Ip n\'est pas valide';
	}
	else
	  return 'Ip vide';
}
function remove_ip($ip){
	$contenu_debut = file_get_contents(ROOT.'caches/.htcache_ipban');
	$contenu = str_replace(ip2long($ip)."\n",'', $contenu_debut);
	$fichier = fopen(ROOT.'caches/.htcache_ipban', 'w');
	fwrite($fichier, $contenu);
	fclose($fichier);
	echo $contenu_debut.'<br />'.$contenu;
	if($contenu_debut == $contenu)
		return false;
	else
        return true;
}
?>