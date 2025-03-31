	<h2>Ski, surf, raquette</h2>
	<include file="commun_topo.tpl" />
	<label for="cot_technique"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="&lt;h3&gt;Cotation des difficultés techniques de descente à ski (toponeige)&lt;/h3&gt;
Ce n'est pas une cotation ponctuelle : elle dépend de la longueur &lt;br /&gt; et de la configuration des difficultés.&lt;br /&gt;
Elle comprend 5 degrés. Chaque degré est divisé en 3 : 4.1 = 4-, 4.2 = 4, 4.3 = 4+.&lt;br /&gt; Le 5ème degré est ouvert sur le haut : 5.4, 5.5..." onmouseover="tooltip.show(this);" /> Cotation technique : </label>
	<select name="cot_technique" id="cot_technique">
		<option value="null"></option>
		<option value="1">1.1</option>
		<option value="2">1.2</option>
		<option value="3">1.3</option>
		<option value="4">2.1</option>
		<option value="5">2.2</option>
		<option value="6">2.3</option>
		<option value="7">3.1</option>
		<option value="8">3.2</option>
		<option value="9">3.3</option>
		<option value="10">4.1</option>
		<option value="11">4.2</option>
		<option value="12">4.3</option>
		<option value="13">5.1</option>
		<option value="14">5.2</option>
		<option value="15">5.3</option>
		<option value="16">5.4</option>
		<option value="17">5.5</option>
		<option value="18">5.6</option>
	</select><br />
	<label for="expo"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="&lt;h3&gt;Exposition&lt;/h3&gt;Cotation de l'exposition de descente à ski (toponeige).&lt;br /&gt;L'exposition décrit le risque de blessure en cas de chute,&lt;br /&gt;autre que la pente elle même : une faible exposition mais une forte pente&lt;br /&gt;ne garantit pas une chute sans conséquence.&lt;br /&gt;L'échelle va de E1 (aucun obstacle) à E4 (grosses barres rocheuses)." onmouseover="tooltip.show(this);" />  Exposition : </label>
	<select name="expo" id="expo">
		<option value="null"></option>
		<option value="E1">E1</option>
		<option value="E2">E2</option>
		<option value="E3">E3</option>
		<option value="E4">E4</option>
	</select><br />
	<label for="cot_ponct"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="&lt;h3&gt;Cotation ponctuelle ski&lt;/h3&gt;Cotation ponctuelle de descente à ski (Labande).&lt;br /&gt;La cotation Labande ponctuelle ski est complémentaire à la cotation globale.&lt;br /&gt;Elle évalue la difficulté du passage le plus délicat de la descente à ski.&lt;br /&gt;Elle est essentiellement liée à la pente, mais prend aussi en compte l'exposition.&lt;br /&gt;L'échelle va de S1 à S7." onmouseover="tooltip.show(this);" />  Cotation ponctuelle ski </label>
	<select name="cot_ponct" id="cot_ponct">
		<option value="null"></option>
		<option value="S1">S1</option>
		<option value="S2">S2</option>
		<option value="S3">S3</option>
		<option value="S4">S4</option>
		<option value="S5">S5</option>
		<option value="S6">S6</option>
		<option value="S7">S7</option>
	</select><br /><br />
	<label for="cot_glob"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="&lt;h3&gt;Cotation globale ski&lt;/h3&gt;Cotation globale d'un itinéraire à ski (Labande).&lt;br /&gt;La cotation Labande globale ski est une estimation du niveau général des difficultés rencontrées&lt;br /&gt;et de leur continuité. Elle tient également compte de l'altitude et de la durée d'une course.&lt;br /&gt;L'échelle, calquée sur celle de la cotation globale d'alpinisme, va de F (facile) à &lt;br /&gt;ABO (abominablement difficile).&lt;br /&gt;&lt;br /&gt;&lt;span class=miseengarde&gt;&lt;em&gt;ATTENTION ! Il s'agit ici d'une cotation pour le ski, et non pour l'alpinisme : &lt;br /&gt; un couloir peut facilement mériter un D pour le ski alors que sa cotation alpinisme, à la montée,&lt;br /&gt; ne dépasse pas PD ou AD.&lt;/em&gt;&lt;/span&gt;" onmouseover="tooltip.show(this);" />  Cotation globale ski : </label>
	<select name="cot_glob" id="cot_glob">
		<option value="null"></option>
		<option value="F" title="Facile">F</option>
		<option value="PD-" title="Pas Difficile moins">PD-</option>
		<option value="PD" title="Pas Difficile">PD</option>
		<option value="PD+" title="Pas Difficile plus">PD+</option>
		<option value="AD-" title="Assez Difficile moins">AD-</option>
		<option value="AD" title="Assez Difficile">AD</option>
		<option value="AD+" title="Assez Difficile plus">AD+</option>
		<option value="D-" title="Difficile moins">D-</option>
		<option value="D" title="Difficile">D</option>
		<option value="D+" title="Difficile plus">D+</option>
		<option value="TD-" title="Très Difficile">TD-</option>
		<option value="TD" title="Très Difficile">TD</option>
		<option value="TD+" title="Très Difficile plus">TD+</option>
		<option value="ED-" title="Extrèmement Difficile moins">ED-</option>
		<option value="ED" title="Extrèmement Difficile">ED</option>
		<option value="ED+" title="Extrèmement Difficile plus">ED+</option>
		<option value="ABO-" title="Abominable moins">ABO-</option>
		<option value="ABO" title="Abominable">ABO</option>
	</select><br />
	<label for="compatible">Compatible avec : </label>
	<select name="compatible[]" id="compatible" multiple="multiple" class="selection_multiple_petite">
		<option value="null"></option>
		<option value="1">ski</option>
		<option value="2">snowboard</option>
		<option value="3">raquettes</option>
		<option value="4">initiation</option>
	</select><br />
	<label for="configurations"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="La configuration décrit le type principal de relief rencontré&lt;br /&gt; le long de l'itinéraire ou de ses difficultés seulement." onmouseover="tooltip.show(this);" />  Configuration : </label>
	<select name="configurations[]" id="configurations" multiple="multiple" class="selection_multiple">
		<option value="null"></option>
		<option value="arête">arête</option>
		<option value="couloir">couloir</option>
		<option value="face">face</option>
		<option value="goulotte">goulotte</option>
		<option value="pilier">pilier</option>
		<option value="cascade/falaise de mixte">cascade/falaise de mixte</option>
		<option value="itinéraire de haute montagne / parcours glaciaire">itinéraire de haute montagne / parcours glaciaire</option>
	</select><br /><br />
	<label for="glacier"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Indique si l'itinéraire passe sur des glaciers&lt;br /&gt; pouvant être crevassés." onmouseover="tooltip.show(this);" />  Itinéraire glaciaire : </label>
	<input type="checkbox" name="glacier" id="glacier" /><br /><br />
	<include file="commun_topo2.tpl" />
	<div class="send buttons">
		<button type="submit" value="Envoyer" class="positive">
			<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
			Envoyer 
		</button>
	</div>