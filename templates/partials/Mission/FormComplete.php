<?php 
use App\Repository\PersonRepository;
use App\Repository\AgentRepository;

$personRepository = new PersonRepository();
$agentRepository = new AgentRepository();
/* var_dump('avec la spe :');
var_dump($idAgentsSpecialityArray);
var_dump('en BDD :');
var_dump($agentsDB);
var_dump('sur la mission :');
var_dump($idAgentsArray); */

?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1> Mission <?php if ($mission){ echo($mission->getId(). ' : '. $mission->getTitle()); } ?></h1>
    </div>
    <div class="col-11 m-3 p-3 ">
        <?php if ($errors) { ?>
            <div class="alert alert-danger">
                <?php echo($errors) ?>
            </div>
        <?php } else {
            if ($mission) { ?>
                <div class="detail">
                    <div class="row m-1 p-1 d-flex">
                        <div class="col-12 col-md-6 col-lg-4">
                            <h2 class="attributName">Nom de Code : <span class="attributValue"><?php if (!is_null($mission->getCodeName())) {echo(htmlspecialchars($mission->getCodeName()));} ?></span></h2>
                            <h2 class="attributName">Statut : <span class="attributValue"><?php if ($status && key_exists('name',$status)) {echo(htmlspecialchars($status['name']));} ?></span></h2>
                            <h2 class="attributName">Type : <span class="attributValue"><?php if ($typeMission && key_exists('type_mission',$typeMission)) {echo(htmlspecialchars($typeMission['type_mission']));} ?></span></h2>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h2 class="attributName">Début : <span class="attributValue"><?php if (!is_null($mission->getBeginDate())) { echo($mission->getBeginDate()->format("m-d-Y")); } ?></span></h2>
                            <h2 class="attributName">Fin : <span class="attributValue"><?php if (!is_null($mission->getEndDate())) { echo($mission->getEndDate()->format("m-d-Y")); } ?></span></h2>
                            <h2 class="attributName">Pays : <span class="attributValue"><?php if ($country && key_exists('country_name',$country)) {echo(htmlspecialchars($country['country_name']));} ?></span></h2>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <h2 class="attributName">Spécialité : <span class="attributValue"><?php if ($speciality && key_exists('name',$speciality)) {echo(htmlspecialchars($speciality['name']));} ?></span></h2>
                        </div>
                    </div>
                    <div class="row m-1 p-1 d-flex">
                        <h2 class="attributName">Description : </h2>
                        <p class="attributValue"><?php if (!is_null($mission->getDescription())) {echo(htmlspecialchars($mission->getDescription()));} ?></p>
                    </div>
                    <div class="row m-1 p-1 d-flex">
                        <div class="col-12 col-md-6">
                            <h2 class="attributName">Cible(s) : </h2>
                            <div class="attributValue"><?php if ($targets) {
                                foreach ($targets as $target) { ?>
                                    <p> <?php echo(htmlspecialchars($target)) ?></p>
                                <?php } } ?>
                            </div>
                            <h2 class="attributName">Planque(s)  (type de planque) : </h2>
                            <div class="attributValue"><?php if ($hideouts) {
                                foreach ($hideouts as $hideout) { ?>
                                    <p> <?php echo(htmlspecialchars($hideout)) ?></p>
                                <?php } } ?>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h2 class="attributName">Agent(s) : </h2>
                            <div class="attributValue"><?php if ($agents) {
                                foreach ($agents as $agent) { ?>
                                    <p> <?php echo(htmlspecialchars($agent)) ?></p>
                                <?php } } ?>
                            </div>
                            <h2 class="attributName">Contact(s) : </h2>
                            <div class="attributValue"><?php if ($contacts) {
                                foreach ($contacts as $contact) { ?>
                                    <p> <?php echo(htmlspecialchars($contact)) ?></p>
                                <?php } } ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php } } ?>
    </div>
