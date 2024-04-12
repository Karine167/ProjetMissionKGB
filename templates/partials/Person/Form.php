<?php
use App\Repository\CountryRepository;
use App\Repository\MissionRepository;
use App\Repository\SpecialityRepository;
use App\Repository\PersonRepository;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\ContactRepository;
use App\Repository\TargetRepository;

$countryRepository = new CountryRepository();
$nationalities = $countryRepository->findAllNationalities();

$missionRepository = new MissionRepository();
$missions = $missionRepository->findAllMissions();

$specialityRepository = new SpecialityRepository();
$specialities= $specialityRepository->findAllSpecialitys();
if (isset($_POST['Person'])){
    $roleRadio=$_POST['roleRadio'];
} else {
    $roleRadio = $_GET['roleRadio'];
}
$adminDB = null;
$agentDB = null;
$contactDB = null;
$targetDB = null;
$idmission = null;
$IdpersonCountrys = null;
if(key_exists('id',$_GET)){
    if (isset($_GET['id'])){
        $idPerson = $_GET['id'];
        $personRepository = new PersonRepository();
        $person = $personRepository->findOnePersonById($idPerson);
        $IdpersonCountrys = $personRepository->findAllIdCountryByIdPerson($idPerson);
        
        $agentRepository = new AgentRepository();
        $agentDB = $agentRepository->findOneAgentById($idPerson);
        if ($agentDB){
            $roleRadio = 'roleAgent';
            $idmission = $agentDB->getIdMission();
            $IdpersonSpecialitys = $agentRepository->findAllIdSpecialityByIdPerson($idPerson);
        } else {
            $adminRepository = new AdminRepository();
            $adminDB = $adminRepository->findOneAdminById($idPerson);
            if ($adminDB){
                $roleRadio = 'roleAdmin';
            }else{
                $contactRepository = new ContactRepository();
                $contactDB = $contactRepository->findOneContactById($idPerson);
                if ($contactDB){
                    $roleRadio = 'roleContact';
                    $idmission = $contactDB->getIdMission();
                }else{
                    $targetRepository = new TargetRepository();
                    $targetDB = $targetRepository->findOneTargetById($idPerson);
                    if ($targetDB){
                        $roleRadio = 'roleTarget';
                        $idmission = $targetDB->getIdMission();
                    }
                }
            }
        }
    } 
}else {
    $person = null;
}

