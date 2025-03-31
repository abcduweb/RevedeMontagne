<include file="header.tpl" />
	<div id="corps">
		<div class="arbre">
			Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-refuge.html">Liste des refuges</a> &gt; <a href="detail-{titre_refuge_url}-{id_refuge}.html">{titre_refuge}</a> &gt; Commentaires {titre_photo}
		</div>
		<h1>{titre_photo}</h1>
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
				<tr id="r{id_com}">
					<td>
						<img src="{DOMAINE}/templates/images/{design}/grade/{status}.png" alt="{status}" /> {pseudo}
					</td>
					<td class="info_message">
						<a href="#r{id_com}">#</a> {date_com} {editer} {supprimer}
					</td>
				</tr>
				<tr>
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
		<br /><br />
	</div>
<include file="footer.tpl" />