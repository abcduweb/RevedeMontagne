<include file="header.tpl" />
	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Album photos</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<table class="listemess">
					<thead>
						<tr>
							<th colspan="5">
								<div id="niveaux"><a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="upload{textareaRoot}.html">Upload</a> &gt; <a href="photos.html{textarea}">Photos</a> &gt; <a href="photos-{idDir}.html{textarea}">{dirName}</a> &gt; <a href="photos-{idDir}-{idSubDir}.html{textarea}">{subDirTitle}</a> &gt; contenu du dossier</div>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<---IMG--->
							<td>
								<a href="{DOMAINE}/images/album/{imgDir}/{imgName}"><img src="{DOMAINE}/images/album/{imgDir}/mini/{imgName}" alt="{legende}"></a>
								<br />
								{titre}<br />
								{insert} {supprimer}
							</td>{endline}
							</---IMG--->
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