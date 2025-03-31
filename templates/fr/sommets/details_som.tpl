<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_common_h_carte_r.tpl" />

</head>

<body onload="initialize()">
	<include file="../headers/header_common_b_carte.tpl" />
	<div id="corps">
		<div class="arbre">Vous &#234;tes ici : 
			<a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-sommets.html">liste des sommets</a> &gt; 			
			<a href="#">{nom_som}</a> &gt; information sur le sommet
		</div>
		<h1>{nom_som}</h1>
		<div class="rmq attention">
			Toutes les informations indiqu�es dans cet article sont susceptibles d'�voluer. Veuillez vous tenir inform� avant toutes nouvelles sorties. L'auteur d�cline toutes responsabilit�s en cas d'accidents ou d'incidents survenant dans les itin�raires choisit.
		</div>
		<br />
		<div class="infos_g�n�">
			<div class="infos_hg">
				<div class="infos_hd">
					<h2>Informations g�n�rales</h2>
				</div>
			</div>
			<div class="infos_cg">
				<div class="infos_cd int_gene">
					<!---Informations g�n�rales concernant la cabane--->
					<strong>D�tail pour : {nom_cabane}</strong>, {type_cabane}<br />
					<strong>Couchage : </strong> {nbre_place} places<br />
					<br />					
					Informations G�ographique : <br />
					<strong>Altitude : </strong> {altitude} m�tres<br />
					<strong>Latitude : </strong> {latitude} <br />
					<strong>Longitude : </strong> {longitude} <br />
					<br />
					<strong>Mise en ligne :</strong> {creation} par <a href="membres-{mid1}-fiche.html">{pseudo1}</a><br />
					<strong>Derni�re mise � jour :</strong> {maj}<br />
					
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
					<h2>Dernier commentaire</h2>
				</div>
			</div>

			<div class="infos_cg">
				<div class="infos_cd ">


				
					<div id="map_canvas"></div>
				
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
	

		
		
		
		

		

		
		
		
		<div class="anti-float">
			<div class="sign">
				<div class="infos_hg">
					<div class="infos_hd">
						<h2>Acc�s</h2>
					</div>
				</div>
				<div class="infos_cg">
					<div class="infos_cd">		
						{refuge_acces}	
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
		
		
		
			<div class="bio">
				<div class="infos_hg">
					<div class="infos_hd">
						<h2>Information sur la cabane</h2>
					</div>
				</div>
				<div class="infos_cg">
					<div class="infos_cd">	
						{refuge.infos1}
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
			
			<div class="bio">
				<div class="infos_hg">
					<div class="infos_hd">
						<h2>Photos</h2>
					</div>
				</div>
				<div class="infos_cg">
					<div class="infos_cd">	
					
					<---PHOTOS--->
						{PHOTOS.nom_photos}					
					</---PHOTOS--->
					
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
			
			
			<div class="bio">
				<div class="infos_hg">
					<div class="infos_hd">
						<h2>Commentaires</h2>
					</div>
				</div>
				<div class="infos_cg">
					<div class="infos_cd">	
					<table>
						<thead>
							<tr class="head_tableau">
								<th colspan="2" class="num_page">
								Page(s) : 
								<---PAGES--->
								{page}
								</---PAGES--->
								</th>
							</tr>
							<tr>
								<th class="taille_infos">Pseudo</th>
								<th>Commentaires</th>
							</tr>	
						</thead>
						<tfoot>
							<tr>
								<th colspan="2" class="num_page">
								Page(s) : 
								<---PAGES--->
								{page}
								</---PAGES--->
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
				<div class="infos_bg">
					<div class="infos_bd">
						<div class="infos_b">
							&nbsp;
						</div>
					</div>
				</div>
			</div>
			
		</div>
		


		
	</div>



<include file="../footer.tpl" />