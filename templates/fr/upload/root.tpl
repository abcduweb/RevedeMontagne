<include file="header.tpl" />
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Mes images</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<table class="listemess">
				<thead>
					<tr>
						<th colspan="5">
							<div id="niveaux"><a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="upload{textarea}.html">Upload</a> &gt; Choix du répertoire</div>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="titre_upload">
							<a href="photos.html{textarea_photo}"><img src="{DOMAINE}/templates/images/{design}/commun/dir.png" alt="Photos" /></a><br />
							<a href="photos.html{textarea_photo}">Photos</a>
						</td>
					<---FOLDERS--->
						<td class="titre_upload">
							<a href="upload-{idDir}{textarea}.html"><img src="{DOMAINE}/templates/images/{design}/commun/dir.png" alt="{titreDir}" /></a><br />
							<a href="upload-{idDir}{textarea}.html">{titreDir}</a>
						</td>{endline}
					</---FOLDERS--->
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