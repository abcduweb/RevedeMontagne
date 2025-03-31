<include file="./../headers/header_common_head.tpl" />
<!-- ########################################### -->
<!-- Script pour l'ajout / édition de message -->
<!-- ########################################### -->
<script type="text/javascript" src="{DOMAINE}/templates/js/form.js"></script>
<script type="text/javascript" src="{DOMAINE}/templates/js/edition.js"></script>
<include file="./../headers/header_common_body.tpl" />
			
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
			<ul class="list clearfix">
				<---MESSAGES--->
					<li class="ligne{ligne}" id="r{id_message}">
					<div class="row fmessage">
						<div class="message_gauche">
							<span>
								<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres-{id_auteur}-fiche.html">{auteur}</a><br />
								{avatar}<br />
								{group}
							</span>
						</div>
						<div class="message_droite">
							<div class="message_droite_haut">
								<a href="#r{id_message}">#</a> Post&#233; {date}. 
								{actions_possibles}
							</div>
							<br />
							<div class="message_droite_bas" {edit_rapide}>
								{message}
							</div>
						</div>
					</div>
					</li>
				</---MESSAGES--->
			</ul>
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
