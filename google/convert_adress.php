<?php
$data = array(
  'street'     => '5 rue belle image',
  'postalcode' => '26000',
  'city'       => 'Valence',
  'country'    => 'france',
  'format'     => 'json',
);
$url = 'https://nominatim.openstreetmap.org/?' . http_build_query($data);
echo $url;
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mettre ici un user-agent adéquat');
$geopos = curl_exec($ch);
curl_close($ch);

$json_data = json_decode($geopos, true);
var_dump($json_data);
?>