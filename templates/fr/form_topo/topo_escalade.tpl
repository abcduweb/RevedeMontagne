<fieldset>
	<legend>Escalade</legend>
	<include file="commun_topo.tpl" />
	<label for="cot_libre"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Cotation des difficultés d'escalade rocheuse en libre.&lt;br /&gt;La cotation libre évalue la difficulté maximale de l'escalade libre rocheuse.&lt;br /&gt;Elle se donne sur l'échelle française traditionnellement utilisée, qui va de 2 à 9b" onmouseover="tooltip.show(this);" />  Cotation : </label>
	<select name="cot_libre" id="cot_libre">
		<option value="null"></option>
		<option value="II">II</option>
		<option value="II">III</option>
		<option value="III+">III+</option>
		<option value="IV-">IV-</option>
		<option value="IV">IV</option>
		<option value="IV+">IV+</option>
		<option value="5a">5a</option>
		<option value="5b">5b</option>
		<option value="5c">5c</option>
		<option value="6a">6a</option>
		<option value="6a+">6a+</option>
		<option value="6b">6b</option>
		<option value="6b+">6b+</option>
		<option value="6c">6c</option>
		<option value="6c+">6c+</option>
		<option value="7a">7a</option>
		<option value="7a+">7a+</option>
		<option value="7b">7b</option>
		<option value="7b+">7b+</option>
		<option value="7c">7c</option>
		<option value="7c+">7c+</option>
		<option value="8a">8a</option>
		<option value="8a+">8a+</option>
		<option value="8b">8b</option>
		<option value="8b+">8b+</option>
		<option value="8c">8c</option>
		<option value="8c+">8c+</option>
		<option value="9a">9a</option>
		<option value="9a+">9a+</option>
		<option value="9b">9b</option>
	</select><br />
	<label for="cot_glob">Cotation globale : </label>
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
	<label for="qt_equip"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Ce champ permet de préciser la présence et la qualité de points de protections pour l'escalade." onmouseover="tooltip.show(this);" />Qualité de l'équipement en place : </label>
	<br />
	<select name="qt_equip" id="qt_equip">
		<option value="null"></option>
		<option value="1">Bien équipé</option>
		<option value="2">Partiellement équipé</option>
		<option value="3">Peu équipé</option>
		<option value="4">Pas équipé</option>
	</select><br /><br />
</fieldset>
<include file="commun_topo2.tpl" />
<div class="send buttons">
	<button type="submit" value="Envoyer" class="positive">
		<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
		Envoyer 
	</button>
</div>