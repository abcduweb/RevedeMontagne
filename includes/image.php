<?php
/*
 * Créer le 24 août 07 par NeoZer0
 *
 * Ceci est un morceau de code de http://www.lemontagnardesalpes.fr
 * Cette partie est: image de vérification
 */
#######A METTRE SUR CHAQUE PAGE##########
define('ROOT', '../'); 					#
define('TPL_ROOT', ROOT . 'templates/');#
define('INC_ROOT', ROOT . 'includes/'); #
session_start(); 						#
include (INC_ROOT . 'commun.php'); 		#
############FIN #########################
header('Content-type: image/png');
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');

function imagelinethick($image, $x1, $y1, $x2, $y2, $color, $thick = 1){
    if ($thick == 1) {
        return imageline($image, $x1, $y1, $x2, $y2, $color);
    }
    $t = $thick / 2 - 0.5;
    if ($x1 == $x2 || $y1 == $y2) {
        return imagefilledrectangle($image, round(min($x1, $x2) - $t), round(min($y1, $y2) - $t), round(max($x1, $x2) + $t), round(max($y1, $y2) + $t), $color);
    }
    $k = ($y2 - $y1) / ($x2 - $x1); //y = kx + q
    $a = $t / sqrt(1 + pow($k, 2));
    $points = array(
        round($x1 - (1+$k)*$a), round($y1 + (1-$k)*$a),
        round($x1 - (1-$k)*$a), round($y1 - (1+$k)*$a),
        round($x2 + (1+$k)*$a), round($y2 - (1-$k)*$a),
        round($x2 + (1-$k)*$a), round($y2 + (1+$k)*$a),
    );
    imagefilledpolygon($image, $points, 4, $color);
    return imagepolygon($image, $points, 4, $color);
}

$liste = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$code = '';
$longCode = 6;
while(strlen($code) != $longCode) {
        $code .= $liste[mt_rand(0,strlen($liste) - 1)];
}
$_SESSION['codeCaptcha'] = $code;

$textSize = 30;
$w = $textSize*strlen($code) + $textSize;
$h = 60;

$image = imagecreate($w,$h);

$color = array();
$color[] = imagecolorallocate($image,220,220,220);
$color[] = imagecolorallocate($image,0,0,0);
$color[] = imagecolorallocate($image,110,110,110);

$fontfile[0] = ROOT."polices/tintin_talking.ttf";
$fontfile[1] = ROOT."polices/EnigmaU_2.TTF";

for($i=0;$i<strlen($code);$i++){
    $colorIndex = mt_rand(1,2);
	$y = mt_rand(-10,10);
    if($i == 0)
        $phase = 0;
    else
        $phase = mt_rand(-10,20);
    ImageTTFText($image,$textSize,$phase,($i * $textSize) + 15,40 + $y,$color[$colorIndex],'../polices/lsansd.ttf',$code[$i]);
    $abs[]  = $i * $textSize + 15;
    $ord[] = 40 + mt_rand(-30,0);
}

/*for($i=0;$i<count($abs);$i++){
    if(isset($abs[$i+1]))
        imagelinethick($image,$abs[$i],$ord[$i],$abs[$i+1],$ord[$i+1],$color[1],5);
    else
        imagelinethick($image,$abs[$i],$ord[$i],$abs[$i] + $textSize,mt_rand(0,40),$color[1],5);
}*/
/*for($i=0;$i<2000;$i++){
    imagesetpixel  ($image, mt_rand(0,$w), mt_rand(0,$h), $color[0]);
}*/

$canvas = imagecreatetruecolor($w,$h);
$osc = mt_rand(1,2)*(round(mt_rand(0,1))?1:-1);
$max_distort=mt_rand(3,4);

for ($i = 0; $i < $w; $i++) {
    $distortion = $max_distort*sin(deg2rad(2*$i*$osc));
    imagecopyresized($canvas, $image, 0 + $i, 0 + $distortion, 0 + $i, 0, $w + $i, $h, $w + $i, $h);
}


for ($i = 0; $i < $h; $i++) {
    $distortion = 10*sin (deg2rad(2*$i*$osc));
    imagecopyresized($image, $canvas, 0 + $distortion, 0 + $i, 0, 0 + $i, $w, $h + $i, $w, $h + $i);
}

for($i=0;$i < 25;$i++){
	imageline($image,mt_rand(0,$w),mt_rand(0,$h),mt_rand(0,$w),mt_rand(0,$h),$color[mt_rand(1,2)]);
}

imagecolortransparent($image, $color[0]);
imagepng($image);
?>
