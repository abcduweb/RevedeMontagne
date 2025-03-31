<include file="../headers/header_common_head.tpl" />
<include file="../headers/header_scriptaculous.tpl" />
<include file="../headers/header_common_body.tpl" />
<div class="arbre">Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="contributions.html">Mes Contributions</a> &gt;
	<a href="participer.html">participer</a> &gt;
	Rédaction 
</div>

<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajouter un topo</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form enctype="multipart/form-data" action="participer.html" method="post">
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
			<br />
			<table>
			<thead>
				<tr class="intitules_tabl">					
					<th>Liste des sommets</th>
				</tr>
			</thead>
			<tbody>
				{sommet}
			</tbody>
			<tfoot>
				<tr>
					<th>
						<h2><a href="./ajouter-un-sommet-m{massif}.html">Ajouter un sommet au massif</a></h2>
					</th>
				</tr>
			</tfoot>
			</table>
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