<include file="headers/header_common_head.tpl" />
	<script src="http://maps.google.com/maps?file=api&amp;v=2.x&amp;key=ABQIAAAA9MqCOVKQoMF37ULkDslXSBSZ4pO-OzGbLh8kli8noNM1DL5BQhQtA8vRpssFxq5U_TA-kf8bZEWBcg"
	      type="text/javascript"></script>
	<script src="templates/js/gmap.js" type="text/javascript"></script>
<include file="headers/header_common_body.tpl" />
	<div id="corps">
		<div class="arbre">
			Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="liste-des-cartes.html">Cartes</a> &gt; <a href="{url_carte}">{carte}</a> &gt; {carte}
		</div>
		<h1>{carte}</h1>
		<div class="text-article">
		<br />
			<div class="big_maps" id="http://127.0.0.1/rdm/{kml_carte}"><img src="templates/images/{design}/ajax-loader.gif" alt="Chargement carte..." onload="loadMap(this);"/></div><br />
		<form action="#" method="post">
			<fieldset>
				<legend>Coordonnées du pointeur</legend>
				<label for="gps_lat">Lat:</label> <input type="text" id="gps_lat" name="gps_lat" value="" /><br />
				<label for="gps_lng">Lon:</label> <input type="text" id="gps_lng" name="gps_lng" value="" />
			</fieldset>
			<fieldset>
				<legend>Options</legend>
				<label for="departement">Limites des departements</label><input type="checkbox" name="departement" id="departement" onclick="toggledepartement(this);" />
			</fieldset>
		</form>
		<h2>Carte dans google earth</h2>
			<ul>
				<li><a href="http://www.revedemontagne.com/{kml_carte}">{carte}</a></li>
			</ul>
		<h2>Legende</h2>
		<ul>
			<li><img src="templates/images/{design}/carte/refugeGarde.png" alt="refuge garde"> Refuge garde</li>
			<li><img src="templates/images/{design}/carte/refugeNonGarde.png" alt="refuge non garde">  Refuge non garde</li>
		</ul>
		</div>
		<br />
	</div>
<include file="footer.tpl" />
