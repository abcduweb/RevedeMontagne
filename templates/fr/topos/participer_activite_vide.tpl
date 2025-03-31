<include file="../headers/header_common_head.tpl" />

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