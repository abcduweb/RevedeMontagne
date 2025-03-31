<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="liste-des-sommets.html">liste des sommets</a> &gt;
		Liste des sommets
	</div>
	<h1>Liste des points à certifier</h1>	
	<form action="{DOMAINE}/administration/certifier_points.php" method="post">
	<input type="hidden" name="action" value="validate">
		<table>
			<thead>
				<tr class="intitules_tabl">
					<th>Nom du sommet</th>
					<th>Altitude</th>
					<th>Coordonnées GPS</th>
					<th>Type de point</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tfoot>
				<th colspan="5">					
					<div class="wp-pagenavi">
						Page(s) : {liste_page}
					</div>
				</th>
			</tfoot>
			<tbody>
				<---listepoints--->
				<tr>
					<td class="col_titre"><a href="detail-{listepoints.nom_som_url}-{listepoints.id_som}-2.html">{listepoints.nom_som}</a></td>
					<td>{listepoints.alt} m</td>
					<td>Lat : {listepoints.lat} / Long : {listepoints.lng}</td>
					<td>{listepoints.type}</td>
					<td class="col_autre"><input type="checkbox" name="pts[{listepoints.id_som}]" /></td>
				</tr>
				</---listepoints--->						
		</table>
		
		<input type="submit" value="Valider les points sélectionnées" onclick="this.value='Validation en cours...';">
		
	</form>
<include file="../footer.tpl" />