					<div class="bouton_form">
						<img src="{DOMAINE}/templates/images/{design}/form/gras.png" alt="Gras" title="Gras" onclick="balise('&lt;gras&gt;','&lt;/gras&gt;', '{prev}');parse('{prev}', 'prev_{prev}');" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/italique.png" alt="Italique" title="Italique" onclick="balise('&lt;italique&gt;','&lt;/italique&gt;', '{prev}');parse('{prev}', 'prev_{prev}');" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/souligne.png" alt="Souligné" title="Souligné" onclick="balise('&lt;souligne&gt;','&lt;/souligne&gt;', '{prev}');parse('{prev}', 'prev_{prev}');" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/barre.png" alt="Barré" title="Barré" onclick="balise('&lt;barre&gt;','&lt;/barre&gt;', '{prev}');parse('{prev}', 'prev_{prev}');" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/liste.png" alt="Liste à puces" title="Liste à puces" onclick="add_liste('{prev}','prev_{prev}')" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/citation.png" alt="Citation" title="Citation" onclick="add_bal2('citation','nom','{prev}','prev_{prev}')" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/image.png" alt="Image" title="Image" onclick="balise('&lt;image&gt;','&lt;/image&gt;', '{prev}');parse('{prev}', 'prev_{prev}');" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/zcode_video.png" alt="Video" title="Video" onclick="balise('&lt;video&gt;','&lt;/video&gt;', '{prev}');parse('{prev}', 'prev_{prev}');"  class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/lien.png" alt="Lien" title="Lien" onclick="add_bal2('lien','url','{prev}','prev_{prev}')" class="bouton_cliquable" />
						<img src="{DOMAINE}/templates/images/{design}/form/mail.png" alt="E-mail" title="E-mail" onclick="add_bal2('email','addr','{prev}','prev_{prev}')" class="bouton_cliquable" />
						<a href="{url}" onclick="ouvrir_page(this.href,'uploads',700,500); return false;"><img src="{DOMAINE}/templates/images/{design}/form/upload.png" alt="upload" /></a>
						<img src="{DOMAINE}/templates/images/{design}/form/rmq/zcode_information.png" alt="Information" title="Information" onclick="balise('<information>','</information>', '{prev}');parse('{prev}', 'prev_{prev}'); return false;" class="bouton_cliquable">
						<img src="{DOMAINE}/templates/images/{design}/form/rmq/zcode_attention.png" alt="Attention" title="Attention" onclick="balise('<attention>','</attention>', '{prev}');parse('{prev}', 'prev_{prev}'); return false;" class="bouton_cliquable">
						<img src="{DOMAINE}/templates/images/{design}/form/rmq/zcode_erreur.png" alt="Erreur" title="Erreur" onclick="balise('<erreur>','</erreur>', '{prev}');parse('{prev}', 'prev_{prev}'); return false;" class="bouton_cliquable">
						<img src="{DOMAINE}/templates/images/{design}/form/rmq/zcode_question.png" alt="Question" title="Question" onclick="balise('<question>','</question>', '{prev}');parse('{prev}', 'prev_{prev}'); return false;" class="bouton_cliquable">
						<br />
						<span class="cleaner">			
							<select id="position_texte" onchange="add_bal('position','valeur','position_texte','{prev}','prev_{prev}')">
								<option class="opt_titre" selected="selected" disabled="disabled">Position</option>
								<option value="justifie">Justifié</option>
								<option value="gauche">A gauche</option>
								<option value="centre" class="centre">Centré</option>
								<option value="droite" class="droite">A droite</option>
							</select>
							<select id="flottant_texte" onchange="add_bal('flottant','valeur','flottant_texte','{prev}','prev_{prev}')">
								<option class="opt_titre" selected="selected" disabled="disabled">Flottant</option>
								<option value="gauche">A gauche</option>
								<option value="droite" class="droite">A droite</option>
							</select>

							<select id="taille_texte" onchange="add_bal('taille','valeur','taille_texte','{prev}','prev_{prev}')">
								<option class="opt_titre" selected="selected" disabled="disabled">Taille</option>
								<option value="ttpetit">Très très petit</option>
								<option value="tpetit">Très petit</option>
								<option value="petit">Petit</option>
								<option value="gros">Gros</option>
								<option value="tgros">Très gros</option>
								<option value="ttgros">Très très gros</option>
							</select>
							
							<select id="couleur_texte" onchange="add_bal('couleur','nom','couleur_texte','{prev}','prev_{prev}')">
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
							
							<select id="police_texte" onchange="add_bal('police','nom','police_texte','{prev}','prev_{prev}')">
								<option class="opt_titre" selected="selected" disabled="disabled">Police</option>
								<option value="arial" class="arial">arial</option>
								<option value="times" class="times">times</option>
								<option value="courrier" class="courrier">courrier</option>
								<option value="impact" class="impact">impact</option>
								<option value="geneva" class="geneva">geneva</option>
								<option value="optima" class="optima">optima</option>
							</select>
							
							<select id="semantique_texte" onchange="balise('&lt;titre'+this.value+'&gt;','&lt;/titre'+this.value+'&gt;','{prev}');parse('{prev}','prev_{prev}');this.options[0].selected = true;">
								<option class="opt_titre" selected="selected">Sémantique</option>
								<option value="1">Titre 1</option>
								<option value="2">Titre 2</option>
							</select>
						</span>
					</div>
					<div class="smiley">
						<img src="{DOMAINE}/images/smilies/smile.png" class="smiley_cliquable" alt=":)" onclick="balise(':)','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/heureux.png" class="smiley_cliquable" alt=":D" onclick="balise(':D','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/hihi.png" class="smiley_cliquable" alt="^^" onclick="balise('^^','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/rire.gif" class="smiley_cliquable" alt=":lol:" onclick="balise(':lol:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/clin.png" class="smiley_cliquable" alt=";)" onclick="balise(';)','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/langue.png" class="smiley_cliquable" alt=":p" onclick="balise(':p','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/triste.png" class="smiley_cliquable" alt=":(" onclick="balise(':(','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/pleure.png" class="smiley_cliquable" alt=":'(" onclick="balise(':\'(','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/mechant.png" class="smiley_cliquable" alt=":colere2:" onclick="balise(':colere2:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/angry.gif" class="smiley_cliquable" alt=":colere:" onclick="balise(':colere:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/blink.gif" class="smiley_cliquable" alt="o_O" onclick="balise('o_O','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/huh.png" class="smiley_cliquable" alt=":o" onclick="balise(':o','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/pinch.png" class="smiley_cliquable" alt=">_<" onclick="balise(':-:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/rouge.png" class="smiley_cliquable" alt=":honte:" onclick="balise(':honte:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/soleil.png" class="smiley_cliquable" alt=":soleil:" onclick="balise(':soleil:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/waw.png" class="smiley_cliquable" alt=":waw:" onclick="balise(':waw:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/ange.png" class="smiley_cliquable" alt=":ange:" onclick="balise(':ange:','','{prev}');parse('{prev}','prev_{prev}'); return false;"> 
						<img src="{DOMAINE}/images/smilies/diable.png" class="smiley_cliquable" alt=":diable:" onclick="balise(':diable:','','{prev}');parse('{prev}','prev_{prev}'); return false;">
					</div>
					<label for="activ_{prev}">
						<input type="checkbox" name="activ_{prev}" id="activ_{prev}" checked="checked" onchange="switch_activ('{prev}','prev_{prev}')" />
						Aper&#231;u temps r&#233;el
					</label>
					<textarea onselect="storeCaret('{prev}')" onclick="storeCaret('{prev}');parse('{prev}', 'prev_{prev}')" onkeyup="storeCaret('{prev}');parse('{prev}', 'prev_{prev}');" name="{prev}" id="{prev}" tabindex="30">{{prev}}</textarea>
					<br /><br />
					<---SIGNACT--->
					<label for="sign" class="aperçus_form"><input type="checkbox" name="sign" id="sign" {attache_sign} /> Attacher ma signature</label>
					<br /><br />
					</---SIGNACT--->
					<div id="prev_{prev}" class="apercu_tps_reel"></div>