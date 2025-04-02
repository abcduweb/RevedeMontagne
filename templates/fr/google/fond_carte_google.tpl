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
            #map{height: 100vh;}
        </style>
<include file="../headers/header_common_body.tpl" />

<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Visualiser un fond de carte
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Localisation d'un lieu</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
		
			<div id="map"></div>
			
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

<!-- Fichiers Javascript -->
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<script type='text/javascript' src='https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js'></script>
<script>
    
	// On initialise la carte
	"use strict";
    var layer;
	var markers = []; // Nous initialisons la liste des marqueurs
	var macarte = null;
	var markerClusters; // Servira à stocker les groupes de marqueurs
	macarte = L.map('map').setView([48.852969, 2.349903], 13);
	markerClusters = L.markerClusterGroup();
	
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
	).addTo(macarte);

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = () => 
	{
		// La transaction est terminée ?
		if(xmlhttp.readyState == 4)
		{
			// Si la transaction est un succès
			if(xmlhttp.status == 200){
				// On traite les données reçues
				let donnees = JSON.parse(xmlhttp.responseText)
							
				// On boucle sur les données (ES8)
				Object.entries(donnees.agences).forEach(agence => {
				
					var myIcon = L.icon({
                    iconUrl: agence[1].iconRDM,
                    iconSize: [23, 23],
                    iconAnchor: [15, 23],
                    popupAnchor: [-3, -76],
                    });
					
					
					// Ici j'ai une seule agence
					// On crée un marqueur pour l'agence					
					let marker = L.marker([agence[1].lat, agence[1].lon], { icon: myIcon })
					marker.bindPopup(agence[1].nom + agence[1].lien)
					markerClusters.addLayer(marker)
					markers.push(marker); // Nous ajoutons le marqueur à la liste des marqueurs
					

				})
				var group = new L.featureGroup(markers); // Nous créons le groupe des marqueurs pour adapter le zoom
				macarte.fitBounds(group.getBounds().pad(0.5)); // Nous demandons à ce que tous les marqueurs soient visibles, et ajoutons un padding (pad(0.5)) pour que les marqueurs ne soient pas coupés
				macarte.addLayer(markerClusters);
				
			}else
			{
				console.log(xmlhttp.statusText);
			}
		}
			
    }
	
    xmlhttp.open("GET", "{DOMAINE}/google/carte_gene.php");
	xmlhttp.send(null);

</script>
<include file="../footer.tpl" />



