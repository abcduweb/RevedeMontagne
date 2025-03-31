<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="mes_options.html">Mes Options</a> &gt;
	Changer d'e-mail
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Changer mon e-mail</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<form action="actions/changer_mail.php" method="post" name="formulaire">
				<fieldset>
					<legend>Changement d'e-mail</legend>
					<label for="mail">Votre ancien email : </label>
					<input type="text" name="mail" id="mail" /><br /><br />
					<label for="mail2">Votre nouvel email : </label>
					<input type="text" name="mail2" id="mail2" /><br /><br />
					<label for="pass">Votre mot de passe : </label>
					<input type="password" name="pass" id="pass" />
					<br />
					<div class="send buttons">
						<button type="submit" value="Envoyer l'image" class="positive">
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
				&nbsp	
			</div>
		</div>
	</div>
</div>
<include file="footer.tpl" />