<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
<?php if (array_key_exists('user', $_SESSION)) {?>
    <div class="row d-flex justify-content-center ">
        <div class="col-11 m-1 p-1 d-none d-md-block d-flex align-items-center justify-content-center pageTitle">
            <div class="row ms-1 flex-direction-row  ">
                <ul class="nav nav-pills align-items-start justify-content-center">
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=person" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Personnes">Personnes</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=target" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Cibles">Cibles</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=agent" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Agents">Agents</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=contact" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Contacts">Contacts</a></li>
                    </div>
                    <div class="col">    
                        <li class="nav-item mb-5"><a href="/index.php?controller=back&action=admin" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Admins">Admins</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=country" class="btn btn-primary btn-back mx-2 pt-1 " aria-current="Pays / nationalités">Pays nationalités</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=speciality" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Spécialités">Spécialités</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=hideout" class="btn btn-primary btn-back pt-2 mx-2" aria-current="Planques">Planques</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=typeHideout" class="btn btn-primary btn-back pt-1 mx-2" aria-current="Type de planque">Type de planque</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=mission" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Missions">Missions</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=status" class="btn btn-primary btn-back mx-2 pt-1" aria-current="Statut  mission">Statut de mission</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-5"><a href="/index.php?controller=back&action=typeMission" class="btn btn-primary btn-back mx-2 pt-1" aria-current="Type de missions">Type de missions</a></li>
                    </div>
                </ul>
            </div> 
        </div>
        <div class="col-11 d-block d-md-none ">
            <div class="row m-3 p-1 d-flex align-items-center justify-content-center pageTitle">
                <h1 class="col col-11 m-2 d-flex align-items-center justify-content-center"> Menu </h1>
            </div>

            <div class="row m-1 p-1 d-block d-md-none align-items-center menuBackMobile">
                <div class="col col-10 ms-1 ">
                    <ul class="nav nav-pills ">
                        <div class="col-7 ">
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=person" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Personnes">Personnes</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=target" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Cibles">Cibles</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=contact" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Contacts">Contacts</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=country" class="btn btn-primary btn-back mx-1 pt-1 " aria-current="Pays / nationalités">Pays nationalités</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=hideout" class="btn btn-primary btn-back pt-2 mx-1" aria-current="Planques">Planques</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=typeHideout" class="btn btn-primary btn-back pt-1 mx-1" aria-current="Type de planque">Type de planque</a></li>
                        </div>
                        <div class="col-5 ">   
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=agent" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Agents">Agents</a></li> 
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=admin" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Admins">Admins</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=speciality" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Spécialités">Spécialités</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=mission" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Missions">Missions</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=typeMission" class="btn btn-primary btn-back mx-1 pt-1" aria-current="Type de missions">Type de missions</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=status" class="btn btn-primary btn-back mx-1 pt-1" aria-current="Statut  mission">Statut de mission</a></li>
                        </div>
                    </ul>
                </div> 
            </div>
        </div>
    </div>    
<?php } else { ?>
    <div class="row d-flex justify-content-center fw-bold fs-1 m-5 p-5 alert alert-danger">
        <?php echo("Vous devez être connecté pour pouvoir accéder à cette page !") ?>
    </div>
<?php } ?>
    


</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>