<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="admin.html">Administration</a> &gt;
	Liste des membres
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des Membres</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">

			<table>
				<thead>
					<tr class="intitules_tabl">
						<th>Pseudo</th>
						<th>Groupe</th>
						<th>IP</th>
						<th>Pourcent</th>
						<th>Changer de groupe</th>
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
				<---MEMBRES--->
					<tr>
						<td class="col_autre"><a href="membres-{idMembre}-fiche.html">{pseudo}</a></td>
						<td class="col_autre">{groupe}</td>
						<td class="col_autre"><a href="actions/ban.php?ip={ip}">{ip}</a></td>
						<td>{punir}</td>
						<td>{changer_groupe}</td>
					</tr>
				</---MEMBRES--->
				</tbody>
			</table>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp	
			</div>
		</div>
	</div>
</div>

<include file="../footer.tpl" />
