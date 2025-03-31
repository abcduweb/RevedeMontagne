<include file="header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="index.php">Les News</a> &gt; Commentaires {titre_news} </div>
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
		<div class="reprapide">
			{reponse_rapide}
			<h2>Pas de commentaires</h2>
		</div>
	</div>
<include file="footer.tpl" />