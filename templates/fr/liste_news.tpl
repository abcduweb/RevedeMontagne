<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	<a href="mes-news.html">Mes News</a> &gt;
	Liste de mes news
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Liste de vos news</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">
				<a href="rediger-news.html"><img src="{DOMAINE}/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a>
			</div>
			<table>
				<thead>
					<tr class="intitules_tabl">
						<th>Titre</th>
						<th>Date</th>
						<th>Statut</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="6">					
							<div class="wp-pagenavi">
								Page(s) : {liste_page}
							</div>
						</th>
					</tr>
				</tfoot>
			<tbody>
				<---listenews--->
				<tr  class="ligne{ligne}">
					<td class="col_titre"><a href="{news_url}-z{id}.html">{titrenews}</a></td>
					<td class="col_date">{date}</td>
					<td class="col_status">{statut}</td>
					<td class="centre">
						<a href="editer-{id}-news.html"><img src="{DOMAINE}/templates/images/1/form/edit.png" alt="Editer"></a>
						<a href="actions/action_news.php?action=3&amp;nid={id}"><img src="{DOMAINE}/templates/images/1/form/faire_valider.png" alt="Demander une validation"></a>
						<a href="actions/action_news.php?action=6&amp;nid={id}"><img src="{DOMAINE}/templates/images/1/form/supprimer.png" alt="Supprimer"></a></td>
					</td>
				</tr>
				</---listenews--->	
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