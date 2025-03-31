<include file="header.tpl" />            
	<div class="arbre">
		Vous &#234;tes ici : 
		<a href="index.php">R&ecirc;ve de montagne</a> &gt;
		<a href="index.php">Les News</a> &gt;
		Bienvenue
	</div>				
	<h1>Bienvenue sur R&ecirc;ve de montagne</h1>

	{texte-intro}
	<div class="cadregd">			
		<!--Cadre gauche-->
		<div class="cadre_gauche">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>La derni&egrave;re photo</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
					<div class="img_gauche">
						<a href="album-{titre_url}-c{id_categorie}.html">
							<img src="images/album/{album}/mini/{image}" alt="{image}" />
						</a>
					</div>
					<p>
						{titre}<br />
						dans la cat&eacute;gorie : <a href="album-{titre_url}-c{id_categorie}.html">{categorie}</a><br/>
					</p>		
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
		<!--Fin cadre gauche-->			
				
		<!--Cadre droite-->
		<div class="cadre_droite">
			<div class="cadre_1_hg">
				<div class="cadre_1_hd">
					<h2>Les 5 derniers articles</h2>
				</div>
			</div>  
			<div class="cadre_1_cg">
				<div class="cadre_1_cd">
					<ul>
						<li><a href="article-{url_rando1}-a{id1}.html">{rando1}</a></li>
						<li><a href="article-{url_rando2}-a{id2}.html">{rando2}</a></li>
						<li><a href="article-{url_rando3}-a{id3}.html">{rando3}</a></li>
						<li><a href="article-{url_rando4}-a{id4}.html">{rando4}</a></li>
						<li><a href="article-{url_rando5}-a{id5}.html">{rando5}</a></li>
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
		<!--Fin cadre droite-->
	</div>

<!---Dernièrs topos --->	

<div class="cadregd">			
	<!--Cadre gauche-->
	<div class="cadre_gauche">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>les derniers topos de skis de randonn&eacute;es</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<li><a href="{urlts1}-t{idts1}.html">{toposki1}</a></li>
					<li><a href="{urlts2}-t{idts2}.html">{toposki2}</a></li>
					<li><a href="{urlts3}-t{idts3}.html">{toposki3}</a></li>
					<li><a href="{urlts4}-t{idts4}.html">{toposki4}</a></li>
					<li><a href="{urlts5}-t{idts5}.html">{toposki5}</a></li>
					<li><a href="{urlts6}-t{idts6}.html">{toposki6}</a></li>
				</ul>	
				<div class="lien_bas"><a class="button" href="{DOMAINE}liste-des-topos-skis-rando.html">Voir plus</a></div>
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
	<!--Fin cadre gauche-->			
				
	<!--Cadre droite-->
	<div class="cadre_droite">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>les derniers topos de randonn&eacute;es</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<ul>
					<li><a href="{urltr1}-tr{idtr1}.html">{toporando1}</a></li>
					<li><a href="{urltr2}-tr{idtr2}.html">{toporando2}</a></li>
					<li><a href="{urltr3}-tr{idtr3}.html">{toporando3}</a></li>
					<li><a href="{urltr4}-tr{idtr4}.html">{toporando4}</a></li>
					<li><a href="{urltr5}-tr{idtr5}.html">{toporando5}</a></li>
					<li><a href="{urltr6}-tr{idtr6}.html">{toporando6}</a></li>
				</ul>	
				
				<div class="lien_bas"><a class="button" href="{DOMAINE}liste-des-topos-de-randonnee.html">Voir plus</a></div>
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
	<!--Fin cadre droite-->
</div>	
	
<!---Dernières actualités --->	
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Actualit&eacute;s de Reve de Montagne</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<ul>
				<li>{daten1} - <a href="{urln1}-z{idn1}.html#commentaires">{news1}</a></li>
				<li>{daten2} - <a href="{urln2}-z{idn2}.html#commentaires">{news2}</a></li>
				<li>{daten3} - <a href="{urln3}-z{idn3}.html#commentaires">{news3}</a></li>
				<li>{daten4} - <a href="{urln4}-z{idn4}.html#commentaires">{news4}</a></li>
				<li>{daten5} - <a href="{urln5}-z{idn5}.html#commentaires">{news5}</a></li>
				<li>{daten6} - <a href="{urln6}-z{idn6}.html#commentaires">{news6}</a></li>
			</ul>	
			<div class="lien_bas"><a class="button" href="{DOMAINE}liste-des-actualites.html">Voir plus</a></div>
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


			
<!---Dernières sorties--->	
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Les derni&egrave;res sorties</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<ul>
				<li>{date1} <a href="{DOMAINE}{surl1}">{sortie1}</a></li>
				<li>{date2} <a href="{DOMAINE}{surl2}">{sortie2}</a></li>
				<li>{date3} <a href="{DOMAINE}{surl3}">{sortie3}</a></li>
				<li>{date4} <a href="{DOMAINE}{surl4}">{sortie4}</a></li>
				<li>{date5} <a href="{DOMAINE}{surl5}">{sortie5}</a></li>
				<li>{date6} <a href="{DOMAINE}{surl6}">{sortie6}</a></li>
			</ul>	
			<div class="lien_bas"><a class="button" href="{DOMAINE}liste-des-sorties.html">Voir plus</a></div>
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
<include file="footer.tpl" />