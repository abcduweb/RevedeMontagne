<!DOCTYPE html>
<html lang="fr">

  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
  </head>

<body>

<div class="cadre_5_hg">
	<div class="cadre_5_hd">
		<h5>Localisation</h5>
	</div>
</div>
<div class="cadre_5_cg">
	<div class="cadre_5_cd">

		    <!-- Le conteneur de notre carte (avec une contrainte CSS pour la taille -->
		<div id="macarte" style="width:545px; height:490px"></div>
		
		<div class="float_r"><input type="button" value="Valider la position" onclick="window.opener.document.getElementById('lat').value=document.getElementById('lat').innerHTML;window.opener.document.getElementById('lng').value=document.getElementById('lng').innerHTML;window.close()"; /><input type="button" value="Annuler" onclick="window.close()"; /></div>
		Latitude : <span id="lat">NaN</span> ; Longitude : <span id="lng">NaN</span>

	</div>				
</div>
<div class="cadre_5_bg">			
	<div class="cadre_5_bd">
		<div class="cadre_5_b">
			&nbsp;
		</div>
	</div>
</div>

<script>
	"use strict";
    var layer;
      var carte = L.map('macarte').setView([46.5630104, 1.4846608], 6);
		function layerUrl(key, layer) {
			return "https://wxs.ign.fr/" + key
				+ "/geoportail/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&"
				+ "LAYER=" + layer + "&STYLE=normal&TILEMATRIXSET=PM&"
				+ "TILEMATRIX={z}&TILEROW={y}&TILECOL={x}&FORMAT=image%2Fjpeg";
		}
		
				
		// On charge les "tuiles"
		L.tileLayer(
			layerUrl(
				"26i4kmg8961ialiuqtxk1q5e", "GEOGRAPHICALGRIDSYSTEMS.MAPS"
			), 
			{
			 attribution: 'données © <a href="https://www.ign.fr/">IGN</a>',     
			 minZoom: 1,
			 maxZoom: 20,
			 layers: [layer]
			}
		).addTo(carte);
			var marker = L.marker([{lat}, {long}]).addTo(carte);
      carte.on('click', placerMarqueur);
      
      function placerMarqueur(e) {
		
		marker.setLatLng(e.latlng);
		var Lat = e.latlng.lat
		var Lng = e.latlng.lng
		document.getElementById('lat').innerHTML=Math.round(e.latlng.lat*100000)/100000;
		document.getElementById('lng').innerHTML=Math.round(e.latlng.lng*100000)/100000;
      };
</script>

<include file="../footer_vide.tpl" />


