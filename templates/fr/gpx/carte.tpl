<include file="../headers/header_common_head.tpl" />

<include file="../headers/header_common_body.tpl" />


	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/google-maps-gpx-viewer/editor.css" type="text/css" />
	<link rel="stylesheet" href="{DOMAINE}/templates/css/{design}/google-maps-gpx-viewer/gmap_v3.css" type="text/css" />

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">google.load("maps", "3", {other_params:"sensor=false&libraries=places,panoramio"});</script>
	
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_size.js"></script>
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_gpx_overlay.js"></script>
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_wms_overlay.js"></script>
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_init.js"></script>
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_edit.js"></script>
	
	<script type="text/javascript" id="script">google.load('visualization', '1', {packages: ['corechart']});</script>
	<script type="text/javascript" src="{DOMAINE}/templates/js/google-maps-gpx-viewer/gmap_v3_elevation.js"></script>

	<script type="text/javascript">  
		// map load action
		function OnLoadGpxPoiDb(map){
			map.g_seCookie = false; // no cookie		
			map.g_showCnt++;
			jQuery.ajax({
			type: "GET",
			url:  "http://adriendubois.fr/wp-admin/admin-ajax.php?action=gmap_poi_action&post_id=111&get_pois=true",
			success: function(msg){
				// alert (msg);
				jQuery('.loader').remove();
				var obj = jQuery.parseJSON(msg);
				var out = "0 POIs";
				var bbox = new google.maps.LatLngBounds();
				if (obj.length){
					out = obj.length + " POIs";
					jQuery(obj).each( function(){
						var m = insertPoiMap(map, this)
						map.markers.push(m);
						bbox.extend(m.position);
					});
				}
				jQuery('#result').html(out).fadeIn('slow');
				fitViewport(map, bbox);
				updateMarkerUI(map, null);
				},
				complete:function (jqXHR, textStatus){
					/* enable for error check in loading gpx
					if(textStatus != "success")
						alert('Error: ' + jqXHR.responseText + ' + ' + textStatus);	*/ 			
				}
			});    
			google.maps.event.addListener(map, 'click', function(e) { 
				jQuery('#gmap_poi_action_map').attr('value', map.getDiv().id);
				jQuery('#result').html("");
				updateMarkerUI(map, null);
				if(map.gmap_poi_db && 1) {
					jQuery('#result').html('<img src="{DOMAINE}/templates/js/google-maps-gpx-viewer/loading.gif" class="loader" width="25" height="25" />').fadeIn();
					var geocoder = new google.maps.Geocoder();
					var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
					geocoder.geocode({'latLng': latlng}, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							if (results[0]) {
								var places_postal = results[0].address_components;
								var addr = new Object();
								if(places_postal){
									for (var i = 0; i < places_postal.length; i++ ) {
										addr[places_postal[i].types[0]] = places_postal[i].long_name;
									}					
								}
								// if(addr.country){
									// jQuery('#item_name').attr('value', addr.country);
								if(addr.locality)
									jQuery('#item_name').attr('value', addr.locality);
								// postal address	
								var mail_address = "";
								if(addr.route)
									mail_address += addr.route;
								if(addr.street_number)
									mail_address += ' ' + addr.street_number;
								jQuery('#street').attr('value' ,mail_address);							
								mail_address = "";
								if(addr.postal_code)
									mail_address += addr.postal_code + ' ';
								if(addr.locality)
									mail_address += addr.locality;
								jQuery('#city').attr('value', mail_address);
												
								
								jQuery('#gpx_poi-widget').addClass('red_border'); 

							} else {
								// alert('No results found');
							}
						} else {
							//alert('Geocoder failed due to: ' + status);
						}
						jQuery('.loader').remove();
					});
		
					jQuery('#poi_click').attr('value', 1); // ?
					
					jQuery('#lat').attr('value',latlng.lat());
					jQuery('#lng').attr('value',latlng.lng());
					click_marker = new google.maps.Marker({
						map: map,
						position: latlng
					});
				}			
			});  
		}
		var click_marker = null;
		
		//	insert from OnLoad Insert and Update
		function insertPoiMap(map, ele){
			if(map.akt_marker)
				map.akt_marker.infowindow.close();
			var item_type = '';
			jQuery('#item_type > option').each( function(){
				if(this.value == ele.item_type){
					item_type = this.value; // 
				}
			}); 
			var description = '';
			if(ele.item_url == "http://" || ele.item_url == "")
				description = '<strong>' + ele.item_name + '</strong>';
			else
				description = '<a href="' + ele.item_url + '" target="_blank"><strong>' + ele.item_name + '</strong> </a>';
			if(ele.city != "" && ele.street != ""){
				description += '<br>Address ' + ele.city + ', ' + ele.street;
				description += '<br>';
			}
			if(ele.contact != "")
				description += '<br>' + ele.contact;
			if(ele.description != "")
				description += '<br>' + ele.description;
			var pos = new google.maps.LatLng(ele.lat, ele.lng);
			
			var marker = new google.maps.Marker({
				icon: new google.maps.MarkerImage('{DOMAINE}templates/images/1/google-maps-gpx-viewer/gmapIcons/'+ele.item_type+'.png',
					new google.maps.Size(32, 32),
					new google.maps.Point(0, 0),
					new google.maps.Point(12,25),
					new google.maps.Size(24, 24)
				),
				map: map,
				draggable: true,			id:map.markers.length,
				position: pos,
				startpos: pos,
				db_id: ele.id,
				title: ele.item_name,
				home:ele.item_url,
				busi:ele.item_type,
				city:ele.city,
				street:ele.street,
				contact:ele.contact,
				descr:ele.description,
				content: description
			});
			marker.infowindow = new google.maps.InfoWindow({
				content: description
			});
			marker.infowindow.event = google.maps.event.addListener(marker.infowindow, 'closeclick', function() {
				updateMarkerUI(map, null);
			});		
			marker.event = google.maps.event.addListener(marker, 'click', function() {
				jQuery('#result').html("");
				updateMarkerUI(map, this);
				map.akt_marker = marker;
				marker.infowindow.open(map ,marker);
			});  
			if(map.gmap_poi_db) marker.event = google.maps.event.addListener(marker, 'dragend', function() {
				updateMarkerUI(map, this);
			});  
			return marker;
		}

		// update marker info 
		function updateMarkerUI(map, marker){
			jQuery('#gmap_poi_action_map').attr('value', map.getDiv().id);
			if(map.akt_marker)
				map.akt_marker.infowindow.close();
			if(click_marker){
				click_marker.setMap(null);
				click_marker = null;
			}
			stopBouncer(map);
			jQuery('#poi_click').attr('value', 0); 
			// fill form with marker values on click
			if(marker){
				jQuery('#gpx_poi-widget').addClass('red_border');
			
				jQuery('#delbutton').css('visibility','visible');
				jQuery('#lat').attr('value',marker.startpos.lat());
				jQuery('#lng').attr('value',marker.startpos.lng());
				jQuery('#item_name').attr('value',marker.title);
				jQuery('#item_url').attr('value',marker.home);
				jQuery('#city').attr('value',marker.city);
				jQuery('#street').attr('value',marker.street);
				jQuery('#contact').attr('value',marker.contact);
				jQuery('#description').attr('value',marker.descr);
				var m = marker.busi;
				jQuery('#item_type > option').each( function(){
					if(this.value == m)
						this.selected = true; // establishment select
				}); 			
				jQuery('#poi_db_id').attr('value',marker.db_id);
				marker.setAnimation(google.maps.Animation.BOUNCE);
			} else { // empty poi
				jQuery('#gpx_poi-widget').removeClass('red_border');
			
				jQuery('#delbutton').css('visibility','hidden');
				jQuery('#poi_db_id').attr('value','');
				jQuery('#lat').attr('value','');
				jQuery('#lng').attr('value','');
				jQuery('#item_name').attr('value','Place name');
				jQuery('#item_url').attr('value','http://');
				jQuery('#city').attr('value','Zip & City');
				jQuery('#street').attr('value','Street & No.');
				jQuery('#contact').attr('value','Contact person, phone');
				jQuery('#description').attr('value','Description');
			}
		}
		
		// stop all bouncing selected icon
		function stopBouncer(map){
			for(var i = 0; i < map.markers.length ; i++){
				map.markers[i].setAnimation(null);
			}
		}
	</script>
	


	<div class="gm_gpx_body" id="holder_map_0" style="width: auto; height:400px; margin:20px 0px 20px 0px;">
	<div class="google_map_holder" id="map_0" style="width: auto; height:400px; border: 1px solid black;"></div></div>
	<script type="text/javascript">
	
		var fszIndex = 1;
		var distanceUnit = "meter";
		var gmapv3_disableDefaultUI = false;
		var gmapv3_zoomControl = false;

		
		var scrollToEle = "html";
		var mapSizeButton = true;
		var mapobj = { 
			name: "OSM",
			wms: "osm",
			minzoom: 18,
			maxzoom: 0,
			url: "http://tile.openstreetmap.org/",
			copy:"<a href=\"http://www.openstreetmap.org\" target=\"_blank\">Open Street Map</a>",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "OSM Cycle",
			wms: "osm",
			minzoom: 18,
			maxzoom: 0,
			url: "http://b.tile.opencyclemap.org/cycle/",
			copy:"<a href=\"http://creativecommons.org/licenses/by-sa/2.0/\">Cycle OSM</a>",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "Relief",
			wms: "",
			minzoom: 18,
			maxzoom: 0,
			url: "",
			copy:"<a href=\"http://www.maps-for-free.com/html/about.html\" target=\"_blank\">maps-for-free</a>",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "Demis",
			wms: "wms",
			minzoom: 13,
			maxzoom: 1,
			url: "http://www2.demis.nl/wms/wms.ashx?Service=WMS&WMS=BlueMarble&Version=1.1.0&Request=GetMap&Layers=Earth Image,Borders,Coastlines&Format=image/jpeg",
			copy:"WMS demo by Demis",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "ROADMAP",
			wms: "",
			minzoom: 13,
			maxzoom: 10,
			url: "",
			copy:"",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "SATELLITE",
			wms: "",
			minzoom: 13,
			maxzoom: 10,
			url: "",
			copy:"",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "HYBRID",
			wms: "",
			minzoom: 13,
			maxzoom: 10,
			url: "",
			copy:"",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var mapobj = { 
			name: "TERRAIN",
			wms: "",
			minzoom: 13,
			maxzoom: 10,
			url: "",
			copy:"",
			visible:true
		};
		mapTypesArr.push(mapobj);
		var msg_00 = "click to full size";
		var msg_01 = "IE 8 or higher is needed / switch of compatibility mode";
		var msg_03 = "Distance";
		var msg_04 = "Dénnivelé";
		var msg_05 = "Télécharger";
		var pluri = "{DOMAINE}/templates/js/google-maps-gpx-viewer/";
		var ieX = false;
		if (window.navigator.appName == "Microsoft Internet Explorer") {
			var err = ieX = true;
			if (document.documentMode > 7) err = false;
			if(err){
				//alert(msg_01);
			}
		}
		
			var map_0; 
			google.setOnLoadCallback(function() {		
			map_0 = init_map("TERRAIN", "map_0", 1);
			load_map(map_0, "", "", "13");	
			
			map_0["elevation"] = true; 
			map_0["download"] = false; 
			map_0.g_seCookie = false; // no cookie
			map_0.g_showCnt++;
			showGPX(map_0, "{DOMAINE}/templates/js/google-maps-gpx-viewer/129a3f4fd58404360b18cc71fd1adb6e(3).gpx");
					
			map_0.gmap_poi_db = false; 
			
			post_init(map_0);
		
			});
		
		</script>
		
		
		<div class="gm_gpx_body" id="holder_map_1" style="width: auto; height:400px; margin:20px 0px 20px 0px;">
		<div class="google_map_holder" id="map_1" style="width: auto; height:400px; border: 1px solid black;"></div></div>
		<script type="text/javascript">
	
			var map_1; 
			google.setOnLoadCallback(function() {		
			map_1 = init_map("TERRAIN", "map_1", 1);
			load_map(map_1, "", "", "15");	
			
			map_1["elevation"] = true; 
			map_1["download"] = true; 
			map_1.g_seCookie = false; // no cookie
			map_1.g_showCnt++;
			showGPX(map_1, "http://127.0.0.1/revedemontagne2/mapgpx/download.php?mpgpx=a08962ad891f50e12afc852bf9e35944");
					
				map_1.gmap_poi_db = false; 
			
			post_init(map_1);
		
			});
		
		</script>
		
		
<include file="../footer.tpl" />

