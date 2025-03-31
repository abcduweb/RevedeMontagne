<include file="../header.tpl" />
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des articles {type}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<span class="arbre">
				Vous &#234;tes ici : 
				<a href="index.php">R&ecirc;ve de montagne</a> &gt; 
				<a href="admin.html">Administration</a> &gt;
				Liste des articles {type}
			</span>
			<table class= "listemess">
				<thead>
					<tr class="intitules_tabl">
						<th>Titre</th>
						<th>Actions</th>
						<th>Cat&eacute;gorie</th>
						<th>D&eacute;placer</th>
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
					<---ARTICLES--->
					<tr  class="ligne{ligne}">
						<td class="titrenews"><a href="article-{titre_url}-a{id}.html">{titre_article}</a></td>
						<td>
							<a href="editer-article-{id}.html"><img src="{DOMAINE}/templates/images/1/form/edit.png" alt="Editer"></a>
							{validation}
							<a href="actions/supprimer_article.php?artid={id}"><img src="{DOMAINE}/templates/images/1/form/supprimer.png" alt="Supprimer"></a>
							
						</td>

						<td class="statut">{cat}</td>
						<td>{deplacer}</td>
					</tr>
					</---ARTICLES--->
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
<include file="../footer.tpl" />
