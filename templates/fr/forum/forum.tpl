<include file="../header.tpl" />
<div class="arbre">
	Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="forum.html">Forum</a> &gt;
	Liste des cat&#233;gories
</div>
	
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Forum</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">	
			<---THEMES--->
			<div class="lp_rdm">
				<h2>{info_theme_titre}</h2>
			</div>
			<div class="lp_rdm">
				<div class="row">
					<---FORUM--->
					<div class="col4 col6-s">
						<div class="category-forum">
							<a href="{DOMAINE}forum-{id_forum}-{titre_url}.html" class="category-forum__top">
								<!---
									<span data-image-cdn-attr-src="icone_forum.png" data-image-cdn-attr-alt="{titre_forum}" data-image-cdn-width="45" data-image-cdn-attr-class="category-forum__illustration"><img class="category-forum__illustration" width="45" src="icone_forum.png" /></span>
								--->
								<div class="category-forum__illustrated">
									<div class="category-forum__title"> 
										<img src="{DOMAINE}/templates/images/{design}/forum/{flag}.png" alt="{flag}"/>
										{titre_forum}
									</div>
									<div class="category-forum__description">{description}</div>
								</div>
							</a>
							<a title="{titre_forum}" href="forum-{id_forum}-{id_dernier_sujet}-{titre_dernier_sujet_url}.html" class="category-forum__bottom">
								<hr>
								<strong><span class="category-forum__last-msg">Dernier message :</span></strong>
								<br />
								<div class="category-forum__last-msg-link">
								{titre_dernier_sujet}<br />
								Par : <img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> {dernier_posteur}<br />
								Le : {date_dernier_message}
								</div>
							</a>
						</div>
					</div>
					</---FORUM--->
				</div>
			</div>
			</---THEMES--->			
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
