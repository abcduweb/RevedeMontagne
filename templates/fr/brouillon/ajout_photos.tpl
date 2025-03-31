<include file="header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="album-photos.html">Album photos</a> &gt; Ajouter une photo </div>
		<h1>Ajouter une photo</h1>
		<form enctype="multipart/form-data" action="actions/submit_photo.php" method="post" name="formulaire">
			<fieldset>
				<legend>Ajouter une photo</legend>
				<label for="titre">Titre de la photo : </label>
				<input type="text" id="titre" name="titre" />
				<br />
				<label for="texte">Votre commentaire sur la photo : </label><br /><br />
				<include form="bouton_form.tpl" prev="texte" sign="0" url="upload.html" />	
				<label for="cat">Catégorie choisie</label>
				<select name="cat" id="cat">
					<option selected value="nul"></option>
					<---categ--->
					<option value="{categ.id}">{categ.nom}</option>
					</---categ--->
				</select>
				<br/><br/>
				<label for="fichier">Indiquez le chemin de la photo à uploader : </label><br />
				<input name="fichier" id="fichier" type="file"/><br/><br/>	
				<div class="send buttons">
					<button type="submit" value="Envoyer l'image" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
						Envoyer l'image
					</button>
				</div>
			</fieldset>
		</form>
		<br /><br />
	</div>
<include file="footer.tpl" />