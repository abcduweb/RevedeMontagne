<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="inscription.html">Inscription</a> &gt;
		Nouvelle Inscription
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Inscription</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form method="post" action="actions/inscription.php" name="formulaire">
					<fieldset>
						<legend>Inscription</legend>
						<label for="pseudo">Pseudo :</label><input type="text" name="pseudo" /><br /><br />
						<label for="mdp1">Mot de passe :</label><input type="password" name="mdp1" /><br /><br />
						<label for="mdp2">Retapez votre mot de passe :</label><input type="password" name="mdp2" /><br /><br /><br />
						<label for="email1">Adresse email :</label><input type="text" name="email1" /><br /><br />
						<label for="email2">Retapez votre E-mail :</label><input type="text" name="email2" /><br /><br />
							
						<p>Veillez &agrave; indiquer une adresse e-mail <strong>valide</strong>. Elle sera utilis&eacute;e pour valider votre compte.</p>
					</fieldset>

					<fieldset>
						<label for="regles_ok">J'ai lu et j'accepte <a href="./article-reglement-de-bonne-conduite-sur-le-site-revedemontagne-a174.html">les r&egrave;gles</a></label>
						<input type="checkbox" name="regles_ok" id="regles_ok" />
					</fieldset>

<input type="hidden" id="recaptchaResponse" name="recaptcha-response">

					<div class="send buttons">
						<button type="submit" value="Envoyer l'image" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
							Envoyer 
						</button>
					</div>
				</form>

<script src="https://www.google.com/recaptcha/api.js?render=6LeAlM8ZAAAAADEv03dB1qszdkmOe467YB7MUalR"></script> <script> grecaptcha.ready(function() { grecaptcha.execute('6LeAlM8ZAAAAADEv03dB1qszdkmOe467YB7MUalR', {action: 'homepage'}).then(function(token) { document.getElementById('recaptchaResponse').value = token }); }); </script>

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