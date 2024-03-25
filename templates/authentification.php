<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
    <h1> Se connecter </h1>

    <form method="POST">
        <div class="mb-3 ms-1">
            <div class="mb-3 ms-1">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3 ms-1">
                <label for="password" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <input type="submit" name="connect" class="btn btn-primary" value="Se connecter">
        </div>
    </form>

</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>