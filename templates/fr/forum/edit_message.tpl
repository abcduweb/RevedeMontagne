<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />

<div class="arbre">
	Vous &#234;tes ici :
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="forum.html">Forum</a> &gt;
	<a href="forum-c{niveau_cat_id}-{niveau_cat_titre_url}.html">{niveau_cat_titre}</a> &gt;
	<a href="forum-{niveau_forum_id}-{niveau_forum_titre_url}.html">{niveau_forum_titre}</a> &gt;
	<a href="forum-{niveau_forum_id}-{niveau_sujet_id}-{niveau_sujet_titre_url}.html">{niveau_sujet_titre}</a> &gt;
	Editer un message
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Edition d'un message</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">			
			<form action="actions/submit_edition.php?f={id_forum}&amp;t={id_sujet}&amp;m={id_message}" method="post" id="formulaire">
				<fieldset>
					<legend>Modifier message</legend>
					<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-3-{id_sujet}-texte.html" />	
					<div class="send buttons">
						<button type="submit" name="send" value="Modifier" tabindex="100" accesskey="s" class="positive"/>
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
							Modifier
						</button>
					</div>
				</fieldset>
			</form>

			<div class="liste_dernier_message">
				<table>
					<thead>
						<tr class="head_tableau">
							<th class="taille_infos">Auteur</th>
							<th>Message</th>
						</tr>
					</thead>
					<tbody>
						<---MESSAGES--->
						<tr id="{id_message}">
							<td>
								<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres.php?id={id_auteur}">{auteur}</a>
							</td>
							<td class="info_message">
								<a href="#{id_message}">#</a>Poster {date}. 
							</td>
						</tr>
						<tr>
							<td class="info_membre">
								{avatar}<br />
								{group}
							</td>
							<td>
								<div class="boite_message">
									{message}
								</div>
							</td>
						</tr>
						</---MESSAGES--->
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