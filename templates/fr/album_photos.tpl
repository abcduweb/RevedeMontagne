<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="album-photos.html">Album photos</a> &gt;
		Liste des albums photos
	</div>
	
	<h1>Album Photos (choix de la categorie)</h1>
	
	<div class="fauneflore">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Faune/flore</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<---fauneflore--->
					<li><span class="liste_img">{fauneflore.regroupement}</span> ({fauneflore.nb} images)</li>
					</---fauneflore--->
				</ul>

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
	<div class="activites">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Activités sportives</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<---activites--->
					<li><span class="liste_img">{activites.regroupement}</span>({activites.nb} images)</li>
					</---activites--->
				</ul>
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
	<div class="divers">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Divers</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<---divers--->
					<li><span class="liste_img">{divers.regroupement}</span> ({divers.nb} images)</li>
					</---divers--->
				</ul>
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