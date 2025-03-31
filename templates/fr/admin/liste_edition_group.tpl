<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt
	<a href="{DOMAINE}admin.html">administration</a> &gt
	Gestion du groupe {nom_group}
</div>

<h1>{nom_group}</h1>	

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Edition {nom_group}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action="actions/edit_group.php?gid={id_group}" method="post">
				<fieldset>	
					<legend>Autorisations g&eacute;n&eacute;rales</legend>
					<label for="groupName">Nom : </label>
					<input type="text" name="groupName" value="{nom_group}" /><br /><br />
					<table>
						<thead>
							<tr>
								<th colspan="9">
									Gestion des news, articles, photos
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
							</tr>
						<tr>
							<td class="checked"><input type="checkbox" name="adminMenu" {admin.checked} title="afficher menu Administration" /></td>
							<td class="checked"><input type="checkbox" name="global[modifier_news]" {modifier_news.checked} title="modifier toutes les news" /></td>
							<td class="checked"><input type="checkbox" name="global[supprimer_news]" {supprimer_news.checked} title="supprimer toutes les news" /></td>
							<td class="checked"><input type="checkbox" name="global[valider_news]" {valider_news.checked} title="valider toutes les news" /></td>
							<td class="checked"><input type="checkbox" name="global[modifier_topo]" {modifier_topo.checked} title="modifier touts les articles" /></td>
							<td class="checked"><input type="checkbox" name="global[supprimer_topo]" {supprimer_topo.checked} title="supprimer touts les articles" /></td>
							<td class="checked"><input type="checkbox" name="global[ajouter_album]" {ajouter_album.checked} title="ajouter des albums" /></td>
							<td class="checked"><input type="checkbox" name="global[supprimer_album]" {supprimer_album.checked} title="suprimer des albums" /></td>
							<td class="checked"><input type="checkbox" name="global[supprimer_photo]" {supprimer_photo.checked} title="Supprimer toutes les photos" /></td>
						</tr>
					</table>
					
										<table>
						<thead>
							<tr>
								<th colspan="3">
									Gestion des commentaires
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="col_admin">modifier des commentaires</td>
								<td class="col_admin">supprimer des commmentaires</td>
								<td class="col_admin">punnir les membres</td>
							</tr>
							<tr>
								<td class="checked"><input type="checkbox" name="global[modifier_com]" {modifier_com.checked} title="modifier touts les commentaires" /></td>
								<td class="checked"><input type="checkbox" name="global[supprimer_com]" {supprimer_com.checked} title="supprimer tous les commmentaires" /></td>
								<td class="checked"><input type="checkbox" name="global[ban]" {ban.checked} title="punnir les membres" /></td>
							</tr>
					</table>
					
					
					<table>
						<thead>
							<tr>
								<th colspan="6">
									Autorisations globales
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="col_admin">ajout - modifier - supprimer ses photos</td>
								<td class="col_admin">ajout - modifier - supprimer ses news</td>
								<td class="col_admin">ajout - modifier - supprimer ses articles</td>
								<td class="col_admin">r&eacute;daction officiel</td>
								<td class="col_admin">ajouter des commentaires</td>
								<td class="col_admin">Envoyer des MP</td>
							</tr>
							<tr>
								<td class="checked"><input type="checkbox" name="other[photos]" {photos.checked} title="ajouter modifier supprimer ses photos" />
								<td class="checked"><input type="checkbox" name="other[news]" {news.checked} title="ajouter modifier supprimer ses news" />
								<td class="checked"><input type="checkbox" name="other[articles]" {articles.checked} title="ajouter modifier supprimer ses articles" />
								<td class="checked"><input type="checkbox" name="other[redacOff]" {redacOff.checked} title="r&eacute;daction officiel" />
								<td class="checked"><input type="checkbox" name="other[com]" {com.checked} title="ajouter des commentaires" />
								<td class="checked"><input type="checkbox" name="other[mp]" {mp.checked} title="Envoyer des MP" />
							</tr>
						</tbody>
					</table>
				</fieldset>
				<fieldset>
					<legend>Autorisations sur les forums</legend>
				
					<---THEMES--->
					<table>
						<thead>
							<tr><th colspan="7">{theme.titre}</th></tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="6">Ajouter des forums</td>
								<td class="checked"><input type="checkbox" name="add_forum[{theme.id}]" {add_forum.checked} title="ajouter des forum à cette cat&eacute;gorie" /></td>
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
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][add]" {add.checked} title="ajouter message et sujet" /></td>
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][modifier]" {modifier.checked} title="modifier tous les messages" /></td>
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][supprimer]" {supprimer.checked} title="supprimer les messages" /></td>
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][afficher]" {afficher.checked} title="lire le forum" /></td>
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][close]" {close.checked} title="fermer les sujets" /></td>
								<td class="checked"><input type="checkbox" name="auth[{forum.id}][move]" {move.checked} title="d&eacute;placer un sujet" /></td>
							</tr>
					</---FORUM--->
						</tbody>
					</table>
					</---THEMES--->
						<div class="send buttons">
							<button type="submit" value="Editer" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Editer"/> 
								Editer
							</button>
						</div>
				</fieldset>
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