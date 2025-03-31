<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-topos-skis-rando.html">liste des topos de skis de randonée</a> &gt;  
	<a href="#">{massif}</a> &gt;  
	<a href="/detail-rochers-de-lours-{id_som}-2.html">{sommet}</a> &gt;  
	Editer du topo
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Edition d'un topo</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<br />
			<!--- D颵t du formulaire--->
			<form enctype="multipart/form-data" action="{DOMAINE}/topos/envoi_topo_skis.php?s={s}{edition}" method="post">	
				<label for="nom_topo">Nom de l'itinéraire : </label>
					<input type="text" name="nom_topo" id="nom_topo" value="{nom_topo}"/><br />
							
				<label for="orientation">Orientation : </label>
					<select name="orientation">
						{orientation}
					</select><br />
				<label for="denni">Dénnivelés : </label>
					<input type="text" name="denni" id="denni" value="{denni}"/><br />
				<label for="diff_monte">Difficultée de montée :</label> 		
					<select name="diff_monte" id="diff_monte">
						{diff_topo_monte}
					</select><br />
				<label for="diff_ski">Difficultée ski :</label>							
					<select name="diff_ski" id="dif_ski">
						{diff_ski}
					</select><br />
				<label for="expo">Exposition (1 à 4) :</label>		
					<select name="expo" id="expo">
						{expo}
					</select><br />
				
				<br />
				
				<!---Liste des cartes--->
				<label for="carte">Carte :</label>	
				<span style="display: block;height:80px;width:460px;border:1px solid #9DB3CB;overflow:auto;">
					{carte}
				</span>
				<label for="depart">Départ :</label>	
				<select name="depart" id="depart">
					{depart}
				</select> <a href="ajouter-un-depart-m{id_massif}.html">Ajouter un départ</a><br />
					
					
					
				<label for="pente">Pente : </label>
					<input type="text" name="pente" id="pente" value="{pente}"/><br />
				<label for="nb_jours">Nombre de jours :</label>		
					<select name="nb_jours" id="nb_jours">
						{nb_jours}
					</select><br />
				<label for="type_iti">Type d'itinéraire :</label>		
					<select name="type_iti" id="type_iti">
						{type_iti}
					</select><br />
				
				<br />			
					
				<label for="intro">Itinéraire :</label><br />
				<include form="../bouton_form.tpl" prev="intro" sign="0" url="popupload-8-{id_topo}-intro.html" />
			
				<label for="conclu">Remarques :</label><br />
				<include form="../bouton_form.tpl" prev="conclu" sign="0" url="popupload-8-{id_topo}-conclu.html" />
				
				
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