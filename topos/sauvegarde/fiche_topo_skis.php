<?php
if(!isset($load_tpl)){
$load_tpl = true;
########### A METTRE SUR CHAQUE PAGE ############
session_start();							  # 
define('ROOT', '../');                        #
define('INC_ROOT', ROOT . 'includes/'); 	  #
include (INC_ROOT . 'commun.php'); 			  #
define('TPL_ROOT',ROOT.'templates/'.LANG.'/');#
##########################################
}
if(!empty($_GET['pid']))
{
	$midi = intval($_GET['pid']);
		$reponse =  $db->requete("SELECT id_m_join, invisible, nom_topo, idf, id_activite, nom_point, id_point, nom_topo, topos.id_massif, nom_massif, orientation, denniveles, difficulte_topo, difficulte, topos.statut, exposition,
									departs.id_depart, lieu_depart, alt_depart, pente, nb_jours, nom_type, acces_parser, itineraire_parser, remarque_parser, altitude, topos.id_m, membres.pseudo, avatar
									FROM topos
									LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
									LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
									LEFT JOIN departs ON departs.id_depart = topos.id_depart
									LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
									LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
									LEFT JOIN membres ON membres.id_m = topos.id_m
									LEFT JOIN enligne ON enligne.id_m_join = topos.id_m
									LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
								WHERE topos.id_topo = '".$midi."'
								AND id_activite = 1");
		$num = $db->num();
		$donnees = $db->fetch($reponse);
	if($num > 0){
			
		$data = get_file(TPL_ROOT."topos/fiche_skis.tpl");
		include(INC_ROOT.'header.php');
		//On vérifi la validation du point GPS par l'équipe
		if($donnees['statut']==2)
		{
			$retour = $db->requete('SELECT COUNT(*) FROM messages WHERE id_topics = "'.$donnees['idf'].'"');
			$nb_coms = $db->row($retour);		
			$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe.png" alt="validé par l\'équipe" /></a>';
			$com='<li>Discussions : <a href="'.$config['domaine'].'forum-1-'.$donnees['idf'].'-'.title2url($donnees['nom_topo']).'.html">('.$nb_coms[0].') commentaire(s)</a></li>';
		}
		else
		{
			$validate='<a href="'.$config['domaine'].'article-la-certification-sur-reve-de-montagne-a140.html"><img src="'.$config['domaine'].'templates/images/'.$_SESSION['design'].'/valider_equipe_encours.png" alt="validé par l\'équipe" /></a>';
			$com='';
		}
		
		//$donnees = $db->fetch($reponse);
		//Récupération des cartes...
		$result =  $db->requete("SELECT * FROM utiliser_carte
									LEFT JOIN cartes ON cartes.id_carte = utiliser_carte.id_carte
								 WHERE id_topo = '".$midi."'");
		while ($row = $db->fetch($result))
		{
			$data = parse_boucle('CARTE',$data,FALSE,array(
			'CARTE.nom_carte'=>$row['num_carte'],
			'CARTE.nom_url_carte'=>title2url($row['nom_carte']),
			'CARTE.id_carte'=>$row['id_carte']
			));
		}
		
		$data = parse_boucle('CARTE',$data,TRUE);
		
		if($donnees['avatar'] != '')
			$avatar = '<img src="'.$donnees['avatar'].'" alt="avatar" class="emplacement_avatar"/>';
		else
			$avatar = '';
		
		if(isset($donnees['id_m_join']) AND $donnees['invisible'] == 0)
			$online = 'online';
		else	
			$online = 'offline';
		
		$data = parse_var($data,array(
			'validation'=>$validate,
			'url_nom_acces'=>title2url($donnees['lieu_depart']),
			'id_acces'=>$donnees['id_depart'],
			'nom_acces'=>$donnees['lieu_depart'],
			'alt_acces'=>$donnees['alt_depart'],
			'coms'=>$com,
			'ids'=>$donnees['id_activite'],
			'nom_sommet'=>$donnees['nom_point'],
			'url_nom_sommet'=>'detail-'.title2url($donnees['nom_point']).'-'.$donnees['id_point'].'-2.html',
			'nom_topo'=>$donnees['nom_topo'],
			'id_massif'=>$donnees['id_massif'],
			'nom_massif_url'=>title2url($donnees['nom_massif']),
			'massif'=>$donnees['nom_massif'],
			'orientation'=>$donnees['orientation'],
			'dennivele'=>$donnees['denniveles'],
			'difficulte'=>$donnees['difficulte_topo'],
			'difficulte_skis'=>$donnees['difficulte'],
			'exposition'=>$donnees['exposition'],
			'depart'=>$donnees['lieu_depart'],
			'alt_depart'=>$donnees['alt_depart'],
			'pente'=>$donnees['pente'],
			'nb_jours'=>$donnees['nb_jours'],
			'type'=>$donnees['nom_type'],
			'acces'=>$donnees['acces_parser'],
			'itineraire'=>$donnees['itineraire_parser'],
			'remarques'=>$donnees['remarque_parser'],
			'id_m'=>$donnees['id_m'],
			'pseudo'=>$donnees['pseudo'],
			'avatar'=>$avatar,
			'enligne'=>$online,
			'design'=>$_SESSION['design'],
			'titre_page'=>$donnees['nom_point'].', '.$donnees['nom_topo'].' ('.$donnees['altitude'].' m)- '.SITE_TITLE,'nb_requetes'=>$db->requetes,'ROOT'=>'',
			));		
			
		$rep =  $db->requete("SELECT * FROM map_gpx WHERE id_topo = '".$midi."'");
		$nbr = $db->num();
		$gpx = $db->fetch($rep);
		
		if($nbr > 0)
		{		
			if(isset($_SESSION['ses_id']))
				$telecharger = ' - <a href="'.$config['domaine'].'mapgpx/download.php?mpgpx='.$gpx['cle_mapgpx'].'">T&eacute;l&eacute;charger le fichier</a>';	
			else
				$telecharger = '';
			
			$mapgpx = '
			<link rel="stylesheet" href="'.$config['domaine'].'/templates/css/1/google-maps-gpx-viewer/editor.css" type="text/css" />
			<link rel="stylesheet" href="'.$config['domaine'].'/templates/css/1/google-maps-gpx-viewer/gmap_v3.css" type="text/css" />

			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">google.load("maps", "3", {other_params:"sensor=false&libraries=places,panoramio"});</script>
	
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_size.js"></script>
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_gpx_overlay.js"></script>
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_wms_overlay.js"></script>
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_init.js"></script>
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_edit.js"></script>
	
			<script type="text/javascript" id="script">google.load(\'visualization\', \'1\', {packages: [\'corechart\']});</script>
			<script type="text/javascript" src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/gmap_v3_elevation.js"></script>

	<script type="text/javascript">  
		// map load action
		function OnLoadGpxPoiDb(map){
			map.g_seCookie = false; // no cookie		
			map.g_showCnt++;
			jQuery.ajax({
			type: "GET",
			url:  "",
			success: function(msg){
				// alert (msg);
				jQuery(\'.loader\').remove();
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
				jQuery(\'#result\').html(out).fadeIn(\'slow\');
				fitViewport(map, bbox);
				updateMarkerUI(map, null);
				},
				complete:function (jqXHR, textStatus){
					/* enable for error check in loading gpx
					if(textStatus != "success")
						alert(\'Error: \' + jqXHR.responseText + \' + \' + textStatus);	*/ 			
				}
			});    
			google.maps.event.addListener(map, \'click\', function(e) { 
				jQuery(\'#gmap_poi_action_map\').attr(\'value\', map.getDiv().id);
				jQuery(\'#result\').html("");
				updateMarkerUI(map, null);
				if(map.gmap_poi_db && 1) {
					jQuery(\'#result\').html(\'<img src="'.$config['domaine'].'/templates/js/google-maps-gpx-viewer/loading.gif" class="loader" width="25" height="25" />`\').fadeIn();
					var geocoder = new google.maps.Geocoder();
					var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
					geocoder.geocode({\'latLng\': latlng}, function(results, status) {
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
									// jQuery(\'#item_name\').attr(\'value\', addr.country);
								if(addr.locality)
									jQuery(\'#item_name\').attr(\'value\', addr.locality);
								// postal address	
								var mail_address = "";
								if(addr.route)
									mail_address += addr.route;
								if(addr.street_number)
									mail_address += \' \' + addr.street_number;
								jQuery(\'#street\').attr(\'value\' ,mail_address);							
								mail_address = "";
								if(addr.postal_code)
									mail_address += addr.postal_code + \' \';
								if(addr.locality)
									mail_address += addr.locality;
								jQuery(\'#city\').attr(\'value\', mail_address);
												
								
								jQuery(\'#gpx_poi-widget\').addClass(\'red_border\'); 

							} else {
								// alert(\'No results found\');
							}
						} else {
							//alert(\'Geocoder failed due to: \' + status);
						}
						jQuery(\'.loader\').remove();
					});
		
					jQuery(\'#poi_click\').attr(\'value\', 1); // ?
					
					jQuery(\'#lat\').attr(\'value\',latlng.lat());
					jQuery(\'#lng\').attr(\'value\',latlng.lng());
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
			var item_type = \'\';
			jQuery(\'#item_type > option\').each( function(){
				if(this.value == ele.item_type){
					item_type = this.value; // 
				}
			}); 
			var description = \'\';
			if(ele.item_url == "http://" || ele.item_url == "")
				description = \'<strong>\' + ele.item_name + \'</strong>\';
			else
				description = \'<a href="\' + ele.item_url + \'" target="_blank"><strong>\' + ele.item_name + \'</strong> </a>\';
			if(ele.city != "" && ele.street != ""){
				description += \'<br>Address \' + ele.city + \', \' + ele.street;
				description += \'<br>\';
			}
			if(ele.contact != "")
				description += \'<br>\' + ele.contact;
			if(ele.description != "")
				description += \'<br>\' + ele.description;
			var pos = new google.maps.LatLng(ele.lat, ele.lng);
			
			var marker = new google.maps.Marker({
				icon: new google.maps.MarkerImage(\''.$config['domaine'].'/templates/images/1/google-maps-gpx-viewer/gmapIcons/\'+ele.item_type+\'.png\',
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
			marker.infowindow.event = google.maps.event.addListener(marker.infowindow, \'closeclick\', function() {
				updateMarkerUI(map, null);
			});		
			marker.event = google.maps.event.addListener(marker, \'click\', function() {
				jQuery(\'#result\').html("");
				updateMarkerUI(map, this);
				map.akt_marker = marker;
				marker.infowindow.open(map ,marker);
			});  
			if(map.gmap_poi_db) marker.event = google.maps.event.addListener(marker, \'dragend\', function() {
				updateMarkerUI(map, this);
			});  
			return marker;
		}

		// update marker info 
		function updateMarkerUI(map, marker){
			jQuery(\'#gmap_poi_action_map\').attr(\'value\', map.getDiv().id);
			if(map.akt_marker)
				map.akt_marker.infowindow.close();
			if(click_marker){
				click_marker.setMap(null);
				click_marker = null;
			}
			stopBouncer(map);
			jQuery(\'#poi_click\').attr(\'value\', 0); 
			// fill form with marker values on click
			if(marker){
				jQuery(\'#gpx_poi-widget\').addClass(\'red_border\');
			
				jQuery(\'#delbutton\').css(\'visibility\',\'visible\');
				jQuery(\'#lat\').attr(\'value\',marker.startpos.lat());
				jQuery(\'#lng\').attr(\'value\',marker.startpos.lng());
				jQuery(\'#item_name\').attr(\'value\',marker.title);
				jQuery(\'#item_url\').attr(\'value\',marker.home);
				jQuery(\'#city\').attr(\'value\',marker.city);
				jQuery(\'#street\').attr(\'value\',marker.street);
				jQuery(\'#contact\').attr(\'value\',marker.contact);
				jQuery(\'#description\').attr(\'value\',marker.descr);
				var m = marker.busi;
				jQuery(\'#item_type > option\').each( function(){
					if(this.value == m)
						this.selected = true; // establishment select
				}); 			
				jQuery(\'#poi_db_id\').attr(\'value\',marker.db_id);
				marker.setAnimation(google.maps.Animation.BOUNCE);
			} else { // empty poi
				jQuery(\'#gpx_poi-widget\').removeClass(\'red_border\');
			
				jQuery(\'#delbutton\').css(\'visibility\',\'hidden\');
				jQuery(\'#poi_db_id\').attr(\'value\',\'\');
				jQuery(\'#lat\').attr(\'value\',\'\');
				jQuery(\'#lng\').attr(\'value\',\'\');
				jQuery(\'#item_name\').attr(\'value\',\'Place name\');
				jQuery(\'#item_url\').attr(\'value\',\'http://\');
				jQuery(\'#city\').attr(\'value\',\'Zip & City\');
				jQuery(\'#street\').attr(\'value\',\'Street & No.\');
				jQuery(\'#contact\').attr(\'value\',\'Contact person, phone\');
				jQuery(\'#description\').attr(\'value\',\'Description\');
			}
		}
		
		// stop all bouncing selected icon
		function stopBouncer(map){
			for(var i = 0; i < map.markers.length ; i++){
				map.markers[i].setAnimation(null);
			}
		}
	</script>
	
	
	<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>'.$gpx['nom_mapgpx'].'</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="gm_gpx_body" id="holder_map_0" style="width: auto; height:400px; margin:20px 0px 20px 0px;">
			<div class="google_map_holder" id="map_0" style="width: auto; height:400px; border: 1px solid black;"></div>
			<a href="'.$config['domaine'].'map-'.title2url($gpx['nom_mapgpx']).'-m'.$gpx['cle_mapgpx'].'.html">Voir le d&eacute;tail</a>'.$telecharger.'</div>
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
				var msg_03 = "";//Distance
				var msg_04 = "";//d&eacute;nnivel&eacute;
				var msg_05 = "T&eacute;l&eacute;charger";
				var pluri = "'.$config['domaine'].'/templates/";
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
					map_0["Height"] = false; 
					map_0.g_seCookie = false; // no cookie
					map_0.g_showCnt++;
					showGPX(map_0, "'.$config['domaine'].'/mapgpx/GPX/'.$gpx['url_mapgpx'].'");
							
					map_0.gmap_poi_db = false; 
					
					post_init(map_0);
				
					});
				
				</script>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp;
			</div>
		</div>
	</div>
</div>';
		}else{
			$mapgpx = '';
		}
		//On cherche les dernières sorties
		$sql = "SELECT * FROM sortie
					LEFT JOIN topos ON topos.id_topo = sortie.id_topo
					LEFT JOIN topos_skis ON topos_skis.id_topo = topos.id_topo
					LEFT JOIN point_gps ON point_gps.id_point = topos.id_sommet
					LEFT JOIN departs ON departs.id_depart = topos.id_depart
					LEFT JOIN massif ON massif.id_massif = point_gps.id_massif
					LEFT JOIN type_topo ON type_topo.id_type_iti = topos.id_type_iti 
					LEFT JOIN membres ON membres.id_m = sortie.id_m
					LEFT JOIN autorisation_globale ON autorisation_globale.id_group = '$_SESSION[group]'
			WHERE sortie.id_topo = '".$midi."'
			ORDER BY id_point DESC LIMIT 0,10";
		
		$result = $db->requete($sql);
		while ($row = $db->fetch($result))
		{
			$text_lien = '';
				
			if($row['id_activite'] == 1)
				$text_lien = '[skis de randonnée] - '.$row['nom_point'].', '.$row['nom_topo'].'';
			else
				$text_lien = ''.$row['nom_point'].', '.$row['nom_topo'].'';
		
			$data = parse_boucle('SORTIES',$data,FALSE,array(
			'SORTIES.id_sortie'=>$row['id_sortie'],
			'SORTIES.mid'=>$row['id_m'],
			'SORTIES.date'=> date("d/m/Y", strtotime($row['dates'])),
			'SORTIES.text_lien'=>$text_lien,
			'SORTIES.url_sommet'=>title2url($row['nom_point']),
			'SORTIES.url_topo'=>title2url($row['nom_topo']),
			'SORTIES.pseudo'=>$row['pseudo']
			));
		}
		
		$data = parse_boucle('SORTIES',$data,TRUE);
		
		
		$auth = $db->fetch($db->requete("SELECT * FROM autorisation_globale WHERE id_group = $_SESSION[group]"));
		if($auth['redacteur_topo'] == 1){
			$ajout_sortie = '<a href="'.$config['domaine'].'/ajouter-une-sortie-t'.$midi.'-'.$donnees['id_activite'].'.html">Ajouter une sortie</a>';
			if($nbr == 0){
				$ajout_trace = ' - <a href="'.$config['domaine'].'/ajouter-une-trace-au-topo-n'.$midi.'-a'.$donnees['id_activite'].'.html">Ajouter une trace GPX</a>';
			}else{
				$ajout_trace = '';
			}
		}else{
			$ajout_sortie = '';
			$ajout_trace = '';
		}
		
		
		
		$data = parse_var($data,array('fichierGPX'=>$mapgpx, 'ajout_sortie'=>$ajout_sortie, 'ajout_trace'=>$ajout_trace,'idt'=>$midi, 'design'=>$_SESSION['design'], 'mapid'=>'zoom_canvas'));
	}	
	else
	{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
	}
	
}else
{
	$message = 'La fiche n\'existe pas';
	$redirection = 'javascript:history.back(-1);';
	$data = display_notice($message,'important',$redirection);
}
echo $data;
$db->deconnection();
?>