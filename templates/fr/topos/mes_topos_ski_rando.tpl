<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	mes topos
</div>
<h1>Liste des topos de skis de randonn&#233;es</h1>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Mes topos de skis de randonnées</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd centre">
			<div class="bouton_forum">
				{ajout_som}
			</div>
			<table>
				<thead>
					<tr class="intitules_tabl">					
						<th>Nom du topos</th>
						<th>Activit&#233;</th>
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
					<---topo--->
					<tr  class="ligne{topo.ligne}">
						<td class="gauche"><a href="{topo.url_nom_topo}-t{topo.id_topo}.html">{topo.nom_sommet}, {topo.nom_topo}</a></td>
						<td><img src="{DOMAINE}templates/images/1/activites/{topo.idact}.png" alt="" /></td>
						<td>{topo.mass}</td>
						<td>{topo.denniveles} m</td>
						<td>{topo.modif}</td>
					</tr>
					</---topo--->
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