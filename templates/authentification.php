<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
    <div class="row d-flex justify-content-center ">
        <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
            <h1> Se connecter </h1>
        </div>
        <div class="col-11 m-3 p-3 formConnect">
            <form method="POST">
                <div class="mb-5 ms-1">
                    <div class="mt-3 mb-5 mx-2">
                        <label for="email" class="form-label">Email :</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mt-3 mb-5 mx-2">
                        <label for="password" class="form-label">Mot de passe :</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <input type="submit" name="connect" class="m-3 btn btn-primary" value="Se connecter">
                </div>
            </form>
        </div>
    </div>

</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>