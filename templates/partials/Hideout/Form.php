<?php
use App\Repository\CountryRepository;
use App\Repository\TypeHideoutRepository;
use App\Repository\MissionRepository;
$countryRepository = new CountryRepository();
$countries = $countryRepository->findAllCountrys();
$typeHideoutRepository = new TypeHideoutRepository();
$typeHideouts = $typeHideoutRepository->findAllTypeHideouts();
$missionRepository = new MissionRepository();
$missions = $missionRepository->findAllMissions();

?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Planques : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des planques : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="" method="POST">
                        <div class="mt-3 mb-5 mx-2">
                            <label for="address" class=" col-4 d-inline attributName"> Adresse :</label>
                            <textarea class="col-8 d-inline attribueValue formInput" id="address" name="address" ></textarea>
                            <?php if (!empty($errors['address'])){?>
                                <div class="alert alert-danger"><?php echo($errors['address']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="zipcode" class=" col-4 d-inline attributName"> Code Postal :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="zipcode" name="zipcode">
                            <?php if (!empty($errors['zipcode'])){?>
                                <div class="alert alert-danger"><?php echo($errors['zipcode']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="city" class=" col-4 d-inline attributName"> Ville :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="city" name="city">
                            <?php if (!empty($errors['city'])){?>
                                <div class="alert alert-danger"><?php echo($errors['city']) ?></div>
                            <?php } ?>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <label for="country" class=" col-4 d-inline attributName"> Pays :</label>
                            <select name="country" id="country" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="pays">
                                    <?php foreach ($countries as $country) { ?>
                                        <option value=<?php echo($country['id'])?> ><?php echo(htmlspecialchars($country['country_name']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['country'])){?>
                                <div class="alert alert-danger"><?php echo($errors['country']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="typeHide" class=" col-4 d-inline attributName"> Type de planque :</label>
                            <select name="typeHide" id="typeHide" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="type de planque">
                                    <?php foreach ($typeHideouts as $typeHideout) { ?>
                                        <option value=<?php echo($typeHideout['id'])?> ><?php echo(htmlspecialchars($typeHideout['type_hide']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['typeHide'])){?>
                                <div class="alert alert-danger"><?php echo($errors['typeHide']) ?></div>
                            <?php } ?>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <label for="mission" class=" col-4 d-inline attributName"> Mission :</label>
                            <select name="mission" id="mission" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="mission">
                                    <?php foreach ($missions as $mission) { ?>
                                        <option value=<?php echo($mission['id'])?> ><?php echo(htmlspecialchars($mission['title'].'('.$mission['code_name']).')')?> </option>
                                    <?php } ?>
                                    <option value="autre" selected> aucune mission </option>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['mission'])){?>
                                <div class="alert alert-danger"><?php echo($errors['mission']) ?></div>
                            <?php } ?>
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