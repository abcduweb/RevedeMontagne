<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		Liste des d&eacute;parts
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Liste des d&eacute;parts</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<table>
					<thead>
						<tr class="intitules_tabl">					
							<th>Nom du topos</th>
							<th>Activité</th>
							<th>Massif</th>
							<th>Altitude</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th colspan="7">
								<div class="wp-pagenavi">
									Page(s) : {liste_page}
								</div>
							</th>
						</tr>
					</tfoot>
					<tbody>
						<---depart--->
						<tr class="ligne{depart.ligne}">
							<td class="col_titre"><a href="{depart.url_nom_depart}-d{depart.id_depart}.html">{depart.nom_depart}</a></td>
							<td>{depart.acces}</td>
							<td class="centre">{depart.massif}</td>
							<td class="centre">{depart.altitude} m</td>
							<td class="centre">{depart.modif}</td>
						</tr>
						</---depart--->
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