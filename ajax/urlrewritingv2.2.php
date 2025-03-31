<?php
function rewriting()
{
        $fichier_conf = '.htrewriterules';
        $page_erreur = '404.php';
        $url = substr_replace($_SERVER['REQUEST_URI'],'',0,1);
        $open = fopen($fichier_conf,"r");
		while(!feof($open)){
			$rules = fgets($open,filesize($fichier_conf));
			$masque = explode('|',$rules);
			$url_finale = $masque[1];
			preg_match('`^'.$masque[0].'$`U',$url,$ereg);
			if(isset($ereg[0])){
					$i =0;
					$count = count($ereg);
					while($i <= $count -1){
						$url_finale = str_replace("$".$i,$ereg[$i],$url_finale);
						$i++;
					}
					$url_finale = str_replace(array("\n","\r"),'',$url_finale);
					$parse_url = parse_url($url_finale);
					if(isset($parse_url['query']))
					{
							$varget = $parse_url['query'];
							$varget = explode("&",$varget);
							foreach($varget as $varval)
							{
									$varval = explode("=",$varval);
									$_GET[$varval[0]] = $varval[1];
							}
					}
					header("HTTP/1.1 200 OK");
					header("Status: 200 OK");
					include($parse_url["path"]);
					exit;
			}
		}
        include($page_erreur);
}
rewriting();
?>