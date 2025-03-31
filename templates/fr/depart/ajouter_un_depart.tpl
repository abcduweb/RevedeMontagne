<include file="../header_vide.tpl" />

<script type="text/javascript">
function ouvrirmap(lat,lng)
	{
window.open('./depart/google_map.php?lat=' +  lat + '&long=' + lng,'','scrollbars=yes,width=600,height=500')
	}
</script>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'un d&eacute;part</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<!--- Début du formulaire--->
			<form enctype="multipart/form-data" action="{DOMAINE}/depart/envoi_depart.php?m={id_massif}{edition}" method="post">
				<label for="nom_depart">Lieu de départ : </label>
				<input type="text" name="nom_depart" id="nom_depart" value="{nom_depart}" /><br />
						
				<label for="acces">Acc&egrave;s : </label>
				<input type="text" name="acces" id="acces" value="{acces}" /><br />
						
				<label for="altitude">Altitude :</label>
				<input type="text" name="altitude" id="altitude" value="{altitude}" /><br />
				
				
				<input type="hidden" name="lienpage" id="lienpage" value="{lienpage}" /><br />						

						
				<label for="lat">Latitude :</label>
				<input type="text" name="lat" id="lat" value="NaN"/><br />
				
				<label for="lng">Longitude :</label>
				<input type="text" name="lng" id="lng" value="NaN"/><br />
				(<em>V&eacute;rifier sur <a href="#" onclick="ouvrirmap(document.getElementById('lat').value,document.getElementById('lng').value);return false">GoogleMaps</a></em>)<br />

							
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

<include file="../footer_vide.tpl" />

