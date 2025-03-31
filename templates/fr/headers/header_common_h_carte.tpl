<style type="text/css">
 html {
  height: 100%;
 }
 body {
  height: 100%;
 }
 #map_canvas {
  height: 800px;
  width:95%;
  margin:auto;
  margin-bottom:5%;
  
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
   mapTypeId: google.maps.MapTypeId.SATELLITE
  };
  map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
 
 downloadUrl("{DOMAINE}/cartes/get_pointrefuge.php", function(data) { 

   var xml = xmlParse(data);
   var markers = xml.documentElement.getElementsByTagName("marker");
   
   for (var i = 0; i < markers.length; i++) {
    createMarker(markers[i].getAttribute('uri'), markers[i].getAttribute('id_refuge'), parseFloat(markers[i].getAttribute("lat")), parseFloat(markers[i].getAttribute("lng")), markers[i].getAttribute('titre'), markers[i].getAttribute('description'), markers[i].getAttribute('icone'));
   }
  });

 }

 function createMarker(uri, id_refuge, lat, lng, titre, description, icone){
  var latlng = new google.maps.LatLng(lat, lng);
  var icontest = icone;
  var marker = new google.maps.Marker({
   position: latlng,
   map: map,
   title: titre,
   icon: icontest
  });

  var infobulle = new google.maps.InfoWindow({
   content: description+'<br /> <a href="detail-'+uri+'-'+id_refuge+'.html">Voir la fiche détaillée</a>' 
  });

  google.maps.event.addListener(marker, 'click', function(){
   infobulle.open(map, marker);
  });

 }

</script>