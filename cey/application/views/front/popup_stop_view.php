<!-- MODAL -->
<div class="modal fade" id="modal-accueil">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- MODAL HEADER -->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Attention</h3>
			</div>
			<!-- END MODAL HEADER -->

			<!-- MODAL BODY -->
			<div class="modal-body">
				<p class="astuce"><img src="<?php echo img_url('attention.png'); ?>" alt="logo_attention" />&nbsp;Voulez-vous vraiment revenir à l'accueil, sans terminer le processus ?</p>
			</div>
			<!--  END MODAL BODY -->

			<!-- MODAL FOOTER -->
			<div class="modal-footer">
				<a href="<?php echo site_url('front/traitement/deviation'); ?>" class="btn btn-block btn-danger"> Oui</a>
			</div>
			<!--  END MODAL FOOTER -->
		
		</div>
	</div> 
</div>
<!-- END MODAL -->