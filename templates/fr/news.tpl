<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici :
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="index.php">Les News</a> &gt;
		News Précédentes
	</div>
	
	<h1>Les news</h1>

	<table>
		<thead>
			<tr>
				<th>Icône</th>
				<th>Titre</th>
				<th>Date de publication</th>
				<th>Auteur</th>
				<th>Commentaire(s)</th>
				</tr>
		</thead>
		<tbody>
			<---NEWS--->	
			<tr>
				<td><img src="images/autres/1/mini/{icone}" alt="{titre_news}" style="width:50px;"/></td>
				<td>
					<h2>{titre_news}</h2>
					{texte-news}<br />
					<span class="lien_commentaires_news">{modifier_news} {supprimer_news} {devalider_news} {fermer_com}</span>
				</td>
				<td>
					{date-news}
				</td>
				<td>
					{pseudo}
				</td>
				<td>
					{comm}
				</td>
			</tr>
			</---NEWS--->
		</tbody>
		<tfoot>
			<tr>
				<th colspan="5">
					<div class="wp-pagenavi">
						Page(s) : {liste_page}
					</div>
				</th>
			</tr>
		</tfoot>
	</table>
<include file="footer.tpl" />