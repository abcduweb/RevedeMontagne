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
		<a href="editer-article-{id_article}.html">Editer un article</a> &gt;
		Edition : {titre}
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Edition de {titre}</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form enctype="multipart/form-data" action="actions/editer_article.php?artid={id_article}" method="post" name="formulaire">
					<fieldset>
						<legend>Editer l'article {titre}</legend>
						<div id="header_form">
							<label for="titre">Titre :</label>
							<input type="text" name="titre" value="{titre}" />
						</div>
						<div id="header_article">
							<h3>Les diff&eacute;rentes parties</h3>
							<div class="bouton_forum"><a href="ajouter-une-partie-{id_article}.html">Ajouter une partie</a></div>
								{part_enter}
								<---PARTIE--->
								<tr>
									<td class="col_titre" style="width:90%;">{part_titre}</td>
									<td style="width:10%;">
										<a href="editer-partie-{id_article}-{id_part}.html"><img src="{DOMAINE}/templates/images/1/form/edit.png" alt="Editer"></a>
										<a href="actions/supprimer_partie.php?partid={id_part}&amp;artid={id_article}"><img src="{DOMAINE}/templates/images/1/form/supprimer.png" alt="Supprimer"></a>
										<a href="monter-partie-{id_article}-{id_part}.html"><img src="{DOMAINE}/templates/images/1/form/montee.png" alt="Remonter"></a>
										<a href="descendre-partie-{id_article}-{id_part}.html"><img src="{DOMAINE}/templates/images/1/form/descente.png" alt="Descente"></a>
									</td>
								</tr>
								</---PARTIE--->
								{part_out}
								<div class="bouton_forum"><a href="ajouter-une-partie-{id_article}.html">Ajouter une partie</a></div>
							</div>
							<fieldset>
								<legend>Introduction</legend>
								<include form="bouton_form.tpl" prev="intro" sign="0" url="popupload-4-{id_article}-intro.html" />
							</fieldset>
							
							<fieldset>
								<legend>Conclusion</legend>
								<include form="bouton_form.tpl" prev="conclu" sign="0" url="popupload-4-{id_article}-conclu.html" />
							</fieldset>
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