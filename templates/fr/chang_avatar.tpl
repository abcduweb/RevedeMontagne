<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="mes_options.html">Mes Options</a> &gt;
	<a href="changement-avatar.html">Changer d'avatar</a> &gt;
	Avatars
</div>
		
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Changement d'avatar</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="centre">{avatar} <img src="{DOMAINE}/images/rien.gif" id="new_avatar" alt="Nouvel avatar"></div>
			<form action="actions/changer_avatar.php" method="post">
				<fieldset>
					<legend>Choisir un Avatar...</legend>
					<label for="new_avatar">Nouvel avatar</label>
					<select name="new_avatar" id="new_avatar" onchange="document.getElementById('new_avatar').src = this.value;">
						<option value="{DOMAINE}/images/rien.gif">Aucun</option>
						<---AVATARUP--->
							<option value="{DOMAINE}/images/autres/{dir}/{fichier}">{titre}</option>
						</---AVATARUP--->
					</select>
					<input type="submit" value="Choisir"/><br />
					Si certaines images de votre dossier avatar ne s'affiche pas dans cette liste c'est qu'elles ont une taille supérieur à 138x132px. Redimentionnez les pour les utiliser.
				</fieldset>
			</form>
			<form action="actions/changer_avatar.php" method="post">
				<fieldset>
					<legend>...Ou entrer son addresse.</legend>
					<label for="new_avatard">Nouvel avatar</label>
					<input type="text" name="new_avatard" id="new_avatard" value="http://" onblur="document.getElementById('new_avatar').src = this.value" />
					<input type="submit" value="Choisir" />
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