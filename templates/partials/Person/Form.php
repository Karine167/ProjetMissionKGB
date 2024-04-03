<?php
use App\Repository\CountryRepository;
use App\Repository\MissionRepository;
$countryRepository = new CountryRepository();
$nationalities = $countryRepository->findAllNationalities();

$missionRepository = new MissionRepository();
$missions = $missionRepository->findAllMissions();

?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Personnes : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des personnes : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="" method="POST">
                        <div class="mt-3 mb-5 mx-2">
                            <label for="firstName" class=" col-4 d-inline attributName"> Prénom :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="firstName" name="firstName" >
                            <?php if (!empty($errors['firstName'])){?>
                                <div class="alert alert-danger"><?php echo($errors['firstName']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="lastName" class=" col-4 d-inline attributName"> Nom :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="lastName" name="lastName">
                            <?php if (!empty($errors['lastName'])){?>
                                <div class="alert alert-danger"><?php echo($errors['lastName']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="birthdate" class=" col-4 d-inline attributName"> Date de naissance :</label>
                            <input type="date" class="col-8 d-inline attribueValue formInput" id="birthdate" name="birthdate">
                            <?php if (!empty($errors['birthdate'])){?>
                                <div class="alert alert-danger"><?php echo($errors['birthdate']) ?></div>
                            <?php } ?>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <label for="nationality" class=" col-4 d-inline attributName"> Nationalité :</label>
                            <select name="nationality" id="nationality" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="nationalité">
                                    <?php foreach ($nationalities as $nationality) { 
                                        echo($nationality['nationality']);
                                        if ($nationality['nationality']==='AAAAA - Aucune ') {?>
                                            <option value=<?php echo($nationality['id'])?> selected > Aucune </option> 
                                        <?php } else { ?>
                                        <option value=<?php echo($nationality['id'])?> ><?php echo(htmlspecialchars($nationality['nationality']))?> </option>
                                    <?php }} ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['nationality'])){?>
                                <div class="alert alert-danger"><?php echo($errors['nationality']) ?></div>
                            <?php } ?>
                        </div>
                        
                        <fieldset>
                            <legend class="attributName">Sélectionner un rôle :</legend>
                            <div class="row d-flex justify-content-space-between ">
                                <div class="col-3">
                                    <input type="radio" id="roleAdmin" name="role" value="roleAdmin" />
                                    <label for="roleAdmin">Admin</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleAgent" name="role" value="roleAgent" />
                                    <label for="roleAgent">Agent</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleTarget" name="role" value="roleTarget" />
                                    <label for="roleTarget">Cible</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleContact" name="role" value="roleContact" />
                                    <label for="roleContact">Contact</label>
                                </div>
                            </div>
                        </fieldset> 

                        <div id="formAdmin" class="d-none">
                            <div class="mt-3 mb-5 mx-2">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="adresse@exemple.com">
                                <?php if (!empty($errors['email'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['email']) ?></div>
                                <?php } ?>
                            </div>
                            <div class="mt-3 mb-5 mx-2">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="password">
                                <?php if (!empty($errors['password'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['password']) ?></div>
                                <?php } ?>
                            </div>
                        </div>

                        <div id="formNoAdmin" class="d-none">
                            <div class="mt-3 mb-5 mx-2">
                                <label for="mission" class=" col-4 d-inline attributName"> Mission :</label>
                                <select name="mission" id="mission" class="col-8 d-inline attribueValue formInput" >
                                    <optgroup label="mission">
                                        <?php foreach ($missions as $mission) { ?>
                                            <option value=<?php echo($mission['id'])?> ><?php echo(htmlspecialchars($mission['title'].'('.$mission['code_name']).')')?> </option>
                                        <?php } ?>
                                        <option value="autre" selected > aucune mission </option>
                                    </optgroup>
                                </select>
                                <?php if (!empty($errors['mission'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['mission']) ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div id="formAgent" class="d-none">
                            <div class="mt-3 mb-5 mx-2">
                                <label for="name" class=" col-4 d-inline attributName"> Nom de la spécialité :</label>
                                <input type="text" class="col-8 d-inline attribueValue formInput" id="name" name="name">
                                <?php if (!empty($errors['name'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['name']) ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="Hideout" class="m-3 btn btn-primary" value="Enregistrer">
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <?php if (!empty($errors['save'])){?>
                                <div class="alert alert-danger"><?php echo($errors['save']) ?></div>
                            <?php } ?>
                            <?php if (!empty($errors['exist'])){?>
                                <div class="alert alert-danger"><?php echo($errors['exist']) ?></div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>