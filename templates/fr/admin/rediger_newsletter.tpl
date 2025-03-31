<include file="../header.tpl" />            
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="mes-news.html">Mes News</a> &gt;
		Edition/Rédaction d'une newsletter
	</div>
	<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Rédaction d'une newsletter</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form enctype="multipart/form-data" action="administration/action_newsletter.php?{action_news}" method="post" name="formulaire">
				<fieldset>
					<legend>Rédiger la news</legend>
					<label for="titre">Titre : </label>
					<input type="text" size="30" name="titre" value="{titre}" /><br /><br />
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