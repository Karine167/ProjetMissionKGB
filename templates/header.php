<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missions du KGB</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@200;300;400;600;700;800;900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>

<header class="d-flex flex-wrap  py-2 mb-2 border-bottom">
    <a href="/" class="d-flex justify-content-start align-items-center mb-1 ps-3 mb-md-0 me-md-auto">
        <img src="assets/images/logoKGB.png" height="100">
    </a>

    <ul class="nav nav-pills justify-content-end  me-md-5 pt-3 pe-md-5">
        <?php if (!array_key_exists('user', $_SESSION)) {?>
            <li class="nav-item"><a href="/index.php?controller=auth&action=login" class="btn btn-primary pt-2" aria-current="pageConnexion">Connexion</a></li>
        <?php } else { ?>
            <li class="nav-item"><a href="/index.php?controller=back&action=Mission&todo=home" class="btn btn-primary pt-2 me-1" aria-current="pageAdministration">Administration</a></li>
            <li class="nav-item"><a href="/index.php?controller=auth&action=logout" class="btn btn-primary pt-2" aria-current="pageDéconnexion">Déconnexion</a></li>
        <?php } ?>
    </ul>
</header>
    
