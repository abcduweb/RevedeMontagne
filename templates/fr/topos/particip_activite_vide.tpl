<include file="../headers/header_common_head.tpl" />
<!-- Rédaction d'un nouveau topo -->
<script language="JavaScript" type="text/javascript">
jQuery(document).ready(function($) {
// Function to change form action.
$("#db").change(function() {
var selected = $(this).children(":selected").text();
switch (selected) {
case "Randonnées pédestre":
$("#myform").attr('action', 'ajouter-un-topo-de-randonnees-{ids}.html');
break;
case "Skis de randonnée":
$("#myform").attr('action', 'ajouter-un-topo-de-skis-de-rando-{ids}.html');
break;
case "VTT":
alert("Fonction non disponible pour le moment");
break;
case "Cascade de glace":
alert("Fonction non disponible pour le moment");
break;
case "Surf de randonnée":
alert("Fonction non disponible pour le moment");
break;
case "Ski alpin":
alert("Fonction non disponible pour le moment");
break;
case "Telemark":
alert("Fonction non disponible pour le moment");
break;
case "Descente de Canyon":
alert("Fonction non disponible pour le moment");
break;
case "Sports aériens":
alert("Fonction non disponible pour le moment");
break;
case "Alpinisme":
alert("Fonction non disponible pour le moment");
break;
case "Escalade":
alert("Fonction non disponible pour le moment");
break;
case "Raquette":
alert("Fonction non disponible pour le moment");
break;
case "Ski nordique":
alert("Fonction non disponible pour le moment");
break;
case "Spéléo":
alert("Fonction non disponible pour le moment");
break;


default:
$("#myform").attr('action', '#');
}
});
				
// Function For Back Button
$(".back").click(function() {
parent.history.back();
return false;
});
});
</script>

<include file="../headers/header_common_body.tpl" />

<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	Choisir l'activité
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajouter un topo</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
		
		
		<form id="myform" method="post" name="myform">
		<select id="db">
				<option>Choisissez l'activité</option>
			<---ACTIVITE--->
				<option>{ACTIVITE.nom_act}</option>
			</---ACTIVITE--->
		</select>
		<input class="submit" id="submit" type="submit" value="Submit">
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