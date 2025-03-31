<include file="./headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./headers/header_common_body.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	Formulaire de contact
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Nous contacter</h2>			
		</div>
	</div> 
	
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div class="miseengarde">
				Vous pouvez gr&acirc;ce &agrave; ce formulaire envoyer un message aux webmasters du site, si vous avez un probl&egrave;me ou une proposition/remarque &agrave; nous faire.<br >
				Aussi veuillez noter qu'il existe un forum <a href="forum-5-rapports-de-bug.html">Rapports de bug</a> pour tous les bugs que vous rencontrez, ainsi
				qu'un forum <a href="forum-6-idees-dameliorations.html">Id&eacute;es d'am&eacute;liorations</a> pour toutes les remarques pouvant faire &eacute;voluer le site.<br />
				Merci donc d'utiliser ce formulaire que si vous avez r&eacute;ellement besoin de contacter les webmasters.
			</div>
			<br />
			<form action="actions/contact.php" method="post">
				<fieldset>
					<legend>Formulaire de contact</legend>
						<label for="email">E-mail : </label>
						<input type="text" name="email" id="email" /><br />
						<label for="nom">Nom : </label>
						<input type="text" name="nom" id="nom" /><br />
						<label for="sujet">Sujet : </label>
						<input type="text" name="sujet" id="sujet" /><br /><br />
						<div class="bouton_form">
							<img src="./templates/images/1/form/gras.png" alt="Gras" title="Gras" onclick="balise('&lt;gras&gt;','&lt;/gras&gt;', 'texte');parse('texte', 'prev_texte');" class="bouton_cliquable" />
							<img src="./templates/images/1/form/italique.png" alt="Italique" title="Italique" onclick="balise('&lt;italique&gt;','&lt;/italique&gt;', 'texte');parse('texte', 'prev_texte');" class="bouton_cliquable" />
							<img src="./templates/images/1/form/souligne.png" alt="Souligné" title="Souligné" onclick="balise('&lt;souligne&gt;','&lt;/souligne&gt;', 'texte');parse('texte', 'prev_texte');" class="bouton_cliquable" />
							<img src="./templates/images/1/form/barre.png" alt="Barré" title="Barré" onclick="balise('&lt;barre&gt;','&lt;/barre&gt;', 'texte');parse('texte', 'prev_texte');" class="bouton_cliquable" />
							<img src="./templates/images/1/form/liste.png" alt="Liste à puces" title="Liste à puces" onclick="add_liste('texte','prev_texte')" class="bouton_cliquable" />
							<img src="./templates/images/1/form/citation.png" alt="Citation" title="Citation" onclick="add_bal2('citation','nom','texte','prev_texte')" class="bouton_cliquable" />
							<img src="./templates/images/1/form/image.png" alt="Image" title="Image" onclick="balise('&lt;image&gt;','&lt;/image&gt;', 'texte');parse('texte', 'prev_texte');" class="bouton_cliquable" />
							<img src="./templates/images/1/form/lien.png" alt="Lien" title="Lien" onclick="add_bal2('lien','url','texte','prev_texte')" class="bouton_cliquable" />
							<img src="./templates/images/1/form/mail.png" alt="E-mail" title="E-mail" onclick="add_bal2('email','addr','texte','prev_texte')" class="bouton_cliquable" />
							<img src="./templates/images/1/form/rmq/zcode_information.png" alt="Information" title="Information" onclick="balise('<information>','</information>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable">
							<img src="./templates/images/1/form/rmq/zcode_attention.png" alt="Attention" title="Attention" onclick="balise('<attention>','</attention>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable">
							<img src="./templates/images/1/form/rmq/zcode_erreur.png" alt="Erreur" title="Erreur" onclick="balise('<erreur>','</erreur>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable">
							<img src="./templates/images/1/form/rmq/zcode_question.png" alt="Question" title="Question" onclick="balise('<question>','</question>', 'texte');parse('texte', 'prev_texte'); return false;" class="bouton_cliquable">
							<br />
							<span class="cleaner">			
								<select id="position_texte" onchange="add_bal('position','valeur','position_texte','texte','prev_texte')">
									<option class="opt_titre" selected="selected" disabled="disabled">Position</option>
									<option value="justifie">Justifié</option>
									<option value="gauche">A gauche</option>
									<option value="centre" class="centre">Centré</option>
									<option value="droite" class="droite">A droite</option>
								</select>
								<select id="flottant_texte" onchange="add_bal('flottant','valeur','flottant_texte','texte','prev_texte')">
									<option class="opt_titre" selected="selected" disabled="disabled">Flottant</option>
									<option value="gauche">A gauche</option>
									<option value="droite" class="droite">A droite</option>
								</select>
								<select id="taille_texte" onchange="add_bal('taille','valeur','taille_texte','texte','prev_texte')">
									<option class="opt_titre" selected="selected" disabled="disabled">Taille</option>
									<option value="ttpetit">Très très petit</option>
									<option value="tpetit">Très petit</option>
									<option value="petit">Petit</option>
									<option value="gros">Gros</option>
									<option value="tgros">Très gros</option>
									<option value="ttgros">Très très gros</option>
								</select>							
								<select id="couleur_texte" onchange="add_bal('couleur','nom','couleur_texte','texte','prev_texte')">
									<option class="opt_titre" selected="selected" disabled="disabled">Couleur</option>
									<option value="rose" class="rose">rose</option>
									<option value="rouge" class="rouge">rouge</option>
									<option value="orange" class="orange">orange</option>
									<option value="jaune" class="jaune">jaune</option>
									<option value="vertc" class="vertc">vert clair</option>
									<option value="vertf" class="vertf">vert foncé</option>
									<option value="olive" class="olive">olive</option>
									<option value="turquoise" class="turquoise">turquoise</option>
									<option value="bleugris" class="bleugris">bleu-gris</option>

									<option value="bleu" class="bleu">bleu</option>
									<option value="marine" class="marine">marine</option>
									<option value="violet" class="violet">violet</option>
									<option value="marron" class="marron">marron</option>
									<option value="noir" class="noir">noir</option>
									<option value="gris" class="gris">gris</option>

									<option value="argent" class="argent">argent</option>
									<option value="blanc" class="blanc">blanc</option>
								</select>
								
								<select id="police_texte" onchange="add_bal('police','nom','police_texte','texte','prev_texte')">
									<option class="opt_titre" selected="selected" disabled="disabled">Police</option>
									<option value="arial" class="arial">arial</option>
									<option value="times" class="times">times</option>

									<option value="courrier" class="courrier">courrier</option>
									<option value="impact" class="impact">impact</option>
									<option value="geneva" class="geneva">geneva</option>
									<option value="optima" class="optima">optima</option>
								</select>
								
								<select id="semantique_texte" onchange="balise('&lt;titre'+this.value+'&gt;','&lt;/titre'+this.value+'&gt;','texte');parse('texte','prev_texte');this.options[0].selected = true;">
									<option class="opt_titre" selected="selected">Sémantique</option>
									<option value="1">Titre 1</option>
									<option value="2">Titre 2</option>
								</select>
							</span>
						</div>
						<div class="smiley">
							<img src="{DOMAINE}/images/smilies/smile.png" class="smiley_cliquable" alt=":)" onclick="balise(':)','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/heureux.png" class="smiley_cliquable" alt=":D" onclick="balise(':D','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/hihi.png" class="smiley_cliquable" alt="^^" onclick="balise('^^','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/rire.gif" class="smiley_cliquable" alt=":lol:" onclick="balise(':lol:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/clin.png" class="smiley_cliquable" alt=";)" onclick="balise(';)','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/langue.png" class="smiley_cliquable" alt=":p" onclick="balise(':p','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/triste.png" class="smiley_cliquable" alt=":(" onclick="balise(':(','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/pleure.png" class="smiley_cliquable" alt=":'(" onclick="balise(':\'(','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/mechant.png" class="smiley_cliquable" alt=":colere2:" onclick="balise(':colere2:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/angry.gif" class="smiley_cliquable" alt=":colere:" onclick="balise(':colere:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/blink.gif" class="smiley_cliquable" alt="o_O" onclick="balise('o_O','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/huh.png" class="smiley_cliquable" alt=":o" onclick="balise(':o','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/pinch.png" class="smiley_cliquable" alt=">_<" onclick="balise('>_<','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/rouge.png" class="smiley_cliquable" alt=":honte:" onclick="balise(':honte:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/soleil.png" class="smiley_cliquable" alt=":soleil:" onclick="balise(':soleil:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/waw.png" class="smiley_cliquable" alt=":waw:" onclick="balise(':waw:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/ange.png" class="smiley_cliquable" alt=":ange:" onclick="balise(':ange:','','texte');parse('texte','prev_texte'); return false;"> 
							<img src="{DOMAINE}/images/smilies/diable.png" class="smiley_cliquable" alt=":diable:" onclick="balise(':diable:','','texte');parse('texte','prev_texte'); return false;">
						</div>
						<label for="activ_texte">
							<input type="checkbox" name="activ_texte" id="activ_texte" checked="checked" onchange="switch_activ('texte','prev_texte')" />
							Aperçu temps réel
						</label>
						<textarea onselect="storeCaret('texte')" onclick="storeCaret('texte');parse('texte', 'prev_texte')" onkeyup="storeCaret('texte');parse('texte', 'prev_texte');" name="texte" id="texte" tabindex="30"></textarea>
						<br /><br />
							
						<div id="prev_texte" class="apercu_tps_reel"></div>	

						<input type="hidden" id="recaptchaResponse" name="recaptcha-response">
						
							<div class="send buttons">
								<button type="submit" value="Envoyer" class="positive">
									<img src="{DOMAINE}/templates/images/1/tick.png" alt="Envoyer"/> 
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
<include file="footer.tpl" />