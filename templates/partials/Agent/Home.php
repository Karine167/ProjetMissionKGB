<div class="row d-flex justify-content-center ">
    <div class="col-10 col-md-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Liste des agents : </h1>
        <div class="d-flex justify-content-end my-1 ms-2 me-1">
            <a href="/index.php?controller=back&action=Person&todo=create&roleRadio=roleAgent" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
        </div>
    </div>
    <div class="col-11 m-3 p-3 ">
        <?php if ($errors) { ?>
            <div class="alert alert-danger">
                <?php echo($errors) ?>
            </div>
        <?php } else {
            if ($allElements) { ?>
                <table class="col-12 tabMissions">
                    <thead>
                        <th class="col-5   tabTitle">Prénom Nom</th>
                        <th class="col-2  tabTitle">Nom de code</th>
                        <th class="col-2  tabTitle">Id mission</th>
                        <th class="col-3 col-md-2 tabTitle">Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach ($allElements as $element) { ?>
                        <tr>
                            <td><?php if (!is_null($element['complete_name'])){ echo(htmlspecialchars($element['complete_name']));} 
                                if ($_GET['todo']=='delete'){ 
                                    if ($element['id'] == $_GET['id'] ){ ?>
                                    <p class="alert alert-danger"><?php echo('Supprimez cet élément ?'); ?>
                                    <a href="/index.php?controller=back&action=Person&todo=delete&rep=oui&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="OUI">OUI</a>
                                    <a href="/index.php?controller=back&action=Person&todo=home" class="btn btn-primary pt-2" aria-current="NON">NON</a></p>
                                <?php } } ?>
                            </td>
                            <td><?php echo(htmlspecialchars($element['identify_code'])); ?></td>
                            <td><?php echo($element['id_mission']); ?></td>
                            <td>
                                <a href="/index.php?controller=back&action=Person&roleRadio=roleAgent&todo=edit&id=<?php echo($element['id_agent']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                <a href="/index.php?controller=back&action=Person&todo=delete&id=<?php echo($element['id_agent']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
        <?php } } ?>
    </div>
</div>