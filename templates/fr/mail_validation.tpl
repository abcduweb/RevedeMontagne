<include file="header.tpl" />
<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; Demande e-mail de validation</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>E-mail de validation</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action= "actions/demande_mail_validation.php" method= "post" id= "formulaire">
				<fieldset>	
					<legend>Demande e-mail de validation</legend>
					<label for="mail">E-mail </label><input value="" name="mail" /><br />
					<div class="send buttons">
						<button type="submit" value="Demander" class="positive">
							<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
							Demander
						</button>
					</div>
				</fieldset>
			</form>
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