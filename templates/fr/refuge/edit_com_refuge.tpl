<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="album-photos.html">Album photos</a> &gt; <a href="album-{titre_album_url}-c{id_album}.html">{titre_album}</a> &gt; Editer un commentaire</div>
		<h1>Editer Commentaire</h1>
		<form action="actions/edit_com_refuge.php?m={msg}" method="post" name="formulaire">
			<fieldset>
				<legend>Editer un commentaire</legend>
				<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-6-{id_refuge}-texte.html" />
				<div class="send buttons">
					<button type="submit" name="send" value="Editer" class="positive">
						<img src="./templates/images/{design}/tick.png" alt="Editer"/> 
						Editer
					</button>
				</div>
			</fieldset>
		</form>
		<---LISTE_MSG--->
		<div class="liste_dernier_message">
			<table>
				<thead>
					<tr class="head_tableau">
						<th class="taille_infos">Auteur</th>
						<th>Commentaire</th>
					</tr>
				</thead>
				<tbody>
					<---COMM--->
					<tr id="r{id_com}">
						<td>
							<img src="{DOMAINE}/templates/images/{design}/grade/{status}.png" alt="{status}" /> {pseudo}
						</td>
						<td class="info_message">
							<a href="#r{id_com}">#</a> {date_com}
						</td>
					</tr>
					<tr>
						<td class="infos_membre">
							{avatar}<br />
							{img_rang}
						</td>
						<td>
							<div class="boite_message">
								{commentaire} {signature}
							</div>
						</td>
					</tr>
				</---COMM--->
				</tbody>
			</table>
		</div>
		</---LISTE_MSG--->
	</div>
<include file="../footer.tpl" />