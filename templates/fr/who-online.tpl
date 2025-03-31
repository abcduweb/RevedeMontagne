<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;  
		Affichage des personnes connect&eacute;es
	</div>

	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Membres connect&eacute;s actuellement</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				<table>
					<thead>
						<tr class="head_tableau">
							<th>Pseudo</th>
							<th>Groupe</th>
						</tr>
					</thead>
					<tbody class="centre">
					<---ENLIGNE--->
					<tr  class="ligne{ligne}">
						<td><a href="membres-{mid}-fiche.html">{pseudo}</a></td>
						<td>{groupe}</td>
					</tr>
					</---ENLIGNE--->
				</table>
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
<include file="footer.tpl" />