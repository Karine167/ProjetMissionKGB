<div class="row d-flex justify-content-center ">
    <div class="col-10 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Liste des planques : </h1>
        <div class="d-flex justify-content-end my-1 ms-2 me-1">
            <a href="/index.php?controller=back&action=Hideout&todo=create" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
        </div>
    </div>
    <div class="col-11 m-3 p-3 ">
        <?php if ($errors) { ?>
            <div class="alert alert-danger">
                <?php echo($errors[0]) ?>
            </div>
        <?php } else {
            if ($allElements) { ?>
                <table class="col-12 tabMissions">
                    <thead>
                        <th class="col-1 tabTitle d-none d-md-table-cell">Id</th>
                        <th class="col-1 tabTitle d-none d-md-table-cell">Code planque</th>
                        <th class="col-2 tabTitle">Type planque</th>
                        <th class="col-4 tabTitle">Adresse</th>
                        <th class="col-1 tabTitle ">Id Mission</th>
                        <th class="col-3 tabTitle">Actions</th>
                    </thead>
                    <tbody>
                    <?php foreach ($allElements as $element) { ?>
                        <tr>
                            <td class="d-none d-md-table-cell"><?php echo($element['id']); ?></td>
                            <td class="d-none d-md-table-cell"><?php echo(htmlspecialchars($element['code_hide'])); ?></td>
                            <td><?php if(!is_null($element['type_hide'])) echo(htmlspecialchars($element['type_hide'])); ?></td>
                            <td><?php echo(htmlspecialchars($element['address'] . ", " . $element['zipcode'] . ", " . $element['city'] . ", " . $element['country_name'])); 
                            if ($_GET['todo']=='delete'){ 
                                if ($element['id'] == $_GET['id'] ){ ?>
                                <p class="alert alert-danger"><?php echo('Supprimez cet élément ?'); ?>
                                <a href="/index.php?controller=back&action=Hideout&todo=delete&rep=oui&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="OUI">OUI</a>
                                <a href="/index.php?controller=back&action=Hideout&todo=home" class="btn btn-primary pt-2" aria-current="NON">NON</a></p>
                            <?php } } ?></td>
                            <td><?php echo($element['id_mission']); ?></td>
                            <td>
                                <a href="/index.php?controller=back&action=Hideout&todo=edit&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                <a href="/index.php?controller=back&action=Hideout&todo=delete&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
        <?php } } ?>
    </div>
</div>