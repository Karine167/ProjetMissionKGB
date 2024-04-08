<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
    <div class="row d-flex justify-content-center ">
        <div class="col-9 m-3 p-3 d-flex align-items-center justify-content-center pageTitle">
            <h1> Liste des missions : </h1>
        </div>
        <div class="col-11 m-3 p-3 ">
            <?php if ($errors) { ?>
                <div class="alert alert-danger">
                    <?php echo($errors) ?>
                </div>
            <?php } else {
                if ($allMissions) { ?>
                    <div class="tabMissions ">
                        <table>
                            <thead>
                                <th class="col-1  d-none d-md-table-cell tabTitle">Id</th>
                                <th class="col-2 tabTitle">Titre</th>
                                <th class="col-4 tabTitle">Description</th>
                                <th class="col-1 d-none d-md-table-cell tabTitle">Nom de Code</th>
                                <th class="col-1 tabTitle">Début</th>
                                <th class="col-1 d-none d-md-table-cell tabTitle">Fin</th>
                                <th class="col-1 tabTitle">Plus d'infos</th>
                            </thead>
                            <tbody>
                            <?php foreach ($allMissions as $mission) { ?>
                                <tr>
                                    
                                    <td class="d-none d-md-table-cell"><?php echo($mission['id']); ?></td>
                                    <td><?php echo(htmlspecialchars($mission['title'])); ?></td>
                                    <td><?php 
                                        if ($mission['description']){
                                            echo(htmlspecialchars($mission['description'])); 
                                        }
                                    ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo(htmlspecialchars($mission['code_name'])); ?></td>
                                    <td><?php echo($mission['begin_date']); ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo($mission['end_date']); ?></td>
                                    <td><a href="/index.php?controller=front&action=plus&id=<?php echo($mission['id']) ?>" class="btn btn-primary pt-2" aria-current="pagePlusInfos">Plus</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
            <?php } } ?>
        </div>
    </div>


</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>