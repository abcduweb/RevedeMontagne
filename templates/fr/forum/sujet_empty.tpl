<include file="../header.tpl" />

<span class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a> &gt;
	<a href="forum.html">Forum</a> &gt;
	<a href="forum-c{id_cat}-{cat_titre_url}.html">{cat_titre}</a> &gt;
	<a href="forum-{niveaux_forum_id}-{niveaux_forum_titre_url}.html">{niveaux_forum_titre}</a> &gt;
	Liste des sujets
</span>

<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>{niveaux_forum_titre}</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<div class="text-article centre">Pas de sujet dans ce forum<br />
				<a href="ajouter-sujet-{niveaux_forum_id}.html">Ajouter un sujet</a>
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