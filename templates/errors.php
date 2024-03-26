<?php 
require_once _TEMPLATEPATH_.'/header.php';
?>
<main> 
    <?php if ($error) { ?>
        <div class="alert alert-danger">
            <?php echo($error) ?>
        </div>
    <?php } ?>

</main>
<?php
require_once _TEMPLATEPATH_.'/footer.php';
?>