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
				<h2 id="commentaires">Commentaires</h2>
				<table>
					<thead>
						<tr>
							<th class="taille_infos">Pseudo</th>
							<th>Commentaires</th>
						</tr>	
					</thead>
					<tfoot>
						<tr>
							<th colspan="2">
								<div class="wp-pagenavi">
									Page(s) : <---PAGES--->{page}</---PAGES--->
								</div>
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