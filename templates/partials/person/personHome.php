
<div class="row d-flex justify-content-center ">
        <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
            <h1 class="d-flex justify-content-center m-2"> Liste des personnnes : </h1>
            <div class="d-flex justify-content-end my-1 ms-2 me-1">
                <a href="/index.php?controller=back&action=person&todo=create" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
            </div>
        </div>
        <div class="col-11 m-3 p-3 ">
            <?php if ($errors) { ?>
                <div class="alert alert-danger">
                    <?php echo($errors) ?>
                </div>
            <?php } else {
                if ($allPersons) { ?>
                    <table class="col-12 tabMissions">
                        <thead>
                            <th class="col-4  d-none d-md-table-cell tabTitle">Id</th>
                            <th class="col-3 col-md-2 tabTitle">Prénom</th>
                            <th class="col-3 col-md-2 tabTitle">Nom</th>
                            <th class="col-3 col-md-2 tabTitle">Date de naissance</th>
                            <th class="col-3 col-md-2 tabTitle">Actions</th>
                        </thead>
                        <tbody>
                        <?php foreach ($allPersons as $person) { ?>
                            <tr>
                                <td class="d-none d-md-table-cell"><?php echo($person['id']); ?></td>
                                <td><?php echo($person['first_name']); ?></td>
                                <td><?php echo($person['last_name']); ?></td>
                                <td><?php echo($person['birthdate']); ?></td>
                                <td>
                                    <a href="/index.php?controller=back&action=person&todo=edit&id=<?php echo($person['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                    <a href="/index.php?controller=back&action=person&todo=delete&id=<?php echo($person['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
            <?php } } ?>
