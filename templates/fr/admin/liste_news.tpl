<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="admin.html">Administration</a> &gt;
	Liste des news {status}
</div>
	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Les news {status}</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<table class= "listemess">
					<thead>
						<tr class="intitules_tabl">
							<th>Titre news</th>
							<th>Auteur</th>
							<th>Date</th>
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
					<---NEWS--->
						<tr class="ligne{ligne}">
							<td><a href="{NEWS.url_news}-z{NEWS.id_news}.html#commentaires">{titre_news}</a></td>
							<td>par {pseudo} </td>
							<td>le : {date-news}</td>
							<td class="modifier">{modifier_news} {devalider_news} {supprimer_news}</td>
						</tr>
					</---NEWS--->
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