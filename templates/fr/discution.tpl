<include file="header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="liste-mp.html">Messages priv&eacute;</a> &gt;
	Liste des discutions
</div>
<div class="cadre">			
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Discutions</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<div class="bouton_forum">
				<a href="creer-discution.html"><img src="{DOMAINE}/templates/images/{design}/MP/ajout.png" alt="Envoyer un nouveau message" /></a>
			</div>

			<form action="actions/supprimer_mp.php" method="post">
				<table class="listemess">
					<thead>
						<tr class="head_tableau">
							<th>&nbsp;</th>
							<th>Titre message</th>
							<th>Cr&#233;ateur</th>
							<th>Page(s)</th>
							<th>R&#233;ponses</th>
							<th>Lectures</th>
							<th>Dernier message</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
							<th colspan="8">					
								<div class="wp-pagenavi">
									Page(s) : {liste_page}
								</div>
							</th>
						</tr>
					</tfoot>
					<tbody>
						<---DISCUTIONS--->
							<tr class="ligne{ligne}">
								<td class="drapeau_forum">
									<img src="{DOMAINE}/templates/images/{design}/forum/{flag}.png" alt="{flag}" />
								</td>
								<td class="sujet_titre">
									<a href="mp-{id_disc}-{titre_url}.html">{titre}</a><br />
									<span class="description_forum">{sous_titre}</span>
								</td>
								<td class="sujet_createur"><img src="templates/images/{design}/grade/{c_enligne}.png" alt="{c_enligne}" /> <a href="membres-{id_auteur}-fiche.html">{createur}</a></td>
								<td class="sujet_page">
									{liste_page_sujet}
								</td>
								<td class="sujet_nb_reponse">
									{nb_reponse}
								</td>
								<td class="sujet_nb_lecture">
									{nb_lecture}
								</td>
								<td class="forum_dernier_message">
									<a href="mp-{id_disc}-r{id_last_msg}-{titre_url}.html#r{id_last_msg}">{date}</a><br />
									Par : <img src="{DOMAINE}/templates/images/{design}/grade/{p_enligne}.png" alt="{p_enligne}" /> <a href="membres-{id_dernier_posteur}-fiche.html">{dernier_posteur}</a>
								</td>
								<td class="col_autre">
									<input type="checkbox" name="discution[{id_disc}]" />
								</td>
							</tr>
						</---DISCUTIONS--->
					</tbody>
				</table>
				<br />
				<div class="buttons bouton_forum">
					<button type="submit" value="Supprimer les messages sélectionnés" class="negative">
						<img src="{DOMAINE}/templates/images/{design}/cross.png" alt="Envoyer"/> 
						Supprimer les messages sélectionnées 
					</button>
				</div>
			</form>
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