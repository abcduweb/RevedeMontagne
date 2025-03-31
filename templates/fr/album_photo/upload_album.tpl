<include file="../headers/header_common_head.tpl" />	
<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel='stylesheet' />	
<include file="../headers/header_common_body.tpl" />
		
<div class="cadre_1_hg">
	<div class="cadre_1_hd">
		<h5>Ajout / Edition d'un topo</h5>
	</div>
</div>
<div class="cadre_1_cg">
	<div class="cadre_1_cd">
		<h1>Ajouter un album photos</h1>
		<form id="dragdrop" method="post" action="./actions/envoi_photo_album.php" enctype="multipart/form-data">
			<div id="drop">
				Giller déposer les photos ici

				<a>Parcourir</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

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




		<!-- JavaScript Includes -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
			<script src="templates/js/assets/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
			<script src="templates/js/assets/jquery.ui.widget.js"></script>
			<script src="templates/js/assets/jquery.iframe-transport.js"></script>
			<script src="templates/js/assets/jquery.fileupload.js"></script>

		<!-- Our main JS file -->
			<script src="templates/js/assets/script.js"></script> 
<include file="../footer.tpl" />

