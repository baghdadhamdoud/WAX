<?php
require '../model/get_products.php';

function get_types_nqv_bar(){
    $types = get_types_of_clothes_from_db();
    ob_start();
    foreach ($types as $type){
        ?>
		<li class="li"><?php print $type?></li>
        <?php
    }
    $types = ob_get_clean();
    echo $types;
}

function get_tissues_nav_bar(){
    global $offset, $limit;
    $offset = 1;
    $limit = 10;
    $tissues = get_tissues_from_db($offset,$limit);
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

function get_clothes_nav_bar(){
    global $offset, $limit;
    $offset = 1;
    $limit = 10;
    if(isset($_POST['sexe'])){ $sexe = '="'.$_POST['sexe'].'"';} else{ $sexe = 'IS NOT NULL';}
    if(isset($_POST['type'])){ $type = '="'.$_POST['type'].'"';} else{ $type = 'IS NOT NULL';}
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
        case 'get_types_nqv_bar':
            get_types_nqv_bar();
            break;
        case 'get_tissues_nav_bar':
            get_tissues_nav_bar();
            break;
        case 'get_clothes_nav_bar':
            get_clothes_nav_bar();
            break;
    }
}
main();
//get_clothes();