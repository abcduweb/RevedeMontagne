<include file="../headers/header_common_head.tpl" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
		<link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />
		<!-- CSS -->
        <style>
            body{margin:0}
            #map{height: 50vh;}
        </style>
		<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
		<script type="text/javascript" src="{DOMAINE}/templates/js/refuges/edition_pt_abris.js"></script>
<include file="../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-refuges-m{id_massif}.html">{nom_massif}</a> &gt; 			
	<a href="#">{nom_refuge}</a> &gt; information sur la cabane
</div>


<h1>{nom_refuge}</h1>
{validation}
		
<div class="cadregd">
	<div class="cadre_droite3">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Image &agrave; la une</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd centre">
				{image_a_la_une}<br />
				
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
				<h2>Informations</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<!---Informations générales concernant le sommet--->
				<label>Nom :</label>{nom_refuge}, {type_cabane}<br />
				<label>Altitude :</label> {alt_refuge} m<br />
				<label>Massif :</label> {massif}<br />
				<label>Carte :</label> <---CARTE---><a href="carte-ign-{CARTE.nom_url_carte}-n{CARTE.id_carte}.html">{CARTE.nom_carte}</a> </---CARTE---><br />
				<label>Coordonn&eacute;es :</label> Lat/Long : {lat} N / {long} E<br />
				<label>Couchage :</label> {nbre_place} places<br />
				{coms}	
				<label>MAJ de la fiche :</label> {maj}<br />
				<label>Contributeur :</label> <img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="{DOMAINE}membres-{id_m}-fiche.html">{pseudo}</a><br />
				{modifier_fiche}
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
			<h2>Carte de situation</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div id="map" style="border:1px solid #000;text-align: center;width: 90%; height: 300px; margin:auto;"></div>
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
			<h2>Acc&eacute;s</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd" {edit_rapide_intro}>	
	    	{intro}
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
	    	{conclu}
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

<include file="../footer.tpl" />

<!-- Fichiers Javascript -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
<script type='text/javascript' src='https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js'></script>
<script type="text/javascript">
    // On initialise la latitude et la longitude de Paris (centre de la carte)
		var layer;
    var lat = {lat};
    var lon = {long};
	var iconBase = '{iconRDM}';
    var macarte = null;
    var markerClusters; // Servira à stocker les groupes de marqueurs

    // Nous initialisons une liste de marqueurs
    var pts = {
		"{info_bulle}": { "lat": {lat}, "lon": {long} }
        };
	
	// Fonction d'initialisation de la carte
        function initMap() {

	// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
        macarte = L.map('map').setView([lat, lon], 11);
        markerClusters = L.markerClusterGroup(); // Nous initialisons les groupes de marqueurs
    
    // On charge les "tuiles"
		function layerUrl(key, layer) {
					return "https://wxs.ign.fr/" + key
						+ "/geoportail/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&"
						+ "LAYER=" + layer + "&STYLE=normal&TILEMATRIXSET=PM&"
						+ "TILEMATRIX={z}&TILEROW={y}&TILECOL={x}&FORMAT=image%2Fjpeg";
				}
				

						
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
				).addTo(macarte);
    
	// Nous parcourons la liste des villes
    for (pts_montagne in pts) {
	
	// Nous définissons l'icône à utiliser pour le marqueur, sa taille affichée (iconSize), sa position (iconAnchor) et le décalage de son ancrage (popupAnchor)
    var myIcon = L.icon({
        iconUrl: iconBase,
        iconSize: [25, 25],
        iconAnchor: [10, 25],
        popupAnchor: [-3, -76],
        });
        var marker = L.marker([pts[pts_montagne].lat, pts[pts_montagne].lon], { icon: myIcon }); // pas de addTo(macarte), l'affichage sera géré par la bibliothèque des clusters
        marker.bindPopup(pts_montagne);
        markerClusters.addLayer(marker); // Nous ajoutons le marqueur aux groupes
    }
    macarte.addLayer(markerClusters);
    }
	window.onload = function(){
	
	// Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
	initMap(); 
	};
</script>		
		