	<label for="orientation">Orientation principale : </label>
	<select name="orientation" id="orientation">
		<option value="null"></option>
		<option value="N">N</option>
		<option value="NW">NW</option>
		<option value="W">W</option>
		<option value="SW">SW</option>
		<option value="S">S</option>
		<option value="SE">SE</option>
		<option value="E">E</option>
		<option value="NE">NE</option>
	</select><br />
	<label for="alt_max"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="L'altitude maximale atteinte lors du parcours" onmouseover="tooltip.show(this);" /> Altitude maximale : </label>
	<input type="text" name="alt_max" id="alt_max" />(en m)<br />
	<label for="alt_min"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="L'altitude minimal atteinte lors du parcours" onmouseover="tooltip.show(this);" /> Altitude minimale : </label>
	<input type="text" name="alt_min" id="alt_min" />(en m)<br />
	<label for="deniv_pos"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="D�nivel� positif cumul� du parcours" onmouseover="tooltip.show(this);" /> D�nivel� positif : </label>
	<input type="text" name="deniv_pos" id="deniv_pos" />(en m)<br />
	<label for="deniv_neg"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="D�nivel� n�gatif cumul� du parcours" onmouseover="tooltip.show(this);" /> D�nivel� n�gatif : </label>
	<input type="text" name="deniv_neg" id="deniv_neg" />(en m)<br />
	
	<label for="itin_type"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="&lt;h3&gt;Type de parcours&lt;/h3&gt; aller-retour : � partir d'un point unique &lt;br /&gt;&lt;br /&gt; travers�e : travers�e entre 2 points distincts &lt;br /&gt; (ex: �tape d'un raid) &lt;br /&gt;&lt;br /&gt; boucle : travers�e avec retour au point de d�part" onmouseover="tooltip.show(this);" /> Type de parcours : </label>
	<select name="itin_type" id="itin_type">
		<option value="null"></option>
		<option value="1">aller-retour</option>
		<option value="2">boucle</option>
		<option value="3">travers�e</option>
	</select><br />
	<label for="temps"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Nombre de jours n�cessaires (en moyenne)&lt;br /&gt; pour parcourir l'itin�raire, donn� � titre indicatif." onmouseover="tooltip.show(this);" />  Temps de parcours : </label>
	<select name="temps" id="temps">
		<option value="null"></option>
		<option value="0.1" title="inf�rieur � 1/2 journ�e">&lt; 1/2</option>
		<option value="0.5">1/2</option>
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11" title="supp�rieur � 10 jours">&gt;10</option>
	</select>(en Journ�e)<br />