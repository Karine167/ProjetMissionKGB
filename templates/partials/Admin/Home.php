<div class="row d-flex justify-content-center ">
        <div class="col-10  col-md-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
            <h1 class="d-flex justify-content-center m-2"> Liste des admins : </h1>
            <div class="d-flex justify-content-end my-1 ms-2 me-1">
                <a href="/index.php?controller=back&action=Person&todo=create" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
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
                            <th class="col-3   tabTitle">Prénom Nom</th>
                            <th class="col-4  tabTitle">Email</th>
                            <th class="col-2  tabTitle">Date de création</th>
                            <th class="col-3 col-md-2 tabTitle d-none d-md-table-cell">Actions</th>
                        </thead>
                        <tbody>
                        <?php foreach ($allElements as $element) { ?>
                            <tr>
                                <td><?php echo($element['complete_name']); ?></td>
                                <td><?php echo($element['email']); ?></td>
                                <td class="d-none d-md-table-cell"><?php echo($element['created_at']); ?></td>
                                <td>
                                    <a href="/index.php?controller=back&action=Admin&todo=edit&id=<?php echo($element['id_admin']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                    <a href="/index.php?controller=back&action=Admin&todo=delete&id=<?php echo($element['id_admin']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
            <?php } } ?>