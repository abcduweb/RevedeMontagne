<include file="../header.tpl" />

<div class="arbre">Vous &#234;tes ici : <a href="index.php">R&ecirc;ve de montagne</a> &gt; <a href="forum.html">Forum</a> &gt; <a href="forum-c{id_cat}-{cat_titre_url}.html">{info_theme_titre}</a> &gt; Liste des forums</div>
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{info_theme_titre}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			{info_theme_titre}
			<div class="lp_rdm">
				<div class="row">
					<---FORUM--->
						<div class="col4 col6-s">
							<div class="category-forum">
								<!--- ligne{ligne} --->
								<a href="forum-{id_forum}-{titre_url}.html" class="category-forum__top">
									<div class="category-forum__illustrated">
										<div class="category-forum__title">
											<img src="{DOMAINE}/templates/images/{design}/forum/{flag}.png" alt="{flag}"/>
											{titre_forum} ({nombre_de_sujet} / {nombre_de_reponse})
										</div>
										<div class="category-forum__description">
											{description}<br />
										</div>
									</div>
								</a>
								<a href="forum-{id_forum}-{id_dernier_sujet}-{titre_dernier_sujet_url}.html" class="category-forum__bottom">
									<hr>
									<strong><span class="category-forum__last-msg">Dernier message :</span></strong>
									<br />
									<div class="category-forum__last-msg-link">
										Dans : {titre_dernier_sujet}<br />
										Par : <img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> {dernier_posteur}<br />
										Le : {date_dernier_message}
									</div>
								</a>
							</div>
						</div>
					</---FORUM--->
				</div>
			</div>

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