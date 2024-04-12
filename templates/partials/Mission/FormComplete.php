
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
// Ajout des planques de la mission :
if ($country && key_exists('id',$country)) { 
    $idCountry = $country['id'];
}?>
<div class="row d-flex justify-content-center ">
    <div class="col-7 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h4> Ajouter ou supprimer des planques : </h4>
    </div>
    <div class="col-11 m-3 p-3 formCategory">
        <form action="/index.php?controller=back&action=Mission&todo=complete&id=<?php echo($_GET['id']);?>" method="POST" name="hideouts">
            <div class="mt-3 mb-5 mx-2">
                <p class=" col-4 d-inline attributName"> Sélectionner toutes les planques associées à la mission :</p>
                <select multiple="multiple" name="hideouts[]" id="hideouts" class="col-8 d-inline attribueValue formInput" >
                    <optgroup label="planque">
                        <option value=null > Aucune </option>
                        <?php if ($hideoutsDB){
                            foreach ($hideoutsDB as $hideout) { 
                                //vérification que la planque est situé dans le pays de la mission, et qu'elle n'est pas déjà occupé par une autre mission que celle concernée par l'id de l'url
                                if($hideout['id_country']==$idCountry && (is_null($hideout['id_mission']) || ($idHideoutsArray && in_array($hideout['id'],$idHideoutsArray)))) { ?> 
                                    <option value="<?php echo($hideout['id'])?>" 
                                    <?php  
                                    if ($idHideoutsArray && in_array($hideout['id'],$idHideoutsArray)){ ?> selected <?php }
                                    ?> ><?php echo(htmlspecialchars($hideout['type_hide']." : ".$hideout['address'] . ", " . $hideout['zipcode'] . ", " . $hideout['city'] . ", " . $hideout['country_name']))?> </option>
                            <?php } }}?>
                    </optgroup>
                </select>
                <?php if (!empty($errors['hideouts'])){?>
                    <div class="alert alert-danger"><?php echo($errors['hideouts']) ?></div>
                <?php } ?>
                <div class="mt-3 mb-5 mx-2">
                    <input type="submit" name="hideouts[]" class="m-3 btn btn-primary" value="Enregistrer">
                </div>
            </div>
        </form>
    </div>
</div>