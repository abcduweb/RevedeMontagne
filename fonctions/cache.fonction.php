<?php
function write_cache($file,$vars)
{
	if(is_array($vars))
	{
		$cache = '<?php ';
		$open = fopen($file,'w');
		foreach($vars as $key => $var)
		{
			$cache .= '$'.$key.' = '.var_export($var,TRUE).';';
		}
		$cache .= '?>';
		fwrite($open,$cache);
		fclose($open);
	}
}
function is_cache($file,$time_life=120)
{
	if(!file_exists($file) OR time() > (filemtime($file) + $time_life))
		return FALSE;
	else
		return TRUE;
}

function purge($path,$match){
	if(is_dir($path)){
		if(function_exists("fnmatch")){
			$open = opendir($path);
			while(($file = readdir($open)) != false){
				if(fnmatch($match,$file))unlink($path.$file);
			}
			closedir($open);
		}else{
			if(function_exists("glob")){
				$files = glob($path.$match);
				foreach($files as $file) {
					if(is_file($file))unlink($file);
				}
			}
		}
	}
}

header("Cache-Control: no-cache, must-revalidate"); 
header("Pragma: no-cache");
?>