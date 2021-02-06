<?php
require '../model/get_products.php';

function get_tissue(){
    global $offset, $limit;
    $tissues = get_tissues_from_db($offset, $limit);
    $offset = $offset + $limit;
    ob_start();
    foreach ($tissues as $id_tissue => $tissue){
        ?>
        <div class="product">
            <img class="img-product" src="<?php print $tissue['path_photo'] ?>" alt="Photo du Tissu">
            <p class="title-product"><?php print $tissue['label']?></p>
            <p class="price-product"><?php print $tissue['prix_unit']?></p>
        </div>
        <?php
    }
    $tissues = ob_get_clean();
    echo $tissues;
}

function get_clothes(){
    global $offset, $limit;
    $sexe = 'IS NOT NULL';
    $type = 'IS NOT NULL';
    $clothes = get_clothes_from_db($offset, $limit, $sexe, $type);
    $offset = $offset + $limit;
    ob_start();
    foreach ($clothes as $id_clothe => $clothe){
        ?>
        <div class="product">
            <img class="img-product" src="<?php print $clothe['path_photo'] ?>" alt="Photo du Vêtement">
            <p class="title-product"><?php print $clothe['label']?></p>
            <p class="price-product"><?php print $clothe['prix_vetement']?></p>
        </div>
        <?php
    }
    $clothes = ob_get_clean();
    echo $clothes;
}

function main(){
    switch ($_POST['target']){
        case 'get_tissues':
            get_tissue();
            break;
		case 'get_clothes':
			get_clothes();
			break;
    }
}
//get_tissue();
main();