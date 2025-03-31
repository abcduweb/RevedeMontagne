<include file="../header.tpl" />
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'une sortie</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<!--- Début du formulaire--->
			<form enctype="multipart/form-data" action="{DOMAINE}/sorties/envoi_sortie.php?t={idt}{edition}" method="post">
				<label for="date_sortie">Date de la sortie : </label>
					<select name="jour" id="jour">
						{jour}
					</select>
					
					<select name="mois" id="mois">
						{mois}
					</select>
					
					<select name="annee" id="annee">
						{annee}
					</select><br />
				
				<label for="gpx">Ajouter un fichier GPX :</label>	
				<select name="gpx" id="gpx">
						<option value="0">Joindre un fichier GPX à la sortie</option>
					<---TYPE--->
						<option value="{TYPE.id_gpx}" {TYPE.select}>{TYPE.date_gpx} - {TYPE.nom_gpx}</option>
					</---TYPE--->
				</select><br />
				
				<label for="meteo">Météo </label>
				<textarea name="meteo" id="meteo" rows="10" cols="20">{meteo}</textarea>
								
				<label for="recit">Récit de la sortie</label>
				<textarea name="recit" id="recit" rows="10" cols="69">{recit}</textarea>
							
				<div class="send buttons">
					<button type="submit" value="Envoyer" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
						Envoyer 
					</button>
				</div>
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
<include file="../footer.tpl" />

