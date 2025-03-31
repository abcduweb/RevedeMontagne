<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-des-refuges.html">liste des refuges</a> &gt;
	liste des cabanes et refuges
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des refuges</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			Choisir le massif
			<table>
			<---MASSIFG--->
				<tr class="massif_groupe">
					<td colspan = "2">{MASSIFG.nomg}</td>
				</tr>
					<---MASSIF--->
						<tr class="ligne{ligne}">
							<td class="nb_pts">({MASSIF.nb_refuge})</td><td><a href="{DOMAINE}liste-des-refuges-m{MASSIF.id_massif}.html">{MASSIF.nom_massif}</a></td>
						</tr>
					</---MASSIF--->
			</---MASSIFG--->
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


