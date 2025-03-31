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
		<a href="contribution.html">Mes contributions</a> &gt;
		Ajouter une photo 
	</div>

	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Ajouter une photo</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">		
				<form enctype="multipart/form-data" action="actions/submit_photo.php" method="post" name="formulaire">
					<fieldset>
						<legend>Ajouter une photo</legend>
						<label for="titre">Titre de la photo : </label>
						<input type="text" id="titre" name="titre" />
						<br />
						<label for="texte">Votre commentaire sur la photo : </label><br /><br />
						<include form="bouton_form.tpl" prev="texte" sign="0" url="upload.html" />	
						<label for="cat">Cat&eacute;gorie choisie</label>
						<select name="cat" id="cat">
							<option selected value="nul"></option>
							<---categ--->
								<option value="{categ.id}">{categ.nom}</option>
							</---categ--->
						</select>
						<br/><br/>
						<label for="fichier">Indiquez le chemin de la photo &agrave; uploader : </label><br />
						<input name="fichier" id="fichier" type="file"/><br/><br/>	
						<div class="send buttons">
							<button type="submit" value="Envoyer l'image" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
								Envoyer l'image
							</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp;
				</div>
			</div>
		</div>
	</div>
<include file="footer.tpl" />