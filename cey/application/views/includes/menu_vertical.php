<!-- NAVBAR -->
<div class="navbar navbar-fixed-top navbar-primary main" role="navigation">
    <div class="navbar-header pull-left">
        <div class="navbar-brand">
            <div class="pull-left <?php if($titre=="ACCUEIL" || $titre=="GESTION PROCESSUS" || $titre=="UTILISATEUR" || $titre=="HISTORIQUES"){ echo "hidden"; } ?>">
                <a href="" class="toggle-button toggle-sidebar btn-navbar"><i class="fa fa-bars"></i></a>
            </div>
            <a href="#" class="appbrand innerL logo_brand"> <?php echo img('logo_CPE.png','logo-cpe');  ?> </a>
        </div>
    </div>
   
        <ul class="nav navbar-nav navbar-right hidden-xs">
            <?php 
            if($level =="admin"){
                
                if($gestion_proc == 1){
            ?>
                <li><a href="<?php echo site_url('back/gestion_process/normal'); ?>" class="menu-icon"><i class="fa fa-home"></i><span class="text_couleur"> Processus</span></a></li>
                <?php 
                }
                if($gestion_usr == 1){
                ?>
                <li><a href="<?php echo site_url('back/utilisateur'); ?>" class="menu-icon"><i class="fa fa-user"></i><span class="text_couleur"> Utilisateurs</span></a></li>
                <?php 
                }
                ?>
                <?php /* ?>
                <li><a href="<?php echo site_url('front/historique'); ?>" class="menu-icon"><i class="fa fa-pencil-square-o"></i><span class="text_couleur"> Historique</span></a></li>
                <?php */ ?>
                <li><a href="<?php echo site_url('front/deconnexion'); ?>" class="menu-icon"><i class="fa fa-sign-out"></i><span class="text_couleur"> Déconnexion</span></a></li>
            <?php 
            }else{
            ?>  

                <?php if($titre =="ACCUEIL"){ ?>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle user" data-toggle="dropdown"><i class="fa fa-user"></i><span class="hidden-xs hidden-sm"> &nbsp; <?php echo ascii_to_entities($prenom); ?> </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu list">
                        <li><a href="#profil_user" data-toggle="modal" style="color: white; margin : 0; text-align : center;">Votre profil &nbsp; <i class="fa fa-user"></i></a></li>
                    </ul>
                </li>
                <?php } ?>
                <li><a href="<?php echo site_url('front/accueil'); ?>" class="menu-icon"><i class="fa fa-home"></i><span class="text_couleur"> Accueil</span></a></li>
                <?php /* ?>
                <li><a href="<?php echo site_url('front/historique'); ?>" class="menu-icon"><i class="fa fa-pencil-square-o"></i><span class="text_couleur"> Historique</span></a></li>
                <?php */ ?>
                <li><a href="<?php echo site_url('front/deconnexion'); ?>" class="menu-icon"><i class="fa fa-sign-out"></i><span class="text_couleur"> Déconnexion</span></a></li>
            <?php 
            }
            ?>
        </ul>
        
</div>
<!-- END NAVBAR -->