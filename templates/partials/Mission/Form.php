<?php
use App\Repository\CountryRepository;
use App\Repository\TypeHideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\StatusRepository;
use App\Repository\TypeMissionRepository;
use App\Repository\SpecialityRepository;
$countryRepository = new CountryRepository();
$countries = $countryRepository->findAllCountrys();
$typeHideoutRepository = new TypeHideoutRepository();
$typeHideouts = $typeHideoutRepository->findAllTypeHideouts();
$missionRepository = new MissionRepository();
$missions = $missionRepository->findAllMissions();
$statusRepository = new StatusRepository();
$status = $statusRepository->findAllStatuss();
$typeMissionRepository = new TypeMissionRepository();
$typeMissions = $typeMissionRepository->findAllTypeMissions();
$specialitiesRepository = new SpecialityRepository();
$specialities =  $specialitiesRepository->findAllSpecialitys();
?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Missions : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des missions : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="/index.php?controller=back&action=Mission&todo=create" method="POST">
                        <div class="mt-3 mb-5 mx-2">
                            <label for="title" class=" col-4 d-inline attributName"> Titre :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="title" name="title" required
                            <?php if (isset($_POST['Mission']) && !empty($_POST['title'])){
                                echo('value="'.trim(htmlspecialchars($_POST['title'])).'"');
                            } ?> >
                            <?php if (!empty($errors['title'])){?>
                                <div class="alert alert-danger"><?php echo($errors['title']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="description" class=" col-4 d-inline attributName"> description :</label>
                            <textarea class="col-8 d-inline attribueValue formInput" rows="5" id="description" name="description" ></textarea>
                            <?php if (!empty($errors['description'])){?>
                                <div class="alert alert-danger"><?php echo($errors['description']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="beginDate" class=" col-4 d-inline attributName"> Date de début de mission :</label>
                            <input type="date" class="col-8 d-inline attribueValue formInput" id="beginDate" name="beginDate" 
                            <?php if (isset($_POST['Person']) && !empty($_POST['beginDate'])){
                                echo('value="'.trim(htmlspecialchars($_POST['beginDate'])).'"');
                            } ?> >
                            <?php if (!empty($errors['beginDate'])){?>
                                <div class="alert alert-danger"><?php echo($errors['beginDate']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="endDate" class=" col-4 d-inline attributName"> Date de fin de mission :</label>
                            <input type="date" class="col-8 d-inline attribueValue formInput" id="endDate" name="endDate" 
                            <?php if (isset($_POST['Person']) && !empty($_POST['endDate'])){
                                echo('value="'.trim(htmlspecialchars($_POST['endDate'])).'"');
                            } ?> >
                            <?php if (!empty($errors['endDate'])){?>
                                <div class="alert alert-danger"><?php echo($errors['endDate']) ?></div>
                            <?php } ?>
                        </div>
                                                
                        <div class="mt-3 mb-5 mx-2">
                            <label for="idCountry" class=" col-4 d-inline attributName"> Pays de la mission :</label>
                            <select name="idCountry" id="idCountry" class="col-8 d-inline attribueValue formInput" required>
                                <optgroup label="pays">
                                    <?php foreach ($countries as $country) { ?>
                                        <option value=<?php echo($country['id'])?> ><?php echo(htmlspecialchars($country['country_name']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['idCountry'])){?>
                                <div class="alert alert-danger"><?php echo($errors['idCountry']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="idStatus" class=" col-4 d-inline attributName"> Statut de la mission :</label>
                            <select name="idStatus" id="idStatus" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="Statut">
                                    <?php foreach ($status as $statut) { ?>
                                        <option value=<?php echo($statut['id'])?> ><?php echo(htmlspecialchars($statut['name']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['idStatus'])){?>
                                <div class="alert alert-danger"><?php echo($errors['idStatus']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="idTypeMission" class=" col-4 d-inline attributName"> Type de mission :</label>
                            <select name="idTypeMission" id="idTypeMission" class="col-8 d-inline attribueValue formInput" required>
                                <optgroup label="type de mission">
                                    <?php foreach ($typeMissions as $typeMission) { ?>
                                        <option value=<?php echo($typeMission['id'])?> ><?php echo(htmlspecialchars($typeMission['type_mission']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['idTypeMission'])){?>
                                <div class="alert alert-danger"><?php echo($errors['idTypeMission']) ?></div>
                            <?php } ?>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <label for="idSpeciality" class=" col-4 d-inline attributName"> Spécialité requise :</label>
                            <select name="idSpeciality" id="idSpeciality" class="col-8 d-inline attribueValue formInput" required>
                                <optgroup label="spécialité">
                                    <?php foreach ($specialities as $speciality) { ?>
                                        <option value=<?php echo($speciality['id'])?> ><?php echo(htmlspecialchars($speciality['name']))?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['idSpeciality'])){?>
                                <div class="alert alert-danger"><?php echo($errors['idSpeciality']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="Mission" class="m-3 btn btn-primary" value="Enregistrer">
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