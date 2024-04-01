<div class="row d-flex justify-content-center ">
    <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
        <h1 class="d-flex justify-content-center m-2"> Liste des Missions : </h1>
        <div class="d-flex justify-content-end my-1 ms-2 me-1">
            <a href="/index.php?controller=back&action=Missions&todo=create" class="btn btn-primary pt-2" aria-current="page creation Personne">Ajouter</a>
        </div>
    </div>
    <div class="col-11 m-3 p-3 ">
        <?php if ($errors) { ?>
            <div class="alert alert-danger">
                <?php echo($errors) ?>
            </div>
        <?php } else {
            
            if ($allElements) { 
                $allMissions=$allElements;?>
                <div class="tabMissions ">
                    <table>
                        <thead>
                            <th class="col-1  d-none d-md-table-cell tabTitle">Id</th>
                            <th class="col-2 tabTitle">Titre</th>
                            <th class="col-3 tabTitle">Description</th>
                            <th class="col-1 d-none d-md-table-cell tabTitle">Nom de Code</th>
                            <th class="col-1 tabTitle">Début</th>
                            <th class="col-1 d-none d-md-table-cell tabTitle">Fin</th>
                            <th class="col-2 tabTitle">Action</th>
                        </thead>
                        <tbody>
                        <?php foreach ($allMissions as $mission) { ?>
                            <tr>
                                
                                <td class="d-none d-md-table-cell"><?php echo($mission['id']); ?></td>
                                <td><?php echo($mission['title']); ?></td>
                                <td><?php echo($mission['description']); ?></td>
                                <td class="d-none d-md-table-cell"><?php echo($mission['code_name']); ?></td>
                                <td><?php echo($mission['begin_date']); ?></td>
                                <td class="d-none d-md-table-cell"><?php echo($mission['end_date']); }?></td>
                                <td>
                                    <a href="/index.php?controller=back&action=Mission&todo=edit&id=<?php echo($mission['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Editer</a>
                                    <a href="/index.php?controller=back&action=Mission&todo=delete&id=<?php echo($mission['id']) ?>" class="btn btn-primary pt-2" aria-current="pageEdit">Supprimer</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        <?php } } ?>
    </div>
</div>