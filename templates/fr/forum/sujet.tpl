<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="forum.html">Forum</a> &gt;
	<a href="forum-c{id_cat}-{cat_titre_url}.html">{cat_titre}</a> &gt;
	<a href="forum-{niveaux_forum_id}-{niveaux_forum_titre_url}.html">{niveaux_forum_titre}</a> &gt;
	Liste des sujets
</div>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{niveaux_forum_titre}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="bouton_forum">
				{ajouter}
			</div>
				
			<div class="wp-pagenavi">
				Page(s) : {liste_page}
			</div>
			
			<ul class="list clearfix">
			<---TOPICS--->
				<li class="ligne{ligne}">
				<div class="row">
					<div class="sujet_gauche">
						<span class="postit"></span>
						<span><a href="forum-{id_forum}-{id_sujet}-{titre_url}.html">
							<h3>{titre}</h3>
						</a><br />
						{sous_titre}<br />
						Auteur :
							<strong>
								<img src="{DOMAINE}/templates/images/{design}/grade/{c_enligne}.png" alt="{c_enligne}" /> 
								<a href="membres-{id_auteur}-fiche.html">{createur}</a>
							</strong>
						</span>
					</div>
					<div class="sujet_droite">
						<span>Dernier message : <br />
						Le : <a href="forum-{id_forum}-{id_sujet}-r{id_last_msg}-{titre_url}.html#r{id_last_msg}">{date}</a><br />
						Par : <img src="{DOMAINE}/templates/images/{design}/grade/{p_enligne}.png" alt="{p_enligne}" /> 
						<a href="membres-{id_dernier_posteur}-fiche.html">{dernier_posteur}</a>
						</span>
					</div>
					<div class="sujet_centre">
						<span>
							{nb_reponse} message(s)
							<!--- <br />
							{nb_lecture} vue(s) ---!>
						</span>
					</div>

				</div>
				</li>
			</---TOPICS--->
			</ul>


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