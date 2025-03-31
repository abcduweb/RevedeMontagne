<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_scriptaculous.tpl" />
<include file="../headers/header_common_body.tpl" />

<script type="text/javascript">
function ouvrirmap(lat,lng)
	{
window.open('./depart/google_map.php?lat=' +  lat + '&long=' + lng,'','scrollbars=yes,width=600,height=500')
	}
</script>


<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-sommets.html">liste des sommets</a> &gt;  
	<a href="#">{nom_massif}</a> &gt; 
	<a href="ajouter-un-sommet.html">Ajouter un sommet</a> &gt; Rédaction
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'un sommet</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
		<br />
			<form enctype="multipart/form-data" action="{DOMAINE}/sommets/envoi_sommet.php{massif}{edition}" method="post">
				<fieldset>
				<legend>Ajout / Edition</legend>
				<label for="nom_sommet">Nom du sommet :</label>
				<input type="text" name="nom_sommet" id="nom_sommet" value="{nom_sommet}"/><br />
				
				<label for="type">Type de point :</label>
				<select name="type_sommet" id="type">
					<---TYPE--->
						<option value="{TYPE.id_type}" {TYPE.select}>{TYPE.nom_type}</option>
					</---TYPE--->
				</select><br />
				
				<label for="type">Département :</label>
				<select name="departement" id="departement">
					<---DPT--->
						<option value="{DPT.id_dpt}" {DPT.select}>{DPT.nom_dpt}</option>
					</---DPT--->
				</select><br />
				
				{carte_edite}					
				   
				<label for="altitude">Altitude :</label>
				<input type="text" name="altitude" id="altitude" value="{altitude}"/><br />
										
				<label for="lat">Latitude :</label>
				<input type="text" name="lat" id="lat" value="{lat}"/><br />
				
				<label for="lng">Longitude :</label>
				<input type="text" name="lng" id="lng" value="{lng}"/><br />
				(<em>Vérifier sur <a href="#" onclick="ouvrirmap(document.getElementById('lat').value,document.getElementById('lng').value);return false">GoogleMaps</a></em>)<br />

				
														
				<div class="send buttons">
					<button type="submit" value="Envoyer" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
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
<include file="../footer.tpl" />