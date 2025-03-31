<include file="../header.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; Liste de mes news</div>
		<h1>Liste des refuges</h1>
		
		<table>
			<thead>
				<tr>
					<th colspan="5" class="num_page">
						Page(s) : {liste_page}
					</th>
				</tr>
				<tr class="intitules_tabl">
					<th>Nom du refuge</th>
					<th>Massif</th>
					<th>Type</th>
					<th>Nombre d'images</th>
					<th>Mise à jour : </th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th colspan="5" class="num_page">Page(s) : {liste_page}</th>
				</tr>
			</tfoot>
			<tbody>
				<---listerefuge--->
				<tr>
					<td class="col_titre">{listerefuge.modif} <a href="detail-{listerefuge.nom_refuge_url}-{listerefuge.id_refuge}.html">{listerefuge.nom_refuge}</a></td>
					<td>{listerefuge.massif}</td>
					<td>{listerefuge.type}</td>
					<td>{listerefuge.img}</td>
					<td class="col_date">{date2}</td>
				</tr>
				</---listerefuge--->						
		</table>
		<br />
		<div class="bouton_forum">{ajout_refuge}</div>
	</div>
<include file="../footer.tpl" />