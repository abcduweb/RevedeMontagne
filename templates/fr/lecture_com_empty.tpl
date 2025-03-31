<include file="./headers/header_common_head.tpl" />
<include file="./headers/header_common_body.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="{DOMAINE}index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="{DOMAINE}liste-des-actualites.html">Les News</a> &gt;
	{titre_news} 
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{titre_news}</h2>			
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div class="admin_news">{supprimer_news} {devalider_news} {fermer_com} {modifier_news}</div>
			<h2>par {pseudo_auteur} le : {date_news}</h2>
			{texte_news}
			<div class="partage">
				<div class="addthis_sharing_toolbox"></div>
			</div>
			<div class="reprapide">
					{reponse_rapide}
				<h2>Pas de commentaires</h2>
			</div>	
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