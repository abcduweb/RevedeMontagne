<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_common_body.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-traces-gpx.html">trac&egrave; gpx</a> &gt;
	ajout d'une trace
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajouter un nouveau trac&eacute;</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<form enctype="multipart/form-data" action="actions/actions_mapgpx.php?{action_news}&a={idact}&n={idt}" method="post" name="formulaire">
				<fieldset>
					<legend>Ajouter une cat&eacute;gorie</legend>
					<label for="nom">Nom du trac&eacute; : </label>
					<input type="text" name="nom" /><br />	
					<label for="fichier">Choix du fichier GPX : </label>
					<input name="fichier" id="fichier" type="file"/><br />
							
					<include form="../bouton_form.tpl" prev="texte" sign="0" url="{url_upload}" />

					<div class="send buttons">
						<button type="submit" value="Envoyer" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
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
<include file="../footer.tpl" />