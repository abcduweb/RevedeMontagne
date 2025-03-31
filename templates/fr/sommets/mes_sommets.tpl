<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="contributions.html">Mes Contributions</a> &gt;
		Liste des sommets propos&eacute;s par {pseudo}
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Liste des sommets propos&eacute;s par {pseudo}</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div class="bouton_forum">{ajout_som}</div>		
					<table>
						<thead>
							<tr class="intitules_tabl">
								<th>Nom du sommet</th>
								<th>Massif</th>
								<th>Altitude</th>
								<th>Coordonnées GPS</th>
								<th>Type de point</th>
								{hcol_action}
							</tr>
						</thead>
						<tfoot>
							<th colspan="{nb_colonne}">					
								<div class="wp-pagenavi">
									Page(s) : {liste_page}
								</div>
							</th>
						</tfoot>
						<tbody>
							<---listesom--->
							<tr class="ligne{listesom.ligne}">
								<td class="col_titre"><a href="detail-{listesom.nom_som_url}-{listesom.id_som}-2.html">{listesom.nom_som}</a></td>
								<td>{listesom.mass}</td>
								<td>{listesom.alt} m</td>
								<td>Lat : {listesom.lat} / Long : {listesom.lng}</td>
								<td>{listesom.type}</td>
								{listesom.col_action}
							</tr>
							</---listesom--->						
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