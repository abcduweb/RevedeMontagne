<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="livre-d-or.html">Livre d'or</a> &gt;
	Remarques sur le site 
</div>
	
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Le livre d'or</h2>			
		</div>
	</div> 
	
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<form method="post" action="actions/livreor.php" name="formulaire">
				<fieldset>
					<legend>Laisser tous vos commentaires pour l'équipe</legend>
						{pseudo}
					<br /><br />
					<textarea name="textarea" id="texte" tabindex="30"></textarea>
					
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
				&nbsp	
			</div>
		</div>
	</div>
</div>


	<p class="lien_page">
		Nous avons pour le moment <strong>{nb} {messages}</strong>
		<br />
		<div class="wp-pagenavi">
			Page(s) : {liste_page}
		</div>
	</p>		

	
	<---COMM--->
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Par : {COMM.pseudo} {COMM.date} </h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				{COMM.commentaire}	<br />
				{affichageIP} {delMsg}
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
	</---COMM--->

	<div class="wp-pagenavi">
		Page(s) : {liste_page}
	</div>
<include file="footer.tpl" />