<include file="../header.tpl" />
	<div class="arbre">Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt; 
		<a href="admin.html">Administration</a> &gt; 
		gestion des cat&eacute;gories du forum
	</div>
	<div class="cadre">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Gestion des cat&eacute;gories du forum</h2>
			</div>
		</div>
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<form action="actions/add_cat.php" method="post">
					<fieldset>
						<legend>Ajouter une cat&eacute;gorie</legend>
							<label for="nom">Nom : </label>
							<input type="text" name="nom" /><br />
							<label for="nom_forum">Forum : </label>
							<input type="text" name="nom_forum" /><br />
							<label for="description">Description</label>
							<input type="text" name="description" /><br />
							<---GROUPES--->
							<label for="auth[{nom_group}]">{nom_group}</label>
							<input type="checkbox" name="auth[{id_group}][add]" {ajouter.checked} title="ajouter message et sujet" />
							<input type="checkbox" name="auth[{id_group}][modifier]" {modifier_tout.checked} title="modifier tous les messages" />
							<input type="checkbox" name="auth[{id_group}][supprimer]" {supprimer.checked} title="supprimer les messages" />
							<input type="checkbox" name="auth[{id_group}][afficher]" {afficher.checked} title="lire le forum" />
							<input type="checkbox" name="auth[{id_group}][close]" {interdire_topics.checked} title="fermer les sujets" />
							<input type="checkbox" name="auth[{id_group}][move]" {move.checked} title="déplacer un sujet" />
							<input type="checkbox" name="auth[{id_group}][add_forum]" {add_forum.checked} title="ajouter des forum" /><br />
							</---GROUPES--->
							<input type="submit" value="ajouter" />
					</fieldset>
				</form>
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