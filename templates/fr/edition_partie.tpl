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
		<a href="contributions.html">Mes Contributions</a> &gt;
		<a href="mes-articles.html">Mes Articles</a> &gt;
		<a href="editer-article-{id_article}.html">Editer {titre_article}</a> &gt;
		<a href="editer-partie-{id_article}-{id_part}.html">Editer une partie</a> &gt; Edition : {titre}
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>{titre_article} edition {titre}</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form enctype="multipart/form-data" action="actions/editer_article.php?artid={id_article}&amp;partid={id_part}" method="post" name="formulaire">
					<fieldset>	
						<legend>Edition partie {titre}</legend>
						<label for="titre">Titre :</label>
						<input type="text" name="titre" value="{titre}" />
						<include form="bouton_form.tpl" prev="texte" sign="0" url="popupload-4-{id_article}-texte.html" />	
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
<include file="footer.tpl" />