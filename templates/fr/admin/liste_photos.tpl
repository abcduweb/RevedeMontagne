<include file="../header.tpl" />

<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt; 
	<a href="admin.html">Administration</a> &gt; 
	Liste des photos
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des photos</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<table>
				<thead>
					<tr>
						<th colspan="5" class="num_page">
							Page(s) : {liste_page}
						</th>
					</tr>
					<tr class="intitules_tabl">
						<th>Photos</th>
						<th>Album</th>
						<th>Modifier</th>
						<th>Supprimer</th>
						<th>Déplacer</th>
					</tr>
				</thead>
				<tfoot>
						<tr>
							<th colspan="5" class="num_page">
								Page(s) : {liste_page}
							</th>
						</tr>
				</tfoot>
				<tbody>
					<---IMAGES--->
					<tr>
						<td class="col_titre"><a href="#" class="info" title="{images}" onmouseover="tooltip.show(this,'toolmini','load_photos();');">{titre_photo}</a></td>
						<td class="col_status">{regroupement} =&gt; {categorie}</td>
						<td class="col_modifier"><a href="modifier-photos-{id}.html">Modifier</a></td>
						<td class="col_supprimer"><a href="actions/supprimer_photo.php?pid={id}">Supprimer</a></td>
						<td class="col_publier"><a href="deplacer-photos-{id}.html">Déplacer</a></td>
					</tr>
					</---IMAGES--->
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