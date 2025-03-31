<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="mes_options.html">Mes Options</a> &gt;
	<a href="chang-profil.html">Changer profil</a> &gt;
	Votre profil
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Edition de mon profil</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form enctype="multipart/form-data" action="actions/changer_profil.php" method="post" name="formulaire">
				<fieldset>
					<fieldset>
						<legend>Messageries instantanées</legend>
						<label for="icq">ICQ : </label>
						<input type="text" name="icq" id="icq" value="{icq}" /><br /><br />
						<label for="msn">MSN : </label>
						<input type="text" name="msn" id="msn" value="{msn}" /><br /><br />
						<label for="aim">AIM : </label>
						<input type="text" name="aim" id="aim" value="{aim}" /><br /><br />
						<label for="jabber">Jabber : </label>
						<input type="text" name="jabber" id="jabber" value="{jabber}" /><br /><br />
						<label for="yahoo">Yahoo Messenger : </label>
						<input type="text" name="yahoo" id="yahoo" value="{yahoo}" />
					</fieldset>
						
					<fieldset>
						<legend>Informations personelles</legend>
						<label for="date_naissance">Date de naissance : </label>
						<input type="text" name="date_naissance" id="date_naissance" value="{date_naissance}" /><br /><br />
						<label for="interets">Intérêts : </label>
						<input type="text" name="interets" id="interets" value="{interets}" /><br /><br />
						<label for="site">Site web : </label>
						<input type="text" name="site" id="site" value="{site_web}" /><br /><br />
						<label for="newsletter">Inscrit &agrave; la Newsletter : </label>
						<input type="checkbox" name="newsletter" id="newsletter" {checked_newsletter} />
					</fieldset>
							
					<fieldset>
						<legend>Votre signature</legend>
						<include form="bouton_form.tpl" prev="intro" sign="0" url="upload-intro.html" />
					</fieldset>
						
					<fieldset>
						<legend>Votre biographie</legend>
						<include form="bouton_form.tpl" prev="conclu" sign="0" url="upload-conclu.html" />	
					</fieldset>
					<div class="send buttons">
						<button type="submit" value="Envoyer" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="tick"/> 
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
