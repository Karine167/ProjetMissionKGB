<div class="row d-flex justify-content-center ">
        <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
            <h1 class="d-flex justify-content-center m-2"> Liste des pays et nationalités : </h1>
            <div class="d-flex justify-content-end my-1 ms-2 me-1">
                <a href="/index.php?controller=back&action=Country&todo=create" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
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
                            <th class="col-3 tabTitle">Id</th>
                            <th class="col-3 tabTitle">Pays</th>
                            <th class="col-3 tabTitle">Nationalité</th>
                            <th class="col-3 tabTitle">Actions</th>
                        </thead>
                        <tbody>
                        <?php foreach ($allElements as $element) { ?>
                            <tr>
                                <td><?php echo($element['id']); ?></td>
                                <td><?php echo($element['country_name']); ?></td>
                                <td><?php echo($element['nationality']); ?></td>
                                <td>
                                    <a href="/index.php?controller=back&action=Country&todo=edit&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                    <a href="/index.php?controller=back&action=Country&todo=delete&id=<?php echo($element['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
            <?php } } ?>
