<?php 
use App\Repository\TypeMissionRepository;
if(key_exists('id',$_GET)){
    if ($_GET['id']){
    $typeMissionRepository = new TypeMissionRepository();
    $typeMission = $typeMissionRepository->findOneTypeMissionById($_GET['id']);
    } 
}else {
    $typeMission = null;
}
?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Type de mission : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des types de mission : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="" method="POST">
                            <label for="typeMission" class=" col-4 d-inline attributName"> Nom du type :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="typeMission" name="typeMission"
                            <?php if (!is_null($typeMission)) { ?> value="<?php echo(htmlspecialchars($typeMission['type_mission']));}?>">
                            <?php if (!empty($errors['typeMission'])){?>
                                <div class="alert alert-danger"><?php echo($errors['typeMission']) ?></div>
                            <?php } ?>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="TypeMission" class="m-3 btn btn-primary" value="Enregistrer">
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
