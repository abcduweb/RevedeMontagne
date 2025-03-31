<include file="../header.tpl" />

<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="{DOMAINE}prochains-evenements.html">Prochains &eacute;v&eacute;nements</a> &gt;
	<a href="evenement-{url_event}-n{id_event}.html">{name_event}</a> &gt; 					
	{date_debut_event}
</div>
		
<div class="cadre_1_hg">
	<div class="cadre_1_hd">
		<h5>{name_event}, {date_debut_event}</h5>
	</div>
</div>  
<div class="cadre_1_cg">
	<div class="cadre_1_cd">
		<h2>proposé par : <a href="{DOMAINE}membres-{id_m}-fiche.html">{pseudo_auteur}</a></h2>
		{event_parser}
		<br />
		Plus d'informations : <a href="{url_event}">{url_event}</a>
	</div>
</div>			
<div class="cadre_1_bg">
	<div class="cadre_1_bd">
		<div class="cadre_1_b">
		</div>
	</div>
</div>	

<include file="../footer.tpl" />