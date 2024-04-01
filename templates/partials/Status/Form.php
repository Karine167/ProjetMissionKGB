<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Statuts de mission : </h1>
    </div>
    <div class="col-11 m-3 p-3 d-flex justify-content-center align-items-center formCategory" >
        
            <div class="row m-3 p-3 d-flex align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center m-2 attributName formCategory fs-3"> Formulaire des statuts: </h1>
                <div class="row d-flex justify-content-start my-3 ms-2 me-1">
                    <form action="" method="POST">
                            <label for="name" class=" col-4 d-inline attributName"> Nom du statut :</label>
                            <input type="text" class="col-8 d-inline attribueValue formInput" id="name" name="name">
                            <?php if (!empty($errors['name'])){?>
                                <div class="alert alert-danger"><?php echo($errors['name']) ?></div>
                            <?php } ?>
                        
                        <div class="mt-3 mb-5 mx-2">
                            <input type="submit" name="Status" class="m-3 btn btn-primary" value="Enregistrer">
                        </div>
                        
                    </form>
                </div>
            </div>
    </div>
</div>
