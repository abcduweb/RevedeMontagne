<include file="header.tpl" /> 
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt; 
		<a href="contributions.html">Mes Contributions</a> &gt;
		<a href="mes-articles.html">Mes Articles</a> &gt;
		Liste de mes articles
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Liste de mes articles</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div class="bouton_forum"><a href="ajouter-un-article.html"><img src="{DOMAINE}/templates/images/1/forum/ajout.png" alt="Ajouter une fiche"></a></div>
				<table>
					<thead>
						<tr>
							<th>Titre</th>
							<th>Statut</th>
							<th>Actions</th>
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
						<---ARTICLES--->
						<tr class="ligne{ligne}">
							<td class="gauche"><a href="{DOMAINE}article-{titre_url}-a{id}.html">{titre_article}</a></td>
							<td class="col_status">{statut}</td>
							<td class="centre">
								<a href="{DOMAINE}editer-article-{id}.html"><img src="{DOMAINE}/templates/images/1/form/edit.png" alt="Editer"></a>
								<a href="{DOMAINE}demande-validation-{id}.html"><img src="{DOMAINE}/templates/images/1/form/faire_valider.png" alt="Demander une validation"></a>
								<a href="{DOMAINE}actions/supprimer_article.php?artid={id}"><img src="{DOMAINE}/templates/images/1/form/supprimer.png" alt="Supprimer"></a>
							</td>
						</tr>
						</---ARTICLES--->
					</tbody>
				</table>
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
