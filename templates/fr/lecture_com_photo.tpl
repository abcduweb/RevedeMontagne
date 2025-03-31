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
			<h1 id="commentaires">Commentaires</h1>
			<div class="bouton_forum">{repondre}</div>
			<table>
				<thead>
					<tr class="head_tableau">
						<th colspan="2" class="num_page">
						Page(s) : 
						<---PAGES--->
						{page}
						</---PAGES--->
						</th>
					</tr>
					<tr>
						<th class="taille_infos">Pseudo</th>
						<th>Commentaires</th>
					</tr>	
				</thead>
				<tfoot>
					<tr>
						<th colspan="2" class="num_page">
						Page(s) : 
						<---PAGES--->
						{page}
						</---PAGES--->
						</th>
					</tr>
				</tfoot>
				<tbody>
					<---COMM--->
					<tr id="r{id_com}"  class="ligne{ligne}">
						<td>
							<img src="{DOMAINE}/templates/images/{design}/grade/{status}.png" alt="{status}" /> {pseudo}
						</td>
						<td class="info_message">
							<a href="#r{id_com}">#</a> {date_com} {editer} {supprimer}
						</td>
					</tr>
					<tr  class="ligne{ligne}">
						<td class="infos_membre">
							{avatar}<br />
							{img_rang}
						</td>
						<td>
							<div class="boite_message">
								{commentaire} {signature}
							</div>
						</td>
					</tr>
					</---COMM--->
				</tbody>
			</table>
			<div class="bouton_forum">{repondre}</div>
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