<?php
    if($isPartial == false) {
        include_once DX_ROOT_DIR . "/views/elements/header.php";
    }
?>
<?php include_once $template_name ?>
<?php
    if($isPartial == false){
        include_once DX_ROOT_DIR . "/views/elements/footer.php";
    }
?>