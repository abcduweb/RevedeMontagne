<h2>Alpinisme neige, glace, mixte</h2>
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
		<option value="TD-" title="Tr�s Difficile">TD-</option>
		<option value="TD" title="Tr�s Difficile">TD</option>
		<option value="TD+" title="Tr�s Difficile plus">TD+</option>
		<option value="ED-" title="Extr�mement Difficile moins">ED-</option>
		<option value="ED" title="Extr�mement Difficile">ED</option>
		<option value="ED+" title="Extr�mement Difficile plus">ED+</option>
		<option value="ABO-" title="Abominable moins">ABO-</option>
		<option value="ABO" title="Abominable">ABO</option>
</select><br />
<label for="configurations"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="La configuration d�crit le type principal de relief rencontr�&lt;br /&gt; le long de l'itin�raire ou de ses difficult�s seulement." onmouseover="tooltip.show(this);" />  Configuration : </label>
<select name="configurations[]" id="configurations" multiple="multiple" class="selection_multiple">
	<option value="null"></option>
	<option value="ar�te">ar�te</option>
	<option value="couloir">couloir</option>
	<option value="face">face</option>
	<option value="goulotte">goulotte</option>
	<option value="pilier">pilier</option>
	<option value="cascade/falaise de mixte">cascade/falaise de mixte</option>
	<option value="itin�raire de haute montagne / parcours glaciaire">itin�raire de haute montagne / parcours glaciaire</option>
</select><br />
<label for="qt_equip"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Ce champ permet de pr�ciser la pr�sence et la qualit� de points de protections pour l'escalade." onmouseover="tooltip.show(this);" />Qualit� de l'�quipement en place : </label>
<br />
<select name="qt_equip" id="qt_equip">
	<option value="null"></option>
	<option value="1">Bien �quip�</option>
	<option value="2">Partiellement �quip�</option>
	<option value="3">Peu �quip�</option>
	<option value="4">Pas �quip�</option>
</select><br /><br />
<label for="glacier"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Indique si l'itin�raire passe sur des glaciers&lt;br /&gt; pouvant �tre crevass�s." onmouseover="tooltip.show(this);" />  Itin�raire glaciaire : </label>
<input type="checkbox" name="glacier" id="glacier" /><br /><br />
<include file="commun_topo2.tpl" />
<div class="send buttons">
	<button type="submit" value="Envoyer" class="positive">
		<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
		Envoyer 
	</button>
</div>