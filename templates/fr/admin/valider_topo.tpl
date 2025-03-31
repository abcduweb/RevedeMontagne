<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt
	<a href="{DOMAINE}admin.html">administration</a> &gt
	<a href="{DOMAINE}valider-topos-randonnee.html">liste des topos &agrave; valider</a> &gt;
	Liste des topos
</div>

<h1>{nom_activite}</h1>	

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Valider des topos de {nom_activite}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			
			<form action="{DOMAINE}administration/valider_topo.php?idact={idact}" method="post">
			<input type="hidden" name="action" value="validate">
				<table>
					<thead>
						<tr class="intitules_tabl">
							<th>Nom du topo</th>
							<th class="centre">Massif</th>
							<th class="centre">Altitude</th>
							<th class="centre">Difficult&eacute;s topos</th>
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
							<td class="col_titre"><a href="topo-{listetopo.nom_topo_url}-tr{listetopo.id_topo}.html">{listetopo.nom_sommet}, {listetopo.nom_topo}</a></td>
							<td class="centre">{listetopo.massif}</td>
							<td class="centre">{listetopo.alt} m</td>
							<td class="centre">{listetopo.diff_topo}</td>
							<td class="col_autre"><input type="checkbox" name="pts[{listetopo.id_topo}]" /></td>
						</tr>
						</---listetopo--->						
				</table>
				
				<input type="submit" value="Valider les topos s&eacute;lectionn&eacute;e" onclick="this.value='Validation en cours...';">
				
			</form>
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