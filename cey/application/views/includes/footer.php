
</div>
	
	</div>
		
<div class="clearfix"></div><!-- ESPACE -->
		

<!-- FOOTER -->
<div id="footer" class="hidden-print">
	<!--  COPYRIGHT -->
		<?php /*?>
	<script type="text/javascript">
	  	$(document).ready(function(){

	  		if(window.location.href!='<?php echo site_url("front/accueil"); ?>' && window.location.href!='<?php echo site_url("front/traitement"); ?>' && window.location.href!='<?php echo site_url("front/historique"); ?>'){
	  			$('#script_intro').removeClass('hidden');

	  			$('#script_intro').mouseover(function(){
	  				$('#script_intro2').removeClass('hidden');
	  				$('#script_intro').addClass('hidden');
			  	})


			  	$('#script_intro2').mouseover(function(){
		  			$('#script_intro').removeClass('hidden');
		  			$('#script_intro2').addClass('hidden');
			  	})
	  		}

	  	});


  	</script>


  			<div class="pull-left hidden" id="script_intro2" style="color: black; z-index:-2;">
				
				<h3 class="titre"><i class="dire"><img src="<?php echo img_url('dire.png') ?>"></i> A DIRE AU CLIENT</h3>
				<p><?php if(isset($nom_entre)){ echo ascii_to_entities($nom_entre); }  ?> Service Livraison bonjour, <?php  echo $this->session->userdata('prenom');   ?> à votre écoute. En quoi puis-je vous aider ?</p>
				<p> <span style="color: red">Consigne</span> : <i>Reformuler la demande du client</i></p>
				<p> Pouvez-vous me communiquer votre nom et  code postal afin que je puisse accéder à votre compte.  </p>
				<p> <span style="color: red">Consigne</span> : <i>se faire épeler le nom</i></p>
				

			</div>


  			<div class="pull-left hidden" id="script_intro" style="color: black; z-index:-2;">
				
				<h3 class="titre"><i class="dire"><img src="<?php echo img_url('dire.png') ?>"></i> A DIRE AU CLIENT</h3>
				<p><?php if(isset($nom_entre)){ echo ascii_to_entities($nom_entre); }  ?> Service Livraison bonjour, <?php  echo $this->session->userdata('prenom');   ?> à votre écoute. En quoi puis-je vous aider ?</p>
				<p> <span style="color: red">Consigne</span> : <i>Reformuler la demande du client</i></p>
				<p> Pouvez-vous me communiquer votre nom et  code postal afin que je puisse accéder à votre compte.  </p>
				<p> <span style="color: red">Consigne</span> : <i>se faire épeler le nom</i></p>
				

			</div>
			<?php */?>
  	
  		
	  	<div class="copy">&copy; 2016 </div>

	<?php /*?>
	<script type="text/javascript">
	  	$(document).ready(function(){
	  		
	  		if(window.location.href=='<?php echo site_url("front/accueil"); ?>'){
	  			
	  			$("open").click(function(){
	  			$("#bizzbar").effect("bounce","slow");
	  				$("open").slideUp()
		  		})
		  		$("#bizzbar").effect("bounce","slow");
		  		$("close").click(function(){$("#bizzbar").slideUp();
		  			$("open").slideDown()
		  		})

	  		}else{

	  			$("#bizzbar").hide();
	  			$("open").show();

	  			$("open").click(function(){
	  			
	  			$("#bizzbar").effect("bounce","slow");
	  				$("open").slideUp()
		  		})
		  		
	  		}
	  		
	  		$("close").click(function(){$("#bizzbar").slideUp();
		  		$("open").slideDown()
		  	})

	  	});


  	</script>
	  	
	  	
		<div class="video" id="bizzbar">
			<video id="vid1" controls="controls" preload="auto" poster="<?php echo img_url("formation_cpe.png")?>" style="height:100%;padding: 0 30px 0 0;">
				<source src="<?php echo img_url("formation_cpe.webm")?>" type="video/webm" />
				Navigateur incompatible!
			</video>
			<close></close>
		</div>
		<open></open>
		<?php */?>
	
	<!--  END COPYRIGHT -->
</div>
<!-- END FOOTER -->

</div>
<!-- END CONTENUE DE LA PAGE -->