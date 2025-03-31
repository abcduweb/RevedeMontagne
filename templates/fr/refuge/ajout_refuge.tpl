<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />

<script type="text/javascript">
function ouvrirmap(lat,lng)
	{
window.open('./depart/google_map.php?lat=' +  lat + '&long=' + lng,'','scrollbars=yes,width=600,height=500')
	}
</script>

<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	<a href="mes-refuges-m{idm}.html">Liste des refuges, abris propos&eacute;s par {nom_membre}</a> &gt;
	Ajout / Edition d'un abri
</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'un abri</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
		<br />
			<form enctype="multipart/form-data" action="{DOMAINE}/refuge/envoi_refuge.php{edition}" method="post">
				<fieldset>
					<legend>Ajout / Edition</legend>

					<label for="nom_refuge">Nom du refuge :</label>
					<input type="text" name="nom_refuge" id="nom_refuge" value="{nom_refuge}"/><br />
								
					<label for="nbre_place" >Nombre de place :</label>
					<input type="text" name="nbre_place" id="nbre_place" value="{nbre_place}"/><br />
									
					<label for="type">Type de refuge :</label>
					<select name="type" id="type">
					<---TYPE--->
						<option value="{TYPE.id_type}" {TYPE.select}>{TYPE.nom_type}</option>
					</---TYPE--->
					</select><br />
					
					{carte_edite}	
				
					<label for="altitude">Altitude :</label>
					<input type="text" name="altitude" id="altitude" value="{altitude}"/><br />
											
					<label for="lat">Latitude :</label>
					<input type="text" name="lat" id="lat" value="{lat}"/><br />
					
					<label for="lng">Longitude :</label>
					<input type="text" name="lng" id="lng" value="{lng}"/><br />
					(<em>V&eacute;rifier sur <a href="#" onclick="ouvrirmap(document.getElementById('lat').value,document.getElementById('lng').value);return false">la carte</a></em>)<br />

									
					<label for="massif">Massif :</label>
					<select name="massif" id="massif">
						<option value="0">Choix du massif (Obligatoire)</option>
						<---MASSIFG--->
							<optgroup label="{MASSIFG.nomg}">
								<---MASSIF--->
									<option value="{MASSIF.id_massif}" {MASSIF.selected}>{MASSIF.nom_massif}</option>
								</---MASSIF--->
							</optgroup>
						</---MASSIFG--->
					</select><br />
					<label for="type">Département :</label>
					<select name="departement" id="departement">
						<---DPT--->
							<option value="{DPT.id_dpt}" {DPT.select}>{DPT.nom_dpt}</option>
						</---DPT--->
					</select><br />
					{edit_com_point}
									
									
					<fieldset>
						<legend>Accès</legend>
						<include form="../bouton_form.tpl" prev="intro" sign="0" url="popupload-6{id_point}-intro.html" />
					</fieldset>
					<fieldset>
						<legend>Remarques</legend>
						<include form="../bouton_form.tpl" prev="conclu" sign="0" url="popupload-6{id_point}-conclu.html" />	
					</fieldset>
					<div class="send buttons">
						<button type="submit" value="Envoyer" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
						Envoyer 
						</button>
					</div>


				</fieldset>
			</form>
					<br /><br />
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