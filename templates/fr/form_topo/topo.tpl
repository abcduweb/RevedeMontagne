<br /><br />
<fieldset>
	<legend>Topo</legend>
	<label for="titre">Titre : </label>
	<input type="text" name="titre" id="titre" /><br />
	<label for="type_topo">Type de topo : </label>
	<select name="type_topo" id="type_topo" onchange="load_form('load_topo',this.value);">
		<option value="">S�lectionner un type de topo</option>
		<option value="ski_rando">Ski, surf, raquette</option>
		<option value="alpinisme">alpinisme neige, glace, mixte</option>
		<option value="rocher">rocher haute montagne</option>
		<option value="escalade">escalade</option>
		<option value="cascade">cascade</option>
		<option value="rando">randonn�e p�destre</option>
		<option value="refuge">refuge</option>
	</select>
	<br />
	<div class="miseengarde">
		Ce formulaire permet de cr�er un article formater pour �tre pr�senter comme un topo. Si vous souhaitez l'�diter plus tard celui-ci sera �ditable comme un article (il n'y aura plus ce formulaire).
		C'est pourquoi nous vous recommandons de bien renseigner les champs connues pour vous �vitez une �dition laborieuse (excepter pour les textes <strong>description</strong> et <strong>remarques</strong>).<br />
	</div>
</fieldset>
<div id="load_topo"></div>