<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="album-photos.html">Les Albums</a> &gt;
	<a href="album-{titre_album_url}-c{id_album}.html">{titre_album}</a> &gt;
	Commentaires {titre_photo}
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>{titre_photo}</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="centre">
				<img src="images/album/{dir}/{photo}" alt="" style="width:{width}px;height:{height}px;" />
			</div>
			<br />
			<div class="text-article centre">
				Il n'y a encore aucun commentaire sur cette photo. <br />
				{repondre}
			</div>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp	
			</div>
		</div>
	</div>
</div>
<include file="footer.tpl" />