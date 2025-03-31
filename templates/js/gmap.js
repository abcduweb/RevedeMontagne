var map;
var departements;
function loadMap(obj) {
	if (GBrowserIsCompatible()) {
		node = obj.parentNode;
		node.removeChild(obj);
		url = node.id.replace('&amp;','&');
		map = new GMap2(document.getElementById(node.id));
		map.addMapType(G_PHYSICAL_MAP);
		map.addControl(new GLargeMapControl());
		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());
		//map.setMapType(G_PHYSICAL_MAP);
		GEvent.addListener(map, "mousemove", function( pointgps ){
				document.getElementById('gps_lat').value = Math.round( pointgps.lat() * 10000 ) / 10000 ;
				document.getElementById('gps_lng').value = Math.round( pointgps.lng() * 10000 ) / 10000 ;
		});
		geoXml = new GGeoXml(url,function(){
			if(geoXml.getDefaultCenter() != null){
				map.setCenter(geoXml.getDefaultCenter(), 11,G_PHYSICAL_MAP );
			}else{
				map.setCenter(new GLatLng(41.875696,-87.624207), 11,G_PHYSICAL_MAP );
			}
			map.addOverlay(geoXml);
			geoXml.gotoDefaultViewport(map);
		});
	}
}

function toggledepartement(obj){
	if(obj.checked == true){
		departements = new GGeoXml("http://www.revedemontagne.com/cartes/departements/73.kml",function(){
			map.addOverlay(departements);
		});
	}else{
		map.removeOverlay(departements);
	}
}