<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
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
                    <div class="detailMission ">
                        <div class="row m-1 p-1 d-flex">
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="attributName">Nom de Code : <span class="attributValue"><?php if (!is_null($mission->getCodeName())) {echo($mission->getCodeName());} ?></span></h2>
                                <h2 class="attributName">Statut : <span class="attributValue"><?php if (!is_null($status['name'])) {echo ($status['name']);} ?></span></h2>
                                <h2 class="attributName">Type : <span class="attributValue"><?php if (!is_null($typeMission['type_mission'])) {echo ($typeMission['type_mission']);} ?></span></h2>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="attributName">Début : <span class="attributValue"><?php if (!is_null($mission->getBeginDate())) { echo($mission->getBeginDate()->format("m-d-Y")); } ?></span></h2>
                                <h2 class="attributName">Fin : <span class="attributValue"><?php if (!is_null($mission->getEndDate())) { echo($mission->getEndDate()->format("m-d-Y")); } ?></span></h2>
                                <h2 class="attributName">Pays : <span class="attributValue"><?php if (!is_null($country['country_name'])) {echo ($country['country_name']);} ?></span></h2>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="attributName">Spécialité : <span class="attributValue"><?php if (!is_null($speciality['name'])) {echo ($speciality['name']);} ?></span></h2>
                            </div>
                        </div>
                        <div class="row m-1 p-1 d-flex">
                            <h2 class="attributName">Description : </h2>
                            <p class="attributValue"><?php if (!is_null($mission->getDescription())) {echo($mission->getDescription());} ?></p>
                        </div>
                        <div class="row m-1 p-1 d-flex">
                            <div class="col-12 col-md-6">
                                <h2 class="attributName">Cible(s) : </h2>
                                <div class="attributValue"><?php if ($targets) {
                                    foreach ($targets as $target) { ?>
                                        <p> <?php echo($target) ?></p>
                                    <?php } } ?>
                                </div>
                                <h2 class="attributName">Planque(s)  (type de planque) : </h2>
                                <div class="attributValue"><?php if ($hideouts) {
                                    foreach ($hideouts as $hideout) { ?>
                                        <p> <?php echo($hideout) ?></p>
                                    <?php } } ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2 class="attributName">Agent(s) : </h2>
                                <div class="attributValue"><?php if ($agents) {
                                    foreach ($agents as $agent) { ?>
                                        <p> <?php echo($agent) ?></p>
                                    <?php } } ?>
                                </div>
                                <h2 class="attributName">Contact(s) : </h2>
                                <div class="attributValue"><?php if ($contacts) {
                                    foreach ($contacts as $contact) { ?>
                                        <p> <?php echo($contact) ?></p>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php } } ?>


</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>