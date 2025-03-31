<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici :
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		Liste des traces gpx
	</div>
	
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Chargement de la trace</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				<form method="post" action="{DOMAINE}/mapgpx/download_visiteur.php?idfichier={idfichier}" name="formulaire">
				<fieldset>
					<legend>T&eacute;l&eacute;charger la trace {nom_trace}</legend>
					Afin que nous puissions vous envoyer par mail le fichier GPX souhait&eacute;, nous avons besoin de quelques renseignements
					<fieldset>
						<legend>Renseignement :</legend>
						<label for="nom">Nom :</label>
						<input type="nom" name="nom" /><br />
						<label for="email">adresse mail :</label>
						<input type="email" name="email" /><br />
						<label for="newsletter">Newsletter</label>
						<input type="checkbox" name="newsletter" id="newsletter" />
					</fieldset>

					<input type="hidden" id="recaptchaResponse" name="recaptcha-response">					
					
					<div class="buttons send">
						<button type="submit" value="Envoyer" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
							Envoyer
						</button>
					</div>
				</fieldset>
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

<include file="../footer.tpl" />