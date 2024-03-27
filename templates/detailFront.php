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
                                <h2 class="attributName">Statut : <span class="attributValue"><?php echo("............"); ?></span></h2>
                                <h2 class="attributName">Type : <span class="attributValue"><?php echo("............"); ?></span></h2>   
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="attributName">Début : <span class="attributValue"><?php if (!is_null($mission->getBeginDate())) { echo($mission->getBeginDate()->format("m-d-Y")); } ?></span></h2>
                                <h2 class="attributName">Fin : <span class="attributValue"><?php if (!is_null($mission->getEndDate())) { echo($mission->getEndDate()->format("m-d-Y")); } ?></span></h2>
                                <h2 class="attributName">Pays : <span class="attributValue"><?php echo("............"); ?></span></h2>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <h2 class="attributName">Spécialité : <span class="attributValue"><?php echo("..............."); ?></span></h2>
                            </div>
                        </div>
                        <div class="row m-1 p-1 d-flex">
                            <h2 class="attributName">Description : </h2>
                            <p class="attributValue"><?php if (!is_null($mission->getDescription())) {echo($mission->getDescription());} ?></p>
                        </div>
                        <div class="row m-1 p-1 d-flex">
                            <div class="col-12 col-md-6">
                                <h2 class="attributName">Cible(s) : </h2>
                                <p class="attributValue"><?php echo("............"); ?></p>
                                <h2 class="attributName">Planque(s)  (type de planque) : </h2>
                                <p class="attributValue"><?php echo("............". "(". ".................." . ")"); ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <h2 class="attributName">Agent(s) : </h2>
                                <p class="attributValue"><?php echo("....."); ?></p>
                                <h2 class="attributName">Contact(s) : </h2>
                                <p class="attributValue"><?php echo("............"); ?></p>
                            </div>
                        </div>
                    </div>
            <?php } } ?>


</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>