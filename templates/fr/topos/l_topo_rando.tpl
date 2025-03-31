<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Topos de randonn&#233es
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des topos de randonn&#233;es</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">{ajout_som}</div>
			<table>
				<thead>
					<tr class="intitules_tabl">			
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=id&amp;order={order_id}{search}{page}">#</a></th>
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=nomtopo&amp;order={order_nomtopo}{search}{page}">Nom du topos</a></th>
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=activitee&amp;order={order_activitee}{search}{page}">Activit&#233;e</a></th>
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=massif&amp;order={order_massif}{search}{page}">Massif</a></th>
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=denniveles&amp;order={order_denniveles}{search}{page}">denniveles</a></th>
						<th><a href="{DOMAINE}liste-des-topos-de-randonnee.html?type=auteur&amp;order={order_auteur}{search}{page}">Auteur</a></th>
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
					<---topo--->
					<tr  class="ligne{topo.ligne}">
						<td class="centre">{topo.id_topo}</td>
						<td class="col_titre"><a href="{topo.url_nom_topo}-tr{topo.id_topo}.html">{topo.nom_sommet}, {topo.nom_topo}</a></td>
						<td class="centre">{topo.activite}</td>
						<td class="centre">{topo.mass}</td>
						<td class="centre">{topo.denniveles} m</td>
						<td class="centre"><a href="membres-{topo.id_m}-fiche.html">{topo.auteur}</a></td>
						{topo.col_action}
					</tr>
					</---topo--->
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