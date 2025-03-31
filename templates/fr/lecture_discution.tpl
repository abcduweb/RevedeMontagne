<include file="header.tpl" />		
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-mp.html">Message Priv&eacute;</a> &gt;
	<a href="mp-{id_disc}-{titre_url_disc}.html">{titre_disc}</a> &gt;
	Lectures des messages
</div>
<div class="cadre">			
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{titre_disc}</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<ul>
				{inviter}
				<---PARTICIPANTS--->
					<li>{supprimer} {in}<a href="membres-{id_participant}-fiche.html">{pseudo_participant}</a>{inend}</li>
				</---PARTICIPANTS--->
			</ul>
			<div class="bouton_forum">{repondre}</div>
			<table>
				<thead>
					<tr>
						<th class="taille_infos">Nom</th>
						<th>Message</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th colspan="2">					
							<div class="wp-pagenavi">
								Page(s) : {liste_page}
							</div>
						</th>
					</tr>
				</tfoot>
				<tbody>
					<---MESSAGES--->
						<tr id="r{id_message}" class="ligne{ligne}">
							<td>
								<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres-{id_auteur}-fiche.html">{auteur}</a>
							</td>
							<td class="info_message">
								<a href="#r{id_message}">#</a> Post&eacute; {date}. {citation}
							</td>
						</tr>
						<tr class="ligne{ligne}">
							<td class="infos_membre">
								{avatar}<br />
								{group}
							</td>
							<td>
								<div class="boite_message">
									{message}
								</div>
							</td>
						</tr>
					</---MESSAGES--->
				</tbody>
			</table>
			<div class="bouton_forum">{repondre}</div>
		</div>
	</div>			
	<div class="cadre_1_bg">
		<div class="cadre_1_bd">
			<div class="cadre_1_b">.
				&nbsp	
			</div>
		</div>
	</div>
</div>
<include file="footer.tpl" />