<?php
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
require_once(ROOT.'fonctions/beta.fonction.php');
?>




<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Développez avec les API Google Maps</title>
<style type="text/css">
 html {
  height: 100%;
 }
 body {
  height: 100%;
  margin: 0px;
  padding: 0px;
 }
 #map_canvas {
  height: 100%;
 }
</style>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">

function createXmlHttpRequest() {
	try {
		if (typeof ActiveXObject != 'undefined') {
			return new ActiveXObject('Microsoft.XMLHTTP');
		} else if (window["XMLHttpRequest"]) {
			return new XMLHttpRequest();
		}
	} catch (e) {
		changeStatus(e);
	}
	return null;
};

function downloadUrl(url, callback) {
	var status = -1;
	var request = createXmlHttpRequest();
	if (!request) {
		return false;
	}

	request.onreadystatechange = function() {
		if (request.readyState == 4) {
			try {
				status = request.status;
			} catch (e) {
			}
			if (status == 200) {
				callback(request.responseText, request.status);
				request.onreadystatechange = function() {};
			}
		}
	}
	request.open('GET', url, true);
	try {
		request.send(null);
	} catch (e) {
		changeStatus(e);
	}
};

function xmlParse(str) {
  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
    var doc = new ActiveXObject('Microsoft.XMLDOM');
    doc.loadXML(str);
    return doc;
  }

  if (typeof DOMParser != 'undefined') { 
    return (new DOMParser()).parseFromString(str, 'text/xml');
  }

  return createElement('div', null);
}

 var map;

 function initialize() {
  var latlng = new google.maps.LatLng(46.7, 2.5);
  var myOptions = {
   zoom: 6,
   center: latlng,
   mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
 
 downloadUrl("http://127.0.0.1/rdm/cartes/get_pointrefuge.php", function(data) { 

   var xml = xmlParse(data);
   var markers = xml.documentElement.getElementsByTagName("marker");
   
   for (var i = 0; i < markers.length; i++) {
    createMarker(parseFloat(markers[i].getAttribute("lat")), parseFloat(markers[i].getAttribute("lng")), markers[i].getAttribute('titre'), markers[i].getAttribute('description'), markers[i].getAttribute('icone'));
   }
  });

 }

 function createMarker(lat, lng, titre, description, icone){
  var latlng = new google.maps.LatLng(lat, lng);
  var icontest = icone;
  var marker = new google.maps.Marker({
   position: latlng,
   map: map,
   title: titre,
   icon: icontest
  });

  var infobulle = new google.maps.InfoWindow({
   content: description
  });

  google.maps.event.addListener(marker, 'click', function(){
   infobulle.open(map, marker);
  });

 }

</script>
</head>
<body onload="initialize()">
 <div id="map_canvas" style="width: 100%; height: 100%;"></div>

</body>
</html>
