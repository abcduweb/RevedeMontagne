<include file="header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="index.php">Les News</a> &gt; {titre_news} </div>
		<h1>{titre_news}</h1>
		<div class="conteneur_news">
			<div class="news_hg">
				<div class="news_hd">
					<h2>{titre_news}</h2>
				</div>
			</div>
			<div class="news_cg">
				<div class="news_cd">
					<div class="auteur_date_commentaire">
						par {pseudo_auteur} le : {date_news}
					</div>
				{texte_news}
				</div>
			</div>
			<div class="news_bg">
				<div class="news_bd">
					<div class="news_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>
		<h1 id="commentaires">Commentaires</h1>
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
						<img src="{DOMAINE}/templates/images/{design}/grade/{statut}.png" alt="{statut}" /> {pseudo}
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
		<div class="reprapide">
			{reponse_rapide}
		</div>
		<br /><br />
	</div>
<include file="footer.tpl" />