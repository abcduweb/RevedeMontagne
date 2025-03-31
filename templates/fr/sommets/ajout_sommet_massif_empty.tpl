<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_scriptaculous.tpl" />
<include file="../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-sommets.html">liste des sommets</a> &gt;
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Choix du massif</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<form enctype="multipart/form-data" action="ajouter-un-sommet.html" method="get">
			<select name="massif" id="massif">
				<option value="0">Choix du massif (Obligatoire)</option>
				<---MASSIFG--->
					<optgroup label="{MASSIFG.nomg}">
						<---MASSIF--->
							<option value="{MASSIF.id_massif}" {MASSIF.selected}>{MASSIF.nom_massif}</option>
						</---MASSIF--->
					</optgroup>
				</---MASSIFG--->
			</select>
			<input type="submit" value="Chercher" />
			</form>
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