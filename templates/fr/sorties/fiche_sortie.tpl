<include file="../header.tpl" />

	<div class="arbre">Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="{ROOT}{nom_massif_url}-m{id_massif}.html">{massif}</a> &gt; 			
		<a href="{url_nom_sommet}">{nom_sommet}</a> &gt; 		
		<a href="{ROOT}{nom_topo_url}-{t}{id_topo}.html">{nom_topo}</a> &gt; 				
		sortie ajout&eacute;e le : {date_sortie} 
	</div>
		
		
	<h1>{nom_sommet}, {nom_topo}</h1>
	
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>M&eacute;t&eacute;o</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				{meteo}
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
	
	<!---Fin du cadre haut--->
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>R&eacute;cit de la Sortie</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
		<br />
			<div class="cadre_1_cd">
				{recit}
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
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Photos de la sortie</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
		<br />
			<div class="cadre_1_cd">
				<---PHOTO--->
					{PHOTO.photos}
				</---PHOTO--->
			</div>
		</div>		
		
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					<h2><a href="{DOMAINE}ajouter-photo-sortie-{ids}.html" onclick="ouvrir_page(this.href,'uploads',700,500); return false;">Ajouter des photos</a></h2>
				</div>
			</div>
		</div>	
	</div>
	
	<h2 class="voir_topo">
		<a href="{ROOT}{nom_topo_url}-{t}{id_t}.html">Voir le topo {nom_sommet}, {nom_topo}</a>
	</h2>
<include file="../footer.tpl" />