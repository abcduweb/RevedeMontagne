<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-montagnards.html">Liste des Montagnards</a> &gt;
	Liste des membres
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Les Montagnards du site</h2>			
		</div>
	</div> 
	
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<table>
				<thead>
					<tr class="head_tableau">
						<th><a href="liste-montagnards.html?type=id&amp;order={order_id}{search}{page}">#</a></th>
						<th><a href="liste-montagnards.html?type=pseudo&amp;order={order_pseudo}{search}{page}">Pseudo</a></th>
						<th><a href="liste-montagnards.html?type=groupe&amp;order={order_group}{search}{page}">Groupe</a></th>
						<th><a href="liste-montagnards.html?type=inscription&amp;order={order_inscription}{search}{page}">Date d&acute;inscription</a></th>
						<th><a href="liste-montagnards.html?type=connexion&amp;order={order_connexion}{search}{page}">Derni&egrave;re connexion</a></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					<th colspan="5">					
						<div class="wp-pagenavi">
							Page(s) : {liste_page}
						</div>
					</th>
					</tr>
				</tfoot>
				<tbody class="centre">
					<---MEMBRE--->
					<tr class="ligne{ligne}">
						<td>{mid}</td>
						<td class="gauche"><a href="membres-{mid}-fiche.html">{pseudo}</a></td>
						<td>{groupe}</td>
						<td>{date_inscription}</td>
						<td>{date_log}</td>
					</tr>
					</---MEMBRE--->
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
<include file="footer.tpl" />