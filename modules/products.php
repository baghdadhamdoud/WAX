<?php
ob_start();
?>
<main id="main">
<!-- CHOICE BETWEEN TISSUE AND CLOTHES IN THE FIRST TIME ---------------------------------------------------- -->
    <?php include_once 'choice.php';?>
<!-- CONTAINER OF PRODUCTS ---------------------------------------------------- -->
    <div id="container-products"></div>
</main>
<?php
$main = ob_get_clean();
echo $main;