<include file="../header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="photos.html">Mes photos</a> &gt; Modifier une photo </div>
		<h1>Modifier une photo</h1>
		<form enctype="multipart/form-data" action="actions/modifier_photos.php" method="post" name="formulaire">
			<fieldset>
				<legend>Infos sur la photo</legend>
				<label for="titre">Titre de la photo : </label>
				<input type="text" id="titre" name="titre" value="{titre_photo}" />
				<br />
				<label for="texte">Votre commentaire sur la photo : </label><br /><br />
				<include form="../bouton_form.tpl" prev="texte" sign="0" url="upload.html" />	
				<br/>
				<label for="fichier">Indiquez le chemin de la photo à uploader : </label><br />
				<input type="hidden" name="pid" id="pid" value="{id}" />
				<input name="fichier" id="fichier" type="file" /><br/><br/>
				<div class="send buttons">
					<button type="submit" value="Modifier l'image" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
						Modifier l'image
					</button>
				</div>
			</fieldset>
		</form>
		<br /><br />
	</div>
<include file="../footer.tpl" />