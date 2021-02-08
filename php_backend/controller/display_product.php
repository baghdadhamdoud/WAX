<?php

require '../model/get_products.php';

function display_product(){
    if(!isset($_POST['id']) || !isset($_POST['tissue_or_clothes'])){
        return null;
    }
    $id = $_POST['id'];
    $tissue_or_clothes = $_POST['tissue_or_clothes'];
    $product = get_product_by_id($id, $tissue_or_clothes);
    switch ($tissue_or_clothes){
        case 'tissue':
            ob_start();
            ?>
            <img src="<?php print $product['path_photo']?>" alt="Photo du Tissu">
            <div class="desc">
                <span class="tissue_or_clothes" style="display: none">tissue</span>
                <span class="id" style="display: none"><?php print $product['id_tissu']?></span>
                <p class="label"><?php print $product['label']?></p>
                <p class="price"><?php print $product['prix_unit'].' DA/m&#xB2;'?></p>
            </div>
            <?php
            return ob_get_clean();
        case 'clothes':
            ob_start();
            ?>
            <img src="<?php print $product['path_photo']?>" alt="Photo du Vêtement">
            <div class="desc">
                <span class="tissue_or_clothes" style="display: none">clothes</span>
                <span class="id" style="display: none"><?php print $product['id_vetement']?></span>
                <p class="label"><?php print $product['label']?></p>
                <p class="label"><?php print $product['article']?></p>
                <select>
                <?php
                $tailles = explode('-', strval($product['taille']));
                foreach ($tailles as $taille){
                    ?>
                    <option><?php print $taille ?></option>
                    <?php
                }
                ?>
                </select>
                <p class="price"><?php print $product['prix_vetement'].' DA'?></p>
            </div>
            <?php
            return ob_get_clean();
    }
}

function main(){
    switch ($_POST['target']){
        case 'display_product':
            echo display_product();
            break;
    }
}

main();