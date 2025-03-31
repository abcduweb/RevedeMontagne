<include file="../headers/header_common_head.tpl" />
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5719da4d1c679baf"></script>
<include file="../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="{ROOT}liste-des-topos-skis-rando.html">topos skis de rando</a> &gt; 
	<a href="{ROOT}liste-des-sommets-m{id_massif}.html">{massif}</a> &gt; 			
	<a href="{url_nom_sommet}">{nom_sommet}</a> &gt; 			
	{nom_topo}
</div>
<h1>{nom_sommet}, {nom_topo}</h1>
{validation}

<div class="cadregd">
	<div class="cadre_droite3">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Auteur</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd centre">
					<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="{DOMAINE}membres-{id_m}-fiche.html">{pseudo}</a>	<br />
					<div class="avatar-imp">{avatar}</div>					
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
	<div class="cadre_gauche3">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Informations générale</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
					<!---Informations gꯩrales concernant le topos--->
				<ul>
					<li>Massif : {massif}</li>
					<li>Orientation : {orientation}</li>
					<li>Dénivelé : {dennivele} m.</li>
					<li>Difficultée de montée : {difficulte}</li>
					<li>Difficultée ski : {difficulte_skis}</li>
					<li>Exposition (1 à 4) : {exposition}</li>
					{coms}
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
</div>

<div class="cadregd">	
	<div class="cadre_gauche">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Informations générales</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">			
				Cartes : 
				<---CARTE--->
					<a href="carte-ign-{CARTE.nom_url_carte}-n{CARTE.id_carte}.html">{CARTE.nom_carte}</a>
				</---CARTE---><br />
				Départ : {depart}<br />
				Altitude de départ : {alt_depart} m.<br />
					
				Pente : {pente}	<br />
				Nb de jours : {nb_jours}<br />
				Type : {type}
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
	<div class="cadre_droite">	
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Accés</h2>
			</div> 
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				<a href="depart-{url_nom_acces}-d{id_acces}.html">{nom_acces} ({alt_acces} m)</a> : <br /> 
				{acces}	
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
</div>

{fichierGPX}

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Itinéraire</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<br />
		<div class="cadre_1_cd">
			{itineraire}
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
			<h2>Remarques</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
	<br />
		<div class="cadre_1_cd">
			{remarques}
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
			<h2>Conditions récentes</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<---SORTIES--->
				<li>le {SORTIES.date} : <a href="{ROOT}{SORTIES.url_sommet}-{SORTIES.url_topo}-sortie-n{SORTIES.id_sortie}.html">{SORTIES.text_lien}</a> par : <a href="{ROOT}membres-{SORTIES.mid}-fiche.html">{SORTIES.pseudo}</a></li>					
			</---SORTIES--->	
		</div>
	</div>			
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">
				<h2>{ajout_sortie}{ajout_trace}</h2>
			</div>
		</div>
	</div>
</div>	
<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>&nbsp</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div id="avertissement">
				<h4 class="titre2">Avertissement</h4><br />
				Les informations fournies par ce site ne pourront en aucun cas engager la responsabilit&eacute; de revedemontagne et des personnes qui participent au site.<br />
				revedemontagne d&eacute;cline toute responsabilit&eacute; en cas d&acute;accident et ne pourra etre tenu pour responsable de quelque mani&egrave;re que ce soit.
			</div>
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
			
<div class="partage">
	<div class="addthis_sharing_toolbox"></div>
</div>
<include file="../footer.tpl" />