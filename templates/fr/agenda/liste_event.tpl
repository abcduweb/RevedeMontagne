<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Prochains événements
</div>
<h1>Liste des prochains &eacute;v&eacute;nements</h1>
<table>
	<thead>
		<tr class="intitules_tabl">	
			<th>Date de l'&eacute;v&eacute;nement</th>
			<th>Nom de l'&eacute;v&eacute;nement</th>
			<th>lieu</th>
			{hcol_action}
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
		<---EVENT--->
		<tr>
			<td>{EVENT.datedeb} - {EVENT.datefin}</td>
			<td><a href="{EVENT.url_nom_event}-n{EVENT.id_event}.html">{EVENT.nom_event}</a></td>
			<td>{EVENT.lieu}</td>
			{EVENT.col_action}
		</tr>
		</---EVENT--->
	</tbody>
	</table>
<br />
<div class="bouton_forum">{ajout_event}</div>
<include file="../footer.tpl" />