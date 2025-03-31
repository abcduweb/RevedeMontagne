<?php
function miniaturisation($file,$cat)
{
	$valide = array("image/jpeg","image/x-png","image/png","image/gif");
	$ext = array("image/jpeg"=>"jpeg","image/x-png"=>"png","image/png"=>"png","image/gif"=>"gif");
	$image_source = $cat.'/'.$file;
	$size = @getimagesize($image_source);
	if(in_array($size['mime'],$valide))
	{
		if($size[0] > $size[1])
		{
			$x = 150;
			$y = 100;
		}
		elseif($size[0] < $size[1])
		{
			$x = 100;
			$y = 150;
		}
		else{
			$x = 150;
			$y = 150;
		}
		if($size[0] > $x OR $size[1] > $y){
			
			$facteurx = $x / $size[0];
			$facteury = $y / $size[1];
			if($facteurx <= $facteury)
				$facteury = $facteurx;
			else
				$facteurx = $facteury;
			$nlargeur = ceil($size[0] * $facteurx);
			$nhauteur = ceil($size[1] * $facteury);
		}
		if(isset($nlargeur) or isset($nhauteur)){
  		$final = imagecreatetruecolor($nlargeur,$nhauteur);
  		switch($ext[$size['mime']])
  		{
  			case 'jpeg':
  				$source = imagecreatefromjpeg($image_source);
  	            imagecopyresampled($final,$source, 0, 0, 0, 0, $nlargeur, $nhauteur, $size[0], $size[1]);
  				return imagejpeg($final,$cat.'/mini/'.$file.'');  
  			break;
  			case 'png':
  				$source = imagecreatefrompng($image_source);
  	            imagecopyresampled($final,$source, 0, 0, 0, 0, $nlargeur, $nhauteur, $size[0], $size[1]);
  				return imagepng($final,$cat.'/mini/'.$file.'');  
  			break;
  			case 'gif':
  				$source = imagecreatefromgif($image_source);
  	            imagecopyresampled($final,$source, 0, 0, 0, 0, $nlargeur, $nhauteur, $size[0], $size[1]);
  				return imagegif($final,$cat.'/mini/'.$file.'');  
  			break;
  		}
		}
		else{
     copy($image_source,$cat.'/mini/'.$file); 
    }
	}
	else
	{
		return false;
	}
}
?>
