<include file="header.tpl" />
<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; Demande de mot de passe </div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Mot de passe perdu!</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action= "actions/demande_pass.php" method="post">
				<fieldset>
					<legend>Demande de mot de passe</legend>
					<label for="mail">E-mail </label><input value="" name="mail" /><br />
					<div class="send buttons">
						<button type="submit" value="Demander" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Demander"/> 
							Demander
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