<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="admin.html">Administration</a> &gt;
		Gestion du groupe 
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Ajouter un groupe</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form action="actions/add_group.php" method="post">
					<fieldset>
						<legend>Autorisations g&eacute;n&eacute;rales</legend>
						<label for="group">Nom : </label>
						<input type="text" name="group" id="group" value="" /><br /><br />
						<table>
							<thead>
								<tr>
									<th colspan="12">
										Autorisations administratives
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="col_admin">Acc&eacute;s Administration</td>
									<td class="col_admin">modifier les news</td>
									<td class="col_admin">supprimer les news</td>
									<td class="col_admin">valider les news</td>
									<td class="col_admin">modifier les articles</td>
									<td class="col_admin">supprimer les articles</td>
									<td class="col_admin">ajouter des albums</td>
									<td class="col_admin">suprimer des albums</td>
									<td class="col_admin">Supprimer des photos</td>
									<td class="col_admin">modifier des commentaires</td>
									<td class="col_admin">supprimer des commmentaires</td>
									<td class="col_admin">punnir les membres</td>
								</tr>
								<tr>
									<td class="checked"><input type="checkbox" name="adminMenu" title="afficher menu Administration" /></td>
									<td class="checked"><input type="checkbox" name="global[modifier_news]" title="modifier toutes les news" /></td>
									<td class="checked"><input type="checkbox" name="global[supprimer_news]" title="supprimer toutes les news" /></td>
									<td class="checked"><input type="checkbox" name="global[valider_news]" title="valider toutes les news" /></td>
									<td class="checked"><input type="checkbox" name="global[modifier_topo]" title="modifier touts les articles" /></td>
									<td class="checked"><input type="checkbox" name="global[supprimer_topo]" title="supprimer touts les articles" /></td>
									<td class="checked"><input type="checkbox" name="global[ajouter_album]" title="ajouter des albums" /></td>
									<td class="checked"><input type="checkbox" name="global[supprimer_album]" title="suprimer des albums" /></td>
									<td class="checked"><input type="checkbox" name="global[supprimer_photo]" title="Supprimer toutes les photos" /></td>
									<td class="checked"><input type="checkbox" name="global[modifier_com]" title="modifier touts les commentaires" /></td>
									<td class="checked"><input type="checkbox" name="global[supprimer_com]" title="supprimer tous les commmentaires" /></td>
									<td class="checked"><input type="checkbox" name="global[ban]" {ban.checked} title="punnir les membres" /></td>
								</tr>
							</table>
							<table>
								<thead>
									<tr>
										<th colspan="6">
											<label for="other[]">Autorisations globales</label>
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="col_admin">ajout - modifier - supprimer ses photos</td>
										<td class="col_admin">ajout - modifier - supprimer ses news</td>
										<td class="col_admin">ajout - modifier - supprimer ses articles</td>
										<td class="col_adimn">r&eacute;daction officiel</td>
										<td class="col_admin">ajouter des commentaires</td>
										<td class="col_admin">Envoyer des MP</td>
									</tr>
									<tr>
										<td class="checked"><input type="checkbox" name="other[photos]" title="ajouter modifier supprimer ses photos" />
										<td class="checked"><input type="checkbox" name="other[news]" title="ajouter modifier supprimer ses news" />
										<td class="checked"><input type="checkbox" name="other[articles]" title="ajouter modifier supprimer ses articles" />
										<td class="checked"><input type="checkbox" name="other[redacOff]" title="r&eacute;daction officiel" />
										<td class="checked"><input type="checkbox" name="other[com]" title="ajouter des commentaires" />
										<td class="checked"><input type="checkbox" name="other[mp]" title="Envoyer des MP" />
									</tr>
								</tbody>
							</table>
						</fieldset>
						
						<fieldset>
						<legend>Autorisations sur les forums</legend>
							<---THEMES--->
							<table>
								<thead>
									<tr>
										<th colspan="7">
											{theme.titre}
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="6">Ajouter des forums</td>
										<td class="checked">
											<input type="checkbox" name="add_forum[{theme.id}]" title="ajouter des forum à cette cat&eacute;gorie" />
										</td>
									</tr>
									<---FORUM--->
									<tr>
										<td class="col_admin_titre_forum">Titre du forum</td>
										<td class="col_admin">ajouter message et sujet</td>
										<td class="col_admin">modifier tous les messages</td>
										<td class="col_admin">supprimer les messages</td>
										<td class="col_admin">lire le forum</td>
										<td class="col_admin">fermer les sujets</td>
										<td class="col_admin">d&eacute;placer un sujet</td>
									</tr>
									<tr>
										<td class="cel_admin_titre">{forum.titre}</td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][add]" title="ajouter message et sujet" /></td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][modifier]" title="modifier tous les messages" /></td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][supprimer]" title="supprimer les messages" /></td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][afficher]" title="lire le forum" /></td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][close]" title="fermer les sujets" /></td>
										<td class="checked"><input type="checkbox" name="auth[{forum.id}][move]" title="d&eacute;placer un sujet" /></td>
									</tr>
									</---FORUM--->
								</tbody>
							</table>
							</---THEMES--->
								<div class="send buttons">
									<button type="submit" value="Ajouter" class="positive">
										<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
										Ajouter
									</button>
								</div>
						</fieldset>
					</form>
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
