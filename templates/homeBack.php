<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
<?php if (array_key_exists('user', $_SESSION)) {
    //Menu BackOffice sur desktop et tablette ?>
    <div class="row d-flex justify-content-center ">
        <div class="col-11 m-1 p-1 d-none d-md-block d-flex align-items-center justify-content-center pageTitle">
            <div class="row ms-1 flex-direction-row  ">
                <ul class="nav nav-pills align-items-start justify-content-center">
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=Person&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Personnes">Personnes</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=Target&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Cibles">Cibles</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=Agent&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Agents">Agents</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=Contact&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Contacts">Contacts</a></li>
                    </div>
                    <div class="col">    
                        <li class="nav-item mb-5"><a href="/index.php?controller=back&action=Admin&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Admins">Admins</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=Country&todo=home" class="btn btn-primary btn-back mx-2 pt-1 " aria-current="Pays / nationalités">Pays nationalités</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=Speciality&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Spécialités">Spécialités</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=Hideout&todo=home" class="btn btn-primary btn-back pt-2 mx-2" aria-current="Planques">Planques</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=TypeHideout&todo=home" class="btn btn-primary btn-back pt-1 mx-2" aria-current="Type de planque">Type de planque</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-2"><a href="/index.php?controller=back&action=Mission&todo=home" class="btn btn-primary btn-back mx-2 pt-2" aria-current="Missions">Missions</a></li>
                        <li class="nav-item "><a href="/index.php?controller=back&action=Status&todo=home" class="btn btn-primary btn-back mx-2 pt-1" aria-current="Statut  mission">Statut de mission</a></li>
                    </div>
                    <div class="col">
                        <li class="nav-item mb-5"><a href="/index.php?controller=back&action=TypeMission&todo=home" class="btn btn-primary btn-back mx-2 pt-1" aria-current="Type de missions">Type de missions</a></li>
                    </div>
                </ul>
            </div> 
        </div>
        <?php //Menu BackOffice sur mobile ?>
        <div class="col-11 d-block d-md-none ">
            <div class="row m-3 p-1 d-flex align-items-center justify-content-center pageTitle">
                <h1 class="col col-11 m-2 d-flex align-items-center justify-content-center"> Menu </h1>
            </div>

            <div class="row m-1 p-1 d-block d-md-none align-items-center menuBackMobile">
                <div class="col col-10 ms-1 ">
                    <ul class="nav nav-pills ">
                        <div class="col-7 ">
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Person&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Personnes">Personnes</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Target&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Cibles">Cibles</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Contact&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Contacts">Contacts</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Country&todo=home" class="btn btn-primary btn-back mx-1 pt-1 " aria-current="Pays / nationalités">Pays nationalités</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Hideout&todo=home" class="btn btn-primary btn-back pt-2 mx-1" aria-current="Planques">Planques</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=TypeHideout&todo=home" class="btn btn-primary btn-back pt-1 mx-1" aria-current="Type de planque">Type de planque</a></li>
                        </div>
                        <div class="col-5 ">   
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Agent&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Agents">Agents</a></li> 
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Admin&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Admins">Admins</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Speciality&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Spécialités">Spécialités</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Mission&todo=home" class="btn btn-primary btn-back mx-1 pt-2" aria-current="Missions">Missions</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=TypeMission&todo=home" class="btn btn-primary btn-back mx-1 pt-1" aria-current="Type de missions">Type de missions</a></li>
                            <li class="nav-item m-2 p-2"><a href="/index.php?controller=back&action=Status&todo=home" class="btn btn-primary btn-back mx-1 pt-1" aria-current="Statut  mission">Statut de mission</a></li>
                        </div>
                    </ul>
                </div> 
            </div>
        </div>
    </div>    
    <?php
    //appel de la page utile pour l'action
    if (!is_null($page)){
        require_once _TEMPLATEPATH_.$page;
    } ?>
<?php } else { ?>
    <div class="row d-flex justify-content-center fw-bold fs-1 m-5 p-5 alert alert-danger">
        <?php echo("Vous devez être connecté pour pouvoir accéder à cette page !") ?>
    </div>
<?php } ?>
    


</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>