<include file="../header.tpl" />

	<div class="arbre">Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="{ROOT}liste-des-departs.html">liste des d&eacute;parts</a> &gt; 					
		{nom_depart}
	</div>
		
		
	<h1>{nom_depart} - {altitude} m</h1>
			
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Informations g&eacute;n&eacute;rale</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
					<!---Informations générales concernant le topos--->
				<ul>
					<li>Nom : {nom_depart}</li>
					<li>Acc&egrave;s : {acces}</li>
					<li>Massif : {massif}</li>
					<li>Altitude : {altitude} m</li>
				</ul>
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

	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Topos acc&eacute;ssibles depuis ce d&eacute;part</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
		<br />
			<div class="cadre_1_cd">
				<ul>
					<---TOPOS--->
					<li><a href="{TOPOS.nom_topo_url}-t{TOPOS.id_topo}.html">{TOPOS.nom_topo}</a>
					({TOPOS.orientation}, {TOPOS.diff1}, {TOPOS.alti} m)</li>					
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

<include file="../footer.tpl" />