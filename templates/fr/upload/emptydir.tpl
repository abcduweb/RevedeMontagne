<include file="header.tpl" />
	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Mes images</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<---FORMUP--->
				<form enctype="multipart/form-data" action="actions/upload.php?dir={idDir}{textareaSend}" method="post" name="formulaire">
					<fieldset class="ajout_upload">
						<legend>Ajouter une images dans {dirTitle}</legend>
						<label for="fichier">Chemin de l'image à uploader : </label><input name="fichier" type="file"/><br/><br/>
						<label for="titre">Legende de l'image : </label><input type="text" name="titre"/><br/>
						<input type="submit" value="Envoyer l'image"/>
					</fieldset>
				</form>
				</---FORMUP--->
				<table class="listemess">
					<thead>
						<tr>
							<th>
								<div id="niveaux"><a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="upload{textarea}.html">Upload</a> &gt; <a href="upload-{idDir}{textarea}.html">{dirTitle}</a> &gt; contenu du dossier</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<p>il n'y a aucun dossiers ni images.</p>
							</td>
						</tr>
					</tbody>
				</table>
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