?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Personnes :</h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des personnes : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="<?php
                        if ($_GET['todo']=='create') { 
                            echo('/index.php?controller=back&action=Person&todo=create&roleRadio='.$roleRadio);
                        } else {
                            echo('/index.php?controller=back&action=Person&roleRadio='.$roleRadio.'&todo=edit&id='.$_GET['id']);
                        } ?>" method="POST">
                        <div class="mt-3 mb-5 mx-2">
                            <label for="firstName" class=" col-4 d-inline attributName"> Prénom* :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="firstName" name="firstName" required
                            <?php if (isset($_POST['Person']) && !empty($_POST['firstName'])){
                                echo('value="'.trim(htmlspecialchars($_POST['firstName'])).'"');
                            } elseif (!is_null($person)) {echo('value="'.trim(htmlspecialchars($person->getFirstName())).'"');} ?> >
                            <?php if (!empty($errors['firstName'])){?>
                                <div class="alert alert-danger"><?php echo($errors['firstName']); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="lastName" class=" col-4 d-inline attributName"> Nom* :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="lastName" name="lastName" required 
                            <?php if (isset($_POST['Person']) && !empty($_POST['lastName'])){
                                echo('value="'.trim(htmlspecialchars($_POST['lastName'])).'"');
                            } elseif (!is_null($person)) {echo('value="'.trim(htmlspecialchars($person->getLastName())).'"');} ?> >
                            <?php if (!empty($errors['lastName'])){?>
                                <div class="alert alert-danger"><?php echo($errors['lastName']); ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="birthdate" class=" col-4 d-inline attributName"> Date de naissance :</label>
                            <input type="date" class="col-8 d-inline attribueValue formInput" id="birthdate" name="birthdate" 
                            <?php if (isset($_POST['Person']) && !empty($_POST['birthdate'])){
                                echo('value="'.trim(htmlspecialchars($_POST['birthdate'])).'"');
                            } elseif (!is_null($person) && !is_null($person->getBirthdate())) {echo('value="'.date_format($person->getBirthdate(), 'Y-m-d').'"');} ?> >
                            <?php if (!empty($errors['birthdate'])){?>
                                <div class="alert alert-danger"><?php echo($errors['birthdate']); ?></div>
                            <?php } ?>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <label for="nationality" class=" col-4 d-inline attributName"> Nationalité :</label>
                            <select multiple="multiple" name="nationality[]" id="nationality" class="col-8 d-inline attribueValue formInput" >
                                <optgroup label="nationalité">
                                    <?php foreach ($nationalities as $nationality) { ?>
                                        <option value="<?php echo($nationality['id']);?>" 
                                        <?php 
                                        if (is_null($person) && !$IdpersonCountrys && !isset($_POST['Person']) && $nationality['nationality']==='AAAAA - Aucune '){ ?> selected
                                        <?php } elseif (!is_null($person) && $IdpersonCountrys && in_array($nationality['id'],$IdpersonCountrys)){ ?> selected 
                                        <?php } elseif (isset($_POST['Person']) && !empty($_POST['nationality']) && in_array($nationality['id'],$_POST['nationality'])) { ?> selected 
                                        <?php } ?> ><?php echo(htmlspecialchars($nationality['nationality']));?> </option>
                                    <?php } ?>
                                </optgroup>
                            </select>
                            <?php if (!empty($errors['nationality'])){?>
                                <div class="alert alert-danger"><?php echo($errors['nationality']); ?></div>
                            <?php } ?>
                        </div>
                        
                        <fieldset>
                            <legend class="attributName">Sélectionner un rôle :</legend>
                            <div class="row d-flex justify-content-space-between ">
                                <div class="col-3">
                                    <input type="radio" id="roleAdmin" name="roleRadio" value="roleAdmin" 
                                    <?php if ($roleRadio == 'roleAdmin') {?> checked <?php } ?>/>
                                    <label for="roleAdmin">Admin</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleAgent" name="roleRadio" value="roleAgent" 
                                    <?php if ($roleRadio == 'roleAgent') {?> checked <?php } ?>/>
                                    <label for="roleAgent">Agent</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleTarget" name="roleRadio" value="roleTarget" 
                                    <?php if ($roleRadio == 'roleTarget') {?> checked <?php } ?>/>
                                    <label for="roleTarget">Cible</label>
                                </div>

                                <div class="col-3">
                                    <input type="radio" id="roleContact" name="roleRadio" value="roleContact"
                                    <?php if ($roleRadio == 'roleContact') {?> checked <?php } ?>/>
                                    <label for="roleContact">Contact </label>
                                </div>

                            </div>
                        </fieldset> 
                        
                        <div id="formAdmin" class="<?php if ($roleRadio == 'roleAdmin') { echo("d-block"); } else { echo("d-none"); } ?> formCategory" >
                            <div class="mt-3 mb-5 mx-2">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control formInput" id="email" name="email" placeholder="adresse@exemple.com" 
                                <?php if (isset($_POST['Person']) && !empty($_POST['email'])){ ?> value="<?php echo(trim(htmlspecialchars($_POST['email'])));?>"
                                <?php } elseif ($adminDB && !(is_null($adminDB))) { ?> value="<?php echo(trim(htmlspecialchars($adminDB->getEmail())));?>" <?php } ?>/>
                                <?php if (!empty($errors['email'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['email']); ?></div>
                                <?php } ?>
                            </div>
                            <div class="mt-3 mb-5 mx-2">
                                <label for="password" class="form-label">Mot de passe :</label>
                                <input type="password" class="form-control formInput" id="password" name="password" placeholder="password"/>
                                <?php if (!empty($errors['password'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['password']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div id="formNoAdmin" class="<?php if (!($roleRadio == 'roleAdmin')) { echo('d-block'); } else { echo('d-none'); } ?>">
                            <div class="mt-3 mb-5 mx-2">
                                <label for="mission" class="col-4 d-inline attributName"> Mission :</label>
                                <select name="mission" id="mission" class="col-8 d-inline attribueValue formInput" >
                                    <optgroup label="mission">
                                        <option value="aucune" 
                                        <?php if (is_null($idmission)) { ?>selected <?php } ?>> aucune mission </option>
                                        <?php foreach ($missions as $mission) { ?>
                                            <option value="<?php echo($mission['id']); ?>" 
                                            <?php 
                                                if (isset($_POST['Person']) && !(empty($_POST['mission'])) && ($mission['id'] == $_POST['mission']) ){ ?>
                                                selected
                                            <?php } elseif (!(is_null($person)) && !(is_null($idmission)) && ($mission['id'] == $idmission)){ ?> selected 
                                            <?php } ?>><?php echo(htmlspecialchars($mission['title'].' ( '.$mission['code_name'].')'));?> </option>
                                        <?php }  ?>
                                    </optgroup>
                                </select>
                                <?php if (!(empty($errors['mission']))){?>
                                    <div class="alert alert-danger"><?php echo($errors['mission']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div id="formAgent" class="<?php if ($roleRadio == 'roleAgent') { echo("d-block"); } else { echo("d-none"); } ?>">
                            <div class="mt-3 mb-5 mx-2">
                                <label for="specialityNames" class=" col-4 d-inline attributName"> Nom de la (ou des) spécialité(s) :</label>
                                <select multiple="multiple" name="specialityNames[]" id="specialityNames" class="col-8 d-inline attribueValue formInput" >
                                    <optgroup label="Spécialités">
                                        <?php foreach ($specialities as $speciality) { ?>
                                            <option value="<?php echo($speciality['id']);?>"
                                            <?php 
                                                if (!is_null($person) && $IdpersonSpecialitys && in_array($speciality['id'],$IdpersonSpecialitys)){ ?> selected 
                                                <?php } elseif (isset($_POST['Person']) && !empty($_POST['specialityNames']) && in_array($speciality['id'],$_POST['specialityNames'])) { ?> selected 
                                        <?php } ?> ><?php echo(htmlspecialchars($speciality['name']));?> </option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                
                                <?php if (!empty($errors['specialityNames'])){?>
                                    <div class="alert alert-danger"><?php echo($errors['specialityNames']); ?></div>
                                <?php } ?>
                            </div>
                        </div>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="Person" class="m-3 btn btn-primary" value="Enregistrer">
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            
                            <?php if (!empty($errors['save'])){?>
                                <div class="alert alert-danger"><?php echo($errors['save']); ?></div>
                            <?php } ?>
                            <?php if (!empty($errors['exist'])){?>
                                <div class="alert alert-danger"><?php echo($errors['exist']); ?></div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</div>