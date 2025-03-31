<h2>Cascade</h2>
<include file="commun_topo.tpl" />
<label for="cot_glace">Cotation glace : </label>
<select name="cot_galce" id="cot_glace">
	<option value="null"></option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="3+">3+</option>
	<option value="4">4</option>
	<option value="4+">4+</option>
	<option value="5">5</option>
	<option value="5+">5+</option>
	<option value="6">6</option>
	<option value="6+">6+</option>
	<option value="7">7</option>
	<option value="7+">7+</option>
</select><br />
<label for="cot_mixte">Cotation mixte : </label>
<select name="cot_mixte" id="cot_mixte">
	<option value="null"></option>
	<option value="M1">M1</option>
	<option value="M2">M2</option>
	<option value="M3">M3</option>
	<option value="M3+">M3+</option>
	<option value="M4">M4</option>
	<option value="M4+">M4+</option>
	<option value="M5">M5</option>
	<option value="M5+">M5+</option>
	<option value="M6">M6</option>
	<option value="M6+">M6+</option>
	<option value="M7">M7</option>
	<option value="M7+">M7+</option>
	<option value="M8">M8</option>
	<option value="M8+">M8+</option>
	<option value="M9">M9</option>
	<option value="M9+">M9+</option>
	<option value="M10">M10</option>
	<option value="M10+">M10+</option>
	<option value="M11">M11</option>
	<option value="M11+">M11+</option>
	<option value="M12">M12</option>
	<option value="M12+">M12+</option>
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
<label for="qt_equip"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Ce champ permet de préciser la présence et la qualité de points de protections pour l'escalade." onmouseover="tooltip.show(this);" />Qualité de l'équipement en place : </label>
<br />
<select name="qt_equip" id="qt_equip">
	<option value="null"></option>
	<option value="1">Bien équipé</option>
	<option value="2">Partiellement équipé</option>
	<option value="3">Peu équipé</option>
	<option value="4">Pas équipé</option>
</select><br /><br />
<include file="commun_topo2.tpl" />
<div class="send buttons">
	<button type="submit" value="Envoyer" class="positive">
		<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
		Envoyer 
	</button>
</div>