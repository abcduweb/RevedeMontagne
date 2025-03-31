<include file="headers/header_common_head.tpl" />
<meta name="google-signin-client_id" content="386872365092-f4j2dvlc021319meg4u6nrtc4shtbg7p.apps.googleusercontent.com">
<script src="https://apis.google.com/js/api.js"></script>
<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<include file="headers/header_common_body.tpl" />
<script>
			function onSuccess(googleUser) {
				var profile = googleUser.getBasicProfile();
				gapi.client.load('plus', 'v1', function () {
					var request = gapi.client.plus.people.get({
						'userId': 'me'
					});
					//Display the user details
					request.execute(function (resp) {
					
						var profileHTML = '<div class="profile"><div class="head">Welcome '+resp.name.givenName+'! <a href="javascript:void(0);" onclick="signOut();">Sign out</a></div>';
						profileHTML += '<img src="'+resp.image.url+'"/><div class="proDetails"><p>'+resp.displayName+'</p><p>'+resp.emails[0].value+'</p><p>'+resp.gender+'</p><p>'+resp.id+'</p><p><a href="'+resp.url+'">View Google+ Profile</a></p></div></div>';
						$('.userContent').html(profileHTML);
						$('#gSignIn').slideUp('slow');
					});
				});
			}
			function onFailure(error) {
				alert(error);
			}
			function renderButton() {
				gapi.signin2.render('gSignIn', {
					'scope': 'profile email',
					'width': 240,
					'height': 50,
					'longtitle': true,
					'theme': 'dark',
					'onsuccess': onSuccess,
					'onfailure': onFailure
				});
			}
			function signOut() {
				var auth2 = gapi.auth2.getAuthInstance();
				auth2.signOut().then(function () {
					$('.userContent').html('');
					$('#gSignIn').slideDown('slow');
				});
			}
		</script>
		
		
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		Connexion 
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Connexion</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form action="actions/connexion.php" method="post" name="formulaire">
					<fieldset>
						<legend>Connexion</legend>
						<label for="pseudo">Pseudo : </label>
						<input type="text" name="pseudo" id="pseudo" /><br /><br />
						<label for="password">Mot de passe : </label>
						<input type="password" name="password" id="password" /><br /><br />
						<label for="retenir">Connexion Automatique</label>
						<input value="1" name="retenir" id="retenir" type="checkbox"/><br />
						<div class="send buttons">
							<button type="submit" value="Connexion" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Connexion"/>
								Se connecter
							</button>
						</div>
					</fieldset>
				</form>
				
				<div id="gSignIn"></div>		
<div class="userContent"></div>


				<h2>Un probl&egrave;me ?</h2>
				<div class="boite_texte_sup">
					<ul>
						<li><a href="inscription.html">Je ne suis pas encore inscrit!</a></li>
						<li><a href="demande-mail-validation.html">J'ai &agrave; nouveau besoin du mail de validation!</a></li>
						<li><a href="demande-passe.html">Mot de passe oubli&eacute;?</a></li>
					</ul>
				</div>
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