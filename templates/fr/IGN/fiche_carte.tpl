<include file="../headers/header_common_head.tpl" />
<!-- style geoportail -->
<style type="text/css"><!--/*--><![CDATA[/*><!--*/
	div#viewerDiv {
	width:800px;
	height:600px;
	margin:auto;
	background-color:white;
	background-image:url(http://api.ign.fr/geoportail/api/js/latest/theme/geoportal/img/loading.gif);
	background-position:center center;
	background-repeat:no-repeat;
	}
	/*]]>*/-->
</style>
<!-- intÃ©gration script geoportail -->
<script type="text/javascript" src="http://api.ign.fr/geoportail/api/js/latest/Geoportal.js"><!-- --></script>
<include file="../headers/header_common_body.tpl" />

		<div class="arbre">Vous &#234;tes ici : 
			<a href="index.php">R&ecirc;ve de montagne</a> &gt;
			<a href="liste-des-cartes-ign.html">liste des carte IGN</a> &gt; 			
			<a href="#">{nom_sommet}</a> &gt; information sur la carte
		</div>
		<h1>{nom_carte}</h1>
		
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>&nbsp;</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<h3 class="titre1">{nom_carte}</h3>
				<br /><br />
				<div class="flot_gauche"><img src="{DOMAINE}/images/carte/{num_carte}.jpg" alt="aperçu carte IGN" style="width:70%;"/></div>
				S&eacute;rie : {editeur_carte}, {serie_carte}<br />
				Echelle : {echelle_carte}<br />
				<br /><br />
				<h4 class="titre2">Topos de skis de randonn&eacute;es associ&eacute;s</h4>
				<ul>
					<li><a href="topo-{urlts1}-t{idts1}.html">{toposki1}</a></li>
					<li><a href="topo-{urlts2}-t{idts2}.html">{toposki2}</a></li>
					<li><a href="topo-{urlts3}-t{idts3}.html">{toposki3}</a></li>
					<li><a href="topo-{urlts4}-t{idts4}.html">{toposki4}</a></li>
					<li><a href="topo-{urlts5}-t{idts5}.html">{toposki5}</a></li>
					<li><a href="topo-{urlts6}-t{idts6}.html">{toposki6}</a></li>
				</ul>
				<a href="{ROOT}liste-des-topos-skis-rando.html">Voir tous les topos</a><br /><br />
				
				<h4 class="titre2">Topos de randonn&eacute;es associ&eacute;s</h4>
				<ul>
					<li><a href="topo-{urltr1}-tr{idtr1}.html">{toporando1}</a></li>
					<li><a href="topo-{urltr2}-tr{idtr2}.html">{toporando2}</a></li>
					<li><a href="topo-{urltr3}-tr{idtr3}.html">{toporando3}</a></li>
					<li><a href="topo-{urltr4}-tr{idtr4}.html">{toporando4}</a></li>
					<li><a href="topo-{urltr5}-tr{idtr5}.html">{toporando5}</a></li>
					<li><a href="topo-{urltr6}-tr{idtr6}.html">{toporando6}</a></li>
				</ul>		
				<a href="{ROOT}liste-des-topos-de-randonnee.html">Voir tous les topos</a><br />
				<br />
				<a href="http://track.effiliation.com/servlet/effi.redir?id_compteur=15056087&url={url_acheter}" target="blanck"><img src="{DOMAINE}templates/images/1/acheter.png" alt="acheter"</a>
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
