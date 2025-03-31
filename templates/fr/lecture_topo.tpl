<include file="header.tpl" />            
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<---NIVEAUX--->
		{adresse} &gt;
	</---NIVEAUX--->
	{final} &gt; Lecture d'un article
</div>

<h1>{titre_article}</h1>
<h2><strong>Date de publication :</strong> {date-creation}</h2>
<div class="cadregd">
	<div class="cadre_droite3">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Auteur</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd centre">
				<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="{DOMAINE}membres-{id_m}-fiche.html">{pseudo}</a>	<br />
				<div class="avatar-imp">{avatar}</div>					
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
	<div class="cadre_gauche3">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Sommaire</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul class="sommaire_parties">
					<---PARTIE--->
						<li><a href="article-{titre_url}-a{id_article}-p{num}.html">{titre}</a></li>
					</---PARTIE--->
				</ul>	
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
</div>


	
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				&nbsp;
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			{MEG}
			<div class="text-article">
				{intro}
				{titre_part}
				{texte_part}
				{conclu}
			</div>
			
			<div class="lien_bas">{prev} {next}</div>
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
