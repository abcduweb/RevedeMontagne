<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="mes_options.html">Mes Options</a> &gt;
	Changer mot de passe
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Changer mon mot de passe</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form method="post" action="actions/changer_mdp.php" name="formulaire">
				<fieldset>
					<legend>Changement de mot de passe</legend>
					<label for="mdp1">Votre ancien mot de passe :</label><input type="password" name="mdp1" /><br /><br />
					<label for="mdp2">Votre nouveau mot de passe :</label><input type="password" name="mdp2" /><br /><br />
					<label for="mdp3">Retapez votre nouveau mot de passe :</label><input type="password" name="mdp3" /><br />
					<div class="send buttons">
						<button type="submit" value="Envoyer l'image" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Changer" /> 
							Changer
						</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				&nbsp	
			</div>
		</div>
	</div>
</div>
<include file="footer.tpl" />