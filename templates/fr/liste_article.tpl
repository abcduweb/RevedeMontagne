<include file="header.tpl" />      
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<---NIVEAUX--->
	{adresse} &gt;
	</---NIVEAUX--->
	{final} &gt; Liste d'une cat&eacute;gorie
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Cat&eacute;gories des articles</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			{categorie_enter}
			<---CATEGORIES--->
				<tr>
					<td class="titre_cat_article"><a href="categories-des-articles-{id_cat}.html">{titre_cat}</a></td>
					<td class="nb_article">{nombre_article}</td>
				</tr>
			</---CATEGORIES--->
			{categorie_out}
			<br />
			{articles_enter}
			<---ARTICLES--->
				<tr  class="ligne{ligne}">
					<td class="titre_article">
						<a href="article-{titre_url}-a{id_article}.html">{titre}</a>
					</td>
					<td class="auteur_article">
						<a href="membres-{id_auteur}-fiche.html">{auteur}</a>
					</td>
					<td class="date_article">
						{date}
					</td>
				</tr>
			</---ARTICLES--->
			</tbody>
			{articles_out}
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