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
		<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
		<script type="text/javascript" src="{DOMAINE}/templates/js/topos/edition_topos_randos.js"></script>
<include file="../headers/header_common_body.tpl" />
	<div class="arbre">Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="{ROOT}liste-des-topos-de-randonnee.html">topos randonnée</a> &gt; 
		<a href="{ROOT}liste-des-sommets-m{id_massif}.html">{massif}</a> &gt; 			
		<a href="{url_nom_sommet}">{nom_sommet}</a> &gt; 			
		{nom_topo}
	</div>
		
		
	<h1>{nom_sommet}, {nom_topo}</h1>
	{validation}			
	<div class="cadregd">
		<div class="cadre_droite3">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Auteur</h2>
				</div>
			</div>
			<div class="cadre_1_cg">
				<div class="cadre_1_cd centre">
					<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="{DOMAINE}membres-{id_m}-fiche.html">{pseudo}</a>	<br />
					<div class="avatar-imp">{avatar}</div>					
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
		<div class="cadre_gauche3">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Informations générale</h2>
				</div>
			</div>
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
						<!---Informations g鮩rales concernant le topos--->
					<ul>
						<li>Massif : {massif}</li>
						<li>Orientation : {orientation}</li>
						<li>Dénivelé : {dennivele} m.</li>
						<li>Difficultée de montée : {difficulte}</li>
						{coms}
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
	<!---Fin du cadre haut--->

		
		<div class="cadregd">	
			<div class="cadre_gauche">
				<div class="cadre_1_hg">
					<div class="cadre_1_hd">
						<h2>Informations générales</h2>
					</div>
				</div>  
				<div class="cadre_1_cg">
					<div class="cadre_1_cd">			
					Cartes : 
					<---CARTE--->
						<a href="carte-ign-{CARTE.nom_url_carte}-n{CARTE.id_carte}.html">{CARTE.nom_carte}</a>
					</---CARTE---><br />
					Départ : <a href="depart-{url_nom_acces}-d{id_acces}.html">{depart}</a><br />
					Altitude de départ : {alt_depart} m.<br />
						
					Nb de jours : {nb_jours}<br />
					Type : {type}
					</div>
				</div>
				<div class="cadre_1_bg">
					<div class="cadre_1_bd">
						<div class="cadre_1_b">
						&nbsp	
						</div>
					</div>
				</div>	
			</div>
			<!--Fin cadre gauche-->			
					
			<!--Cadre droite-->
			<div class="cadre_droite">	
				<div class="cadre_1_hg">
					<div class="cadre_1_hd">
						<h2>Accés</h2>
					</div>
				</div>  
				<div class="cadre_1_cg">
					<div class="cadre_1_cd">
						{acces}	
					</div>
				</div>
				<div class="cadre_1_bg">
					<div class="cadre_1_bd">
						<div class="cadre_1_b">
						
						</div>
					</div>
				</div>		
			</div>
		</div>
		
		{afficher_carte}
		
		

		
		<div class="cadre">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Itinéraire</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd" {edit_rapide_intro}>
					{itineraire}
				</div>
			</div>			
			<div class="cadre_1_bg">
				<div class="cadre_1_bd">
					<div class="cadre_1_b">
					&nbsp	
					</div>
				</div>
			</div>	
		</div>
		<div class="cadre">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Remarques</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd" {edit_rapide_conclu}>
					{remarques}
				</div>
			</div>				
			<div class="cadre_1_bg">
				<div class="cadre_1_bd">
					<div class="cadre_1_b">
					&nbsp	
					</div>
				</div>
			</div>	
		</div>
		<div class="cadre">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Conditions récentes</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
					<---SORTIES--->
						<li>le {SORTIES.date} : <a href="{ROOT}{SORTIES.url_sommet}-{SORTIES.url_topo}-sortie-n{SORTIES.id_sortie}.html">{SORTIES.text_lien}</a> par : <a href="{ROOT}membres-{SORTIES.mid}-fiche.html">{SORTIES.pseudo}</a></li>					
					</---SORTIES--->	
				</div>
			</div>		
			
			<div class="cadre_1_bg">
				<div class="cadre_1_bd">
					<div class="cadre_1_b">
						<h2>{ajout_sortie}{ajout_trace}</h2>
					</div>
				</div>
			</div>	
		</div>
		<div class="cadre">	
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>&nbsp</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
					<div id="avertissement">
						<h4 class="titre2">Avertissement</h4><br />
						Les informations fournies par ce site ne pourront en aucun cas engager la responsabilit&eacute; de revedemontagne et des personnes qui participent au site.<br />
						revedemontagne d&eacute;cline toute responsabilit&eacute; en cas d&acute;accident et ne pourra etre tenu pour responsable de quelque mani&egrave;re que ce soit.
					</div>
				</div>
			</div>			
			<div class="cadre_1_bg">
				<div class="cadre_1_bd">
					<div class="cadre_1_b">
						&nbsp	
					</div>
				</div>
			</div>
		</div>	

		<div class="partage">
			<div class="addthis_sharing_toolbox"></div>
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