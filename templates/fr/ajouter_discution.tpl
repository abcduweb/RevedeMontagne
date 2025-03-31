<include file="./headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./headers/header_common_body.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-mp.html">Message Privés</a> &gt;
	<a href="creer-discution.html">Ajouter discution</a> &gt;
	Créer une nouvlle discution
</div>
<div class="cadre">			
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Envoyer une discution</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action="actions/submit_discution.php" method="post">
				<fieldset>
					<legend>Nouvelle discution</legend>
					<label for="titre">Titre : </label>
					<input type="text" name="titre" /><br />
					<label for="description">Description :</label>
					<input type="text" name="description" /><br />
					<label for="recherche">Rechercher : </label>
					<input type="text" size="30" name="recherche" id="recherche" />
					<input type="button" onclick="add_user()" value="Ajouter destinataire" />
					<div id="prn_update"></div>
					<script type="text/javascript">
						new Ajax.Autocompleter (
						  'recherche',      // ID of the source field
						  'prn_update',  // ID of the DOM element to update
						  'ajax/complete.php', // Remote script URI
						  {method: 'post', paramName: 'recherche'}
						);
					</script>
					<label for="dest">Destinataire(s): </label><br />
					<textarea name="dest" id="dest" cols="30" rows="4" readonly="readonly">{destinataire}</textarea>
					<include form="bouton_form.tpl" prev="texte" sign="1" url="popupload-5-texte.html" />	
					<div class="send buttons">
						<button type="submit" value="Envoyer" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
							Envoyer 
						</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>			
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">.
				&nbsp	
			</div>
		</div>
	</div>
</div>
<include file="footer.tpl" />