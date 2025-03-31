<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="mes-news.html">Mes News</a> &gt;
		Liste de mes news
	</div>
	<h1>Liste de vos fiches refuge</h1>
	<a href="rediger-news.html">Rédiger une nouvelle fiche</a>
		<table>
			<thead>
				<tr class="intitules_tabl">
					<th>Icones</th>
					<th>Nom du refuge</th>
					<th>Massif</th>
					<th>Type</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th colspan="7">					
						<div class="wp-pagenavi">
							Page(s) : {liste_page}
						</div>
					</th>
				</tr>
			</tfoot>
			<tbody>
				<---listenews--->
				<tr>
					<td><img src="images/autres/1/mini/{icone}" alt="{titrenews}" style="width:50px;"/></td>
					<td class="col_titre"><a href="commentaires-de-{news_url}-n{id}.html">{titrenews}</a></td>
					<td class="col_modifier"><a href="editer-{id}-news.html">Modifier</a></td>
					<td class="col_supprimer"><a href="actions/action_news.php?action=6&amp;nid={id}">Supprimer</a></td>
					<td class="col_publier"><a href="actions/action_news.php?action=3&amp;nid={id}">Publier</a></td>
					<td class="col_date">{date}</td>
					<td class="col_status">{statut}</td>
				</tr>
				</---listenews--->	
			</tbody>
		</table>
<include file="footer.tpl" />