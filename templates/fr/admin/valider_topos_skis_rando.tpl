<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="valider-topos-skis-rando.html">liste des topos à valider</a> &gt;
		Liste des topos
	</div>
	<h1>Valider des topos de skis de randonnées</h1>	
	<form action="{DOMAINE}/administration/valider_topo_skis_rando.php" method="post">
	<input type="hidden" name="action" value="validate">
		<table>
			<thead>
				<tr class="intitules_tabl">
					<th>Nom du topo</th>
					<th>Massif</th>
					<th>Altitude</th>
					<th>Difficultés skis</th>
					<th>Difficultés topos</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tfoot>
				<th colspan="6">					
					<div class="wp-pagenavi">
						Page(s) : {liste_page}
					</div>
				</th>
			</tfoot>
			<tbody>
				<---listetopo--->
				<tr>
					<td class="col_titre"><a href="topo-{listetopo.nom_topo_url}-t{listetopo.id_topo}.html">{listetopo.nom_sommet}, {listetopo.nom_topo}</a></td>
					<td>{listetopo.massif}</td>
					<td>{listetopo.alt} m</td>
					<td>{listetopo.diff_skis}</td>
					<td>{listetopo.diff_topo}</td>
					<td class="col_autre"><input type="checkbox" name="pts[{listetopo.id_topo}]" /></td>
				</tr>
				</---listetopo--->						
		</table>
		
		<input type="submit" value="Valider les topos s&eacute;lectionn&eacute;e" onclick="this.value='Validation en cours...';">
		
	</form>
<include file="../footer.tpl" />