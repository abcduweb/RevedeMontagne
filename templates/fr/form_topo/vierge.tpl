<h2>Article vierge</h2>
<label for="titre">Titre :</label>
<input type="text" name="titre" id="titre" /><br /><br />
<fieldset>
	<legend>Introduction</legend>
	<include form="../bouton_form.tpl" prev="intro" sign="0" url="popupload-4-intro.html" />
</fieldset>
<fieldset>
	<legend>Conclusion</legend>
	<include form="../bouton_form.tpl" prev="conclu" sign="0" url="popupload-4-conclu.html" />	
</fieldset>
<div class="send buttons">
	<button type="submit" value="Envoyer" class="positive">
		<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
		Envoyer 
	</button>
</div>