<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici :
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Liste des traces gpx
</div>
	
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des traces</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div class="bouton_forum">{ajout}</div>
			<table>
				<thead>
					<tr class="intitules_tabl">
						<th><a href="liste-des-traces-gpx.html?type=id&amp;order={order_id}{page}">ID</a></th>
						<th><a href="liste-des-traces-gpx.html?type=date&amp;order={order_date}{page}">Date d'ajout</a></th>
						<th><a href="liste-des-traces-gpx.html?type=nom&amp;order={order_nom}{page}">Nom de la trace</a></th>
						<th><a href="liste-des-traces-gpx.html?type=dpt&amp;order={order_dpt}{page}">D&eacute;partement</a></th>
						<th><a href="liste-des-traces-gpx.html?type=activite&amp;order={order_activite}{page}">Activite</a></th>
						<th><a href="liste-des-traces-gpx.html?type=longueur&amp;order={order_longueur}{page}">Longueur</a></th>
						<th><a href="liste-des-traces-gpx.html?type=duree&amp;order={order_duree}{page}">Dur&eacute;e</a></th>
						<th><a href="liste-des-traces-gpx.html?type=alt_max&amp;order={order_alt_max}{page}">Altitude max</a></th>
						<th><a href="liste-des-traces-gpx.html?type=alt_mini&amp;order={order_alt_mini}{page}">Altitude mini</a></th>
						<th><a href="liste-des-traces-gpx.html?type=dennivele&amp;order={order_dennivele}{page}">D&eacute;nivel&eacute;</th>
						<th><a href="liste-des-traces-gpx.html?type=pseudo&amp;order={order_pseudo}{page}">Auteur</th>
						<th></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="12">					
							<div class="wp-pagenavi">
								Page(s) : {liste_page}
							</div>
						</th>
					</tr>
				</tfoot>
				<tbody>
					<---TRACE--->
					<tr>
						<td class="centre">{TRACE.id}</td>
						<td class="centre">{TRACE.date}</td>
						<td><a href="map-{TRACE.url_nom}-m{TRACE.cle}.html">{TRACE.Nom_trace}</a></td>					
						<td class="centre"><a href="#">{TRACE.departement}</a></td>
						<td class="centre"><a href="#">{TRACE.activite}</a></td>
						<td class="centre">{TRACE.longueur}kms</td>
						<td class="centre">{TRACE.duree}</td>
						<td class="centre">{TRACE.altmax}m</td>
						<td class="centre">{TRACE.altmin}m</td>
						<td class="centre">{TRACE.deni}m</td>
						<td class="centre"><a href="membres-{TRACE.mid}-fiche.html">{TRACE.pseudo}</a></td>
						<td class="centre">{TRACE.actions}</td>
					</tr>
					</---TRACE--->	
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