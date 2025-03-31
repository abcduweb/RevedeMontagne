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
	<a href="forum-c{id_cat}-{cat_titre_url}.html">{cat_titre}</a> &gt;
	<a href="forum-{id_forum}-{niveaux_forum_titre_url}.html">{niveaux_forum_titre}</a> &gt;
	Ajouter un sujet
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Nouveau sujet</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<form action="actions/submit_topics.php?f={id_forum}" method="post" name="formulaire">
				<fieldset>
					<legend>Nouveau sujet</legend>
					<label for="titre">Titre : </label>
					<input type="text" name="titre" id="titre" size="35" tabindex="10" />
					<br />
					<label for="titre2">Sous-titre : </label>
					<input type="text" name="titre2" id="titre2" size="35" tabindex="20" />
					<br /><br />
					<include form="../bouton_form.tpl" prev="texte" sign="1" url="popupload-3-texte.html" />
					<div class="send buttons">
						<button type="submit" name="send" value="Envoyer" tabindex="100" accesskey="s" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Ajouter le sujet"/> 
							Ajouter le sujet
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
