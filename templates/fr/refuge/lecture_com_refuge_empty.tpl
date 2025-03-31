<include file="header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="album-photos.html">Les Albums</a> &gt; <a href="album-{titre_album_url}-c{id_album}.html">{titre_album}</a> &gt; Commentaires {titre_photo}</div>
		<h1>{titre_photo}</h1>
		<div class="centre">
			<img src="images/album/{dir}/{photo}" alt="" style="width:{width}px;height:{height}px;" />
		</div>
		<br />
		<div class="text-article centre">
			Il n'y a encore aucun commentaire sur cette photo. <br />
			{repondre}
		</div>
		<br /><br />
	</div>
<include file="footer.tpl" />