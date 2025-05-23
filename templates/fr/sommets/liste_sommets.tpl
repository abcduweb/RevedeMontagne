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

<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-sommets.html">liste des sommets</a> &gt;
	Liste des sommets
</div>

<div class="cadre afficher_cacher_carte">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Localisation sur la carte</h2>
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


<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des sommets</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">{ajout_som}</div>		
			<table>
				<thead>
					<tr class="intitules_tabl">
						<th>Nom du sommet</th>
						<th>Altitude</th>
						<th>Coordonn�es GPS</th>
						<th>Type de point</th>
						{hcol_action}
					</tr>
				</thead>
				<tfoot>
					<th colspan="{nb_colonne}">					
						<div class="wp-pagenavi">
							Page(s) : {liste_page}
						</div>
					</th>
				</tfoot>
				<tbody>
					<---listesom--->
					<tr class="ligne{listesom.ligne}">
						<td class="col_titre"><a href="detail-{listesom.nom_som_url}-{listesom.id_som}-2.html">{listesom.nom_som}</a></td>
						<td>{listesom.alt} m</td>
						<td>Lat : {listesom.lat} / Long : {listesom.lng}</td>
						<td>{listesom.type}</td>
						{listesom.col_action}
					</tr>
					</---listesom--->	
				</tbody>
			</table>
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

<!-- Fichiers Javascript -->
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
<script type='text/javascript' src='https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js'></script>
<script>
    
	// On initialise la carte
	"use strict";
    var layer;
	var markers = []; // Nous initialisons la liste des marqueurs
	var macarte = null;
	var markerClusters; // Servira � stocker les groupes de marqueurs
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
         attribution: 'donn�es � <a href="https://www.ign.fr/">IGN</a>',     
		 minZoom: 1,
		 maxZoom: 20,
         layers: [layer]
		}
	).addTo(macarte);

    let xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = () => 
	{
		// La transaction est termin�e ?
		if(xmlhttp.readyState == 4)
		{
			// Si la transaction est un succ�s
			if(xmlhttp.status == 200){
				// On traite les donn�es re�ues
				let donnees = JSON.parse(xmlhttp.responseText)
							
				// On boucle sur les donn�es (ES8)
				Object.entries(donnees.agences).forEach(agence => {
				
					var myIcon = L.icon({
                    iconUrl: agence[1].iconRDM,
                    iconSize: [23, 23],
                    iconAnchor: [15, 23],
                    popupAnchor: [-3, -76],
                    });
					
					
					// Ici j'ai une seule agence
					// On cr�e un marqueur pour l'agence					
					let marker = L.marker([agence[1].lat, agence[1].lon], { icon: myIcon })
					marker.bindPopup(agence[1].nom + agence[1].lien)
					markerClusters.addLayer(marker)
					markers.push(marker); // Nous ajoutons le marqueur � la liste des marqueurs
					

				})
				var group = new L.featureGroup(markers); // Nous cr�ons le groupe des marqueurs pour adapter le zoom
				macarte.fitBounds(group.getBounds().pad(0.5)); // Nous demandons � ce que tous les marqueurs soient visibles, et ajoutons un padding (pad(0.5)) pour que les marqueurs ne soient pas coup�s
				macarte.addLayer(markerClusters);
				
			}else
			{
				console.log(xmlhttp.statusText);
			}
		}
			
    }
	
    xmlhttp.open("GET", "{DOMAINE}/google/carte_gene.php?idmass={idmassif}&typep={typepoint}");
	xmlhttp.send(null);

</script>
<include file="../footer.tpl" />