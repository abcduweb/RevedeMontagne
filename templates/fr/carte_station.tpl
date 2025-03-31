<include file="headers/header_common_head.tpl" />
<include file="headers/header_common_h_carte_s.tpl" />

</head>

<body onload="initialize()">
	<include file="headers/header_common_b_carte.tpl" />

	<div id="corps">		
		<div class="arbre">
			Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="liste-des-cartes.html">Cartes</a> &gt; <a href="{url_carte}">Carte des stations</a> &gt; Stations de skis
		</div>
		<br />
		<h1>Carte des stations</h1>
		<a href="liste-refuge.html">Voir la liste de tous les stations</a>
		<div id="map_canvas"></div>
	</div>

<include file="footer.tpl" />

