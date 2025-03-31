<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;  
	<a href="mes-topos-randonnees.html">mes topos de randonn&eacute;e</a> &gt;
	<a href="liste-des-sommets-m{id_massif}.html">{massif}</a> &gt;  
	<a href="detail-{url_som}-{id_som}-{idt_som}.html">{sommet}</a> &gt;  
	<a href="ajouter-un-topo-de-randonnees-{id_som}.html">Ajouter un topo</a> &gt; Rédaction
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'un topo</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
		<br />
			<!--- début du formulaire--->
			<form enctype="multipart/form-data" action="{DOMAINE}/topos/envoi_topo_rando.php?s={s}&m={m}{edition}" method="post" name="formulaire">	
				<label for="nom_topo">Nom de l'itinéraire : </label>
					<input type="text" name="nom_topo" id="nom_topo" value="{nom_topo}"/><br />
							
				<label for="orientation">Orientation : </label>
					<select name="orientation">
						<option value=""></option>
						<option value="N">N</option>
						<option value="NE">NE</option>
						<option value="E">E</option>
						<option value="SE">SE</option>
						<option value="S">S</option>
						<option value="SW">SW</option>
						<option value="W">W</option>
						<option value="NW">NW</option>
						<option value="T">Toutes</option>
					</select><br />
				<label for="denni">Dénnivelés : </label>
					<input type="text" name="denni" id="denni" value="{denni}"/><br />
				<label for="diff_monte">Difficultée de montée:</label> 		
					<select name="diff_monte" id="diff_monte">
						<option value=""></option>
						<option value="R">R</option>
						<option value="F">F</option>
						<option value="PD-">PD-</option>
						<option value="PD" selected="selected">PD</option>
						<option value="PD+">PD+</option>
						<option value="AD-">AD-</option>
						<option value="AD">AD</option>
						<option value="AD+">AD+</option>
						<option value="D-">D-</option>
						<option value="D">D</option>
						<option value="D+">D+</option>
						<option value="TD-">TD-</option>
						<option value="TD">TD</option>
						<option value="TD+">TD+</option>
					</select><br />
				<br />
				
				<br />
				
				<!---Liste des cartes--->
				<label for="carte">Carte :</label>	
					<span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">
				<---TYPE2--->
					<input type="checkbox" name="carte[]" id="carte[]" value="{TYPE2.id_carte}">{TYPE2.num_carte} - {TYPE2.nom_carte}<br />
				</---TYPE2--->
				</span>
				<label for="depart">Départ :</label>	
				<select name="depart" id="depart">
					<---TYPE3--->
						<option value="{TYPE3.id_depart}" {TYPE3.select}>{TYPE3.lieu_depart} - {TYPE3.alt_depart} m</option>
					</---TYPE3--->
				</select> <a href="ajouter-un-depart-m{id_massif}.html" onclick="window.open('ajouter-un-depart-m{id_massif}.html','','scrollbars=yes,width=500,height=350');return false">Ajouter un d鰡rt</a><br />
		</label>
				<label for="nb_jours">Nombre de jours :</label>		
					<select name="nb_jours" id="nb_jours">
						<option value=""></option>
						<option value="0,5">1/2</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="P6">+6</option>
					</select><br />
				<label for="type_iti">Type d'itinéraire :</label>		
					<select name="type_iti" id="type_iti">
						<---TYPE4--->
							<option value="{TYPE4.id_type_iti}" {TYPE4.select}>{TYPE4.nom_type_iti}</option>
						</---TYPE4--->
					</select><br />
				
				<br />			
					
				<label for="intro">Itinéraire :</label><br />
				<include form="../bouton_form.tpl" prev="intro" sign="0" url="popupload-8-intro.html" />
			
				<label for="conclu">Remarques :</label><br />
				<include form="../bouton_form.tpl" prev="conclu" sign="0" url="popupload-8-conclu.html" />
				
				
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