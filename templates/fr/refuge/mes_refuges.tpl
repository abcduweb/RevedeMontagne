<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="contributions.html">Mes Contributions</a> &gt;
		Liste des refuges, abris propos&eacute;s par {pseudo}
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Liste des refuges, abris propos&eacute;s par {pseudo}</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div class="bouton_forum">{ajout_som}</div>
				<table>
					<thead>
						<tr class="intitules_tabl">					
							<th>Nom du refuges</th>
							<th>Massif</th>
							<th>Altitude</th>
							<th>Type</th>
							{hcol_action}
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th colspan="{nb_colonne}">
								<div class="wp-pagenavi">
									Page(s) : {liste_page}
								</div>
							</th>
						</tr>
					</tfoot>
					<tbody>
						<---refuges--->
						<tr class="ligne{refuges.ligne}">
							<td class="col_titre"><a href="detail-{refuges.url_nom_refuges}-{refuges.id_refuge}-1.html">{refuges.nom_refuge}</a></td>
							<td>{refuges.mass}</td>
							<td>{refuges.denniveles} m</td>
							<td>{refuges.type}</td>
							{refuges.col_action}
						</tr>
						</---refuges--->
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
	</div>
<include file="../footer.tpl" />