<include file="../header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="admin.html">Administration</a> &gt; Liste des IPs bannies 
	</div>
	
	<div class="cadre">	
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Liste des IPs bannies</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<form method="get" action="actions/ban.php">
				<label for="ip">Bannir cette ip :</label> <input type="text" name="ip" id="ip" />
				<div class="send buttons"> 				
					<button type="submit" value="Envoyer l'image" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt=""/> 
						Envoyer 
					</button>
				</div>	
			</form>
			<table>
				<thead>
					<tr>
						<th>IP bannie</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<---IP--->
					<tr>
						<td class="col_autre">{ip}</td>
						<td class="col_autre"><a href="actions/deban.php?ip={ip}">D&eacute;bannir cette ip</a></td>
					</tr>
					</---IP--->
				</tbody>
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