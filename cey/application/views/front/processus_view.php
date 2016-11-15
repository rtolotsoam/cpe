<div id="content"><h1 class="content-heading bg-white border-bottom hidden">PROCESSUS</h1> 
<div class="innerAll">

    	
<!-- CONTENT -->

		<div class="row">
			<?php 
				if(!empty($processus)){
					
					
			?>
				<div class="col-md-4">
					<div class="widget widget-inverse">

						<!-- Widget heading -->
						<div class="widget-head">
							<h4 class="heading"><?php echo ascii_to_entities("Par téléphone"); ?></h4>
						</div>
						<!-- // Widget heading END -->

						<div class="widget-body">
							<?php echo ascii_to_entities($tel); ?>
						</div>	
					</div>	   
				</div>
				<div class="col-md-4">
					<div class="widget widget-inverse">

						<!-- Widget heading -->
						<div class="widget-head">
							<h4 class="heading">Par courrier</h4>
						</div>
						<!-- // Widget heading END -->

						<div class="widget-body">
							<?php echo ascii_to_entities($courrier); ?>
						</div>	
					</div>	   
				</div>
				<div class="col-md-4">
					<div class="widget widget-inverse">

						<!-- Widget heading -->
						<div class="widget-head">
							<h4 class="heading">Par mail</h4>
						</div>
						<!-- // Widget heading END -->

						<div class="widget-body">
							<?php echo ascii_to_entities($mail); ?>
						</div>
					</div>	   
				</div>
			<?php 
					
				}
			?>
		</div>

<!-- END CONTENT -->
		
		