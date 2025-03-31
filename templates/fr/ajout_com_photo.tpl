<include file="./headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./headers/header_common_body.tpl" />
<div class="arbre">
	Vous &#234;tes ici :
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="album-photos.html">Album photos</a> &gt;
	<a href="album-{titre_album_url}-c{id_album}.html">{titre_album}</a> &gt;
	Ajouter un commentaire
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Nouveau Commentaire</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action="actions/submit_com_photo.php?pid={id_photo}" method="post" name="formulaire">
				<fieldset>
					<legend>Ajouter un commentaire</legend>
					<include form="bouton_form.tpl" prev="texte" sign="1" url="upload.html" />
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