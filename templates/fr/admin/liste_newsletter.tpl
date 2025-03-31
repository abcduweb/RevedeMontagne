<include file="../header.tpl" />
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Les newsletter {status}</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
		<div class="bouton_forum"><a href="{DOMAINE}rediger-une-newsletter.html"><img src="{DOMAINE}/templates/images/1/forum/ajout.png" alt="Ajouter une Newsletter"></a></div>
			<table class= "listemess">
			<thead>
				<tr>
					<th colspan="9" class="num_page">{liste_page}</th>
				</tr>
				<tr class="intitules_tabl">
					<th>Titre de la newsletter</th>
					<th>Date d'envoi</th>
					<th>Modifier</th>
					<th>Supprimer</th>
					<th>Envoyer</th>
				</tr>
			</thead>
			<tfoot>
				<tr><td colspan="6" class="num_page">{liste_page}</td></tr>
			</tfoot>
			<tbody>
			<---NEWS--->
				<tr>
					<td><a href="{titre_news_url}-n{newsletter_id}.html">{titre_news}</a></td>
					<td>le : {date-news}</td>
					<td class="modifier"><a href="editer-{newsletter_id}-newsletter.html">Editer</a></td>
					<td class="supprimer"><a href="administration/action_newsletter.php?action=6&nid={newsletter_id}">Supprimer</a></td>
					<td class="envoyer"><a href="administration/action_newsletter.php?action=3&nid={newsletter_id}">Envoyer</a></td>
				</tr>
			</---NEWS--->
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