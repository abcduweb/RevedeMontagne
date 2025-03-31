<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-carte-ign.html">liste des cartes</a> &gt;
	Liste des cartes
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des cartes</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">{ajout_som}</div>		
			<table>
				<thead>
					<tr class="intitules_tabl">
						<th>Num carte</th>
						<th>Intitulé</th>
						<th>Série</th>
						<th>Echelle</th>
					</tr>
				</thead>
				<tfoot>
					<th colspan="4">					
						<div class="wp-pagenavi">
							Page(s) : {liste_page}
						</div>
					</th>
				</tfoot>
				<tbody>
					<---IGN--->
					<tr>
						<td>{IGN.numcarte}</td>
						<td><a href="carte-ign-{IGN.url}-n{IGN.pid}.html">{IGN.nomcarte}</a></td>
						<td>{IGN.serie}</td>
						<td>{IGN.echelle}</td>
					</tr>
					</---IGN--->						
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