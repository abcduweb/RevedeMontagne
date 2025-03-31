<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="admin.html">Administration</a> &gt;
		Gestion des groupes
	</div>
	<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des groupes</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<table>
				<thead>
					<tr class="intitules_tabl">
						<th>Nom</th>
						<th class="modifier">Modifier</th>
						<th class="supprimer">Supprimer</th>
					</tr>
				</thead>
				<tbody>
					<---GROUPES--->
					<tr>
						<td class="col_titre">{nom}</td>
						<td class="col_modifier"><a href="editer-groupes-{id}.html">Modifier</a></td>
						<td class="col_supprimer"><a href="actions/supprimer_group.php?gid={id}">Supprimer</a></td>
					</tr>
					</---GROUPES--->
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