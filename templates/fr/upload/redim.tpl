<include file="header.tpl" />
	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Redimenssionnement d'images</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div id="niveaux">
					<a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="upload{textarea}.html">Upload</a> &gt; 
					<---UPLOAD--->
					<a href="upload-{idDir}{textarea}.html">{dirTitle}</a>
					<---SUBDIR--->
					&gt; <a href="upload-{idDir}-{idSubDir}{textarea}.html">{subDirTitle}</a>
					</---SUBDIR--->
					</---UPLOAD--->
					<---PHOTOS--->
					<a href="photos{textarea}.html">Photos</a> &gt; <a href="photos-{idDir}{textarea}.html">{dirName}</a> 
					<---SUBDIRP--->
					&gt; <a href="photos-{idDir}-{idSubDir}{textarea}.html">{subDirTitle}</a>
					</---SUBDIRP--->
					</---PHOTOS--->
					&gt; Redimentionnement
				</div>
				<div id="calquePhoto1">
					<img id="calquePhoto" style="cursor:se-resize;" src="{photo}" alt="photo" />
				</div>
				<form action="actions/redimentionement?pid={id_photo}{textarea2}" method="post">
					<fieldset>
						<legend>Nouvelles dimensions</legend>
						<input type="text" name="nWidth" id="nWidth" onchange="widthChange(this);" /> x 
						<input type="text" name="nHeight" id="nHeight" onchange="heightChange(this);" />
						<input type="submit" value="modifier" />
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