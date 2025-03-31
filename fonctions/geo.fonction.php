<?php

function addRefuge($id,$part,$titre, $text){
	global $db;
	$garde = 1;
	$lat = 0;
	$lon = 0;
	$alt = 0;
	preg_match('`([0-9]+)m`iU',$titre,$matches_alt);
	if($matches_alt[1])$alt = $matches_alt[1];
	preg_match('`(\(non gard&eacute;\))`iU',$titre,$matches_garde);
	if($matches_garde[1])$garde = 0;
	preg_match('`Lat: ([0-9]+\.[0-9]+), Lon: ([0-9]+\.[0-9]+)`i',$text,$matches_latlon);
	if($matches_latlon[1])$lat = $matches_latlon[1];
	if($matches_latlon[2])$lon = $matches_latlon[2];
	$sql = "INSERT INTO refuges VALUES('','$id','$part','$titre','$lat','$lon','$alt','$garde')";
	$db->requete($sql);
}

function addStyle($name,$icon){
	return '<Style id="'.$name.'">
		<IconStyle>
			<Icon>
				<href>'.$icon.'</href>
			</Icon>
		</IconStyle>
	</Style>'."\n";
}

function addPlacemark($name,$description,$lat,$lon,$alt,$style,$id){
	return '<Placemark id="'.$id.'">
				<name>'.$name.'</name>
				<styleUrl>#'.$style.'</styleUrl>
				<description><![CDATA['.$description.']]></description>
				<Point>
					<coordinates>'.$lon.','.$lat.','.$alt.'</coordinates>
				</Point>
			</Placemark>'."\n";
}

function getMapHeader($name){
	return '<?xml version="1.0" encoding="UTF-8"?>
	<kml xmlns="http://earth.google.com/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">
	<Document>
	<name>'.$name.'</name>
	<atom:author>      
      <atom:name>Adrien et NeoZer0</atom:name>
    </atom:author>    
    <atom:link href="http://www.revedemontagne.com" />';
}

function getRefugesMap($options = false){
	global $db;
	if($options and !is_array($options))exit("Map options must be an array");
	$sql = "SELECT id_article,id_refuge, titre,latitude,longitude,garde,altitude FROM refuges";
	if($options and count($options) > 0){
		$sql .= ' WHERE';
		$oneset = false;
		foreach($options as $option => $value){
			switch($option){
				case 'garde':
					if($value != 'all'){
						if($oneset)
							$sql .= ' AND garde = '.$value;
						else{
							$sql .= ' garde = '.$value;
							$oneset = true;
						}
					}
				break;
				case 'altInf':
					if($value != 'all'){
						if($oneset)
							$sql .= ' AND alt >= '.$value;
						else{
							$sql .= ' alt >= '.$value;
							$oneset = true;
						}
					}
				break;
				case 'altSup':
					if($value != 'all'){
						if($oneset)
							$sql .= ' AND alt <= '.$value;
						else{
							$sql .= 'alt <= '.$value;
							$oneset = true;
						}
					}
				break;
			}
		}
	}
	$db->requete($sql);
	$map = getMapHeader(utf8_encode('Carte des refuges de France sur Reve de Montagne'));
	$map .= addStyle('refugeGarde',DOMAINE.'/templates/images/'.DESIGN.'/cartes/refugeGarde.png');
	$map .= addStyle('refugeNonGarde',DOMAINE.'/templates/images/'.DESIGN.'/cartes/refugeNonGarde.png');
	$map .= "<Folder>";
	$id = 1;
	while($row = $db->fetch_assoc()){
		if($row['garde'] == 1)
			$style = 'refugeGarde';
		else
			$style = 'refugeNonGarde';
		$map .= addPlacemark(utf8_encode(html_entity_decode($row['titre'])),'<a href="'.DOMAINE.'/article-'.title2url($row['titre']).'-a'.$row['id_article'].'-p'.$row['id_refuge'].'.html">Plus d\'info sur '.$row['titre'].'</a>',$row['latitude'],$row['longitude'],$row['altitude'],$style,$id);
		$id++;
	}
	return $map."</Folder>
</Document>\n
				</kml>\n";
}
?>
