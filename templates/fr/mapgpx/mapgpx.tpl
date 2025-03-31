<include file="../headers/header_common_head.tpl" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.1/leaflet.css" />
    <style type="text/css">
      .gpx { border: 2px #aaa solid; border-radius: 5px;
        box-shadow: 0 0 3px 3px #ccc; margin: 1em auto; }
      .gpx header { padding: 0.5em; }
      .gpx h3 { margin: 0; padding: 0; font-weight: bold; }
      .gpx .start { font-size: smaller; color: #444; }
      .gpx .map { border: 1px #888 solid; border-left: none; border-right: none;
        width: 100%; height: 500px; margin: 0; }
      .gpx footer { background: #f0f0f0; padding: 0.5em; }
      .gpx ul.info { list-style: none; margin: 0; padding: 0; font-size: smaller; }
      .gpx ul.info li { color: #666; padding: 2px; display: inline; }
      .gpx ul.info li span { color: black; }
    </style>
<include file="../headers/header_common_body.tpl" />

<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="{url_topos}.html">{type_topo}</a> &gt; 
	<a href="{ROOT}liste-des-sommets-m{id_massif}.html">{massif}</a> &gt; 			
	<a href="{url_nom_sommet}">{nom_sommet}</a> &gt; 			
	<a href="{url_nom_topo}">{nom_topo}</a> &gt; 
	d&eacute;tail de la trace
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{nom_trace}</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div id="demo" class="gpx" data-gpx-source="{DOMAINE}mapgpx/GPX/{url_mapgpx}" data-map-target="demo-map">
				<div class="map" id="demo-map"></div>
			</div>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp;
			</div>
		</div>
	</div>
</div>		

<div class="cadregd">
	<div class="cadre_gauche">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Dates, dur&eacute;es & vitesses</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<li>Auteur : {pseudo}</li>
					<li>Envoi du : {date_mapgpx}</li>
					<li>T&eacute;l&eacute;chargement : {telecharger}</li>
					<!-- <li>Date de d&eacute;but : {date_debut}</li>
					<li>Date de fin : {date_fin}</li>-->
					<li>Dur&eacute;e totale : {duree_marche_totale} - dont {duree_pause} de pause</li>
					<li>Vitesse moyenne* : {vitesse_moyenne} km/h ({duree_marche} de marche)</li>
					<li>Vitesse ascensionnelle moyenne* : {vitesse_montee} m/h ({duree_montee} d'ascension)</li>
					<li>Vitesse de descente moyenne* : {vitesse_descente} m/h ({duree_descente} de descente)</li>
				</ul>
				* sans les pauses	
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
	<div class="cadre_droite">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Quelques chiffres</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<li>Nombre de points de trace : {nbpoints}</li>
					<li>Longueur de l'itin&eacute;raire : {longueur} km</li>
					<li>Denivel&eacute; positif cumul&eacute; : {den_positif_cumu} m</li>
					<li>Denivel&eacute; n&eacute;gatif cumul&eacute; : {den_negatif_cumu} m</li>
					<li>Altitude maxi : {altitude_maxi} m</li>
					<li>Altitude mini : {altitude_mini} m</li>
					<li>Altitude moyenne : {altitude_moyenne} m</li>
				</ul>	
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp;
				</div>
			</div>
		</div>
	</div>
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>&nbsp;</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">				
			<h2>Titre et description du fichier</h2>
			<ul>
				<li>Titre : {titre_trace}</li>
				<li>Activit&eacute; : <a href="#">{activite}</a></li>
				<li>Massif : <a href="#">{departement}</a></li>
				<li>Description :<br />
				{desc_trace}</li>
			</ul>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp;
			</div>
		</div>
	</div>
</div>
		
    <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-gpx@1.5.0/gpx.js"></script>
    <script type="application/javascript">
      function display_gpx(elt) {
        if (!elt) return;
		var layer;
        var url = elt.getAttribute('data-gpx-source');
        var mapid = elt.getAttribute('data-map-target');
        if (!url || !mapid) return;

        function _t(t) { return elt.getElementsByTagName(t)[0]; }
        function _c(c) { return elt.getElementsByClassName(c)[0]; }

        var map = L.map(mapid);
		function layerUrl(key, layer) {
					return "https://wxs.ign.fr/" + key
						+ "/geoportail/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&"
						+ "LAYER=" + layer + "&STYLE=normal&TILEMATRIXSET=PM&"
						+ "TILEMATRIX={z}&TILEROW={y}&TILECOL={x}&FORMAT=image%2Fjpeg";
				}
				

						
				// On charge les "tuiles"
L.tileLayer(
        "https://data.geopf.fr/wmts?" +
        "&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0" +
        "&STYLE=normal" +
        "&TILEMATRIXSET=PM" +
        "&FORMAT=image/jpeg"+
        "&LAYER=ORTHOIMAGERY.ORTHOPHOTOS"+
	"&TILEMATRIX={z}" +
        "&TILEROW={y}" +
        "&TILECOL={x}", 
					{
					 attribution: 'données © <a href="https://www.ign.fr/">IGN</a>',     
					 minZoom: 1,
					 maxZoom: 20,
					 layers: [layer]
					}
				).addTo(map);

        var control = L.control.layers(null, null).addTo(map);

        new L.GPX(url, {
          async: true,
          marker_options: {
            startIconUrl: '{DOMAINE}/templates/images/1/carte/pin-icon-start.png',
            endIconUrl:   '{DOMAINE}/templates/images/1/carte/pin-icon-end.png',
            shadowUrl:    '{DOMAINE}/templates/images/1/carte/pin-shadow.png',
          },
        }).on('loaded', function(e) {
          var gpx = e.target;
          map.fitBounds(gpx.getBounds());
          control.addOverlay(gpx, gpx.get_name());

          /*
           * Note: the code below relies on the fact that the demo GPX file is
           * an actual GPS track with timing and heartrate information.
           */
          _t('h3').textContent = gpx.get_name();
          _c('start').textContent = gpx.get_start_time().toDateString() + ', '
            + gpx.get_start_time().toLocaleTimeString();
          _c('distance').textContent = gpx.get_distance_imp().toFixed(2);
          _c('duration').textContent = gpx.get_duration_string(gpx.get_moving_time());
          _c('pace').textContent     = gpx.get_duration_string(gpx.get_moving_pace_imp(), true);
          _c('avghr').textContent    = gpx.get_average_hr();
          _c('elevation-gain').textContent = gpx.to_ft(gpx.get_elevation_gain()).toFixed(0);
          _c('elevation-loss').textContent = gpx.to_ft(gpx.get_elevation_loss()).toFixed(0);
          _c('elevation-net').textContent  = gpx.to_ft(gpx.get_elevation_gain()
            - gpx.get_elevation_loss()).toFixed(0);
        }).addTo(map);
      }

      display_gpx(document.getElementById('demo'));
    </script>		
<include file="../footer.tpl" />

