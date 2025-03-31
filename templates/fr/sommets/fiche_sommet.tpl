<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_common_h_carte_r.tpl" />
</head>

<body onload="initialize()">
	<include file="../headers/header_common_b_carte.tpl" />
		<div class="arbre">Vous &#234;tes ici : 
			<a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-des-sommets.html">liste des sommets</a> &gt; 			
			<a href="#">{nom_sommet}</a> &gt; information sur le sommet
		</div>
		<h1>{nom_sommet}</h1>
		
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
				<!---Informations générales concernant le sommet--->
					<ul>
						<li>Nom : {nom_sommet}</li>
						<li>Altitude : {alt_som}</li>
						<li>Massif : {massif}</li>
						<li>Carte : <---CARTE---><a href="#">{CARTE.nom_carte}</a> </---CARTE--->,<a href="http://www.visugpx.com/ign/?lat={lat}&lng={long}" target="_blank">Voir le fond de carte222</a></li>
						<li>Coordonnées : Lat/Long : {lat} N / {long} E</li>
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
		<br />
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
		<div id="cadre_haut">	
			<div class="cadre_gauche">
				<div class="cadre_1_hg">
					<div class="cadre_1_hd">
						<h5>Topos associès</h5>
					</div>
				</div>  
				<div class="cadre_1_cg">
					<div class="cadre_1_cd">	
						<ul>
							<---TOPOS--->
								<li><a href="{TOPOS.nom_topo_url}-t{TOPOS.id_topo}.html">{TOPOS.nom_topo}</a>
								- Orientation : {TOPOS.orientation}, Difficultés : {TOPOS.diff1}, Altitude {TOPOS.alti} m</li>					
							</---TOPOS--->
						</ul>
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
			<!--Fin cadre gauche-->			
					
			<!--Cadre droite-->
			<div class="cadre_droite">	
				<div class="cadre_1_hg">
					<div class="cadre_1_hd">
						<h5>Dernières sorties</h5>
					</div>
				</div>  
				<div class="cadre_1_cg">
					<div class="cadre_1_cd">	
						<---SORTIES--->
							{SORTIES.nom_photos}					
						</---SORTIES--->
					</div>
				</div>
				<div class="cadre_1_bg">
					<div class="cadre_1_bd">
						<div class="cadre_1_b">
						
						</div>
					</div>
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

				<table>
					<thead>
						<tr>
							<th class="taille_infos">Pseudo</th>
							<th>Commentaires</th>
						</tr>	
					</thead>
							<tfoot>
								<tr>
									<th colspan="2">
										<div class="wp-pagenavi">
											Page(s) : <---PAGES--->{page}</---PAGES--->
										</div>
									</th>
								</tr>
							</tfoot>
					<tbody>
						<---COMM--->
							<tr id="r{id_com}">
								<td>
									<img src="{DOMAINE}/templates/images/{design}/grade/{status}.png" alt="{status}" /> {pseudo}
								</td>
								<td class="info_message">
									<a href="#r{id_com}">#</a> {date_com} {editer} {supprimer}
								</td>
							</tr>
							<tr>
								<td class="infos_membre">
								{avatar}<br />
								{img_rang}
								</td>
								<td>
									<div class="boite_message">
										{commentaire} {signature}
									</div>
								</td>
							</tr>
						</---COMM--->
					</tbody>
				</table>
			<div class="bouton_forum">{repondre}</div>
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
				&nbsp	
				</div>
			</div>
		</div>		
<include file="../footer.tpl" />