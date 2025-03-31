<br /><br />
<fieldset>
	<legend>Topo</legend>
	<label for="titre">Titre : </label>
	<input type="text" name="titre" id="titre" /><br />
	<label for="type_topo">Type de topo : </label>
	<select name="type_topo" id="type_topo" onchange="load_form('load_topo',this.value);">
		<option value="">Sélectionner un type de topo</option>
		<option value="ski_rando">Ski, surf, raquette</option>
		<option value="alpinisme">alpinisme neige, glace, mixte</option>
		<option value="rocher">rocher haute montagne</option>
		<option value="escalade">escalade</option>
		<option value="cascade">cascade</option>
		<option value="rando">randonnée pédestre</option>
		<option value="refuge">refuge</option>
	</select>
	<br />
	<div class="miseengarde">
		Ce formulaire permet de créer un article formater pour être présenter comme un topo. Si vous souhaitez l'éditer plus tard celui-ci sera éditable comme un article (il n'y aura plus ce formulaire).
		C'est pourquoi nous vous recommandons de bien renseigner les champs connues pour vous évitez une édition laborieuse (excepter pour les textes <strong>description</strong> et <strong>remarques</strong>).<br />
	</div>
</fieldset>
<div id="load_topo"></div>