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
                <p class="article">Tissu :</p>
                <div class="input_surface">
                    <input type="number" required>
                    <span class="placeholder">Entrer une surface</span>
                    <span class="m_carre">m&#xB2;</span>
                </div>
                <p class="price"><?php print $product['prix_unit'].' DA/m&#xB2;'?></p>
                <button type="button"><img src="pictures/icon/add_to_basket.png" alt="Icon Basket"></button>
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
                <p class="article"><?php print $product['article'].' :'?></p>
                <select class="taille" required>
                    <option disabled selected hidden>Choisissez votre taille</option>
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
                <button type="button"><img src="pictures/icon/add_to_basket.png" alt="Icon Basket"></button>
            </div>
            <?php
            return ob_get_clean();
    }
    return null;
}

// DECLARE ARRAY OF PANIER
$panier = [];

function add_tissue_to_panier(){
    global $panier;
    $panier += ['tissue_or_clothes'=>'tissue', 'id'=>$_POST['id'], 'label'=>$_POST['label'],
                'surface'=>$_POST['surface']];
    return json_encode(['status'=>'true']);
}

function add_clothes_to_panier(){
    global $panier;
    $panier += ['tissue_or_clothes'=>'clothes', 'id'=>$_POST['id'], 'label'=>$_POST['label'],
                'article'=>$_POST['article'], 'taille'=>$_POST['taille']];
    return json_encode(['status'=>'true']);
}

function main(){
    switch ($_POST['target']){
        case 'display_product':
            echo display_product();
            break;
        case 'add_tissue_to_panier':
            echo add_tissue_to_panier();
            break;
        case 'add_clothes_to_panier':
            echo add_clothes_to_panier();
            break;
    }
}

main();