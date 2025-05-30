<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	mes sorties
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste de mes sorties de randonn&eacute;es</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<table>
				<thead>
					<tr class="intitules_tabl">	
						<th>Date</th>
						<th>Nom de la sortie</th>
						<th>D&eacute;part</th>
						<th>Massif</th>
						<th>D&eacute;nivel&eacute;s</th>
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
					<---sorties--->
					<tr  class="ligne{sorties.ligne}">
						<td  class="centre">{sorties.date}</td>
						<td class="col_titre"><a href="{sorties.url_nom_sortie}-sortie-n{sorties.id_sortie}.html">{sorties.sommet}, {sorties.nom_sorties}</a></td>
						<td  class="centre"><a href="depart-{sorties.url_acces}-d{sorties.id_depart}.html">{sorties.acces}</a></td>
						<td  class="centre">{sorties.massif}</td>
						<td  class="centre">{sorties.deniveles} m</td>
						<td>{sorties.modif}</td>
					</tr>
					</---sorties--->
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

<include file="../footer.tpl" />