</div>
<?php 
// Ajout des planques et des contacts de la mission :
if ($country && key_exists('id',$country)) { 
    $idCountry = $country['id'];
}?>
<div class="row d-flex justify-content-center ">
    <div class="col-8 mx-3 my-2 p-2  d-flex align-items-center justify-content-center pageTitle">
        <h4 class="fw-bold"> Ajouter ou supprimer des planques et des contacts : </h4>
    </div>
    <div class="col-11 mx-3 my-1 p-3 justify-content-center formCategory">
        <form action="/index.php?controller=back&action=Mission&todo=complete&id=<?php echo($_GET['id']);?>" method="POST" name="hideouts">
            <div class="mt-3 mb-2 mx-2">
                <p class="col-12 mb-2  attributName"> Sélectionner toutes les planques associées à la mission :</p>
                <select multiple="multiple" name="hideouts[]" id="hideouts" class="col-12  attribueValue formInput" >
                    <optgroup label="planques">
                        <option value=null > Aucune Planque </option>
                        <?php if ($hideoutsDB){
                            foreach ($hideoutsDB as $hideout) { 
                                //vérification que la planque est situé dans le pays de la mission, et qu'elle n'est pas déjà occupé par une autre mission que celle concernée par l'id de l'url
                                if($hideout['id_country']==$idCountry && (is_null($hideout['id_mission']) || ($idHideoutsArray && in_array($hideout['id'],$idHideoutsArray)))) { ?> 
                                    <option value="<?php echo($hideout['id'])?>" 
                                    <?php  
                                    if ($idHideoutsArray && in_array($hideout['id'],$idHideoutsArray)){ ?> selected <?php }
                                    ?> ><?php echo(htmlspecialchars($hideout['type_hide']." : ".$hideout['address'] . ", " . $hideout['zipcode'] . ", " . $hideout['city'] . ", " . $hideout['country_name'])); ?> </option>
                            <?php } }}?>
                    </optgroup>
                </select>
                <?php if (!empty($errors['hideouts'])){?>
                    <div class="alert alert-danger"><?php echo($errors['hideouts']) ?></div>
                <?php } ?>
                <br>
                <p class=" col-12 mt-2 attributName"> Sélectionner tous les contacts associées à la mission :</p>
                <select multiple="multiple" name="contacts[]" id="contacts" class="col-12 attribueValue formInput" >
                    <optgroup label="contacts">
                        <option value=null > Aucun contact </option>
                        <?php if ($contactsDB){
                            foreach ($contactsDB as $contactDB) { 
                                $personIdsCountry = $personRepository->findAllIdCountryByIdPerson($contactDB['id']);
                                //vérification que le contact habite dans le pays de la mission, et qu'il n'est pas déjà occupé par une autre mission que celle concernée par l'id de l'url
                                if (($personIdsCountry && in_array($idCountry, $personIdsCountry)) && (is_null($contactDB['id_mission']) || ($idContactsArray && in_array($contactDB['id'],$idContactsArray)))) { ?> 
                                    <option value="<?php echo($contactDB['id'])?>" 
                                    <?php  
                                    if ($idContactsArray && in_array($contactDB['id'],$idContactsArray)){ ?> selected <?php }
                                    ?> ><?php echo(htmlspecialchars($contactDB['complete_name'])); ?> </option>
                            <?php } }}?>
                    </optgroup>
                </select>
                <?php if (!empty($errors['contacts'])){?>
                    <div class="alert alert-danger"><?php echo($errors['contacts']) ?></div>
                <?php } ?>
                <br>
                <p class=" col-12 mt-2 attributName"> Sélectionner toutes les cibles de cette mission :</p>
                <select multiple="multiple" name="targets[]" id="targets" class="col-12 attribueValue formInput" >
                    <optgroup label="cibles">
                        <option value=null > Aucune cible </option>
                        <?php if ($targetsDB){
                            foreach ($targetsDB as $targetDB) { 
                                //vérification que la cible n'est pas déjà associée une autre mission que celle concernée par l'id de l'url
                                if (is_null($targetDB['id_mission']) || ($idTargetsArray && in_array($targetDB['id'],$idTargetsArray))) { ?> 
                                    <option value="<?php echo($targetDB['id'])?>" 
                                    <?php  
                                    if ($idTargetsArray && in_array($targetDB['id'],$idTargetsArray)){ ?> selected <?php }
                                    ?> ><?php echo(htmlspecialchars($targetDB['complete_name'])); ?> </option>
                            <?php } }}?>
                    </optgroup>
                </select>
                <?php if (!empty($errors['targets'])){?>
                    <div class="alert alert-danger"><?php echo($errors['targets']) ?></div>
                <?php } ?>
                <br>
                <p class=" col-12 mt-2 attributName"> Sélectionner tous les agents ayant la spécialité requise pour cette mission :</p>
                <?php if (!$idAgentsSpecialityArray) { ?>
                    <div class="alert alert-danger">Aucun agent disponible, il faut recruter !!</div>
                <?php } else {  ?>
                    <select multiple="multiple" name="agentsSpeciality[]" id="agentsSpeciality" class="col-12 attribueValue formInput" >
                        <optgroup label="Agents spécialistes">
                            <?php if ($agentsDB){
                                foreach ($agentsDB as $agentDB) { 
                                    //vérification que l'agent a la spécialité et qu'il n'est pas déjà associé une autre mission que celle concernée par l'id de l'url
                                    if ((is_null($agentDB['id_mission']) || ($idAgentsArray && in_array($agentDB['id'],$idAgentsArray))) && (in_array($agentDB['id'], $idAgentsSpecialityArray))) { 
                                        $speAgent = $agentRepository->findAllSpecialitiesByIdAgent($agentDB['id']);?> 
                                        <option value="<?php echo($agentDB['id'])?>" 
                                        <?php  
                                        if ($idAgentsArray && in_array($agentDB['id'],$idAgentsArray)){ ?> selected <?php }
                                        ?> ><?php echo(htmlspecialchars($agentDB['complete_name']."(".$speAgent.")"));?> </option>
                                <?php } }}?>
                        </optgroup>
                    </select>
                <?php } ?>
                <br>
                <p class=" col-12 mt-2 attributName"> Sélectionner éventuellement d'autres agents pour cette mission :</p>
                <select multiple="multiple" name="agentsNoSpeciality[]" id="agentsNoSpeciality" class="col-12 attribueValue formInput" >
                    <optgroup label="Agents non spécialistes">
                        <option value="null"> Aucun agent </option>
                        <?php if ($agentsDB){
                            foreach ($agentsDB as $agentDB) { 
                                //vérification que l'agent n'a pas la spécialité et qu'il n'est pas déjà associé une autre mission que celle concernée par l'id de l'url
                                if ((is_null($agentDB['id_mission']) || ($idAgentsArray && in_array($agentDB['id'],$idAgentsArray))) && (!in_array($agentDB['id'], $idAgentsSpecialityArray))) { 
                                    $speAgent = $agentRepository->findAllSpecialitiesByIdAgent($agentDB['id']);?> 
                                    <option value="<?php echo($agentDB['id'])?>" 
                                    <?php  
                                    if ($idAgentsArray && in_array($agentDB['id'],$idAgentsArray)){ ?> selected <?php }
                                    ?> ><?php echo(htmlspecialchars($agentDB['complete_name']."(".$speAgent.")"));?> </option>
                            <?php } }}?>
                    </optgroup>
                </select>
                <?php if (!empty($errors['agents'])){?>
                    <div class="alert alert-danger"><?php echo($errors['agents']) ?></div>
                <?php } ?>


                <div class="mt-3 mb-2 mx-3">
                    <input type="submit" name="completeMission" class="mx-3 mt-2 mb-1 btn btn-primary" value="Enregistrer">
                </div>
            </div>
        </form>
    </div>

    
</div>