<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : <a href="../index.php">R&ecirc;ve de montagne</a> &gt; Demande de validation
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Demande de validation</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form action="{url}" method="post" id="formulaire">
					<fieldset>
						<legend>Texte d'information</legend>
						{autre}
						<include form="bouton_form.tpl" prev="texte" sign="0" url="upload.html" />	
						<div class="send buttons">
							<button type="submit" name="send" value="Envoyer" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Répondre"/> 
								Envoyer
							</button>
							<button type="button" onclick="javascript:history.back(-1);" value="Annuler" class="negative">
								<img src="{DOMAINE}/templates/images/{design}/cross.png" alt="Annuler"/> 
								Annuler
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