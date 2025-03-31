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
		<a href="ajouter-un-article.html">Ajouter un article</a> &gt;
		R&eacute;daction
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Ajouter un article</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form enctype="multipart/form-data" action="actions/ajouter_article.php" method="post">
					<fieldset>
						<legend>Nouvel article / topo</legend>
						<label for="model"><img src="{DOMAINE}/templates/images/{design}/info.png" alt="info" title="Si vous souhaitez ajouter un <strong>topo</strong> veuillez sélectionner le modèle &lt;strong&gt;Topos&lt;/strong&gt;. &lt;br /&gt; Sinon laissez sélectionner vierge." onmouseover="tooltip.show(this);" />  Mod&egrave;le :</label>
						<select name="model" id="model" onchange="load_form('loading_part1',this.value);">
						<option value="vierge">Vierge</option>
						</select><br />
						
						<div id="loading_part1">
							<include file="form_topo/vierge.tpl" />
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