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
		<a href="mes-articles.html">Mes Articles</a> &gt;
		<a href="editer-article-{id_article}.html">Editer un article</a> &gt;
		<a href="ajouter-une-partie-{id_article}">Ajouter une partie</a> &gt;
		Rédaction
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Ajouter une partie à votre article</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form enctype="multipart/form-data" action="actions/ajout_partie.php?artid={id_article}" method="post">
					<fieldset>
						<legend>Nouvelle partie</legend>
						<label for="titre">Titre :</label>
						<input type="text" name="titre" id="titre" /><br />
						<include form="bouton_form.tpl" prev="intro" sign="0" url="popupload-4-{id_article}-intro.html" />	
						<div class="send buttons">
							<button type="submit" value="Envoyer" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
								Envoyer 
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