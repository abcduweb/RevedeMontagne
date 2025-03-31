<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="admin.html">Administration</a> &gt;
		Accueil administration
	</div>
		
	<div class="cadregd">			
		<!--Cadre gauche-->
		<div class="cadre_gauche">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Gestions membres / groupes</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">

					{section_group}
					{section_membres}
				
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
		<!--Fin cadre gauche-->			
				
		<!--Cadre droite-->
		<div class="cadre_droite">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>L'Album Photos</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
				<br />
				
					{section_album}
				
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
		<!--Fin cadre droite-->
	</div>
	<br />
	<div class="cadregd">			
		<!--Cadre gauche-->
		<div class="cadre_gauche">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Les News</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">

					{section_news}
				
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
		<!--Fin cadre gauche-->			
				
		<!--Cadre droite-->
		<div class="cadre_droite">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Topos / points charactèristiques</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
					{section_pts}
					{section_topo}
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
		<!--Fin cadre droite-->
	</div>
	<br />
	<div class="cadregd">			
		<!--Cadre gauche-->
		<div class="cadre_gauche">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Le forum</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">

					{section_forum}
				
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
		<!--Fin cadre gauche-->			
				
		<!--Cadre droite-->
		<div class="cadre_droite">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Les Articles</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
				
					{section_article}
				
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
		<!--Fin cadre droite-->
	</div>
<include file="../footer.tpl" />