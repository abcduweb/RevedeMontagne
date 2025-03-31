<h2>Randonnée</h2>
<include file="commun_topo.tpl" />
<label for="cot_rando"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Cotation des difficultés d'un itinéraire de randonnée pédestre.L'échelle va de T1 à T6." onmouseover="tooltip.show(this);" />  Cotation : </label>
<select name="cot_rando" id="cot_rando">
	<option value="null"></option>
	<option value="1">T1</option>
	<option value="2">T2</option>
	<option value="3">T3</option>
	<option value="4">T4</option>
	<option value="5">T5</option>
	<option value="6">T6</option>
</select><br />
<include file="commun_topo2.tpl" />
<div class="send buttons">
	<button type="submit" value="Envoyer" class="positive">
		<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
		Envoyer 
	</button>
</div>