<include file="header.tpl" />
	<div id="corps">
		<form enctype="multipart/form-data" action="actions/edition_com_news.php?m={id_com}" method="post" name="formulaire" id="formulaire">
			<h2>Edition d'un commentaire</h2>
			<div class="contenu_redaction">
				<include form="bouton_form.tpl" prev="texte" sign="0" url="upload-texte.html" />	
				<div class="buttons bouton_envoyer">
					<button type="submit" value="Envoyer" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
						Envoyer 
					</button>
				</div>
			</div>
		</form>
		<table class= "listemess">
			<thead>
				<tr class="intitules_tabl"><th class="titre_pseudo">Pseudo</th>
					<th class="titre_commentaire">Commentaire</th>
				</tr>	
			</thead>
			<tbody>
				<---COMM--->
				<tr class="headcom">
					<td class="pseudo">
						<img src="{DOMAINE}/templates/images/{design}/grade/{statut}.png" alt="{statut}" /> {pseudo}
					</td>
					<td class="date">
						{date_com}
					</td>
				</tr>
				<tr>
					<td class="infosmembres">
						{avatar}<br />
						{img_rang}
					</td>
					<td class="commentaires">
						{commentaire} {signature}
					</td>
				</tr>
				</---COMM--->
			</tbody>
		</table>
	</div>
<include file="footer.tpl" />