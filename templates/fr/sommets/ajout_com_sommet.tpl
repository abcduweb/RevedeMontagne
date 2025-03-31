<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-sommets">liste des sommets</a> &gt; <a href="detail-{nom_sommet_url}-{id_som}.html">{nom_sommet}</a> &gt; Commentaires {nom_sommet}
</div>
<h1>Nouveau Commentaire</h1>
	<form action="actions/submit_com_sommet.php?pid={id_som}" method="post" name="formulaire">
		<fieldset>
			<legend>Ajouter un commentaire</legend>
			<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-6-{id_som}-texte.html" />
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
<include file="../footer.tpl" />