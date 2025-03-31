<include file="../header.tpl" />
	
	<div class="arbre">
		Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="admin.html">Administration</a> &gt; Liste des albums photos 
	</div>
	
	<div class="cadre">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Liste des albums photos</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">

				<div id="admin_album">
					<div class="admin_fauneflore">
						<h2>Faune/flore</h2>
						<table class="listemess">
							<thead>
								<tr class="intitules_tabl"><th>Cat&eacute;gorie</th><th>Nombre</th><th>D&eacute;placer</th><th>Supprimer</th></tr>
							</thead>
							<tbody>
							<---fauneflore--->
							<tr>
							<td>{fauneflore.regroupement}</td><td class="admin_nb_images">{fauneflore.nb} images</td><td class="deplacer">{fauneflore.deplacer}</td><td class="supprimer">{fauneflore.supprimer}</td>
							</tr>
							</---fauneflore--->
							</tbody>
						</table>
					</div>
							
					<div class="admin_activites">
						<h2>Activit&eacute;s sportives</h2>
						<table class="listemess">
							<thead>
								<tr class="intitules_tabl"><th>Cat&eacute;gorie</th><th>Nombre</th><th>D&eacute;placer</th><th>Supprimer</th></tr>
							</thead>
							<tbody>
							<---activites--->
							<tr>
							<td>{activites.regroupement}</td><td class="admin_nb_images">{activites.nb} images</td><td class="deplacer">{activites.deplacer}</td><td class="supprimer">{activites.supprimer}</td>
							</tr>
							</---activites--->
							</tbody>
						</table>
					</div>
							
					<div class="admin_divers">
						<h2>Divers</h2>
						<table class="listemess">
							<thead>
								<tr class="intitules_tabl"><th>Cat&eacute;gorie</th><th>Nombre</th><th>D&eacute;placer</th><th>Supprimer</th></tr>
							</thead>
							<tbody>
							<---divers--->
							<tr>
							<td>{divers.regroupement}</td><td class="admin_nb_images">{divers.nb} images</td><td class="deplacer">{divers.deplacer}</td><td class="supprimer">{divers.supprimer}</td>
							</tr>
							</---divers--->
							</tbody>
						</table>
					</div>
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