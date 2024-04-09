<?php 
use App\Repository\CountryRepository;
if(key_exists('id',$_GET)){
    if ($_GET['id']){
    $countryRepository = new CountryRepository();
    $country = $countryRepository->findOneCountryById($_GET['id']);
    } 
}else {
    $country = null;
}
?>
<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Pays et nationalités : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des pays et des nationalités : </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="" method="POST">
                        <div class="mt-3 mb-5 mx-2">
                            <label for="countryName" class=" col-4 d-inline attributName"> Pays :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="countryName" name="countryName" 
                            <?php if (!is_null($country)) { ?> value="<?php echo(htmlspecialchars($country['country_name']));}?>">
                            <?php if (!empty($errors['countryName'])){?>
                                <div class="alert alert-danger"><?php echo($errors['countryName']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <label for="nationality" class=" col-4 d-inline attributName"> Nationalité :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="nationality" name="nationality"
                            <?php if (!is_null($country)) { ?> value="<?php echo(htmlspecialchars($country['nationality']));}?>">
                            <?php if (!empty($errors['nationality'])){?>
                                <div class="alert alert-danger"><?php echo($errors['nationality']) ?></div>
                            <?php } ?>
                        </div>
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="Country" class="m-3 btn btn-primary" value="Enregistrer">
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