<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_scriptaculous.tpl" />
<include file="../headers/header_common_body.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : 
			<a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-des-topos-skis-rando.html">liste des topos de skis de randonnée</a> &gt;  
			<a href="ajouter-un-topo-de-skis-de-rando.html">Ajouter un topo</a> &gt; Rédaction
		</div>
		<h1>Ajout / Edition d'un sommet</h1>
		
		<form enctype="multipart/form-data" action="{DOMAINE}/topos/envoi_topos_skis.php{edition}" method="post">
		
		
		<label for="nom_topo">Choix de l'itinéraire :</label><input type="text" name="nom_topo" id="nom_topo" value="{nom_topo}"/>
		<br /><br />
		<div class="infos_géné">
			<div class="infos_hg">
				<div class="infos_hd">
					<h2>Informations générales</h2>
				</div>
			</div>
			<div class="infos_cg">
				<div class="infos_cd">			
					<div class="info_topo_droite">			
						
<br />
	
						<label for="denni">Dénivelé :</label>
						<input type="text" name="denni" id="denni" value="{denni}"/><br />



							
						Pente : {pente}°	<br />
						Nb de jours : {nb_jours}<br />
						Type : {type}
					</div>
				</div>
			</div>
			<div class="infos_bg">
				<div class="infos_bd">
					<div class="infos_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>
		
		
		<div class="infos_messagerie">
			<div class="infos_hg">
				<div class="infos_hd">
					<h2>Informations générales</h2>
				</div>
			</div>

			<div class="infos_cg">
				<div class="infos_cd ">		
					<br />				

					</label><br />
<br />
				</div>
			</div>
			<div class="infos_bg">

				<div class="infos_bd">
					<div class="infos_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>	
		
		
		
		
		
		
		
		
		
		
		
			<fieldset>
				<legend>Ajouter un topo de skis de randonnée</legend>						
	   
					<label for="altitude">Altitude :</label>
					<input type="text" name="altitude" id="altitude" value="{altitude}"/><br />
					
					<label for="latlng">Latitude / Longitude :</label>
					<input type="text" name="latitude" id="latlng" value="{lat}"/>
					<input type="text" name="longitude" id="latlng" value="{long}"/><br />
					
					<label for="gps">GPS :</label>
					<input type="text" name="gps" id="gps" value="{gps}"/><br />
					

					
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
<include file="../footer.tpl" />