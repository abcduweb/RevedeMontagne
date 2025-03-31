<include file="header.tpl" />

<div class="arbre">
	Vous &#234;tes ici : 
	<a href="index.php">R&ecirc;ve de montagne</a>	&gt; 
	<a href="membres-{num_membre}-fiche.html">Profil</a> &gt;
	Profil d'un membre
</div>

<h1>Profil de {nom_membre}</h1>
		
<div class="cadregd">			
	<!--Cadre gauche-->
	<div class="cadre_gauche">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Informations g&eacute;n&eacute;rales</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<div class="flot_gauche">{avatar_membre}</div>
				<div class="flot_droite emplacement_infos">
					<strong>Pseudo :</strong> {nom_membre}<br />
					<strong>Groupe :</strong> {groupe_membre}<br /><br />
					<strong>Date d'inscription : </strong><br />{date_insc}<br />
					<strong>Derni&egrave;re visite : </strong><br />{date_visite}<br /><br />
					{connecté}
				</div>	
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp	
				</div>
			</div>
		</div>
	</div>
	<div class="cadre_droite">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>M&eacute;ssagerie</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">			
				<strong>MP</strong> : <a href="creer-discution-m{num_membre}.html">envoy&eacute; un MP</a><br />
				<strong>Mail : </strong>{mail_membre}<br />
				<strong>MSN : </strong>{MSN_membre}<br />
				<strong>AIM : </strong>{AIM_membre}<br />
				<strong>Jabber : </strong>{Jabber_membre}<br />
				<strong>ICQ : </strong>{ICQ_membre}<br />	
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp	
				</div>
			</div>
		</div>
	</div>
</div>

<div class="cadregd">			
	<div class="cadre_gauche">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Mieux le connaitre</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">
				<strong>Date de naissance : </strong>{naissance_membre}<br />
				<strong>Site web : </strong>{site_membre}<br /><br />
				<strong>Int&eacute;rêts : </strong><br />
				{interets_membre}<br />			
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp	
				</div>
			</div>
		</div>
	</div>
	<div class="cadre_droite">
		<div class="cadre_1_hg">
			<div class="cadre_1_hd">
				<h2>Signature sur les forums</h2>
			</div>
		</div>  
		<div class="cadre_1_cg">
			<div class="cadre_1_cd">			
				{signature_membre}
			</div>
		</div>
		<div class="cadre_1_bg">
			<div class="cadre_1_bd">
				<div class="cadre_1_b">
					&nbsp	
				</div>
			</div>
		</div>
	</div>
</div>

<div class="cadre">			
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Sa vie en quelque lignes</h2>
		</div>
	</div>  
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">
			<strong>Biographie : </strong><br />
			{biographie_membre}
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