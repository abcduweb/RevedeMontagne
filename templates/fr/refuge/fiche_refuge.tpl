<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_common_h_carte_r.tpl" />
</head>
<body onload="initialize()">
	<include file="../headers/header_common_b_carte.tpl" />
		<div class="arbre">Vous &#234;tes ici : 
			<a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-refuge.html">liste des refuges</a> &gt; 			
			<a href="#">{nom_cabane}</a> &gt; information sur la cabane
		</div>
		<h1>{nom_cabane}</h1>
		<div class="rmq attention">
			Toutes les informations indiquées dans cet article sont susceptibles d'évoluer. Veuillez vous tenir informé avant toutes nouvelles sorties. L'auteur décline toutes responsabilités en cas d'accidents ou d'incidents survenant dans les itinéraires choisit.
		</div>
		<br />
		
		
			<div id="cadre_haut2">
		<div class="cadre_droite2">
			<div class="cadre_4_hg">
				<div class="cadre_4_hd">
					<h5>Publicité</h5>
				</div>
			</div>
			<div class="cadre_4_cg">
				<div class="cadre_4_cd centre">
					{pub3}
				</div>				
			</div>
			<div class="cadre_4_bg">			
				<div class="cadre_4_bd">
					<div class="cadre_4_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>
		<div class="cadre_gauche2">
			<div class="cadre_3_hg">
				<div class="cadre_3_hd">
					<h5>Informations</h5>
				</div>
			</div>
			<div class="cadre_3_cg">
				<div class="cadre_3_cd">
					<!---Informations générales concernant la cabane--->
					<ul class="liste_cercle">
						<li><strong>Détail pour : {nom_cabane}</strong>, {type_cabane}</li>
						<li><strong>Couchage : </strong> {nbre_place} places</li>				
						<li>Informations Géographique :
							<ul>
								<li><strong>Altitude : </strong> {altitude} mètres</li>
								<li><strong>Latitude : </strong> {latitude}</li>
								<li><strong>Longitude : </strong> {longitude}</li>
							</ul>
						</li>
						<li><strong>Mise en ligne :</strong> {creation} par <a href="membres-{mid1}-fiche.html">{pseudo1}</a></li>
						<li><strong>Dernière mise à jour :</strong></li>
					</ul>
				</div>
			</div>
			<div class="cadre_3_bg">
				<div class="cadre_3_bd">
					<div class="cadre_3_b">
						&nbsp;
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---Fin du cadre haut--->
	
		
		
		
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h5>Carte de situation</h5>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div id="zoom_canvas"></div>
			</div>
		</div>		
		
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>	
		
		
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h5>Accès</h5>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				{refuge_acces}	
			</div>
		</div>		
		
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>
		
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h5>Information sur la cabane</h5>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				{refuge.infos1}
			</div>
		</div>		
		
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>
		
			
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h5>Photos</h5>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
					
					<---PHOTOS--->
						{PHOTOS.nom_photos}					
					</---PHOTOS--->
			</div>
		</div>		
		
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>
		
	
		<h2>Derniers commentaires</h2>
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h5>&nbsp</h5>	
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				Il n'y a encore aucun commentaire sur cette photo. <br />
				{repondre}
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>	
						

		<div id="licence">
			Le contenu de cette pages et toutes les informations du site <a href="http://www.revedemontagne.com">rêve de montagne</a> concernant les refuges sont sous la licence 
			<a href="http://creativecommons.org/licenses/by-sa/2.0/deed.fr" target="_blank">"creative commons by-sa"</a>. Les coordonnées GPS proviennent éssentiellement du site 
			<a href="http://www.refuges.info" target="_blank">refuge.info</a>
		</div>



<include file="../footer.tpl" />