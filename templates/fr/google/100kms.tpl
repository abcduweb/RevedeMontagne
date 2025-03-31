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
      var carte = L.map('macarte').setView([46.5630104, 1.4846608], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                // Il est toujours bien de laisser le lien vers la source des données
                attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                minZoom: 1,
                maxZoom: 20
            }).addTo(carte);

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


