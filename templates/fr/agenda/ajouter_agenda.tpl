<include file="./../header.tpl" />            
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="{DOMAINE}prochains-evenements.html">Prochains &eacute;v&eacute;nements</a> &gt;
		Edition/Rédaction d'un &eacute;v&eacute;nements
	</div>
	<h1>Ajouter un &eacute;v&eacute;nements</h1>
	<form enctype="multipart/form-data" action="agenda/action_agenda.php?nid={action_agenda}&dir=7" method="post" name="formulaire">
		<fieldset>
			<legend>Ajouter un &eacute;v&eacute;nements</legend>
			<label for="titre">Titre : </label><input type="text" size="30" name="titre" value="{titre}" /><br />
			<label for="url_event">URL de l'&eacute;v&eacute;nements : </label><input type="text" size="30" name="titre" value="{url_event}" /><br />
			<label for="date_debut_event">Date de d&eacute;but : </label> <select name="jourd" id="jourd">{jour}</select> <select name="moisd" id="moisd">{mois}</select> <select name="anneed" id="anneed">{annee}</select><br />
			<label for="date_debut_fin">Date de fin : </label> <select name="jourf" id="jourf">{jour}</select> <select name="moisf" id="moisf">{mois}</select> <select name="anneef" id="anneef">{annee}</select><br />
			<include form="./../bouton_form.tpl" prev="texte" sign="0" url="{url_upload}" />
				
				
			<div class="send buttons">
				<button type="submit" value="Envoyer" class="positive">
					<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
					Envoyer 
				</button>
			</div>
		</fieldset>
	</form>
<br />
<include file="./../footer.tpl" />