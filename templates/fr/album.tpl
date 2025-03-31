<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici :
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="album-photos.html">Album photos</a> &gt;
	<a href="album-{titre_url}-c{id_categorie}.html">{nv_categorie}</a> &gt;
	Affichage des photos 
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>{categorie}</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">
				<a href="ajouter-une-photo.html"<img src="templates/images/{design}/forum/ajout.png" alt="Ajouter une photo" /></a><br />
			</div>
			<table>
				<thead>
					<tr>
						<th>Nom de la photo</th>
						<th>Auteur / Description</th>
						<th>Commentaires</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="3">					
							<div class="wp-pagenavi">
								Page(s) : {liste_page}
							</div>
						</th>
					</tr>
				</tfoot>
				<tbody>
					<---Album--->
					<tr class="ligne{ligne}">
						<td class="titre_photo" colspan="3">{Album.titre}</td>
					</tr>
					<tr class="ligne{ligne}">
						<td class="apercus_image centre" rowspan="2">
							<a href="{Album.normal}" rel="test" title="{Album.titre}"><img src="{Album.mini}" alt="{Album.image}" /></a>
						</td>
						<td class="auteur_image">
							Propos&eacute;e par : {Album.auteur} {Album.date}
						</td>
						<td class="lien_com">
							<a href="photo-{Album.titre_photo_url}-commentaires-{Album.id_photo}.html">{Album.commentaire}</a>
						</td>
					</tr>
					<tr class="ligne{ligne}">
						<td class="com_image" colspan="3">{Album.commentaires}</td>
					</tr>
					</---Album--->
				</tbody>
			</table>
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

