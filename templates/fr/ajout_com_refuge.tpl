<include file="../header.tpl" />
	<div id="corps">
		<div class="arbre">
			Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-refuge.html">liste des refuges</a> &gt; <a href="detail-{titre_refuge_url}-{id_refuge}.html">{titre_refuge}</a> &gt; Commentaires {titre_refuge}
		</div>
		<h1>Nouveau Commentaire</h1>
		<form action="actions/submit_com_refuge.php?pid={id_photo}" method="post" name="formulaire">
			<fieldset>
				<legend>Ajouter un commentaire</legend>
				<div class="dnone"><input type="hidden" value="e5f726e0114cb6056315d5547131a8c5d224cbbf" name="challenge" /></div>

				<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-6-{id_refuge}-texte.html" />
				<div class="send buttons">
					<button type="submit" name="send" value="Ajouter" class="positive">
						<img src="./templates/images/{design}/tick.png" alt="Ajouter"/> 
						Ajouter
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