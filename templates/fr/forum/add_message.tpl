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
	Ajouter une r&#234;ponse
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Nouveau message</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<form action="actions/submit_message.php?f={id_forum}&amp;t={id_sujet}" method="post" name="formulaire">
				<fieldset>
					<legend>Ajouter un message</legend>
					<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-3-{id_sujet}-texte.html" />
					<div class="send buttons">
						<button type="submit" name="send" value="Envoyer" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Répondre"/> 
							Répondre
						</button>
					</div>
				</fieldset>
			</form>
				
			<div class="liste_dernier_message">
				<ul class="list clearfix">
					<---MESSAGES--->
						<li class="ligne{ligne}" id="r{id_message}">
						<div class="row fmessage">
							<div class="message_gauche">
								<span>
									<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres-{id_auteur}-fiche.html">{auteur}</a><br />
									{avatar}<br />
									{group}
								</span>
							</div>
							<div class="message_droite">
								<div class="message_droite_bas">
									{message}
								</div>
							</div>
						</div>
						</li>
					</---MESSAGES--->
				</ul>
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
