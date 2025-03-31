<include file="../header.tpl" />	
			
<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="forum.html">Forum</a> &gt; <a href="forum-c{niveau_cat_id}-{niveau_cat_titre_url}.html">{niveau_cat_titre}</a> &gt; <a href="forum-{niveau_forum_id}-{niveau_forum_titre_url}.html">{niveau_forum_titre}</a> &gt; <a href="forum-{niveau_forum_id}-{niveau_sujet_id}-{niveau_sujet_titre_url}.html">{niveau_sujet_titre}</a> &gt; Lectures des messages</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{niveau_sujet_titre}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">{epingle}&nbsp;{opcl}&nbsp;{deplacer}&nbsp;{repondre}</div>
					
			<div class="wp-pagenavi">
				Page(s) : {liste_page}
			</div>
			<table>
				<thead>
					<tr class="head_tableau">
						<th class="taille_infos">Auteur</th>
						<th>Message</th>
					</tr>
				</thead>
				<tbody>
				<---MESSAGES--->
					<tr id="r{id_message}" class="ligne{ligne}">
						<td>
							<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres-{id_auteur}-fiche.html">{auteur}</a>
						</td>
						<td class="info_message">
							<a href="#r{id_message}">#</a> Post&#233; {date}. 
							{actions_possibles}
						</td>
					</tr>
					<tr class="ligne{ligne}">
						<td class="infos_membre">
							{avatar}<br />
							{group}<br />
						</td>
						<td{edit_rapide}>
							<div class="boite_message">
								{message}
							</div>
						</td>
					</tr>
				</---MESSAGES--->
				</tbody>
			</table>
			<div class="bouton_forum">{epingle}&nbsp;{opcl}&nbsp;{deplacer}&nbsp;{repondre}</div>
			<h2 class="retour_forum">
				Retour au forum <a href="forum-{niveau_forum_id}-{niveau_forum_titre_url}.html">{niveau_forum_titre}</a>
			</h2>
			<h2 class="retour_forum">
				Retour à la <a href="forum.html">liste des forums</a>
			</h2>
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
