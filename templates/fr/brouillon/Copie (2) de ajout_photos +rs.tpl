<include file="header.tpl" />

		<label for="cat">Catégorie choisie</label>
			<select name="cat" id="cat">
			<option selected value="nul"></option>
			<---categ--->
				<option value="{categ.id}">{categ.nom}</option>
			</---categ--->
		</select>
		
		<div id="dropbox">
			<span class="message">Drop images here to upload. <br /><i>(they will only be visible to you)</i></span>
		</div>
        		
		<!-- Including the HTML5 Uploader plugin -->
		<script src="{DOMAINE}/templates/js/album_photos/jquery.filedrop.js"></script>
		
		<!-- The main script file -->
        <script src="{DOMAINE}/templates/js/album_photos/script.js"></script>
<include file="footer.tpl" />