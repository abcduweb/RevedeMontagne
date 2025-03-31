<include file="./header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Actualités
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Actualités</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<table>
				<thead>
					<tr class="intitules_tabl">					
						<th>Date</th>
						<th>titre</th>
						<th>Auteur</th>
						<th>nombre commentaire(s)</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="4">
							<div class="wp-pagenavi">
								Page(s) : {liste_page}
							</div>
						</th>
					</tr>
				</tfoot>
				<tbody>
					<---NEWS--->
					<tr class="ligne{NEWS.ligne}">
						<td class="centre">{NEWS.date}</td>
						<td><a href="commentaires-de-{NEWS.url_news}-n{NEWS.id_news}.html#commentaires">{NEWS.nom_news}</a></td>
						<td class="centre">{NEWS.pseudo}</td>
						<td class="centre">{NEWS.nbcomm}</td>
					</tr>
					</---NEWS--->
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
<include file="./footer.tpl" />