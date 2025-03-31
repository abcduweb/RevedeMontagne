<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="mes_options.html">Mes Options</a> &gt;
	Options d'affichage
</div>
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<div class="cadre_1_h">
				<h2>Changer mes options d'affichage</h2>
			</div>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form action="actions/changer_options_affichage.php" method="post" name="formulaire">
				<fieldset>	
					<legend>Options d'affichage</legend>
					<p>Entrez le format de date et heure que vous souhaitez voir affich&eacute; &agrave; votre convenance.<br />
					Cela modifiera l'apparence de toutes les dates et heures affich&eacute;es sur le site.<br />
					Utilisez la <a href="https://www.php.net/manual/fr/function.date.php">syntaxe de PHP (date)</a> pour modifier la pr&eacute;sentation des dates. <br />
					La valeur par d&eacute;faut est : d-m-Y H:i:s</p>
					<br />
					<label for="date_style">Format dates : </label>
					<input type="text" name="date_style" id="date_style" value="{date_style}" />
					<br />
					<label for="nb_message">Nombre de messages par page : </label>
					<input type="text" name="nb_message" id="nb_message" value="{nb_message}" />
					<br /><br />
					<label for="nb_sujet">Nombre de sujets/MP par page : </label>
					<input type="text" name="nb_sujet" id="nb_sujet" value="{nb_sujet}" />
					<br /><br />
					<label for="nb_news">Nombre de news par page : </label>
					<input type="text" name="nb_news" id="nb_news" value="{nb_news}" />
					<br /><br />
					<label for="ordre_msg">Ordre des messages (forum) : </label>
					<select name="ordre_msg" id="ordre_msg">
						<option value="ASC" {select_asc}>Le plus r&eacute;cent en dernier</option>
						<option value="DESC" {select_desc}>Le plus r&eacute;cent en premier</option>
					</select>
					<br /><br />
					<label for="sign">Attacher signature (d&eacute;fault) : </label>
					<input type="checkbox" name="sign" id="sign" {checked_sign}/>
					<br /><br />
					<label for="email">Afficher mon email : </label>
					<input type="checkbox" name="email" id="email" {checked_email} />
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