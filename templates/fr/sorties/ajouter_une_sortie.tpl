<include file="../headers/header_common_head.tpl" />
	<script type="text/javascript" src="{DOMAINE}/templates/js/upload.js"></script>
	<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />
<include file="../headers/header_common_body.tpl" />
<div class="cadre">
	<div class="cadre_1_hg">
		<div class="cadre_1_hd">
			<h2>Ajout / Edition d'une sortie</h2>
		</div>
	</div>
	<div class="cadre_1_cg">
		<div class="cadre_1_cd">		
			<!--- D&eacute;but du formulaire--->
			<form enctype="multipart/form-data" action="{DOMAINE}/sorties/envoi_sortie.php?t={idt}&acts={acts}{edition}" method="post">
				<label for="date_sortie">Date de la sortie : </label>
				<select name="jour" id="jour">
				<option value="1">1
				</option><option value="2">2
				</option><option value="3">3
				</option><option value="4">4
				</option><option value="5">5
				</option><option value="6">6
				</option><option value="7">7
				</option><option value="8">8
				</option><option value="9">9
				</option><option value="10">10
				</option><option value="11">11
				</option><option value="12">12
				</option><option value="13">13
				</option><option value="14">14
				</option><option value="15">15
				</option><option value="16">16
				</option><option value="17">17
				</option><option value="18">18
				</option><option value="19">19
				</option><option value="20">20
				</option><option value="21">21
				</option><option value="22">22
				</option><option value="23">23
				</option><option value="24">24
				</option><option value="25">25
				</option><option value="26">26
				</option><option value="27">27
				</option><option value="28">28
				</option><option value="29">29
				</option><option value="30">30
				</option><option value="31">31
				</option> 					
				</select>
				
				<select name="mois" id="mois">
				<option value="1">Janvier
				</option><option value="2">Fevrier
				</option><option value="3">Mars
				</option><option value="4">Avril
				</option><option value="5">Mai
				</option><option value="6">Juin
				</option><option value="7">Juillet
				</option><option value="8">Aout
				</option><option value="9">Septembre
				</option><option value="10">Octobre
				</option><option value="11">Novembre
				</option><option value="12">D&eacute;cembre
				</option>  		
				</select>
				
				<select name="annee" id="annee">
				<option value="2013">2013
				</option><option value="2014">2014
				</option><option value="2015">2015
				</option><option value="2016">2016
				</option><option value="2017">2017
				</option><option value="2018">2018
				</option><option value="2019">2019
				</option><option value="2020">2020
				</option><option value="2021">2021
				</option>
				</select><br />
					
				<label for="gpx">Fichier GPX :</label>	
				<select name="gpx" id="gpx">
						<option value="0">Joindre un fichier GPX &agrave; la sortie</option>
					<---TYPE--->
						<option value="{TYPE.id_gpx}" {TYPE.select}>{TYPE.date_gpx} - {TYPE.nom_gpx}</option>
					</---TYPE--->
				</select><br />
		
				
				<label for="meteo">M&eacute;t&eacute;o </label>
				<textarea name="meteo" id="meteo" rows="10" cols="20" ></textarea>
				<br />	
				<label for="recit">R&eacute;cit de la sortie : </label>
				<textarea name="recit" id="recit" rows="10" cols="69" ></textarea>
												
				<div class="send buttons">
					<button type="submit" value="Envoyer" class="positive">
						<img src="{DOMAINE}/templates/images/{design}/tick.png" alt="Envoyer"/> 
						Envoyer 
					</button>
				</div>
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
<!-- JavaScript Includes -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="{DOMAINE}/templates/js/assets/jquery.knob.js"></script>

<!-- jQuery File Upload Dependencies -->
	<script src="{DOMAINE}/templates/js/assets/jquery.ui.widget.js"></script>
 	<script src="{DOMAINE}/templates/js/assets/jquery.iframe-transport.js"></script>
	<script src="{DOMAINE}/templates/js/assets/jquery.fileupload.js"></script>

<!-- Our main JS file -->
	<script src="templates/js/assets/script.js"></script> 
	
<include file="../footer.tpl" />

