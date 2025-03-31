	<h2>Refuges</h2>
	<label for="altitude"><img src="/templates/images/{design}/info.png" alt="Altitude à laquelle se trouve le refuge" onmouseover="tooltip.show(this);" /> Altitude du refuge : </label>
	<input type="text" name="altitude" id="altitude" />(en m)<br />
	
	<label for="type"><img src="/templates/images/{design}/info.png" alt="info" title="Est ce un refuge gardé ou non ?" onmouseover="tooltip.show(this);" />  Refuge gardé : </label>
	<select name="type" id="type">
		<option value="null"></option>
		<option value="gardé">gardé</option>
		<option value="non gardé">non gardé</option>
	</select><br />
	
	<label for="nbre_places"><img src="/templates/images/{design}/info.png" alt="nombre de places disponible" onmouseover="tooltip.show(this);" /> Nombre de places : </label>
	<input type="text" name="nbre_places" id="nbre_places" />(en m)<br />
	
	Coordonnées GPS (insispensable pour que l'on puisse intégreé le refuge à la carte)<br />
	<label for="lat"><img src="/templates/images/{design}/info.png" alt="Latitude, on peut la trouver sur Google earth" onmouseover="tooltip.show(this);" /> Latitude : </label>
	<input type="text" name="lat" id="lat" />(en heures)<br />
	
	<label for="long"><img src="/templates/images/{design}/info.png" alt="Longitude, on peut la trouver sur Google earth" onmouseover="tooltip.show(this);" /> Longitude : </label>
	<input type="text" name="long" id="long" />(en heures)<br />
	
	<label for="prop"><img src="/templates/images/{design}/info.png" alt="Nom du propriétaire ou de l'organisme qui posséde le refuge" onmouseover="tooltip.show(this);" /> Nom du Propriètaire : </label>
	<input type="text" name="prop" id="prop" /><br />
	
	<fieldset>
		<legend><img src="/templates/images/{design}/info.png" alt="info" title="Cette partie permet de décrire l'itinéraire d'accè au refuge." onmouseover="tooltip.show(this);" />Accè(s)</legend>
			<include form="../bouton_form.tpl" prev="intro" sign="0" url="popupload-4-intro.html" />
	</fieldset>
	<fieldset>
		<legend><img src="/templates/images/{design}/info.png" alt="info" title="Le blabla explicatif" onmouseover="tooltip.show(this);" />Photos</legend>
		<include form="../bouton_form.tpl" prev="photo" sign="0" url="popupload-4-photo.html" />
	</fieldset>
	<fieldset>
		<legend><img src="/templates/images/{design}/info.png" alt="info" title="Cette partie vous permez d'ajouter vos remarques personnelles sur le refuge (état générale, ce qu'il manque...)" onmouseover="tooltip.show(this);" />Remarques</legend>
			<include form="../bouton_form.tpl" prev="conclu" sign="0" url="popupload-4-conclu.html" />
	</fieldset>

	<div class="send buttons">
		<button type="submit" value="Envoyer" class="positive">
			<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
			Envoyer 
		</button>
	</div>