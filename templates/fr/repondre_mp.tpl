<include file="header.tpl" />
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="liste-mp.html">Message Priv&eacute;</a> &gt;
		<a href="mp-{id_disc}-{titre_url_disc}.html">{titre_disc}</a> &gt;
		Envoyer un message
	</div>
	<div class="cadre">			
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Envoyer uen r&eacute;ponse</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">	
				<form action="actions/submit_reponse_mp.php?idd={id_disc}" method="post" name="formulaire" id="formulaire">
					<fieldset>
						<legend>Réponse</legend>
						<include form="bouton_form.tpl" prev="texte" sign="1" url="popupload-5-{id_disc}-texte.html" />	
						<div class="send buttons">
							<button type="submit" value="Envoyer" class="positive">
								<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
								Envoyer 
							</button>
						</div>
					</fieldset>
				</form>
				
				<div class="liste_dernier_message">
					<table>
						<---MESSAGES--->
							<tr id="r{id_message}" class="ligne{ligne}">
								<td class="taille_infos">
									<img src="{DOMAINE}/templates/images/{design}/grade/{enligne}.png" alt="{enligne}" /> <a href="membres-{id_auteur}-fiche.html">{auteur}</a>
								</td>
								<td class="info_message">
									<a href="#r{id_message}">#</a> Post&eacute; {date}.
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
					</table>
				</div>
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